<?php
namespace Entities\Persons\Models;

use Impark\Ent\Model;

class Phone extends Model
{
	protected $table = 'phones';

	protected $fillable = [
        'person_id'
    ];

    public function callRelationUsers()
    {
        $this->addHidden(['person_id']);
    }

}