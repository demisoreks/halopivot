<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Balping\HashSlug\HasHashSlug;

class PtrVendor extends Model
{
    use HasHashSlug;
    
    protected $table = "ptr_vendors";
    
    protected $guarded = [];
    
    public function projects() {
        return $this->hasMany('App\PtrProject');
    }
}
