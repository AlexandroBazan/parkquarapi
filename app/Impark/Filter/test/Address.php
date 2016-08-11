<?php

namespace Impark\Filter\test;

use Impark\Ent\Model;

class Address extends Model 
{
    protected $table = 'addresses';

    public function callRelationUsers()
    {
    	$this->addHidden(['person_id']);
    }
}