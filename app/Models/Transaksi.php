<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'status',
    ];

    protected function casts()
    {
        return [
            'tanggal_peminjaman' => 'date',
            'tanggal_pengembalian' => 'date',
        ];
    }

    public function user()
    {
        if ($this->status === 'dikembalikan') {
            return false;
        }
    }

}
