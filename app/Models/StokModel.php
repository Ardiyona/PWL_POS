<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokModel extends Model
{
    use HasFactory;

    protected $table = 't_stok';        // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'stok_id';  // Mendefinisikan primary key dari tabel yang digunakan

    protected $fillable = ['stok_tanggal', 'stok_jumlah', 'created_at', 'updated_at', 'supplier_id', 'barang_id', 'user_id'];

    protected $hidden = ['password']; // jangan ditampilkan saat select

    protected $casts = ['password' => 'hashed']; // casting password agar otomatis di hash

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id', 'supplier_id');
    }
    public function barang(): BelongsTo
    {
        return $this->belongsTo(BarangModel::class, 'barang_id', 'barang_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
}
