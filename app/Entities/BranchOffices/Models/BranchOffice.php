<?php
namespace Entities\BranchOffices\Models;

use Impark\Ent\Model;

class BranchOffice extends Model
{
	protected $table = 'branch_offices';

	protected $fillable = [
        'name',
        'delete',
        'created_id',
        'updated_id',
        'deleted_id',
    ];
}