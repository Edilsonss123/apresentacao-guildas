<?php
namespace App\Models;

use App\Models\IRepository\ICampanhaRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Campanha extends Model implements ICampanhaRepository
{
    use SoftDeletes;
    protected $table = "campanha";
    public $timestamps = false;
    protected $dates = ['created_at', 'deleted_at'];
    protected $hidden = [
        'deleted_at'
    ];
    protected $fillable = [
        'descricao', 'valorOrcamento', 'publicoAlvo','status', 'dataInicial', 'dataFinal', 'created_at'
    ];

    public function arquivoCampanha()
    {
        return $this->hasMany(ArquivoCampanha::class, "idCampanha");
    }
    
    public function recuperarCampanhas() 
    {
        return $this->with("arquivoCampanha")->get();
    }

    public function recuperarCampanhaPeloId($id) 
    {
        return $this->with("arquivoCampanha")->find($id);
    }
}