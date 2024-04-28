<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $fillable = ['kategori_id', 'nama_menu', 'harga', 'stok_id', 'images', 'deskripsi'];

    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'kategori_id');
    }
    public function stok(): HasOne
    {
        return $this->hasOne(Stok::class, 'id', 'stok_id',);
    }
}
