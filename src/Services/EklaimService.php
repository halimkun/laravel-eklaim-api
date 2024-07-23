<?php

namespace FaisalHalim\LaravelEklaimApi\Services;

use FaisalHalim\LaravelEklaimApi\Helpers\EKlaimCrypt;
use Illuminate\Support\Facades\Http;

class EklaimService
{
    protected $apiUrl;
    protected $secretKey;
    protected $encryptor;

    public function __construct($apiUrl, $secretKey, EKlaimCrypt $encryptor)
    {
        $this->apiUrl    = $apiUrl;
        $this->secretKey = $secretKey;
        $this->encryptor = $encryptor;
    }

    public function post($data)
    {
        $encryptedData = $this->encryptor::encrypt(json_encode($data), $this->secretKey);
        
        // ensure the data is correctly formatted as a single-line string
        $encryptedData = trim(preg_replace('/\s+/', '', $encryptedData));

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post($this->apiUrl, [ $encryptedData, ]);
        } catch (\Throwable $th) {
            throw new \Exception("Failed to submit data to eklaim API: " . $th->getMessage());
        }

        $first = strpos($response, "\n") + 1;
        $last  = strrpos($response, "\n") - 1;
        $data  = substr($response, $first, strlen($response) - $first - $last);

        return $data;
    }
}
