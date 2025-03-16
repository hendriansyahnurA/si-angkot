<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\OrangTua;
use App\Notifications\AnakNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AnakController extends Controller
{
    public function index()
    {
        $anak = Anak::with('orangtua:id,nama_lengkap')->get();
        return response()->json(['data' => $anak]);
    }

    public function getOrangtua()
    {
        $orangTua = OrangTua::select('id', 'nama_lengkap')->get();

        if ($orangTua->isEmpty()) {
            return response()->json(["message" => "Data orang tua tidak ditemukan"], 404);
        }
        return response()->json(['data' => $orangTua]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "nama_lengkap" => "required|string|max:255",
                "nisn" => "required|string|min:12|unique:anak,nisn",
                "sekolah" => "required|string",
                "alamat_sekolah" => "required|string",
                "no_tlp" => "required|string|min:12|unique:anak,no_tlp",
                "email" => "required|string|email|unique:anak,email",
                "password" => "required|string|min:8",
                "user_id" => "required|exists:orang_tua,id",
            ],
            [
                "nama_lengkap.required" => "Nama lengkap harus diisi",
                "nisn.unique" => "NISN sudah digunakan",
                "no_tlp.unique" => "Nomor telepon sudah digunakan",
                "email.unique" => "Email sudah digunakan",
                "password.min" => "Password minimal 8 karakter",
                "user_id.exists" => "Orang tua tidak ditemukan",
            ]
        );

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $anak = Anak::create([
            "nama_lengkap" => $request->nama_lengkap,
            "nisn" => $request->nisn,
            "sekolah" => $request->sekolah,
            "alamat_sekolah" => $request->alamat_sekolah,
            "no_tlp" => $request->no_tlp,
            "email" => $request->email,
            "user_id" => $request->user_id,
            "password" => Hash::make($request->password), // Hash the password
        ]);

        return response()->json(['message' => 'Data Berhasil ditambahkan', 'data' => $anak], 201);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $anak = Anak::with('orangtua')->findOrFail($id);

            $anak->update(['status' => 'Verified']);

            if ($anak->orangtua) {
                $anak->orangtua->notify(new AnakNotification($anak));
            }

            return response()->json(['message' => 'Anak Telah Diverifikasi'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal Memverifikasi: ' . $e->getMessage()], 500);
        }
    }


    public function show($id)
    {
        $anak = Anak::findOrFail($id);
        return Response::json(['data' => $anak]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "nama_lengkap" => "required|string|max:255",
                "nisn" => "required|string|min:12|unique:anak,nisn" . $id,
                "sekolah" => "required|string",
                "alamat_sekolah" => "required|string",
                "no_tlp" => "required|string|min:12|unique:anak,no_tlp" . $id,
                "email" => "required|string|email|unique:anak,email" . $id,
                "password" => "required|string|min:8",
                "user_id" => "required|string|exits:orang_tua",
            ],
            [
                "nama_lengkap" => "Format Tidak Sesuai",
                "alamat" => "Alamat Tidak Sesuai",
                "nisn.unique" => "NISN sudah digunakan",
                "no_tlp.unique" => "Nomer Telfon sudah digunakan",
                "email.unique" => "email sudah digunakan",
                "password" => "password minimal 8 karakter",
                "user_id" => "User tidak ditemukan",
            ]
        );

        if ($validator->fails()) {
            return Response::json($validator->errors(), 422);
        };

        $anak = Anak::findOrFail($id);
        $validatedData = $validator->validated();

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $anak->update($validatedData);
        return Response::json(["message" => 'Data Anak Berhasil di Update'], 201);
    }

    public function delete($id)
    {
        $anak = Anak::findOrFail($id);
        $anak->delete();
        return Response::json(["message" => 'Data Anak Berhasil dihapus'], 200);
    }
}
