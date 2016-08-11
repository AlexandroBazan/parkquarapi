<?php
namespace Entities\Groups\Models;

use Impark\Ent\Model;

class Group extends Model
{
	protected $table = 'groups';

	protected $fillable = [
        'name',
        'active',
        'delete',
        'created_id',
        'updated_id',
        'deleted_id',
    ];

	public function profiles()
    {
    	return $this->hasMany('Entities\Profiles\Models\Profile', 'group_id', 'id');
    }
}