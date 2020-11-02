<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected $allowFileTypes = [
        'image/png', 'image/jpeg', 'image/jpg'
    ];

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function profile()
    {
        $user = auth()->user();
        if (!$user) {
            return new Response(null, 403);
        }

        if ($data = $user->profile_image) {
            $data = explode("\n", $data);
            [$mime, $size] = explode(':', array_shift($data));
            $avatar = implode("\n", $data);
            die($avatar);
            $avatar = base64_decode($avatar);
        } else {
            $path = resource_path('img/profile-image.jpg');
            $mime = filetype($path);
            $size = filesize($path);
            $avatar = file_get_contents($path);
        }
        // dd($avatar);
        return new Response($avatar, 200, [
            // 'Content-Type' => $mime,
            // 'Content-Length' => $size
        ]);
    }

    public function update()
    {
        $user = auth()->user();
        $image = request('image');
        if (!$user) {
            return new Response('401 (Unauthorized) status code indicates that the request has not been applied because it lacks valid authentication credentials for the target resource.', 401);
        }
        $status = $image ? 'Please upload an image' : 'Please upload one of theses type of image: ' . implode(', ', $this->allowFileTypes);
        $mime = $image->getMimeType();
        $size = $image->getMaxFilesize();
        $path = $image->getRealPath();
        $image = file_get_contents($path);
        if (!in_array($mime, $this->allowFileTypes)) {
            session(compact('status'));
            return redirect()->back();
        }
        $user->profile_image = implode("\n", [implode(':', [$mime, $size]), $image]);
        $user->save();
        session(['status' => 'Updated profile image']);
        return  redirect()->back();
    }
}
