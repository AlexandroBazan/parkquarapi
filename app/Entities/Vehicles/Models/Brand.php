<?php
namespace Entities\Vehicles\Models;

use Impark\Ent\Model;

class Brand extends Model
{
	protected $table = 'vehicle_brands';

	protected $fillable = [
        'name',
        'active',
        'delete',
        'created_id',
        'updated_id',
        'deleted_id',
    ];
}