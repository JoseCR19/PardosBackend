<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table= 'estados';
    protected $primaryKey = 'intIdEstdo';
    public $timestamps = false;
    protected $fillable =['varEstado'];
}
