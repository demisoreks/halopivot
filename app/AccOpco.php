<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AccOpco extends Model
{
    use HasHashSlug;
    
    protected $table = "acc_opcos";
    
    protected $guarded = [];
}
