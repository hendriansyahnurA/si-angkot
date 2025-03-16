<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OrangTua extends Model
{
    use Notifiable;

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
