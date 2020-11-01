<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function avatar()
    {
        $image = auth()->user()->profile_image;
        $response = new Response(null, 200);

        if (!$image) {
            $response->header('Content-Type', 'image/jpeg');
            $response->content(file_get_contents(asset('img/man.svg')));
            return $response;
        }
        $image = explode('base64,', $image);
        $avatar = end($image);
        $mime = explode('data:', $image[0])[1];
        $mime = explode(';', $mime)[1];
        $avatar = base64_decode($avatar);
        $response->content($avatar);
        $response->header('Content-Type', $mime);

        return $response;
    }

    public function update()
    {
        $avatar = request('image');
        $user = auth()->user();
        $user->profile_image = $avatar;
        $user->save();
        return redirect()->back();
    }
}
