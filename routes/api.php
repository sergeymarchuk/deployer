<?php

// route for github webhook api
//Route::post('test', 'WebhookController@runDeploy');
Route::group(['prefix' => 'v2', 'as' => 'api.'], function () {
});

Route::post('/v2/{slug}', 'WebhookController@runDeploy');

