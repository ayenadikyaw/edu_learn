<?php

use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\CourseLevelController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentEnrollController;

Route::get('/course_categories',[CourseCategoryController::class,'index']);
Route::get('/course_levels',[CourseLevelController::class,'index']);

Route::get('/notifications/{user}',[NotificationController::class,'getNotifications']);
Route::post('/notifications/{notification}/mark-as-read',[NotificationController::class,'markAsRead']);

