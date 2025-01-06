<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $searchedUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->searchedUser = User::factory()->create([
            'name' => 'John Doe',
            'username' => 'john',
            'email' => 'john@doe.com',
        ]);

        Post::factory()->for($this->searchedUser)->create();
    }

    public function test_home_page_is_accessible()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('home');
        $response->assertViewHas('posts');
    }

    public function test_home_page_shows_likes_and_comments_count()
    {
        $post = Post::factory()->for($this->user)->create();

        $post->likes()->create(['user_id' => $this->user->id]);
        $post->comments()->create([
            'user_id' => $this->user->id,
            'content' => 'This is a test comment',
        ]);

        $response = $this->get('/');

        $response->assertViewHas('posts', function ($posts) use ($post) {
            $firstPost = $posts->firstWhere('id', $post->id);
            $this->assertEquals(1, $firstPost->likes_count);
            $this->assertEquals(1, $firstPost->comments_count);

            return true;
        });
    }

    public function test_search_by_username()
    {
        $response = $this->get('/?word=john');

        $response->assertViewHas('posts', function ($posts) {
            $this->assertEquals(1, $posts->count());
            $this->assertEquals($this->searchedUser->id, $posts->first()->user->id);

            return true;
        });
    }

    public function test_search_by_name()
    {
        $response = $this->get('/?word=John Doe');

        $response->assertViewHas('posts', function ($posts) {
            $this->assertEquals(1, $posts->count());
            $this->assertEquals($this->searchedUser->id, $posts->first()->user->id);

            return true;
        });
    }

    public function test_search_by_email()
    {
        $response = $this->get('/?word=john@doe.com');

        $response->assertViewHas('posts', function ($posts) {
            $this->assertEquals(1, $posts->count());
            $this->assertEquals($this->searchedUser->id, $posts->first()->user->id);

            return true;
        });
    }
}
