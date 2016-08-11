<?php

namespace Impark\Filter\test;

use Impark\Ent\Model;

class User extends Model 
{
    protected $table = 'users';

    protected $hidden = ['password'];

    protected $fillable = [ 
        'username',
        'password',
        'active',
        'person_id',
        'delete',
        'created_id',
        'updated_id',
        'deleted_id',
    ];
    
    public function permissions()
    {
    	return $this->hasMany('Impark\Filter\test\Permision', 'user_id', 'id');
    }

    public function phones()
    {
    	return $this->hasMany('Impark\Filter\test\Phone', 'id', 'person_id');
    }

    public function addresses()
    {
    	return $this->hasMany('Impark\Filter\test\Address', 'id', 'person_id');
    }
	
	public function emails()
	{
		return $this->hasMany('Impark\Filter\test\Email', 'id', 'person_id');
	}

    public function person()
    {
        return $this->hasMany('Impark\Filter\test\Person', 'person_id', 'id');
    }  
}
