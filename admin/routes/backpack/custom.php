<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('page', 'PageCrudController');
    Route::crud('translation', 'TranslationCrudController');
    Route::crud('settings', 'SettingsCrudController');
    Route::crud('post', 'PostCrudController');
    Route::crud('project', 'ProjectCrudController');
    Route::crud('service', 'ServiceCrudController');
    Route::crud('vacancy', 'VacancyCrudController');
    Route::crud('partner', 'PartnerCrudController');
    Route::crud('manager', 'ManagerCrudController');
    Route::crud('certificate', 'CertificateCrudController');
    Route::crud('license', 'LicenseCrudController');
    Route::crud('city', 'CityCrudController');
    Route::crud('callback', 'CallbackCrudController');
    Route::crud('service-callback', 'ServiceCallbackCrudController');
    Route::crud('jobapplication', 'JobApplicationCrudController');
    Route::crud('partnership', 'PartnershipCrudController');
}); // this should be the absolute last line of this file
