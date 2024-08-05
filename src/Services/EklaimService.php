<?php

namespace FaisalHalim\LaravelEklaimApi\Services;

use FaisalHalim\LaravelEklaimApi\Helpers\EKlaimCrypt;
use FaisalHalim\LaravelEklaimApi\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Http;
use FaisalHalim\LaravelEklaimApi\Services\EklaimResponse;

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
        self::$apiUrl    = $apiUrl;
        self::$secretKey = $secretKey;
        self::$encryptor = $encryptor;
    }

    /**
     * Mengirimkan data ke API E-KLAIM dan mengembalikan respons yang diterima.
     * 
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public static function send($data)
    {
        $encryptedData = self::$encryptor::encrypt(json_encode($data), self::$secretKey);
        $encryptedData = trim(preg_replace('/\s+/', '', $encryptedData));

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post(self::$apiUrl, [$encryptedData]);
        } catch (\Throwable $th) {
            \Log::channel(config('eklaim.log_channel'))->error("E-KLAIM API Error", [
                'data'     => $data,
                'response' => $th->getMessage(),
            ]);

            return self::response(ResponseHelper::error());
        }

        $data = self::extract($response);

        if (config('eklaim.decrypt_response', false)) {
            $data = self::$encryptor::decrypt($data, self::$secretKey);
        }

        return self::response($data);
    }


    /**
     * Mengembalikan respons dalam format JSON dengan kode status yang sesuai.
     * 
     * @param string $data
     * @return FaisalHalim\LaravelEklaimApi\Services\EklaimResponse
     * */
    protected static function response($data)
    {
        $decodedData = ResponseHelper::decode($data, true);
        $statusCode = self::getResponseStatusCode($data);

        if (config('eklaim.auto_response', false)) {
            return new EklaimResponse($decodedData, $statusCode);
        }

        return response($decodedData, $statusCode);
    }


    /**
     * Mengekstrak data dari respons API dengan memotong bagian yang tidak diperlukan.
     * 
     * @param string $response
     * @return string
     */
    protected static function extract($response)
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
