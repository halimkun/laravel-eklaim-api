<?php

use Illuminate\Support\Facades\Route;

use FaisalHalim\LaravelEklaimApi\Controllers\Covid19Controller;
use FaisalHalim\LaravelEklaimApi\Controllers\DeleteKlaimController;
use FaisalHalim\LaravelEklaimApi\Controllers\DiagnosisController;
use FaisalHalim\LaravelEklaimApi\Controllers\DiagnosisInaController;
use FaisalHalim\LaravelEklaimApi\Controllers\FinalKlaimController;
use FaisalHalim\LaravelEklaimApi\Controllers\GetKlaimDataController;
use FaisalHalim\LaravelEklaimApi\Controllers\GetKlaimNumberController;
use FaisalHalim\LaravelEklaimApi\Controllers\GetKlaimStatusController;
use FaisalHalim\LaravelEklaimApi\Controllers\GroupKlaimController;
use FaisalHalim\LaravelEklaimApi\Controllers\NewKlaimController;
use FaisalHalim\LaravelEklaimApi\Controllers\PatientController;
use FaisalHalim\LaravelEklaimApi\Controllers\PrintKlaimController;
use FaisalHalim\LaravelEklaimApi\Controllers\ProceduresController;
use FaisalHalim\LaravelEklaimApi\Controllers\ProceduresInaController;
use FaisalHalim\LaravelEklaimApi\Controllers\PullKlaimController;
use FaisalHalim\LaravelEklaimApi\Controllers\ReEditKlaimController;
use FaisalHalim\LaravelEklaimApi\Controllers\SendKlaimController;
use FaisalHalim\LaravelEklaimApi\Controllers\SendKlaimIndividualController;
use FaisalHalim\LaravelEklaimApi\Controllers\SetKlaimDataController;
use FaisalHalim\LaravelEklaimApi\Controllers\SitbInValidateController;
use FaisalHalim\LaravelEklaimApi\Controllers\SitbValidateController;

Route::as("e-klaim.")->middleware('api')->prefix('eklaim')->group(function () {
    // =====> method : new_claim
    Route::post('/new', [NewKlaimController::class, 'handle'])->name('new.claim');

    // =====> method : set_claim_data
    Route::post('/{sep}', [SetKlaimDataController::class, 'handle'])->name('set.claim.data');

    // =====> method : generate_claim_number
    Route::get('/get/number', [GetKlaimNumberController::class, 'handle'])->name('get.claim.number');

    // =====> method : get_claim_data
    Route::get('/{sep}', [GetKlaimDataController::class, 'handle'])->name('get.claim.data');

    // =====> method : get_claim_status
    Route::get('/{sep}/status', [GetKlaimStatusController::class, 'handle'])->name('get.claim.status');

    // // =====> method : delete_claim
    // Route::post('/delete', [DeleteKlaimController::class, 'handle'])->name('delete.claim');

    // // =====> method : reedit_claim
    // Route::post('/reedit', [ReEditKlaimController::class, 'handle'])->name('reedit.claim');

    // // =====> method : send_claim
    // Route::post('/send', [SendKlaimController::class, 'handle'])->name('send.claim');

    // // =====> method : send_claim_individual
    // Route::post('/send/{sep}', [SendKlaimIndividualController::class, 'handle'])->name('send.claim.individual');

    // // =====> method : claim_print
    // Route::post('/print/{sep}', [PrintKlaimController::class, 'handle'])->name('print.claim');

    // // =====> method : pull_claim
    // Route::post('/pull', [PullKlaimController::class, 'handle'])->name('pull.claim');

    // // =====> method : claim_final
    // Route::post('/final', [FinalKlaimController::class, 'handle'])->name('final.claim');


    // Route::as('sitb.')->prefix('sitb')->group(function () {
    //     // =====> method : sitb_validate
    //     Route::post('/validate', [SitbValidateController::class, 'handle'])->name('validate');

    //     // =====> method : sitb_invalidate
    //     Route::post('/invalidate/{sep}', [SitbInValidateController::class, 'handle'])->name('invalidate');
    // });

    Route::as('patient.')->prefix('patient')->group(function () {
        // =====> method : update_patient
        Route::post('/{no_rekam_medis}', [PatientController::class, 'update'])->name('update');

        // =====> method : delete_patient
        Route::delete('/{no_rekam_medis}/{coder_nik}', [PatientController::class, 'delete'])->name('delete');
    });

    // Route::as('group.')->prefix('group')->group(function () {
    //     // =====> method : grouper, stage:  1
    //     Route::post('/stage/1', [GroupKlaimController::class, 'stage1'])->name('stage.1');

    //     // =====> method : grouper, stage:  2
    //     Route::post('/stage/2', [GroupKlaimController::class, 'stage2'])->name('stage.2');
    // });

    // Route::as('covid19.')->prefix('covid19')->group(function () {
    //     // =====> method : search_diagnosis
    //     Route::post('/status', [Covid19Controller::class, 'handle'])->name('status');
    // });

    Route::as('diagnosis.')->prefix('diagnosis')->group(function () {
        // =====> method : search_diagnosis
        Route::post('/search', [DiagnosisController::class, 'handle'])->name('search');

        // =====> method : search_diagnosis_inagrouper
        Route::post('/search/ina', [DiagnosisInaController::class, 'handle'])->name('search.ina');
    });

    Route::as('procedures.')->prefix('procedures')->group(function () {
        // =====> method : search_procedures
        Route::post('/search', [ProceduresController::class, 'handle'])->name('search');

        // =====> method : search_procedures_inagrouper
        Route::post('/search/ina', [ProceduresInaController::class, 'handle'])->name('search.ina');
    });

    // Route::as('file.')->prefix('file')->group(function () {
    //     // =====> method : file_get
    //     Route::post('/{sep}', [NewKlaimController::class, 'get'])->name('get');

    //     // =====> method : file_upload
    //     Route::post('/upload', [NewKlaimController::class, 'upload'])->name('upload');

    //     // =====> method : file_delete
    //     Route::post('/delete', [NewKlaimController::class, 'delete'])->name('delete');
    // });
});
