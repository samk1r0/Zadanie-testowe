<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

Route::post('/form-submit', function (Request $request) {
    info(gettype($request));
    $validator = Validator::make( $request->only(['cloth', 'layout','leg_color']), [
        'cloth' => 'required',
        'layout' => 'required',
        'leg_color' => 'required'
        ]
    );
    if($validator->validated()){
        return $request;
    }
    return $validator->validated();
});
