<?php

use Illuminate\Support\Facades\Http;

/**
 * Generate a random string.
 *
 * @param  int  $length
 * @return string
 */

function success($data, $message = '', $status = 'success') {
    return response()->json([
        'data' => $data,
        'message' => $message,
        'status' => $status
    ], 200);
}

function error($data, $message = '') {
    return response()->json([
        'data' => $data,
        'message' => $message,
        'status' => 'error'
    ], 500);
}

function eventBriteRequest() {
    return Http::withHeaders([
        'Authorization' => 'Bearer ' . env('EVENTBRITE_API_KEY'),
    ])
    ->acceptJson();
}

function str_slug($name) {
    return Str::slug($name, '-');
}
