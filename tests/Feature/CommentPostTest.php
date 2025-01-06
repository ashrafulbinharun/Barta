<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\CommentNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CommentPostTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Post $post;
    private Comment $comment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->post = Post::factory()->create();
        $this->comment = Comment::factory()->create([
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function test_unauthenticated_user_is_redirected_to_login_page_when_commenting_on_post()
    {
        $response = $this->post(route('posts.comments.store', $this->post), [
            'comment' => 'This is a test comment',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_comment_on_post()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('posts.comments.store', $this->post), [
            'comment' => 'This is a test comment',
        ]);

        $this->assertDatabaseHas('comments', [
            'content' => 'This is a test comment',
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('message', 'Comment added');
    }

    public function test_notification_is_sent_to_post_owner()
    {
        Notification::fake();

        $postOwner = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $postOwner->id]);

        $this->actingAs($this->user);

        $this->post(route('posts.comments.store', $post), [
            'comment' => 'This is a test comment',
        ]);

        Notification::assertSentTo(
            $postOwner,
            CommentNotification::class,
            function (CommentNotification $notification) use ($post, $postOwner) {
                $mail = $notification->toMail($postOwner);
                $this->assertEquals('New Comment on Your Post', $mail->subject);
                $this->assertEquals("Hello, {$postOwner->name}!", $mail->greeting);

                $data = $notification->toArray($postOwner);
                $this->assertEquals($this->user->name, $data['user_name']);
                $this->assertEquals('commented your post', $data['text']);
                $this->assertEquals(route('posts.show', $post->id), $data['url']);

                return true;
            }
        );
    }

    public function test_notification_is_not_sent_when_commenting_on_own_post()
    {
        Notification::fake();
        $ownPost = Post::factory()->create(['user_id' => $this->user->id]);
        $this->actingAs($this->user);

        $this->post(route('posts.comments.store', $ownPost), [
            'comment' => 'This is a test comment',
        ]);

        Notification::assertNotSentTo($this->user, CommentNotification::class);
        $this->assertDatabaseHas('comments', [
            'content' => 'This is a test comment',
            'user_id' => $this->user->id,
            'post_id' => $ownPost->id,
        ]);
    }

    public function test_user_can_update_own_comment()
    {
        $this->actingAs($this->user);

        $response = $this->patch(route('posts.comments.update', [$this->post, $this->comment]), [
            'comment' => 'Updated comment',
        ]);

        $this->assertDatabaseHas('comments', [
            'id' => $this->comment->id,
            'content' => 'Updated comment',
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('message', 'Comment updated');
    }

    public function test_user_cannot_update_others_comment()
    {
        $otherUser = User::factory()->create();
        $this->actingAs($otherUser);

        $response = $this->patch(route('posts.comments.update', [$this->post, $this->comment]), [
            'comment' => 'Updated comment',
        ]);

        $response->assertForbidden();
    }

    public function test_user_can_delete_own_comment()
    {
        $this->actingAs($this->user);

        $response = $this->delete(route('posts.comments.destroy', [$this->post, $this->comment]));

        $this->assertDatabaseMissing('comments', ['id' => $this->comment->id]);
        $response->assertRedirect();
        $response->assertSessionHas('message', 'Comment deleted');
    }

    public function test_user_cannot_delete_others_comment()
    {
        $otherUser = User::factory()->create();
        $this->actingAs($otherUser);

        $response = $this->delete(route('posts.comments.destroy', [$this->post, $this->comment]));

        $response->assertForbidden();
    }
}
