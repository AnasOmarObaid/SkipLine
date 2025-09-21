<?php

namespace App\Services;

use App\Models\Hotel;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ImageService
{


    /**
     * store
     *
     * @param  Request $request
     * @param  mixed $imageable
     * @param  string $storeAs
     * @return mixed
     */
    public function store(Request $request, mixed $imageable, string $storeAs = ''): mixed
    {
        // store image in local and return path
        $path = $request->file('image')->store('uploads\images\\' . $storeAs);

        // create image and store it in database in images table
        return $imageable->image()->create([
            'path' => $path,
        ]);
    }

    /**
     * update
     *
     * @param  Request $request
     * @param  mixed $imageable
     * @param  string $storeAs
     * @return mixed
     */
    public function update(Request $request, mixed $imageable, string $storeAs = 'uploads/'): mixed
    {
        // delete old image, and check if this model has image
        if ($imageable->hasImage())
            $this->delete($imageable);

        // upload new image
        return $this->store($request, $imageable, $storeAs);
    }

    /**
     * delete
     *
     * @param  mixed $imageable
     * @return void
     */
    public function delete(mixed $imageable): void
    {
        // check if the image is exist or not
        if (Storage::disk('public')->exists($imageable->image?->path)) {

            // delete from local
            Storage::delete($imageable->image->path);

            // delete from database
            $imageable->image->delete();
        }

        return;
    }


}
