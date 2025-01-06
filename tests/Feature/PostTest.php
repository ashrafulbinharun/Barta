<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    protected string $postContent;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->postContent = $this->faker->paragraph();
        Storage::fake('public');
    }

    public function test_user_can_create_post_with_content_only()
    {
        $response = $this->actingAs($this->user)
            ->post(route('posts.store'), [
                'content' => $this->postContent,
            ]);

        $response->assertRedirect(route('home'))
            ->assertSessionHas('message', 'Post created');

        $this->assertDatabaseHas('posts', [
            'content' => $this->postContent,
            'user_id' => $this->user->id,
        ]);
    }

    public function test_user_can_create_post_with_image_only()
    {
        $image = UploadedFile::fake()->image('test.jpg');

        $response = $this->actingAs($this->user)
            ->post(route('posts.store'), [
                'image' => $image,
            ]);

        $response->assertRedirect(route('home'))
            ->assertSessionHas('message', 'Post created');

        $post = Post::first();
        $this->assertNotNull($post->image);
        Storage::disk('public')->assertExists($post->image);
    }

    public function user_can_create_post_with_content_and_image()
    {
        $image = UploadedFile::fake()->image('post.jpg');

        $response = $this->actingAs($this->user)
            ->post(route('posts.store'), [
                'content' => $this->postContent,
                'image' => $image,
            ]);

        $response->assertRedirect(route('home'));

        $post = Post::first();
        $this->assertEquals($this->postContent, $post->content);
        $this->assertNotNull($post->image);
        Storage::disk('public')->assertExists($post->image);
    }

    public function test_user_cannot_create_post_without_content_and_image()
    {
        $response = $this->actingAs($this->user)
            ->post(route('posts.store'), []);

        $response->assertSessionHasErrors(['content', 'image']);
        $this->assertDatabaseCount('posts', 0);
    }

    public function test_user_can_update_their_own_post()
    {
        $post = Post::factory()->for($this->user)->create();
        $newContent = $this->faker->paragraph();

        $response = $this->actingAs($this->user)
            ->put(route('posts.update', $post), [
                'content' => $newContent,
            ]);

        $response->assertRedirect()->assertSessionHas('message', 'Post updated');

        $this->assertEquals($newContent, $post->fresh()->content);
    }

    public function test_user_cannot_update_others_post()
    {
        $otherUser = User::factory()->create();
        $post = Post::factory()->for($otherUser)->create();

        $response = $this->actingAs($this->user)
            ->put(route('posts.update', $post), [
                'content' => $this->faker->paragraph(),
            ]);

        $response->assertForbidden();
    }

    public function test_user_can_remove_image_from_post()
    {
        $image = UploadedFile::fake()->image('post.jpg');
        $post = Post::factory()->for($this->user)->create([
            'image' => $image->store('post_images', 'public'),
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('posts.update', $post), [
                'content' => $post->content,
                'remove_image' => true,
            ]);

        $response->assertRedirect();
        $this->assertNull($post->fresh()->image);
        Storage::disk('public')->assertMissing($post->image);
    }

    public function test_user_can_delete_their_own_post()
    {
        $fakeImage = UploadedFile::fake()->image('test.jpg');

        $post = Post::factory()->for($this->user)->create([
            'image' => $fakeImage->store('post_images', 'public'),
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('posts.destroy', $post));

        $response->assertRedirect()->assertSessionHas('message', 'Post deleted');

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        Storage::disk('public')->assertMissing($post->image);
    }

    public function test_user_cannot_delete_others_post()
    {
        $otherUser = User::factory()->create();
        $post = Post::factory()->for($otherUser)->create();

        $response = $this->actingAs($this->user)
            ->delete(route('posts.destroy', $post));

        $response->assertForbidden();
        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }

    public function test_show_page_displays_post_with_comments()
    {
        $post = Post::factory()->for($this->user)->hasComments(3)->create();

        $response = $this->actingAs($this->user)
            ->get(route('posts.show', $post));

        $response->assertOk()
            ->assertViewIs('post.show')
            ->assertViewHas('post')
            ->assertSee($post->content)
            ->assertSee($post->comments->first()->content);
    }
}
