<?php
namespace Entities\Accesses\Models;

use Impark\Ent\Model;

class Access extends Model
{
	protected $table = 'accesses';

	protected $fillable = [
        'profile_id',
        'route_id',
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

    public function route()
    {
        return $this->hasOne('Entities\Routes\Models\Route', 'id', 'route_id');
    }
}