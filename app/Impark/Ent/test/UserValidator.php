<?php
namespace Impark\Ent\test;

use Impark\Validator\Validator;

class UserValidator extends Validator
{
	protected $createRuls = [
		'username'  	  => [
							 	'required',
							 	'regex:/^[a-zñáéíóúÑÁÉÍÓÚ0-9]{5,14}+$/i', 
							 	'unique:users,username'
							 ],
		'password'        => ['required','regex:/^[a-z0-9]{6,16}+$/i'],
		'dni'             => ['required','regex:/^[0-9]{8}+$/', 'unique:persons,dni'],
		'firstname'       => ['required','regex:/^[a-zñáéíóúÑÁÉÍÓÚ\s]{2,35}+$/i'],
		'lastname'        => ['required','regex:/^[a-zñáéíóúÑÁÉÍÓÚ\s]{2,35}+$/i'],
		'active'          => ['required','boolean'],
		'birthday'        => ['required','date_format:Y-m-d'],
		'gender'          => ['required','in:hombre,mujer'],
		'image'           => ['required'],
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
		'firstname'       => ['regex:/^[a-zñáéíóúÑÁÉÍÓÚ\s]{2,35}+$/i'],
		'lastname'        => ['regex:/^[a-zñáéíóúÑÁÉÍÓÚ\s]{2,35}+$/i'],
		'active'          => ['boolean'],
		'birthday'        => ['date_format:Y-m-d'],
		'gender'          => ['in:hombre,mujer'],
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
		'addresses.*'     => ['email', 'unique:emails,description'],

	];

	protected $messages = [
		'required'        => 'Este campo es requerido',
		'emails.required' => 'Este campo es requerido',
		'emails.array' 	  => 'debe haber como minimo un correo',
		'emails.*'        => 'El formato del correo es incorrecto',
		'fisrtname.regex' => 'Solo se aceptan entre 2 a 100 caracteres del alfabeto, tildes y espacios',
		'lastname.regex'  => 'Solo se aceptan entre 2 a 100 caracteres del alfabeto, tildes y espacios',
		'username.regex'  => 'Solo se aceptan entre 2 a 100 caracteres del alfabeto',
		'username.unique' => 'ya existe un usuario con el mismo username',
		'dni.unique'      => 'ya existe un usuario con el mismo DNI',
		'dni.regex'       => 'El formato del DNI es incorrecto',
		'email.unique'    => 'Ya existe un usuario con el mismo correo',
		'password.regex'  => 'solo se aceptan numeros y letras entre 6 a 16 caracteres',
	];
}