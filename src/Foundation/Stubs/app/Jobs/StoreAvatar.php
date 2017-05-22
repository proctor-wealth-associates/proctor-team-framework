<?php

namespace App\Jobs;

use Storage;
use Intervention\Image\ImageManager;

class StoreAvatar
{
    protected $model;
    protected $avatarFolder;
    protected $image;
    protected $disk;

    
    function __construct($model, $avatarFolder, $image)
    {
        $this->model = $model;
        $this->avatarFolder = $avatarFolder;
        $this->image = $image;
        $this->disk = Storage::disk('public');
    }

    public function handle()
    {
        $path = $this->image->hashName($this->avatarFolder);

        $this->disk->put($path, $this->formattedImage());

        $oldPhotoUrl = $this->model->photo_url;

        $this->model->forceFill([
            'photo_url' => $this->disk->url($path),
        ])->save();

        $this->deleteOldAvatar($oldPhotoUrl);
    }

    protected function formattedImage()
    {
        $imageManager = app(ImageManager::class);
        $imagePath = $this->image->path();

        return (string) $imageManager->make($imagePath)->fit(300)->encode();
    }

    protected function deleteOldAvatar($oldPhotoUrl)
    {
        if (preg_match("/$this->avatarFolder\/(.*)$/", $oldPhotoUrl, $matches)) {
            $this->disk->delete($this->avatarFolder . '/' . $matches[1]);
        }
    }
}