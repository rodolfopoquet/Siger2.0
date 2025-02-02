<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Reservas
 * @package App\Models
 */
class Reservas extends Model
{
    
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'equipamentos_id',
        'user_id',
        'dt_agendamento',
        'horario',
        'is_devolido'


    ];
    /**
     * @var string
     */
    protected $table ='reservas';
    /**
     * @var array
     */


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function equipamentos()
    {
        return $this->hasOne(Equipamentos::class, 'id', 'equipamentos_id');
    }

    public function reservas()
    {
        return $this->hasOne(Equipamentos::class, 'id', 'equipamentos_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->BelongsTo(User::class);
    }
}
