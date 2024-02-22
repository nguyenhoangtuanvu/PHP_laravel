<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

trait HandleImageTrait
{
    protected string $path = 'public/upload/';

    /**
     * @param $request
     * @return mixed
     */
    public function verify($request): mixed
    {
        return $request->has('image');
    }

    /**
     * @param $request
     * @return string|void
     */
    public function saveImage($request)
    {
        if ($this->verify($request)) {
            $manager = new ImageManager(new Driver());

            $file = $request->file('image');
            $name = time() . $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            // dd($this->path . $name);
            $image = $manager->read($file);
            $image = $image->resize(300, 300);
            $image->save(base_path($this->path . $name));
            return $name;
        }
    }

    /**
     * @paramfilesystems $request
     * @param $request
     * @param $currentImage
     * @return mixed|string|null
     */
    public function updateImage($request, $currentImage): mixed
    {
        if($this->verify($request))
        {
            $this->deleteImage($currentImage);
            return $this->saveImage($request);
        }
        return $currentImage;
    }

    /**
     * @param $imageName
     * @return void
     */
    public function deleteImage($imageName)
    {
        // return scandir(base_path($this->path));
        if($imageName && file_exists(base_path($this->path.$imageName)))
        {
            // Storage::delete($this->path .$imageName);
            unlink(base_path($this->path.$imageName));
            return true;
        }
        return false;
    }

}