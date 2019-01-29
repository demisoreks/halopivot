<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AccPrivilegedLink extends Model
{
    use HasHashSlug;
    
    protected $table = "acc_privileged_links";
    
    protected $guarded = [];
}
