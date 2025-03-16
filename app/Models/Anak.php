<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    protected $table = "anak";
    protected $fillable = [
        "nama_lengkap",
        "nisn",
        "sekolah",
        "alamat_sekolah",
        "no_tlp",
        "email",
        "password",
        "user_id",
        "status"
    ];
    public function orangtua()
    {
        return $this->belongsTo(OrangTua::class, 'user_id', 'id');
    }
}
