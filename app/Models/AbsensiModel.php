<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiModel extends Model
{
    use HasFactory;
    protected $table = 'absensi';  
    protected $primaryKey = 'id_absensi';   
    public $timestamps = false;
    protected $fillable = ['karyawan_id','tgl_absen','status'];

    public function karyawan()
    {
        return $this->belongsTo(KaryawanModel::class, 'karyawan_id', 'id_karyawan');
    }

}

