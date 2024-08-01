<?php

namespace FaisalHalim\LaravelEklaimApi\Services;

use FaisalHalim\LaravelEklaimApi\Helpers\EKlaimCrypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class EklaimService
{
    /**
     * URL API yang digunakan untuk mengirimkan permintaan.
     * 
     * @var string
     */
    protected static $apiUrl;

    /**
     * Kunci rahasia yang digunakan untuk enkripsi dan dekripsi.
     * 
     * @var string
     */
    protected static $secretKey;

    /**
     * Objek untuk melakukan enkripsi dan dekripsi.
     * 
     * @var EKlaimCrypt
     */
    protected static $encryptor;

    /**
     * Mengkonfigurasi layanan EklaimService dengan URL API, kunci rahasia, dan objek enkripsi.
     * 
     * @param string $apiUrl
     * @param string $secretKey
     * @param EKlaimCrypt $encryptor
     * @return void
     */
    public static function configure($apiUrl, $secretKey, EKlaimCrypt $encryptor)
    {
        self::$apiUrl = $apiUrl;
        self::$secretKey = $secretKey;
        self::$encryptor = $encryptor;
    }

    /**
     * Mengirim data yang dienkripsi ke API eklaim dan mengembalikan respons yang diproses.
     * 
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public static function post($data)
    {
        $encryptedData = self::$encryptor::encrypt(json_encode($data), self::$secretKey);
        $encryptedData = trim(preg_replace('/\s+/', '', $encryptedData));

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post(self::$apiUrl, [$encryptedData]);
        } catch (\Throwable $th) {
            \Log::channel(config('eklaim.log_channel', 'default'))->error("E-KLAIM API Error", [
                'data' => $data,
                'response' => $th->getMessage(),
            ]);

            if (config('eklaim.json_response')) {
                return Response::json([
                    'metadata' => [
                        'code'    => 500,
                        'message' => 'Internal Server Error',
                    ]
                ], 500);
            }

            throw new \Exception("Internal Server Error");
        }

        $data = self::extractResponseData($response);

        if (config('eklaim.decrypt_response', false)) {
            $data = self::$encryptor::decrypt($data, self::$secretKey);
        }

        return config('eklaim.json_response', false) ? Response::json(json_decode($data), self::getResponseStatusCode($data)) : $data;
    }

    /**
     * Mengekstrak data dari respons API dengan memotong bagian yang tidak diperlukan.
     * 
     * @param string $response
     * @return string
     */
    protected static function extractResponseData($response)
    {
        $first = strpos($response, "\n") + 1;
        $last = strrpos($response, "\n") - 1;
        return substr($response, $first, strlen($response) - $first - $last);
    }

    /**
     * Mendapatkan kode status dari respons yang telah didekripsi.
     * 
     * @param string $data
     * @return int
     */
    protected static function getResponseStatusCode($data)
    {
        $jsonData = json_decode($data);
        return $jsonData->metadata->code ?? 200;
    }
}
