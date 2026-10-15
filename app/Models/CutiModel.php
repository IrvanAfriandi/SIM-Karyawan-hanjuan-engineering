<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiModel extends Model
{
    use HasFactory;
    protected $table = 'cuti';   
    protected $primaryKey = 'id_cuti';  
    public $timestamps = false;
    protected $fillable = ['karyawan_id','jenis_cuti','tgl_mulai','tgl_selesai','status','alasan'];

    public function karyawan()
    {
        return $this->belongsTo(KaryawanModel::class, 'karyawan_id', 'id_karyawan');
    }
    public function jenis_cuti_id()
    {
        return $this->belongsTo(JenisCutiModel::class, 'jenis_cuti', 'id_jenis_cuti');
    }

}

