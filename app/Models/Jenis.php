<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jenis extends Model
{
    use HasFactory;
    protected $table = 'jenis';
    protected $fillable = ['nama_jenis', 'kategori_id'];

    public function menu(): HasMany
    {
        return $this->hasMany(Menu::class, 'kategori_id', 'id');
    }
}
