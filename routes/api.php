<?php

Route::post('/login', 'Api\Auth\LoginController@login');

Route::post('/register', 'Api\Auth\RegisterController@register');

Route::get('/email/verify/{id}', 'Api\Auth\VerificationController@verify')
  ->name('email.verify')
  ->middleware('signed');

Route::post('/password/forgot', 'Api\Auth\ForgotPasswordController@getPasswordResetToken')
  ->name('password.forgot');

Route::post('/password/reset', 'Api\Auth\ForgotPasswordController@resetPassword')
  ->name('password.reset');
