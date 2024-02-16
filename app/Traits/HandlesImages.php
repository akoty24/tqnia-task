<?php

namespace App\Traits;

trait HandlesImages
{
    public function storeImage($image, $destination = 'public/post_images')
    {
        if ($image) {
            $imagePath = $image->store($destination);
            return str_replace('public/', 'storage/', $imagePath);
        }

        return null;
    }
}
