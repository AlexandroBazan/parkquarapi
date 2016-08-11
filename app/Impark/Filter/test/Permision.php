<?php

namespace Impark\Filter\test;

use Impark\Ent\Model;

class Permision extends Model 
{
    protected $table = 'permissions';

    public function profile()
    {
    	return $this->hasOne('Impark\Filter\test\Profile', 'id', 'profile_id');
    }

    public function branchOffice()
    {
    	return $this->hasOne('Impark\Filter\test\BranchOffice', 'id', 'branch_office_id');
    }

    public function callRelationUsers()
    {

    	$this->addHidden(['profile_id','branch_office_id','user_id']);
    }
}