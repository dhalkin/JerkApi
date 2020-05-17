<?php

namespace App\ORM\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public const ROLE_OWNER = 1;
    public const ROLE_TRAINER = 2;
    public const ROLE_STUDENT = 3;
    public const ROLE_RENTER = 4;
    
    protected $table = 'roles';

    public $timestamps = false;

}
