<?php

// route for github webhook api
Route::group(['prefix' => 'v1', 'as' => 'api.'], function() {
    Route::post('{slug}', 'WebhookController@runDeploy');
});

