<?php

// route for github webhook api
Route::group(['prefix' => '/v1', 'namespace' => 'API\V1', 'as' => 'api.'], function () {
    Route::match(['get', 'post'], '/{$slug}', 'WebhookController@runDeploy');
});
