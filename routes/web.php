<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get("/", [AuthController::class, 'index'])->name('login');
Route::post("/login", [AuthController::class, 'login'])->name('store');
Route::post("/logout", [AuthController::class, 'logout'])->name('logout');

Route::get("/registrasi", function () {
  return view("auth.registrasi");
});


Route::middleware(["role:admin"])->group(function () {
  Route::get("/Dashboard", function () {
    $token = session("token");
    return view("dashboard", compact("token"));
  });
  Route::get("/orangtua", function () {
    $token = session("token");
    return view("pages.OrangTua", compact("token"));
  });
});

Route::middleware(["role:admin"])->group(function () {});

Route::middleware(["role:anak"])->group(function () {
  Route::get("/anak", function () {
    return view("");
  });
});


Route::middleware(["auth:sanctum", "role:driver"])->group(function () {
  Route::get("/driver", function () {
    return view("");
  });
});
