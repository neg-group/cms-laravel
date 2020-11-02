<?php

namespace App;

use Throwable;

class Ethereal
{
    static public function resize_image(string $file, int $w, int $h, bool $crop = false)
    {
        if (!file_exists($file)) return false;
        $result = false;
        $tmp = tempnam(storage_path(), 'tmp');
        try {
            [$width, $height] = getimagesize($file);
            $r = $width / $height;
            if ($crop) {
                if ($width > $height) {
                    $width = ceil($width - ($width * abs($r - $w / $h)));
                } else {
                    $height = ceil($height - ($height * abs($r - $w / $h)));
                }
                $newwidth = $w;
                $newheight = $h;
            } else {
                if ($w / $h > $r) {
                    $newwidth = $h * $r;
                    $newheight = $h;
                } else {
                    $newheight = $w / $r;
                    $newwidth = $w;
                }
            }
            $src = imagecreatefromjpeg($file);
            $dst = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            imagepng($dst, $tmp);
        } catch (Throwable $e) {
            error_log($e->getMessage(), 4);
        }
        if (file_exists($tmp)) {
            $result = file_get_contents($tmp);
            unlink($tmp);
        }
        return $result;
    }
}
