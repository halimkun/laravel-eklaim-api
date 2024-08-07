<?php

namespace Halim\EKlaim\Helpers;

class EKlaimCrypt
{
    /**
     * Mengenkripsi data menggunakan algoritma AES-256-CBC dan menghasilkan output yang
     * di-encode dalam format base64.
     *
     * @param string $data Data yang akan dienkripsi.
     * @param string $secreteKey Kunci rahasia 256-bit yang digunakan untuk enkripsi.
     * @return string Data yang telah dienkripsi dan di-encode dalam format base64.
     * @throws \Exception Jika panjang kunci tidak sesuai atau terjadi kesalahan enkripsi.
     */
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

    /**
     * Mendekripsi data yang telah dienkripsi menggunakan algoritma AES-256-CBC.
     *
     * @param string $encryptedData Data yang telah dienkripsi dan di-encode dalam format base64.
     * @param string $secreteKey Kunci rahasia 256-bit yang digunakan untuk dekripsi.
     * @return string Data yang telah didekripsi.
     * @throws \Exception Jika panjang kunci tidak sesuai, tanda tangan tidak cocok, atau terjadi kesalahan dekripsi.
     */
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

    /**
     * Membandingkan dua string dalam waktu konstan untuk menghindari serangan timing attack.
     *
     * @param string $str1 String pertama yang akan dibandingkan.
     * @param string $str2 String kedua yang akan dibandingkan.
     * @return bool True jika kedua string cocok, False jika tidak.
     */
    private static function compare($str1, $str2)
    {
        $len = strlen($str1);
        $result = 0;

        if ($len !== strlen($str2)) return false;

        for ($i = 0; $i < $len; $i++) {
            $result |= ord($str1[$i]) ^ ord($str2[$i]);
        }

        return $result === 0;
    }
}
