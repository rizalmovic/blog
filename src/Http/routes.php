<?php

Route::group([
    'prefix' => 'blog',
    'namespace' => 'Rizalmovic\Blog'
], function(){

    Route::get('/', function(){
        return 'Hello';
    });

});