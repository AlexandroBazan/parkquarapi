<?php
namespace Entities\Vehicles\Models;

use Impark\Ent\Model;

class Vehicle extends Model
{
	protected $table = 'vehicles';

	protected $fillable = [
        'registation_plate',
        'customer_id',
        'model_id',
        'color_id',
        'type_id',
        'delete',
        'created_id',
        'updated_id',
        'deleted_id',
    ];

    public function model()
    {
        return $this->hasOne('Entities\Vehicles\Models\BrandModel', 'id', 'model_id');
    }

    public function type()
    {
        return $this->hasOne('Entities\Vehicles\Models\Type', 'id', 'type_id');
    }

    public function color()
    {
        return $this->hasOne('Entities\Vehicles\Models\Color', 'id', 'color_id');
    }

}