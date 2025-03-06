<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class OrangtuaController extends Controller
{
    public function index()
    {
        $Orangtua = OrangTua::all();
        return Response::json($Orangtua);
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

        $Orangtua = OrangTua::create([
            "nama_lengkap" => $request->nama_lengkap,
            "alamat" => $request->alamat,
            "no_tlp" => $request->no_tlp,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        return Response::json(['Orangtua' => $Orangtua], 201);
    }

    public function show($id)
    {
        $Orangtua = OrangTua::findOrFail($id);
        return Response::json(['Orangtua' => $Orangtua]);
    }
    public function update($id, Request $request)
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

        $Orangtua = OrangTua::findOrFail($id);
        $Orangtua->save();

        return Response::json(["Orangtua" => 'Data Orang Tua Berhasil di Update'], 200);
    }

    public function delete($id)
    {
        $Orangtua = OrangTua::findOrFail($id);
        $Orangtua->delete();
        return Response::json(["message" => 'Data Orang Tua berhasil dihapus'], 200);
    }
}
