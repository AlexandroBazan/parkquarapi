<?php
namespace Entities\ParkingLogs;

use Impark\Validator\Validator;

class ParkingLogsValidator extends Validator
{
	/**
	 * reglas de creacion
	 * 
	 * @var array
	 */
	protected $createRuls = [
		'vehicle_id' 		=> ['required', 'exists:vehicles,id'],
        'branch_office_id' 	=> ['required', 'exists:branch_offices,id'],
		
	];

	/**
	 * Reglas de edicion
	 * 
	 * @var array
	 */
	protected $updateRuls = [
		
		'id' 		=> ['required', 'exists:parking_logs,id,egress,0'],
	];

	/**
	 * Mensajes de error personalizados
	 * 
	 * @var array
	 */
	protected $messages = [
		'required'                => 'Este campo es requerido',
		'id.exists' => 'El log no existe o el vehiculo ya se retiro de la zona de parqueo',
		'branch_office_id.exists' => 'El establecimiento seleccionado no existe',
		'vehicle_id.exists' => 'El vehiculo seleccionado no existe',
	];
}