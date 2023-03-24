<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $this->saveImageFile($user);
    }

    /**
     * Handle the user "updating" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updating(User $user)
    {
        if ($user->isDirty('image')) {
            $this->deleteImageFile(User::find($user->id));
            $this->saveImageFile($user);
        }
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        $this->deleteImageFile($user);
    }

    /**
     * Delete a image from file.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    private function deleteImageFile($user)
    {
        $imageDirectory = 'public/uploads/users/' . $user->id;
        $imagePath = $imageDirectory  . '/' . $user->image;
        Storage::delete($imagePath);

        $files = glob($imageDirectory . '/*');
        if (is_array($files) && count($files) === 0) {
            Storage::deleteDirectory($imageDirectory);
        }
    }

    /**
     * Save file in disk.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    private function saveImageFile($user)
    {
        if ($user->image != null) {
            $imageName = Str::slug($user->id . '-' . $user->name, '-') . '.' . $user->image->extension();
            $storePath = 'uploads/users/' . $user->id;

            $user->image->storeAs($storePath, $imageName, 'public');
            $user->image = $imageName;
        }
    }
}
