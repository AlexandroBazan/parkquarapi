<?php 
namespace Impark\Constracts;

use Illuminate\Validation\Factory as NativeValidator;

interface ValidatorInterface
{
	public function __construct(NativeValidator $validator);

	public function create(array $input);

	public function update(array $input);

	public function errors();
}