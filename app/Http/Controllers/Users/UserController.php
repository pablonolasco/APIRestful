<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     *  TODO lista de usuarios
     */
    public function index()
    {
        try {
            $usuarios = User::all();
            //$d=true+'';
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

        return $this->showAll($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];
        $this->validate($request, $rules);
        $campos = $request->all();
        $campos['password'] = bcrypt($campos['password']);
        $campos['verified'] = User::USUARIO_NO_VERIFICADO;
        $campos['verification_token'] = User::generarVerificationToken();
        $campos['admin'] = User::USUARIO_REGULAR;
        $usuario = User::create($campos);
        return $this->showOne($usuario, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $usuario = User::findOrFail($id);
        return $this->showOne($usuario, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        $rules = [
            'email' => 'email|unique:users,email,' . $usuario->id,// obtiene el id de la persona para verificar que sea diferente el email
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR
        ];
        $this->validate($request, $rules);
        if ($request->has('name')) {
            $usuario->name = $request->name;
        }
        if ($request->has('email') && $usuario->email != $request->email) {
            $usuario->verified = User::USUARIO_NO_VERIFICADO;
            $usuario->verification_token = User::generarVerificationToken();
            $usuario->email = $request->email;
        }

        if ($request->has('password')) {
            $usuario->password = bcrypt($request->email);
        }

        if ($request->has('admin')) {
            if (!$usuario->esVerificado()) {
                return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su valor de administrador',409);
            }
        }

        // verifica que la informacion sea distinta a la existente en la base de datos
        if (!$usuario->isDirty()) {
            return $this->errorResponse('Se debe de ingresar un dato diferente para actualizar', 422);
        }

        $usuario->save();

        return $this->showOne($usuario, 200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();
        return response()->json(['data' => $usuario], 200);
    }
}
