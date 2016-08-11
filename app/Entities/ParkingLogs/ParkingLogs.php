<?php 
namespace Entities\ParkingLogs;

use Impark\Ent\Entity;

use Impark\Constracts\RemovingInterface;
use Impark\Constracts\EditingInterface;
use Impark\Constracts\InsertingInterface;

use Impark\Ent\Traits\Removable;
use Impark\Ent\Traits\Editable;
use Impark\Ent\Traits\Insertable;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ParkingLogs extends Entity 
{
    
    /**
     * Atributos que van ha poder ser filtrados
     * 
     * @var array
     */
	protected $attributes = [
		'id',
		'vehicle_id',
        'branch_office_id',
        'egress',
        'ingress_at',
        'ingress_user',
        'egress_at',
        'egress_user',
	];

    /**
     * Relaciones que van hacer activadas en el render
     * 
     * @var array
     */
	protected $relations = [
		
	];

    /**
     * Atributos que van a ser modificados en primera
     * instancia
     * 
     * @var array
     */
    protected $fillable = [
        'id',
		'vehicle_id',
        'branch_office_id',
        'egress',
        'ingress_at',
        'ingress_user',
        'egress_at',
        'egress_user',
    ];

    /**
     * Atributos ocultos al render
     * 
     * @var array
     */
    protected $hidden = [];

    /**
     * Mensaje de error de busqueda
     * 
     * @var string
     */
	protected $messageOneError = 'No existe un log de parqueo con ese identificador';

    /**
     * Mensaje de error de busqueda por eliminacion
     * 
     * @var string
     */
	protected $messageRemoveError = 'El log de parqueo no existe o ya fue eliminado';

	
	public function ingress(Request $request)
	{
		if ($this->validator->create($request->except(['timestamps']))) {

			//$this->mutator->make($request);
			//var_dump($request->file('image'));

			$this->status = 201;

			$id = $this->model
					   ->create([
					   		'vehicle_id' => $request->input('vehicle_id'),
					        'branch_office_id' => $request->input('branch_office_id'),
					        'egress' => false,
					        'ingress_at' => Carbon::now(),
					        'ingress_user' => $request->input('timestamps.user'),
					        'egress_at' =>  Carbon::now(),
					        'egress_user' => $request->input('timestamps.user'),
					   	])
					   ->{$this->findKey};	

			return $this->one($id, $request);
			//return $this->createRegister($request);
		} else {
			return $this->getInsertMessageError();
		}
	}

	public function egress($id, Request $request)
	{
		$data = [
			'id' => $id
		];

		if ($this->validator->update($data)) {

			//$this->mutator->make($request);
			//var_dump($request->file('image'));

			$this->status = 200;

			$registro = $this->model->find($id);
			$registro->egress_at =  Carbon::now();
			$registro->egress =  true;
			$registro->egress_user =  $request->input('timestamps.user');
			$registro->save();

			return $this->one($id, $request);
			//return $this->createRegister($request);
		} else {
			return $this->getInsertMessageError();
		}
	}
}