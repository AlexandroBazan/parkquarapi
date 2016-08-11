<?php

namespace App\Http\Middleware;

use Closure;

use Impark\Error\HttpErrorReporter;

class TimestampsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $validator = app('validator');

        $ruls = [
            'timestamps' => ['required','array'],
            'timestamps.app'  => ['required', 'in:1,2'],
            'timestamps.user' => ['required', 'exists:users,id,delete,0,active,1'],
            'timestamps.ip'   => ['required', 'ip']
        ];

        $messages = [
            'required' => 'El parametro :attribute es obligatorio',
            'timestamps.app.in' => 'El id de la aplicacion  no es un id valido',
            'timestamps.user.exists' => 'El id de usuario no es un id valido o no tiene permisos para esta accion',
            'timestamps.ip.ip' => 'La ip enviada no es una ip valida',
        ];

        $validation = $validator->make($request->all(), $ruls, $messages);

        if($validation->fails()) {
            $error = $this->getError($validation->errors());

            return response()->json($error->response(), $error->httpCode());
        }
        return $next($request);
    }

    public function getError($errors)
    {
        $error = new HttpErrorReporter;

        $error->send([
            'message'                => 'no se han encontrado algunos de los datos para poder ejecutar un timestamps',
            'code'                   => 201,
            'type'                   => 'TimestampsError',
            'user_error_title'       => 'Hay problemas de Timestamps en la peticion',
            'user_error_description' => $errors->toArray(),
        ]);

        return $error;
    }
}
