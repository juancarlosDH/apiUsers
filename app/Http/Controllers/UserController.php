<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function showAllUsers(Request $request)
    {
        $validator = $this->validate($request, [
                'team' => 'required',
                'commission' => 'required',
            ], [
                'team.required' => 'Debes enviar el team',
                'commission.required' => 'Debes enviar la commission (manana o tarde)'
            ]);

        $users = User::where('team', $request->input('team'))
                    ->where('commission', $request->input('commission'));

        if ($filter = $request->input('search')) {
            $users = $users->where('json_data', 'like', '%'.$filter.'%');
        }

        $users = $users->get();
        return response()->json(['data' => $users]);
    }

    public function showOneUser($id, Request $request)
    {
        $validator = $this->validate($request, [
                'team' => 'required',
                'commission' => 'required'
            ], [
                'team.required' => 'Debes enviar el team',
                'commission.required' => 'Debes enviar la commission (manana o tarde)'
            ]);
        $user = User::where('team', $request->input('team'))
                    ->where('commission', $request->input('commission'))
                    ->where('id', $id)
                    ->first();

        return response()->json($user);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
           'json_data' => 'required',
           'commission' => 'required',
           'team' => 'required',
       ], [
           'team.required' => 'Debes enviar el team',
           'commission.required' => 'Debes enviar la commission (manana o tarde)',
           'json_data' => 'Debes enviar los datos a guardar',
       ]);

        $user = new User;
        $user->commission = $request->input('commission');
        $user->team = $request->input('team');
        $user->json_data = json_encode($request->input('json_data'));
        $user->save();

        return response()->json($user, 201);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
           'json_data' => 'required',
           'commission' => 'required',
           'team' => 'required',
       ], [
           'team.required' => 'Debes enviar el team',
           'commission.required' => 'Debes enviar la commission (manana o tarde)',
           'json_data' => 'Debes enviar los datos a guardar',
       ]);

       $user = User::where('team', $request->input('team'))
                   ->where('commission', $request->input('commission'))
                   ->where('id', $id)
                   ->first();

        $user->json_data = json_encode($request->input('json_data'));
        $user->save();

        return response()->json($user, 200);
    }

    public function delete($id, Request $request)
    {
        $validator = $this->validate($request, [
                'team' => 'required',
                'commission' => 'required'
            ], [
                'team.required' => 'Debes enviar el team',
                'commission.required' => 'Debes enviar la commission (manana o tarde)'
            ]);
        $user = User::where('team', $request->input('team'))
                    ->where('commission', $request->input('commission'))
                    ->where('id', $id)
                    ->first();
        $user->delete();
        return response('Eliminado Exitosamente', 200);
    }
}
