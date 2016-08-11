<?php
namespace Entities\Routes\Models;

use Impark\Ent\Model;

class Route extends Model
{
	protected $table = 'routes';

	protected $fillable = [
        'description',
        'app_id',
        'delete',
        'created_id',
        'updated_id',
        'deleted_id',
    ];

    public function app()
    {
    	return $this->hasOne('Entities\App', 'id', 'app_id');
    }

    public function callRelationAccesses()
    {
        $this->addHidden(['app_id']);
    }
}