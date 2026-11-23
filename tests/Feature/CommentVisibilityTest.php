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

    $this->approved = Comment::factory()->create([
        'trip_id' => $this->trip->id,
        'user_id' => $this->stranger->id,
        'content' => 'An approved comment',
    ]);
    $this->waiting = Comment::factory()->unapproved()->create([
        'trip_id' => $this->trip->id,
        'user_id' => $this->writer->id,
        'content' => 'A comment that is waiting',
    ]);
});

test('a guest only sees approved comments', function () {
    $this->get(route('trips.show', $this->trip->id))
        ->assertSee('An approved comment')
        ->assertDontSee('A comment that is waiting');
});

test('the writer sees their own comment before it is approved', function () {
    $this->actingAs($this->writer)
        ->get(route('trips.show', $this->trip->id))
        ->assertSee('An approved comment')
        ->assertSee('A comment that is waiting')
        ->assertSee('awaiting validation');
});

test('the owner of the trip sees comments that are waiting', function () {
    $this->actingAs($this->owner)
        ->get(route('trips.show', $this->trip->id))
        ->assertSee('A comment that is waiting');
});

test('an admin sees comments that are waiting', function () {
    $this->actingAs($this->admin)
        ->get(route('trips.show', $this->trip->id))
        ->assertSee('A comment that is waiting');
});

test('another user does not see comments that are waiting', function () {
    $this->actingAs($this->stranger)
        ->get(route('trips.show', $this->trip->id))
        ->assertSee('An approved comment')
        ->assertDontSee('A comment that is waiting');
});

test('a new comment written through the form waits for approval', function () {
    $this->actingAs($this->stranger)
        ->post(route('trips.comments.store', $this->trip->id), ['content' => 'Fresh from the form']);

    $comment = Comment::where('content', 'Fresh from the form')->first();

    expect($comment->approved_at)->toBeNull()
        ->and($comment->canView(null))->toBeFalse()
        ->and($comment->canView($this->stranger))->toBeTrue()
        ->and($comment->canView($this->owner))->toBeTrue();
});

test('only an admin or the owner of the trip can manage a comment', function () {
    expect($this->waiting->canManage($this->admin))->toBeTrue()
        ->and($this->waiting->canManage($this->owner))->toBeTrue()
        ->and($this->waiting->canManage($this->writer))->toBeFalse()
        ->and($this->waiting->canManage($this->stranger))->toBeFalse();
});
