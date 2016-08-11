<?php 
namespace Impark\Mutator\test;

use Impark\Mutator\Mutator;

class MutatorTestClass extends Mutator
{
	protected $generables = [ 'age' ];

	protected $mutables = ['name'];

	public function mutInputName($value)
	{
		return strtoupper($value);
	}

	public function mutInputUsername($value)
	{
		return strtolower($value);
	}

	public function hasGenPresetInputAge()
	{
		return ['fecha'];
	}

	public function genInputAge($inputs)
	{
		if (isset($inputs['fecha'])) {

		}

		list($ano,$mes,$dia) = explode("-",$inputs['fecha']);

		$ano_diferencia  = date("Y") - $ano;
		$mes_diferencia = date("m") - $mes;
		$dia_diferencia   = date("d") - $dia;

		if ($dia_diferencia < 0 || $mes_diferencia < 0)
		{
			$ano_diferencia--;
		}

		return $ano_diferencia;
	}

	public function setMutable(array $value)
	{
		$this->mutables = $value;
	}

	public function setGenerable(array $value)
	{
		$this->generables = $value;
	}
}