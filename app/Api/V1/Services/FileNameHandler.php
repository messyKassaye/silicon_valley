<?php


namespace App\Api\V1\Services;


class FileNameHandler
{

    public function createFileName($message){


        $key = "tHeApAcHe6410111";
        $enc = encrypt($message, $key);
        echo "Encrypted : " . $enc . "</br>";
        $dec = decrypt($enc, $key);
        echo "Decrypted : " . $dec;
    }

    function encrypt($data, $key)
    {
        return base64_encode(openssl_encrypt($data, "aes-128-ecb", $key, OPENSSL_RAW_DATA));
    }

    function decrypt($data, $key)
    {
        return openssl_decrypt(base64_decode($data), "aes-128-ecb", $key, OPENSSL_RAW_DATA);
    }
}