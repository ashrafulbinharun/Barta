<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\CommentNotification;
use App\Notifications\PostLikedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserNotificationsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Post $post;
    private User $otherUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->otherUser = User::factory()->create();
        $this->post = Post::factory()->for($this->user)->create();
    }

    public function test_user_can_see_like_notifications()
    {
        $this->user->notify(new PostLikedNotification(
            $this->otherUser,
            $this->post
        ));

        $response = $this->actingAs($this->user)
            ->get(route('notifications.index'));

        $response->assertSuccessful()
            ->assertViewIs('notification.index')
            ->assertViewHas('notifications')
            ->assertSee($this->otherUser->name)
            ->assertSee('liked your post');
    }

    public function test_user_can_see_comment_notifications()
    {
        $comment = Comment::factory()->for($this->post)->for($this->otherUser)->create();

        $this->user->notify(new CommentNotification(
            $this->otherUser,
            $this->post,
            $comment
        ));

        $response = $this->actingAs($this->user)
            ->get(route('notifications.index'));

        $response->assertSuccessful()
            ->assertViewIs('notification.index')
            ->assertViewHas('notifications')
            ->assertSee($this->otherUser->name)
            ->assertSee('commented your post');
    }

    public function test_comment_notification_sends_email()
    {
        Notification::fake();

        $comment = Comment::factory()->for($this->post)->for($this->otherUser)->create();

        $this->user->notify(new CommentNotification(
            $this->otherUser,
            $this->post,
            $comment
        ));

        Notification::assertSentTo(
            $this->user,
            CommentNotification::class,
            function (CommentNotification $notification) {
                return $notification->toMail($this->user)->subject === 'New Comment on Your Post';
            }
        );
    }

    public function test_notifications_are_marked_as_read_when_viewed()
    {
        $this->user->notify(new PostLikedNotification(
            $this->otherUser,
            $this->post
        ));

        $comment = Comment::factory()->for($this->post)->for($this->otherUser)->create();
        $this->user->notify(new CommentNotification(
            $this->otherUser,
            $this->post,
            $comment
        ));

        $this->assertEquals(2, $this->user->unreadNotifications->count());

        $this->actingAs($this->user)->get(route('notifications.index'));

        $this->assertEquals(0, $this->user->fresh()->unreadNotifications->count());
    }

    public function test_user_can_mark_all_notifications_as_read()
    {
        $this->user->notify(new PostLikedNotification(
            $this->otherUser,
            $this->post
        ));

        $comment = Comment::factory()->for($this->post)->for($this->otherUser)->create();
        $this->user->notify(new CommentNotification(
            $this->otherUser,
            $this->post,
            $comment
        ));

        $this->assertEquals(2, $this->user->unreadNotifications->count());

        $response = $this->actingAs($this->user)
            ->post(route('notifications.markAllAsRead'));

        $response->assertRedirect()->assertSessionHas('message', 'All notifications marked as read');

        $this->assertEquals(0, $this->user->fresh()->unreadNotifications->count());
    }

    public function test_notification_urls_are_correctly_generated()
    {
        $this->user->notify(new PostLikedNotification(
            $this->otherUser,
            $this->post
        ));

        $response = $this->actingAs($this->user)
            ->get(route('notifications.index'));

        $response->assertSee(route('posts.show', $this->post->id));
    }
}
