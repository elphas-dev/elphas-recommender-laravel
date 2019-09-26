<?php

return [

    /*
     * The API key of your Elphas Recommender app.
     */
    'apiKey' => env('RECOMMENDER_APIKEY'),

    /*
     *  The Secret key of your Elphas Recommender app.
     */
    'secretKey' =>  env('RECOMMENDER_SECRETKEY'),


	/*
   *  The Secret key of your Elphas Recommender app.
   */
	'baseUri' =>  env('RECOMMENDER_BASE_URL', 'http://recommender.test.alledaags.net/api/v1/'),

];
