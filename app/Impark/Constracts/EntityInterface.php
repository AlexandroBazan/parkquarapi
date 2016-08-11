<?php
namespace Impark\Constracts;

use Impark\Ent\Model;
use Impark\Filter\Filter;
use Impark\Validator\Validator;
use Impark\Mutator\Mutator;
use Impark\Timestamps\Timestamps;
use Impark\Error\HttpErrorReporter;
use Illuminate\Http\Request;

interface EntityInterface
{
	public function __construct(
		Model $model, 
		Filter $filter, 
		Validator $validator, 
		Mutator $mutator, 
		Timestamps $timestamps,
		HttpErrorReporter $error 
	);

	public function status();

	public function one($id, Request $request);
	
	public function collection(Request $request);
}