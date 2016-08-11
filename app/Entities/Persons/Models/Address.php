<?php
namespace Entities\Persons\Models;

use Impark\Ent\Model;

class Address extends Model
{
	protected $table = 'addresses';

	protected $fillable = [
        'person_id'
    ];

    public function callRelationUsers()
    {
        $this->addHidden(['person_id']);
    }

}