<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'stok',
        'deskripsi',
    ];

    public function casts()
    {
        return [
            'tahun_terbit' => 'integer',
            'stok' => 'integer'
        ];
    }

    public function transaksiBerlangsung()
    {
        return $this->hasMany(Transaksi::class)->where('status', 'dipinjam');
    }

    public function getAvailableStockAttribute()
    {
        $peminjaman = $this->transaksiBerlangsung()->count();
        return max(0, $this->stok - $peminjaman);
    }

}
