<?php

namespace App\Observers;

use App\Models\Edict;
use Illuminate\Support\Facades\Storage;

class EdictObserver
{
    /**
     * Handle the edict "deleted" event.
     *
     * @param  \App\Models\Edict  $edict
     * @return void
     */
    public function deleted(Edict $edict)
    {
        $this->deletePdfFile($edict);
    }

    /**
     * Delete a pdf from file.
     *
     * @param  \App\Models\Edict  $edict
     * @return void
     */
    private function deletePdfFile($edict)
    {
        $pdfsDirectory = 'public/uploads/edicts/' . $edict->id;
        Storage::deleteDirectory($pdfsDirectory);
    }
}
