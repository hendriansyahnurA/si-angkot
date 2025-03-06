<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = "driver";
    protected $fillable = [
        "nama_lengkap",
        "Alamat",
        "no_tlp",
        "email",
        "password",
    ];
}