<?php

namespace Impark\Filter\test;

use Illuminate\Database\Eloquent\Model;

class Person extends Model 
{
	protected $table = 'persons';

	public $timestamps = false;

    

    public function toArray($options = 0) {
        return parent::toArray();
    }
}
