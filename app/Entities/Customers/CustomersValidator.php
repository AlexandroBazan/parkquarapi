<?php
namespace Entities\Customers;

use Impark\Validator\Validator;

class CustomersValidator extends Validator
{
	protected $createRuls = [
		'dni'             => ['required','regex:/^[0-9]{8}+$/', 'unique:persons,dni'],
		'firstname'       => ['required','regex:/^([a-zñáéíóúÑÁÉÍÓÚ]+\s|[a-zñáéíóúÑÁÉÍÓÚ]){2,35}+$/i'],
		'lastname'        => ['required','regex:/^([a-zñáéíóúÑÁÉÍÓÚ]+\s|[a-zñáéíóúÑÁÉÍÓÚ]){2,35}+$/i'],
		'birthday'        => ['required','date_format:Y-m-d'],
		'gender'          => ['required','in:hombre,mujer'],
		'image'           => ['required'],

	];

	protected $updateRuls = [
		'dni'             => ['regex:/^[0-9]{8}+$/', 'unique:persons,dni'],
		'firstname'       => ['regex:/^([a-zñáéíóúÑÁÉÍÓÚ]+\s|[a-zñáéíóúÑÁÉÍÓÚ]){2,35}+$/i'],
		'lastname'        => ['regex:/^([a-zñáéíóúÑÁÉÍÓÚ]+\s|[a-zñáéíóúÑÁÉÍÓÚ]){2,35}+$/i'],
		'birthday'        => ['date_format:Y-m-d'],
		'gender'          => ['in:hombre,mujer'],
		'image'           => [],

	];

	protected $messages = [
		'required'        		=> 'Este campo es requerido',
		'fisrtname.regex' 		=> 'Solo se aceptan entre 2 a 35 caracteres del alfabeto, tildes y espacios',
		'lastname.regex'  		=> 'Solo se aceptan entre 2 a 35 caracteres del alfabeto, tildes y espacios',
		'dni.unique'      		=> 'ya existe un cliente con el mismo DNI',
		'dni.regex'       		=> 'El formato del DNI es incorrecto',
		'birthday.date_format'  => 'La fecha debe temer el formato Año-Mes-Dia (Y-m-d)',
		'gender.in'       		=> 'Solo se acepta hombre y mujer como dato valido',
	];
}