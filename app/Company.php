<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * Get the phone record associated with the user.
     */
    public function timezone()
    {
        return $this->hasOne('App\Timezone');
    }
}
