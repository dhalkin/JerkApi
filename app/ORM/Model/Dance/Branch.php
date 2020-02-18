<?php

namespace App\ORM\Model\Dance;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'dance_branches';
    protected $hidden = ['company_id'];
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'id', 'company_id');
    }
 
}
