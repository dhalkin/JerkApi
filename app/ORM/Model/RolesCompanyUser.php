<?php

namespace App\ORM\Model;

use Illuminate\Database\Eloquent\Model;

class RolesCompanyUser extends Model
{
    public const ROLE_TRAINER = 1;
    public const ROLE_STUDENT = 2;
    public const ROLE_RENTER = 3;
    
    protected $table = 'roles_company_users';

    public $timestamps = false;

}
