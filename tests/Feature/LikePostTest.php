<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Notifications\PostLikedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class LikePostTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Post $post;
    private User $postOwner;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postOwner = User::factory()->create();
        $this->user = User::factory()->create();
        $this->post = Post::factory()->create([
            'user_id' => $this->postOwner->id,
        ]);
    }

    public function test_unauthenticated_user_is_redirected_to_login_page_when_liking_post()
    {
        $response = $this->post(route('posts.like', $this->post));

        $response->assertRedirect(route('login'));
        $this->assertCount(0, $this->post->likes);
    }

    public function test_authenticated_user_can_like_post()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('posts.like', $this->post));

        $this->assertCount(1, $this->post->likes);
        $this->assertTrue($this->post->likes()->where('user_id', $this->user->id)->exists());
        $response->assertRedirect();
    }

    public function test_authenticated_user_can_unlike_post()
    {
        $this->actingAs($this->user);

        // First like the post
        $this->post->likes()->create(['user_id' => $this->user->id]);

        // Then unlike it
        $response = $this->post(route('posts.like', $this->post));

        $this->assertCount(0, $this->post->fresh()->likes);
        $response->assertRedirect();
    }

    public function test_notification_is_sent_when_other_user_likes_post()
    {
        $this->actingAs($this->user);

        Notification::fake();
        $this->post(route('posts.like', $this->post));

        Notification::assertSentTo(
            [$this->postOwner],
            PostLikedNotification::class,
            function (PostLikedNotification $notification) {
                $data = $notification->toArray($this->postOwner);

                $this->assertEquals($this->user->name, $data['user_name']);
                $this->assertEquals('liked your post', $data['text']);
                $this->assertEquals(route('posts.show', $this->post->id), $data['url']);

                return true;
            }
        );
    }

    public function test_no_notification_when_user_likes_own_post()
    {
        $this->actingAs($this->postOwner);

        Notification::fake();
        $this->post(route('posts.like', $this->post));

        Notification::assertNotSentTo($this->postOwner, PostLikedNotification::class);
    }
}
