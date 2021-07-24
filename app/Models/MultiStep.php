<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultiStep extends Model
{
    protected $table = 'multi_step';
	protected $guarded = [];  
    
	public function steps()
    {
        return $this->belongsTo(MultiStepMaster::class,'id','master_id');
    }
}
