<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisCutiModel extends Model
{
    use HasFactory;
    protected $table = 'jenis_cuti';  
    protected $primaryKey = 'id_jenis_cuti';   
    public $timestamps = false;
    protected $fillable = ['nama_cuti'];

}

