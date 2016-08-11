<?php
namespace Entities\ParkingLogs\Models;

use Impark\Ent\Model;

class ParkingLog extends Model
{
	protected $table = 'parking_logs';

	protected $fillable = [
        'vehicle_id',
        'branch_office_id',
        'egress',
        'ingress_at',
        'ingress_user',
        'egress_at',
        'egress_user',
    ];

	public function profiles()
    {
    	return $this->hasMany('Entities\Profiles\Models\Profile', 'group_id', 'id');
    }
}