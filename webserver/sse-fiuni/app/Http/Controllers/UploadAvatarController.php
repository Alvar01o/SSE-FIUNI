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
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        $dirname = 'temp/'.$this->getUser()->id;
        $imageName = time().'.'.$request->avatar->extension();
        $path = url('/storage/'.$request->file('avatar')->storeAs(
            $dirname,
            $imageName,
            'local'
        ));
        $user = $this->getUser();
        $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        return back()->withInput();
    }
}
