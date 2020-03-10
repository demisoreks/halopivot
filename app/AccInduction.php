<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AccInduction extends Model
{
    use HasHashSlug;
    
    protected $table = "acc_inductions";
    
    protected $guarded = [];
    
    public function employee() {
        return $this->belongsTo('App\AccEmployee');
    }
}
