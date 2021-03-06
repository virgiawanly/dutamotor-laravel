<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Mobil extends Model
{
    use HasFactory;

    protected $table = "tb_mobil";

    protected $fillable = ['kode_mobil', 'merek', 'model', 'tipe',  'warna', 'tahun', 'harga', 'gambar'];

    protected $primaryKey = "kode_mobil";

    protected $keyType = "string";

    public function beli_cash(){
        return $this->hasOne(BeliCash::class, 'kode_mobil', 'kode_mobil');
    }

    public function kredit(){
        return $this->hasOne(Kredit::class, 'kode_mobil', 'kode_mobil');
    }

    /**
     * Menggenerate kode mobil berdasarkan kode mobil terbaru
     * @return string $kode_mobil
     */
    public static function get_code($merk)
    {
        $tahun = date("Y");
        $prefix = strtoupper(substr($merk, 0, 3));
        $no_urut = self::selectRaw("IFNULL(MAX(SUBSTRING(`kode_mobil`,8,5)),0) + 1 AS no_urut")->whereRaw("SUBSTRING(`kode_mobil`,4,4) = '" . $tahun . "'")->whereRaw("SUBSTRING(`kode_mobil`,1,3) = '" . $prefix . "'")->orderBy('no_urut')->first()->no_urut;
        $kode_mobil = $prefix . $tahun . sprintf("%'.05d", $no_urut);
        return $kode_mobil;
    }

    /**
     * URL gambar full
     * @return string $url
     */
    public function url_gambar()
    {
        // Check jika data gambar adalah url
        if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
            return $this->gambar;
        }
        // Check jika gambar ada di storage
        else if ($this->gambar && Storage::exists($this->gambar)) {
            return Storage::url($this->gambar);
        }
        // Jika tidak ada gambar
        else {
            return "https://via.placeholder.com/150";
        }
    }
}
