<?php

use App\Models\Comment;
use App\Models\Trip;
use App\Models\User;

beforeEach(function () {
    // is_admin is set explicitly: the user factory makes a random user an admin now and then
    $this->owner = User::factory()->create(['is_admin' => false]);
    $this->writer = User::factory()->create(['is_admin' => false]);
    $this->stranger = User::factory()->create(['is_admin' => false]);
    $this->admin = User::factory()->admin()->create();

    $this->trip = Trip::factory()->create(['user_id' => $this->owner->id, 'is_public' => true]);
    $this->otherTrip = Trip::factory()->create(['user_id' => $this->stranger->id, 'is_public' => true]);

    $this->waiting = Comment::factory()->unapproved()->create([
        'trip_id' => $this->trip->id,
        'user_id' => $this->writer->id,
        'content' => 'Waiting comment on owner trip',
    ]);
    $this->approved = Comment::factory()->create([
        'trip_id' => $this->trip->id,
        'user_id' => $this->writer->id,
        'content' => 'Approved comment on owner trip',
    ]);
    $this->elsewhere = Comment::factory()->unapproved()->create([
        'trip_id' => $this->otherTrip->id,
        'user_id' => $this->writer->id,
        'content' => 'Comment on a different trip',
    ]);
});

test('a guest is sent to the login page', function () {
    $this->get(route('userzone.comments.index'))->assertRedirect(route('login'));
});

test('the owner only sees the comments on their own trips', function () {
    $this->actingAs($this->owner)
        ->get(route('userzone.comments.index'))
        ->assertOk()
        ->assertSee('Waiting comment on owner trip')
        ->assertSee('Approved comment on owner trip')
        ->assertDontSee('Comment on a different trip');
});

test('an admin sees the comments on all trips', function () {
    $this->actingAs($this->admin)
        ->get(route('userzone.comments.index'))
        ->assertSee('Waiting comment on owner trip')
        ->assertSee('Comment on a different trip');
});

test('the unmoderated filter only shows comments waiting for approval', function () {
    $this->actingAs($this->owner)
        ->get(route('userzone.comments.index', ['unmoderated' => 1]))
        ->assertSee('Waiting comment on owner trip')
        ->assertDontSee('Approved comment on owner trip');
});

test('a stranger can not view, edit, update or delete a comment on someone else\'s trip', function () {
    $this->actingAs($this->stranger);

    $this->get(route('userzone.comments.show', $this->waiting->id))->assertForbidden();
    $this->get(route('userzone.comments.edit', $this->waiting->id))->assertForbidden();
    $this->put(route('userzone.comments.update', $this->waiting->id), ['content' => 'Hacked comment', 'approved' => 1])->assertForbidden();
    $this->delete(route('userzone.comments.destroy', $this->waiting->id))->assertForbidden();

    expect($this->waiting->fresh()->content)->toBe('Waiting comment on owner trip');
    expect($this->waiting->fresh()->approved_at)->toBeNull();
});

test('the writer of a comment can not moderate it', function () {
    $this->actingAs($this->writer)
        ->put(route('userzone.comments.update', $this->waiting->id), ['content' => 'Self approved', 'approved' => 1])
        ->assertForbidden();

    expect($this->waiting->fresh()->approved_at)->toBeNull();
});

test('the owner can approve a comment', function () {
    $this->actingAs($this->owner)
        ->put(route('userzone.comments.update', $this->waiting->id), ['content' => 'Waiting comment on owner trip', 'approved' => 1])
        ->assertRedirect(route('userzone.comments.index'));

    expect($this->waiting->fresh()->approved_at)->not->toBeNull();
});

test('the owner can set an approved comment back to not approved', function () {
    $this->actingAs($this->owner)
        ->put(route('userzone.comments.update', $this->approved->id), ['content' => 'Approved comment on owner trip', 'approved' => 0]);

    expect($this->approved->fresh()->approved_at)->toBeNull();
});

test('updating an approved comment keeps its approval date', function () {
    $before = $this->approved->approved_at;

    $this->actingAs($this->owner)
        ->put(route('userzone.comments.update', $this->approved->id), ['content' => 'Edited text', 'approved' => 1]);

    expect($this->approved->fresh()->content)->toBe('Edited text');
    expect($this->approved->fresh()->approved_at->timestamp)->toBe($before->timestamp);
});

test('the update is validated', function () {
    $this->actingAs($this->owner)
        ->put(route('userzone.comments.update', $this->waiting->id), ['content' => 'ab'])
        ->assertSessionHasErrors(['content', 'approved']);
});

test('the owner and an admin can delete a comment', function () {
    $this->actingAs($this->owner)->delete(route('userzone.comments.destroy', $this->waiting->id));
    expect(Comment::find($this->waiting->id))->toBeNull();

    $this->actingAs($this->admin)->delete(route('userzone.comments.destroy', $this->elsewhere->id));
    expect(Comment::find($this->elsewhere->id))->toBeNull();
});

test('the owner can approve a comment with the approve action', function () {
    $this->actingAs($this->owner)
        ->from(route('userzone.comments.index'))
        ->post(route('userzone.comments.approve', $this->waiting->id))
        ->assertRedirect(route('userzone.comments.index'));

    expect($this->waiting->fresh()->approved_at)->not->toBeNull();
});

test('an admin can approve a comment on any trip', function () {
    $this->actingAs($this->admin)->post(route('userzone.comments.approve', $this->elsewhere->id));

    expect($this->elsewhere->fresh()->approved_at)->not->toBeNull();
});

test('approving again keeps the first approval date', function () {
    $before = $this->approved->approved_at;

    $this->actingAs($this->owner)->post(route('userzone.comments.approve', $this->approved->id));

    expect($this->approved->fresh()->approved_at->timestamp)->toBe($before->timestamp);
});

test('a stranger and the writer can not approve a comment', function () {
    $this->actingAs($this->stranger)->post(route('userzone.comments.approve', $this->waiting->id))->assertForbidden();
    $this->actingAs($this->writer)->post(route('userzone.comments.approve', $this->waiting->id))->assertForbidden();

    expect($this->waiting->fresh()->approved_at)->toBeNull();
});

test('a guest can not approve a comment', function () {
    $this->post(route('userzone.comments.approve', $this->waiting->id))->assertRedirect(route('login'));

    expect($this->waiting->fresh()->approved_at)->toBeNull();
});

test('only waiting comments get an approve button in the list', function () {
    $this->actingAs($this->owner)
        ->get(route('userzone.comments.index'))
        ->assertSee(route('userzone.comments.approve', $this->waiting->id))
        ->assertDontSee(route('userzone.comments.approve', $this->approved->id));
});
