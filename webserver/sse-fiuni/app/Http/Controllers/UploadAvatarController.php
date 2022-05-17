<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Resources\MediaResource;

class UploadAvatarController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        var_dump($request->all());die;
/**
 *
        $type = $request->get('type');
        $mediaItem = null;

        if ($type == 'post') {
            $post = Post::findOrFail($id);
            $mediaItem = $post->addMediaFromBase64($request->image)

 *
 */
    }
}
