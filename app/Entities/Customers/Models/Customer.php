<?php
namespace Entities\Customers\Models;

use Impark\Ent\Model;

class Customer extends Model
{
	protected $table = 'customers';

	protected $fillable = [
        'person_id',
        'delete',
        'created_id',
        'updated_id',
        'deleted_id',
    ];
}