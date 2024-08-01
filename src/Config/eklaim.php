<?php

return [
    /**
     * URL dasar untuk API E-KLAIM. Nilai ini diambil dari variabel lingkungan
     * EKLAIM_API_URL yang diatur di file .env. URL ini digunakan untuk membuat
     * permintaan ke API E-KLAIM.
     *
     * @var string
     */
    'api_url' => env('EKLAIM_API_URL'),

    /**
     * Kunci rahasia yang digunakan untuk enkripsi dan dekripsi data.
     * Nilai ini diambil dari variabel lingkungan EKLAIM_SECRET_KEY yang diatur
     * di file .env. Kunci ini harus dalam format hexadecimal dan panjang 256-bit.
     *
     * @var string
     */
    'secret_key' => env('EKLAIM_SECRET_KEY'),

    /**
     * Menentukan apakah respons dari API harus didekripsi.
     * Jika diatur ke true, data respons yang diterima dari API akan didekripsi
     * menggunakan kunci rahasia yang diberikan. Secara default, dekripsi dinonaktifkan.
     *
     * @var bool
     */
    'decrypt_response' => true,

    /**
     * Menentukan apakah respons dari API harus diubah secara otomatis ke format JSON.
     * Jika diatur ke true, respons yang diterima akan secara otomatis dikemas dalam
     * format JSON sebelum dikembalikan. Berguna untuk menjaga konsistensi format respons.
     *
     * @var bool
     */
    'json_response' => true,

    /**
     * Nama saluran log yang digunakan untuk mencatat kesalahan yang terjadi
     * selama interaksi dengan API E-KLAIM. Secara default, kesalahan akan dicatat
     * ke saluran log 'default'. Anda dapat mengubah ini untuk mencatat ke saluran log
     * yang berbeda yang telah dikonfigurasi di file konfigurasi logging.
     *
     * @var string
     */
    'log_channel' => 'default',
];
