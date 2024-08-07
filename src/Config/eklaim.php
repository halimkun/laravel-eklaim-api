<?php

return [
    /**
     * URL dasar untuk API EKlaim.
     * URL ini digunakan untuk mengakses layanan API EKlaim.
     *
     * @var string
     */
    'api_url' => env('EKLAIM_API_URL'),

    /**
     * Kunci rahasia yang digunakan untuk otentikasi dengan API EKlaim.
     * Kunci ini digunakan untuk memastikan bahwa permintaan ke API adalah sah.
     *
     * @var string
     */
    'secret_key' => env('EKLAIM_SECRET_KEY'),

    /**
     * Menentukan apakah respons dari API EKlaim harus didekripsi.
     * Jika true, respons dari API akan didekripsi sebelum digunakan.
     *
     * @var bool
     */
    'decrypt_response' => true,

    /**
     * Menentukan apakah respons API harus dikembalikan sebagai JSON murni.
     * Jika true, respons dari API akan dikembalikan dalam format JSON tanpa perubahan.
     *
     * @var bool
     */
    'pure_json' => false,

    /**
     * Saluran logging yang digunakan untuk mencatat aktivitas API EKlaim.
     * Saluran ini digunakan untuk menyimpan log aktivitas yang berkaitan dengan penggunaan API.
     *
     * @var string
     */
    'log_channel' => env('LOG_CHANNEL', 'stack'),
];
