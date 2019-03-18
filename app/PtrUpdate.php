<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Balping\HashSlug\HasHashSlug;

class PtrUpdate extends Model
{
    use HasHashSlug;
    
    protected $table = "ptr_updates";
    
    protected $guarded = [];
    
    public function project() {
        return $this->belongsTo('App\PtrProject');
    }
}
