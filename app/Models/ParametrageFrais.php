<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParametrageFrais extends Model
{
    use HasFactory;
    protected $table="paramfrais";
    protected $primaryKey="paramfrais_id";
    public $timestamps = false;
}
