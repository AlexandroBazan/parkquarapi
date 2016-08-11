<?php
namespace Entities\Permissions\Models;

use Impark\Ent\Model;

class Permission extends Model
{
	protected $table = 'permissions';

	protected $fillable = [
        'user_id',
        'profile_id',
        'branch_office_id',
        'active',
        'delete',
        'created_id',
        'updated_id',
        'deleted_id',
    ];

	public function profile()
    {
    	return $this->hasOne('Entities\Profiles\Models\Profile', 'id', 'profile_id');
    }

    public function branch_office()
    {
    	return $this->hasOne('Entities\BranchOffices\Models\BranchOffice', 'id', 'branch_office_id');
    }

    public function callRelationUsers()
    {
        $this->addHidden(['profile_id', 'branch_office_id', 'user_id']);
    }
}