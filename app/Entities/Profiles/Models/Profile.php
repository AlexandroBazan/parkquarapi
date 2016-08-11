<?php
namespace Entities\Profiles\Models;

use Impark\Ent\Model;

class Profile extends Model
{
	protected $table = 'profiles';

	protected $fillable = [
        'name',
        'active',
        'group_id',
        'delete',
        'created_id',
        'updated_id',
        'deleted_id',
    ];

	public function callRelationGroups()
    {
    	$this->addHidden(['group_id']);
    }

    public function callRelationPermissions()
    {
    	$this->addHidden(['group_id']);
    }

    public function callRelationAccesses()
    {
        $this->addHidden(['group_id']);
    }

    public function callRelationUsers()
    {
        $this->addHidden(['group_id']);
    }

    public function group()
    {
    	return $this->hasOne('Entities\Groups\Models\Group', 'id', 'group_id');
    }
}