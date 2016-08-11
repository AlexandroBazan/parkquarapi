<?php 
namespace Impark\Constracts;

interface HttpErrorInterface
{
	public function send(array $message, $code=400);

	public function has();

	public function response(); 
	
	public function httpCode();
}