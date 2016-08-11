<?php
namespace Entities\Vehicles;

use Impark\Validator\Validator;

class VehiclesValidator extends Validator
{
	/**
	 * reglas de creacion
	 * 
	 * @var array
	 */
	protected $createRuls = [
		'registation_plate' => ['required', 'unique:vehicles,registation_plate', 'regex:/^([a-z0-9]{3}+\-+[a-z0-9]{3}|[a-z0-9]{2}+\-+[a-z0-9]{4})+$/i'],
        'customer_id' 		 => ['required', 'exists:customers,id'],
        'color_id' 			 => ['required', 'exists:vehicle_colors,id'],
        'model_id' 			 => ['required', 'exists:vehicle_models,id'],
        'type_id' 			 => ['required', 'exists:vehicle_types,id'],
	];

	/**
	 * Reglas de edicion
	 * 
	 * @var array
	 */
	protected $updateRuls = [
		'registation_plate' => ['unique:vehicles,registation_plate', 'regex:/^([a-z0-9]{3}+\-+[a-z0-9]{3}|[a-z0-9]{2}+\-+[a-z0-9]{4})+$/i'],
        'customer_id' 		 => ['exists:customers,id'],
        'color_id' 			 => ['exists:vehicle_colors,id'],
        'model_id' 			 => ['exists:vehicle_models,id'],
        'type_id' 			 => ['exists:vehicle_types,id'],

	];

	/**
	 * Mensajes de error personalizados
	 * 
	 * @var array
	 */
	protected $messages = [
		'required'        => 'Este campo es requerido',
		'registation_plate.regex'      => 'la matricula debe tener el siguiente formato ###-### o ##-####',
		'registation_plate.unique'      => 'la matricula ya ha sido registrada por un vehiculo',
		'customer_id.exists' => 'El cliente que ha enviado no existe o ha sido eliminado',
		'color_id.exists' => 'El color elejido no es un color valido',
		'model_id.exists' => 'El modelo de auto no existe o ha sido eliminado',
		'type_id.exists' => 'El tipo de vehiculo no es valido',
	];
}