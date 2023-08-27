<?php
namespace App\Models;

use App\Models\IRepository\IArquivoCampanhaRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ArquivoCampanha extends Model implements IArquivoCampanhaRepository
{
    use SoftDeletes;
    protected $table = "arquivo_campanha";
    public $timestamps = false;
    protected $dates = ['created_at', 'deleted_at'];
    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable = [
        'idCampanha', 'descricaoArquivo', 'nomeArquivo', 'caminhoArquivo', 'created_at'
    ];
    public function campanha()
    {
        return $this->hasOne(Campanha::class, "id", "idCampanha");
    }

    public function recuperarArquivosCampanha(int $idCampanha)
    {
        return $this->where("idCampanha", $idCampanha)->get();
    }
}