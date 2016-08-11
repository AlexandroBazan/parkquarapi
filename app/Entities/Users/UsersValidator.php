<?php
namespace Entities\Users;

use Impark\Validator\Validator;

class UsersValidator extends Validator
{
	protected $createRuls = [
		'username'  	  => [
							 	'required',
							 	'regex:/^[a-z0-9]{5,14}+$/i', 
							 	'unique:users,username'
							 ],
		'password'        => ['required','regex:/^[a-z0-9]{6,26}+$/i'],
		'dni'             => ['required','regex:/^[0-9]{8}+$/', 'unique:persons,dni'],
		'firstname'       => ['required','regex:/^([a-zñáéíóúÑÁÉÍÓÚ]+\s|[a-zñáéíóúÑÁÉÍÓÚ]){2,35}+$/i'],
		'lastname'        => ['required','regex:/^([a-zñáéíóúÑÁÉÍÓÚ]+\s|[a-zñáéíóúÑÁÉÍÓÚ]){2,35}+$/i'],
		'birthday'        => ['required','date_format:Y-m-d'],
		'gender'          => ['required','in:hombre,mujer'],
		'image'           => ['required', 'mimes:png,jpeg'],
		'emails'          => ['required', 'array'],
		'emails.*'        => ['required','email', 'unique:emails,description'],
		'phones.*.type'   => [
								'required_with:phones.*.number',
								'exists:phone_types,id'
							 ],
		'phones.*.number' => [
								'required_with:phones.*.type',
								'regex:/^[a-zñáéíóúÑÁÉÍÓÚ\s]{2,35}+$/i', 
								'unique:phones,number'
							 ],
		'addresses.*'     => ['required','email', 'unique:emails,description'],

	];

	protected $updateRuls = [
		'username'  	  => [
							 	'regex:/^[a-zñáéíóúÑÁÉÍÓÚ0-9]{5,14}+$/i', 
							 	'unique:users,username'
							 ],
		'password'        => ['regex:/^[a-z0-9]{6,16}+$/i'],
		'dni'             => ['regex:/^[0-9]{8}+$/', 'unique:persons,dni'],
		'firstname'       => ['regex:/^([a-zñáéíóúÑÁÉÍÓÚ]+\s|[a-zñáéíóúÑÁÉÍÓÚ]){2,35}+$/i'],
		'lastname'        => ['regex:/^([a-zñáéíóúÑÁÉÍÓÚ]+\s|[a-zñáéíóúÑÁÉÍÓÚ]){2,35}+$/i'],
		'birthday'        => ['date_format:Y-m-d'],
		'gender'          => ['in:hombre,mujer'],
		'image'           => [],

	];

	protected $messages = [
		'required'        		=> 'Este campo es requerido',
		'username.regex'        => 'Solo se aceptan entre 5 a 14 caracteres del alfabeto, numeros',
		'username.unique'       => 'ya existe un usuario con el mismo username',
		'password.regex'        => 'La contraseña solo acepta entre 6 a 26 caracteres del alfabeto, numeros, tildes, mayusculas y minusculas',
		'fisrtname.regex' 		=> 'Solo se aceptan entre 2 a 35 caracteres del alfabeto, tildes y espacios',
		'lastname.regex'  		=> 'Solo se aceptan entre 2 a 35 caracteres del alfabeto, tildes y espacios',
		'dni.unique'      		=> 'ya existe un usuario con el mismo DNI',
		'dni.regex'       		=> 'El formato del DNI es incorrecto',
		'birthday.date_format'  => 'La fecha debe temer el formato Año-Mes-Dia (Y-m-d)',
		'gender.in'       		=> 'Solo se acepta hombre y mujer como dato valido',
		'emails.array'			=> 'minimo se debe enviar un correo electronico',
		'emails.*.email'		=> 'el formato de correo no es valido',
		'emails.*.unique'		=> 'El correo ya esta siendo usado por otro usuario',
	];
}