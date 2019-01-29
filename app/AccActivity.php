<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AccActivity extends Model
{
    use HasHashSlug;
    
    protected $guarded = [];
    
    public function employee() {
        return $this->belongsTo('App\AccEmployee');
    }
}
