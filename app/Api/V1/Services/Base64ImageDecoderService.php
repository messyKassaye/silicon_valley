<?php


namespace App\Api\V1\Services;


class Base64ImageDecoderService
{

    public function decode($imageString){
        $imageData = base64_decode($imageString);
        $source = imagecreatefromstring($imageData);
        $angle = 90;
        $rotate = imagerotate($source, $angle, 0); // if want to rotate the image
        $imageName = "hello1.png";
        $imageSave = imagejpeg($rotate,$imageName,100);
        imagedestroy($source);
    }
}