<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Resources\MediaResource;
use App\Models\User;
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
        $user_id = intval($request->input('user_id'));
        if ($user_id !== $this->getUser()->id && !$this->getUser()->hasRole(User::ROLE_ADMINISTRADOR)) {
            return view('error_permisos');
        } else {
            $user = User::find($user_id);
            $dirname = 'temp/'.$user_id;
            $imageName = time().'.'.$request->avatar->extension();
            $path = url('/storage/'.$request->file('avatar')->storeAs(
                $dirname,
                $imageName,
                'local'
            ));
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
            return back()->withInput();
        }
    }
}
