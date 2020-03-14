<?php

namespace App\ORM\Model\Dance;

use Illuminate\Database\Eloquent\Model;

class Role extends BaseUIDModel
{
    public const ROLE_TRAINER = 1;
    public const ROLE_STUDENT = 2;
    public const ROLE_RENTER = 3;
    
    protected $table = 'dance_roles';

    public $timestamps = false;
    
    public function getId() {
        
        return $this->id;
    }

}
