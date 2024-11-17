<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function store(array $data, $image = null)
    {
        $post = auth()->user()->posts()->create($data);

        if ($image) {
            $post->image = $this->uploadImage($image);
            $post->save();
        }

        return $post;
    }

    public function update(Post $post, array $data, $image = null)
    {
        if (request()->boolean('remove_image') && $post->image) {
            // Handle image removal
            $this->deleteImage($post->image);
            $data['image'] = null;
        } elseif ($image) {
            // Handle new image upload
            if ($post->image) {
                $this->deleteImage($post->image);
            }

            $data['image'] = $this->uploadImage($image);
        } else {
            // Preserve the existing image
            $data['image'] = $post->image;
        }

        $post->update($data);
    }

    public function delete(Post $post)
    {
        if ($post->image) {
            $this->deleteImage($post->image);
        }

        $post->delete();
    }

    private function uploadImage($image)
    {
        return $image->store('post_images', 'public');
    }

    private function deleteImage($imagePath)
    {
        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
