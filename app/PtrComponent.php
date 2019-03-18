<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Balping\HashSlug\HasHashSlug;

class PtrComponent extends Model
{
    use HasHashSlug;
    
    protected $table = "ptr_components";
    
    protected $guarded = [];
    
    public function project() {
        return $this->belongsTo('App\PtrProject');
    }
}
