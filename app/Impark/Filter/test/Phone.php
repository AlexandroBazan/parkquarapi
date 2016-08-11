<?php

namespace Impark\Filter\test;

use Impark\Ent\Model;

class Phone extends Model 
{
    protected $table = 'phones';
    
    public function callRelationUsers()
    {
    	$this->addHidden(['type_id', 'person_id']);
    }

    public function type()
    {
    	return $this->hasOne('Impark\Filter\test\PhoneType', 'id', 'type_id');
    }
}