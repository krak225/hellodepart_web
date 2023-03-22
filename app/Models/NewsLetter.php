<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model
{
    use HasFactory;

    protected $table      = "newsletter";
    protected $primaryKey = "newsletter_id";
    protected $fillable = [
        'newsletter_email', 
    ];
    public $timestamps    = false;
}
