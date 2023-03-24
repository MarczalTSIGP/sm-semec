<?php

namespace App\Observers;

use App\Models\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PdfObserver
{
    /**
     * Handle the pdf "creating" event.
     *
     * @param  \App\Models\Pdf $pdf
     * @return void
     */
    public function creating(Pdf $pdf)
    {
        $this->savePdfFile($pdf);
    }

    /**
     * Handle the pdf "deleted" event.
     *
     * @param  \App\Models\Pdf $pdf
     * @return void
     */
    public function deleted(Pdf $pdf)
    {
        $this->deletePdfFile($pdf);
    }

    /**
     * Delete a pdf from file.
     *
     * @param  \App\Models\Pdf $pdf
     * @return void
     */
    private function deletePdfFile($pdf)
    {
        $pdfDirectory = 'public/uploads/edicts/' . $pdf->edict_id;
        $pdfPath = $pdfDirectory . '/' . $pdf->pdf;

        Storage::delete($pdfPath);
    }

    /**
     * Save file in disk
     *
     * @param  \App\Models\Pdf $pdf
     * @return void
     */
    private function savePdfFile($pdf)
    {
        if ($pdf->pdf != null) {
            $date = now()->toShortDateTime();
            $pdfName = Str::slug($pdf->edict_id . '-' . $pdf->name . '-' . $date, '-') . '.' . $pdf->pdf->extension();
            $storePath = 'uploads/edicts/' . $pdf->edict_id;

            $pdf->pdf->storeAs($storePath, $pdfName, 'public');
            $pdf->pdf = $pdfName;
        }
    }
}
