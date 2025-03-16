<?php

use App\Http\Controllers\api\AnakController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\DriverController;
use App\Http\Controllers\api\OrangtuaController;
use Illuminate\Support\Facades\Route;


Route::prefix("auth")->group(function () {
  // Route::get("/", [AuthController::class, 'index']);
  Route::post("/registrasi", [AuthController::class, 'registrasi']);
  Route::post("/login", [AuthController::class, 'login']);
});

Route::prefix("admin")->middleware(["auth:sanctum"])->group(function () {
  Route::get("/user", [AuthController::class, "index"]);
  Route::put('/verifikasi/{id}', [AnakController::class, 'updateStatus']);
});

Route::prefix("orang-tua")->middleware(["auth:sanctum"])->group(function () {
  Route::get("/notifications", [OrangtuaController::class, "getNotifications"]);
  Route::get("/", [OrangtuaController::class, "index"]);
  Route::get("/{id}", [OrangtuaController::class, "show"]);
  Route::post("/add-ortu", [OrangtuaController::class, "store"]);
  Route::put("/{id}/update-ortu", [OrangtuaController::class, "update"]);
  Route::delete("/{id}/delete-ortu", [OrangtuaController::class, "delete"]);
});

Route::prefix("driver")->middleware(["auth:sanctum"])->group(function () {
  Route::get("/", [DriverController::class, "index"]);
  Route::post("/add-driver", [DriverController::class, "store"]);
  Route::put("/{id}/update-driver", [DriverController::class, "update"]);
  Route::delete("/{id}/delete-driver", [DriverController::class, "delete"]);
});

Route::prefix("anak")->middleware(["auth:sanctum"])->group(function () {
  Route::get("/show-ortu", [AnakController::class, "getOrangtua"]);
  Route::get("/", [AnakController::class, "index"]);
  Route::post("/add-anak", [AnakController::class, "store"]);
  Route::put("/{id}/update-anak", [AnakController::class, "update"]);
  Route::delete("/{id}/delete-anak", [AnakController::class, "delete"]);
});
