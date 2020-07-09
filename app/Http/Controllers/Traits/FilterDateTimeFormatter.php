<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;

trait FilterDateTimeFormatter
{
    public function filterDateTimeFormat(&$data, $keys, $format = 'd/m/Y H:i')
    {
        foreach ($keys as $key) {
            $validator = Validator::make($data, [
                $key  => 'date_format:' . $format,
            ]);
            if ($validator->fails()) {
                unset($data[$key]);
            }
        }
    }
}
