<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultiStepMaster extends Model
{
    protected $table = 'multi_step_master';
	protected $guarded = [];  
    
	public function steps()
    {
        return $this->hasMany(MultiStep::class,'master_id','id');
    }
}
