<?php

namespace App\Http\Controllers;

use Exception;
use App\Ethereal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
        if ($data = Auth::user()->profile_image) {
            $data = explode("\n", $data);
            [$mime, $size] = explode(':', array_shift($data));
            $avatar = implode("\n", $data);
        } else {
            $path = resource_path('img/profile-image.jpg');
            $mime = filetype($path);
            $size = filesize($path);
            $avatar = file_get_contents($path);
        }

        header('Content-Type: ' . $mime);
        header('Content-Length: ' . $size);

        die($avatar);
    }

    public function update()
    {
        $user = Auth::user();
        $image = request('image');
        try {
            $mime = $image->getMimeType();
        } catch (Exception $e) {
            $mime = $_FILES['image']['type'] ?? null;
        }
        if (!in_array($mime, $this->allowFileTypes)) {
            session(['status' => 'Please upload one of theses type of image: ' . implode(', ', $this->allowFileTypes)]);
            return redirect()->back();
        }
        $path = $image->getRealPath();
        $image = Ethereal::resize_image($path, 320, 320);
        if (!$image) {
            session(['status' => 'Unable to upload that image']);
            return redirect()->back();
        }
        $size = strlen($image);
        $user->profile_image = implode("\n", [implode(':', [$mime, $size]), $image]);
        $user->save();
        session(['status' => 'Updated profile image']);
        return  redirect()->back();
    }
}
