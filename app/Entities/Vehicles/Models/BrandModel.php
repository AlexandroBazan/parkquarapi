<?php
namespace Entities\Vehicles\Models;

use Impark\Ent\Model as ModelParent;

class BrandModel extends ModelParent
{
	protected $table = 'vehicle_models';

	protected $fillable = [
        'name',
        'group_id',
        'delete',
        'created_id',
        'updated_id',
        'deleted_id',
    ];
}