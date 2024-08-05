<?php

use Illuminate\Support\Facades\Route;

use FaisalHalim\LaravelEklaimApi\Controllers\SitbController;
use FaisalHalim\LaravelEklaimApi\Controllers\KlaimController;
use FaisalHalim\LaravelEklaimApi\Controllers\Covid19Controller;
use FaisalHalim\LaravelEklaimApi\Controllers\PatientController;
use FaisalHalim\LaravelEklaimApi\Controllers\DiagnosisController;
use FaisalHalim\LaravelEklaimApi\Controllers\GroupKlaimController;
use FaisalHalim\LaravelEklaimApi\Controllers\ProceduresController;

Route::as("e-klaim.")->middleware('api')->prefix('eklaim')->group(function () {
    // =====> method : new_claim
    Route::post('/new', [KlaimController::class, 'new'])->name('new.claim');

    // =====> method : send_claim
    Route::post('/send', [KlaimController::class, 'sendBulk'])->name('send.claim');

    // =====> method : claim_final
    Route::post('/final', [KlaimController::class, 'final'])->name('final.claim');

    // =====> method : pull_claim || =====>  method sudah ditutup (Manual Web Service 5.8.3b)
    // Route::post('/pull', [PullKlaimController::class, 'handle'])->name('pull.claim');

    // =====> method : set_claim_data
    Route::post('/{sep}', [KlaimController::class, 'set'])->name('set.claim.data');

    // =====> method : generate_claim_number
    Route::get('/get/number', [KlaimController::class, 'generateNumber'])->name('get.claim.number');

    // =====> method : get_claim_data
    Route::get('/{sep}', [KlaimController::class, 'get'])->name('get.claim.data');

    // =====> method : get_claim_status
    Route::get('/{sep}/status', [KlaimController::class, 'getStatus'])->name('get.claim.status');

    // =====> method : reedit_claim
    Route::get('/{sep}/re-edit', [KlaimController::class, 'reEdit'])->name('reedit.claim');

    // =====> method : send_claim_individual
    Route::get('/{sep}/send', [KlaimController::class, 'send'])->name('send.claim.individual');

    // =====> method : claim_print
    Route::get('/{sep}/print', [KlaimController::class, 'print'])->name('print.claim');

    // =====> method : delete_claim
    Route::delete('/{sep}', [KlaimController::class, 'delete'])->name('delete.claim');


    Route::as('sitb.')->prefix('sitb')->group(function () {
        // =====> method : sitb_validate
        Route::post('/validate', [SitbController::class, 'validateSitb'])->name('validate');

        // =====> method : sitb_invalidate
        Route::post('/invalidate/{sep}', [SitbController::class, 'inValidateSitb'])->name('invalidate');
    });

    Route::as('patient.')->prefix('patient')->group(function () {
        // =====> method : update_patient
        Route::post('/{no_rekam_medis}', [PatientController::class, 'update'])->name('update');

        // =====> method : delete_patient
        Route::delete('/{no_rekam_medis}', [PatientController::class, 'delete'])->name('delete');
    });

    Route::as('group.')->prefix('group')->group(function () {
        // =====> method : grouper, stage:  1
        Route::post('/stage/1', [GroupKlaimController::class, 'stage1'])->name('stage.1');

        // =====> method : grouper, stage:  2
        Route::post('/stage/2', [GroupKlaimController::class, 'stage2'])->name('stage.2');
    });

    // Route::as('covid19.')->prefix('covid19')->group(function () {
    //     // =====> method : search_diagnosis
    //     Route::post('/status', [Covid19Controller::class, 'handle'])->name('status');
    // });

    Route::as('diagnosis.')->prefix('diagnosis')->group(function () {
        // =====> method : search_diagnosis
        Route::post('/search', [DiagnosisController::class, 'search'])->name('search');

        // =====> method : search_diagnosis_inagrouper
        Route::post('/search/ina', [DiagnosisController::class, 'searchIna'])->name('search.ina');
    });

    Route::as('procedures.')->prefix('procedures')->group(function () {
        // =====> method : search_procedures
        Route::post('/search', [ProceduresController::class, 'search'])->name('search');

        // =====> method : search_procedures_inagrouper
        Route::post('/search/ina', [ProceduresController::class, 'searchIna'])->name('search.ina');
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
