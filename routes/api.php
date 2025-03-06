<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\OrangtuaController;
use Illuminate\Support\Facades\Route;


Route::prefix("auth")->group(function () {
  // Route::get("/", [AuthController::class, 'index']);
  Route::post("/registrasi", [AuthController::class, 'registrasi']);
  Route::post("/login", [AuthController::class, 'login']);
});

Route::prefix("admin")->middleware(["auth:sanctum"])->group(function () {
  Route::get("/user", [AuthController::class, "index"]);
});

Route::prefix("orang-tua")->middleware(["auth:sanctum"])->group(function () {
  Route::get("/", [OrangtuaController::class, "index"]);
  Route::post("/add-ortu", [OrangtuaController::class, "store"]);
  Route::put("/update-ortu", [OrangtuaController::class, "update"]);
  Route::delete("/delete-ortu", [OrangtuaController::class, "delete"]);
});

Route::prefix("driver")->middleware(["auth:sanctum"])->group(function () {});
