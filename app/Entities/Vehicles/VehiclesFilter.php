<?php
namespace Entities\Vehicles;

use Impark\Filter\Filter;

class VehiclesFilter extends Filter
{
	protected $except = ['type', 'color'];
	
}