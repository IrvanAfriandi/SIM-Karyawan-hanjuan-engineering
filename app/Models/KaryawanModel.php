<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanModel extends Model
{
    use HasFactory;
    protected $table = 'karyawan';   
    protected $primaryKey = 'id_karyawan';  
    public $timestamps = false;
    protected $fillable = ['karyawan_users','jabatan_id','divisi_id','nik','tgl_masuk','foto'];

    public function user_id()
    {
        return $this->belongsTo(User::class, 'karyawan_users', 'id');
    }
    public function jabatan()
    {
        return $this->belongsTo(JabatanModel::class, 'jabatan_id', 'id_jabatan');
    }
    public function divisi()
    {
        return $this->belongsTo(DivisiModel::class, 'divisi_id', 'id_divisi');
    }

}

