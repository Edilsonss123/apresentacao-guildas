<?php
namespace App\Models;

use App\Models\IRepository\IUsuarioRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Usuario extends Model implements IUsuarioRepository
{
    use SoftDeletes;
    protected $table = "usuario";
    public $timestamps = false;
    protected $dates = ['created_at', 'deleted_at'];
    protected $hidden = [
        'deleted_at'
    ];
    protected $fillable = [
        'nome', 'login', 'senha', 'created_at'
    ];

    public function recuperarUsuarioPeloLogin($login)
    {
        $usuario = $this->where("login", $login)->first();
        return $usuario;
    }
}