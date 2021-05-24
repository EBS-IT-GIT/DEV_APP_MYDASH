<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

  protected $table = 'logs';
  protected $fillable = ['id_chamado','datahora', 'analista', 'acao','status_integracao','valor','json'];
  public $timestamps = false;

}
