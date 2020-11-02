<?php


try {
    $d = resize_image(__DIR__ . '/resources/img/profile-image.jpg', 320, 320, true);
} catch (Throwable $err) {
    echo "\033[0;31m";
    var_dump($err);
    echo "\033[0m";
}
