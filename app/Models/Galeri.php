<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeris';
    protected $guarded = ['id'];

    protected $fillable = [
        'judul',
        'foto',
        'keterangan',
        'tipe',
    ];

    public function getTipeLabelAttribute(): string
    {
        return match($this->tipe) {
            'hairstyle' => 'Hairstyle',
            'haircut'   => 'Haircut',
            'beard'     => 'Beard',
            default     => $this->tipe,
        };
    }
}
