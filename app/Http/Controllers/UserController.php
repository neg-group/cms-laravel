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
        if (!$user = auth()->user()) {
            return new Response('401 (Unauthorized) status code indicates that the request has not been applied because it lacks valid authentication credentials for the target resource.', 401);
        }
        if (!$image = $_FILES['image'] ?? null) {
            session(['status' => 'Please upload an image']);
            return redirect()->back();
        };
        if (!in_array($mime = $image['type'], $this->allowFileTypes)) {
            session(['status' => 'Please upload image type of (' . implode(', ', $this->allowFileTypes), ').']);
            return redirect()->back();
        }
        $size = $image['size'];
        $path = $image['tmp_name'];
        $image = file_get_contents($path);
        $user->profile_image = implode("\n", [implode(':', [$mime, $size]), $image]);

        call_user_func([$user, 'save']) &&
            session(['status' => 'Updated profile image']);

        header("Content-Type: $mime");
        header("Content-Length: $size");

        return  redirect()->back();
    }
}
