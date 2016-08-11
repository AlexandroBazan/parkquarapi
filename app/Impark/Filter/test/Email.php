<?php

namespace Impark\Filter\test;

use Impark\Ent\Model;

class Email extends Model 
{
    protected $table = 'emails';

    public function callRelationUsers()
    {
    	$this->addHidden(['person_id']);
    }
    
}