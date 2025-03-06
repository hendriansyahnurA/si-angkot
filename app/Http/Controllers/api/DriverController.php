<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    public function index()
    {
        $Driver = Driver::all();

        return Response::json($Driver);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "nama_lengkap" => "required|string|max:255",
                "alamat" => "required|string",
                "no_tlp" => "required|string|min:12|unique:orang_tua",
                "email" => "required|string|email|unique:orang_tua",
                "password" => "required|string|min:8",
            ],
            [
                "nama_lengkap" => "Format Tidak Sesuai",
                "alamat" => "Alamat Tidak Sesuai",
                "no_tlp.unique" => "Nomer Telfon sudah digunakan",
                "email.unique" => "email sudah digunakan",
                "password" => "password minimal 8 karakter",
            ]
        );

        if ($validator->fails()) {
            return Response::json($validator->errors(), 422);
        }
        $Driver = Driver::create([
            "nama_lengkap" => $request->nama_lengkap,
            "alamat" => $request->alamat,
            "no_tlp" => $request->no_tlp,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        return Response::json(['Driver' => $Driver], 201);
    }

    public function show($id) {}
    public function update($id, Request $request) {}
    public function delete($id) {}
}
