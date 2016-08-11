<?php
namespace Entities\Persons\Models;

use Impark\Ent\Model;

class Email extends Model
{
	protected $table = 'emails';

	protected $fillable = [
        'person_id',
        'username',
        'description',
        'domain',
        'delete',
        'created_id',
        'updated_id',
        'deleted_id',
    ];

    public function callRelationUsers()
    {
        $this->addHidden(['person_id']);
    }

}