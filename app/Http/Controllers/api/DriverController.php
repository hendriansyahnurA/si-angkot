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

        return Response::json(['data' => $Driver]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "nama_lengkap" => "required|string|max:255",
                "alamat" => "required|string",
                "no_tlp" => "required|string|min:12|unique:driver",
                "email" => "required|string|email|unique:driver",
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

        return Response::json(['message' => 'Data Berhasil di Tambahkan'], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "nama_lengkap" => "required|string|max:255",
                "alamat" => "required|string",
                "no_tlp" => "required|string|min:12|unique:driver,no_tlp," . $id,
                "email" => "required|string|email|unique:driver,email," . $id,
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

        $Driver = Driver::findOrFail($id);

        $validatedData = $validator->validated();

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $Driver->update($validatedData);

        return Response::json(["message" => 'Data Driver Berhasil di Update'], 200);
    }

    public function delete($id)
    {
        $Driver = Driver::findOrFail($id);
        $Driver->delete();
        return Response::json(['message' => 'Data Driver Berhasil di Hapus'], 200);
    }
}
