<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    protected $table = "orang_tua";
    protected $fillable = [
        "nama_lengkap",
        "alamat",
        "no_tlp",
        "email",
        "password",
    ];
    public function Anak()
    {
        return $this->hasMany(Anak::class);
    }
}