<?php

namespace App\Observers;

use App\Models\Servant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ServantObserver
{
    /**
     * Handle the servant "created" event.
     *
     * @param  \App\Models\Servant  $servant
     * @return void
     */
    public function created(Servant $servant)
    {
        $this->saveImageFile($servant);
    }

    /**
     * Handle the servant "updating" event.
     *
     * @param  \App\Models\Servant  $servant
     * @return void
     */
    public function updating(Servant $servant)
    {
        if ($servant->isDirty('image')) {
            $this->deleteImageFile(Servant::find($servant->id));
            $this->saveImageFile($servant);
        }
    }

    /**
     * Handle the servant "deleted" event.
     *
     * @param  \App\Models\Servant  $servant
     * @return void
     */
    public function deleted(Servant $servant)
    {
        $this->deleteImageFile($servant);
    }

    /**
     * Delete a image from file.
     *
     * @param  \App\Models\Servant  $servant
     * @return void
     */
    private function deleteImageFile($servant)
    {
        $imageDirectory = 'public/uploads/servants/' . $servant->id;
        $imagePath = $imageDirectory . '/' . $servant->image;
        Storage::delete($imagePath);

        $files = glob($imageDirectory . '/*');
        if (is_array($files) && count($files) === 0) {
            Storage::deleteDirectory($imageDirectory);
        }
    }

    /**
     * Save file in disk
     *
     * @param  \App\Models\Servant  $servant
     * @return void
     */
    private function saveImageFile($servant)
    {
        if ($servant->image != null) {
            $imageName = Str::slug($servant->id . '-' . $servant->name, '-') . '.' . $servant->image->extension();
            $storePath = 'uploads/servants/' . $servant->id;

            $servant->image->storeAs($storePath, $imageName, 'public');
            $servant->image = $imageName;
        }
    }
}
