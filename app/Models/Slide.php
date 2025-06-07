<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    // Nama tabel jika tidak sesuai konvensi Laravel
    protected $table = 'slides';

    // Kolom-kolom yang boleh diisi secara massal
    protected $fillable = [
        'tagline',
        'title',
        'subtitel',
        'link',
        'status',
        'image',
    ];
}

