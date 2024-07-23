<?php

namespace FaisalHalim\LaravelEklaimApi\Helpers;

class EKlaimCrypt
{
    public static function encrypt($data, $secreteKey)
    {
        $key = hex2bin($secreteKey);

        if (mb_strlen($key, "8bit") !== 32) {
            throw new \Exception("Needs a 256-bit key!");
        }

        $iv_size = openssl_cipher_iv_length("aes-256-cbc");
        $iv = openssl_random_pseudo_bytes($iv_size);

        $encrypted = openssl_encrypt($data, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv);

        $signature = mb_substr(hash_hmac("sha256", $encrypted, $key, true), 0, 10, "8bit");

        $encoded = chunk_split(base64_encode($signature . $iv . $encrypted));

        return $encoded;
    }

    public static function decrypt($encryptedData, $secreteKey)
    {
        $key = hex2bin($secreteKey);

        if (mb_strlen($key, "8bit") !== 32) {
            throw new \Exception("Needs a 256-bit key!");
        }

        $iv_size = openssl_cipher_iv_length("aes-256-cbc");

        $decoded = base64_decode($encryptedData);
        $signature = mb_substr($decoded, 0, 10, "8bit");
        $iv = mb_substr($decoded, 10, $iv_size, "8bit");
        $encrypted = mb_substr($decoded, $iv_size + 10, NULL, "8bit");

        $calc_signature = mb_substr(hash_hmac("sha256", $encrypted, $key, true), 0, 10, "8bit");

        if (!self::compare($signature, $calc_signature)) {
            throw new \Exception("Signature doesn't match");
        }

        $decrypted = openssl_decrypt($encrypted, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv);

        return $decrypted;
    }

    private static function compare($str1, $str2)
    {
        $len = strlen($str1);
        $result = 0;
        
        if ($len !== strlen($str2))  return false;
        
        for ($i = 0; $i < $len; $i++) {
            $result |= ord($str1[$i]) ^ ord($str2[$i]);
        }
        
        return $result === 0;
    }
}
