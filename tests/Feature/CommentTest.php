<?php

use App\Models\Comment;
use App\Models\Trip;
use App\Models\User;
use App\Notifications\NewCommentOnYourTripNotification;
use Illuminate\Support\Facades\Notification;

test('a logged in user can comment on a public trip and the owner of the trip is notified', function () {
    Notification::fake();
    $owner = User::factory()->create();
    $writer = User::factory()->create();
    $trip = Trip::factory()->create(['user_id' => $owner->id, 'is_public' => true]);

    $response = $this->actingAs($writer)
        ->post(route('trips.comments.store', $trip->id), ['content' => 'What a lovely trip!']);

    $response->assertRedirect();
    $this->assertDatabaseHas('comments', [
        'trip_id' => $trip->id,
        'user_id' => $writer->id,
        'content' => 'What a lovely trip!',
    ]);
    Notification::assertSentTo($owner, NewCommentOnYourTripNotification::class);
});

test('the owner of a trip is not notified about their own comment', function () {
    Notification::fake();
    $owner = User::factory()->create();
    $trip = Trip::factory()->create(['user_id' => $owner->id, 'is_public' => true]);

    $this->actingAs($owner)
        ->post(route('trips.comments.store', $trip->id), ['content' => 'A comment on my own trip']);

    $this->assertDatabaseCount('comments', 1);
    Notification::assertNothingSent();
});

test('the writer of a comment is always the logged in user', function () {
    Notification::fake();
    $writer = User::factory()->create();
    $someoneElse = User::factory()->create();
    $trip = Trip::factory()->create(['is_public' => true]);

    $this->actingAs($writer)->post(route('trips.comments.store', $trip->id), [
        'content' => 'Nice one',
        'user_id' => $someoneElse->id,
    ]);

    $this->assertDatabaseHas('comments', ['content' => 'Nice one', 'user_id' => $writer->id]);
});

test('a guest can not comment', function () {
    $trip = Trip::factory()->create(['is_public' => true]);

    $response = $this->post(route('trips.comments.store', $trip->id), ['content' => 'Hello there']);

    $response->assertRedirect(route('login'));
    expect(Comment::count())->toBe(0);
});

test('nobody can comment on a private trip', function () {
    $writer = User::factory()->create();
    $trip = Trip::factory()->create(['is_public' => false]);

    $this->actingAs($writer)
        ->post(route('trips.comments.store', $trip->id), ['content' => 'Hello there'])
        ->assertNotFound();

    expect(Comment::count())->toBe(0);
});

test('a comment needs at least 3 characters', function () {
    $writer = User::factory()->create();
    $trip = Trip::factory()->create(['is_public' => true]);

    $this->actingAs($writer)
        ->post(route('trips.comments.store', $trip->id), ['content' => 'Hi'])
        ->assertSessionHasErrors('content');

    expect(Comment::count())->toBe(0);
});

test('the notification email contains the trip, the writer and the comment', function () {
    $owner = User::factory()->create(['name' => 'Olivia Owner']);
    $writer = User::factory()->create(['name' => 'Walter Writer']);
    $trip = Trip::factory()->create(['user_id' => $owner->id, 'title' => 'Walking in Lisbon', 'is_public' => true]);
    $comment = Comment::factory()->create(['trip_id' => $trip->id, 'user_id' => $writer->id, 'content' => 'Great photos!']);

    $mail = (new NewCommentOnYourTripNotification($comment))->toMail($owner);

    expect($mail->greeting)->toBe('Hello Olivia Owner!')
        ->and(implode(' ', $mail->introLines))->toContain('Walter Writer', 'Walking in Lisbon', 'Great photos!')
        ->and($mail->actionUrl)->toBe(route('trips.show', $trip->id));
});
