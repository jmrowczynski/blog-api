<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    public function store(Request $request)
    {
        $fields = $request->validate([
            'image' => 'file|mimes:png,jpg,jpeg|max:3072|required'
        ]);

            $image = $fields['image'];
            $directoryName = now()->year . '-' . now()->month;
            return ['image_url' => asset(Storage::url($image->store('public/images/' . $directoryName)))];
    }
}
