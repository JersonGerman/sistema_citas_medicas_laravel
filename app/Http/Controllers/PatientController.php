<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PatientController extends Controller
{
    public function index()
    {
        $patients = User::patients()->paginate(10);
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name'=>'required|min:3',
            'email' => 'required|email',
            'cedula' => 'required|digits:10',
            'address' => 'nullable|min:6',
            'phone' => 'required'
        ];

        $messages = [
            'name.required' => 'El nombre del paciente es obligatorio.',
            'name.min' => 'El nombre del paciente debe tener más de 3 carácteres.',
            'email.required' => 'El correo eletrónico es obligatorio',
            'email.email' => 'Ingrese una dirección de correo electrónico válido',
            'cedula.required' => 'La cédula es obligatorio',
            'cedula.digits' => 'La cédula debe tener 10 dígitos',
            'address.min' => 'La dirección debe tener al menos 6 carácteres',
            'phone.required' => 'El número de telefono es obligatorio'
        ];
        
        $this->validate($request, $rules, $messages);

        // Utilizamos el create y request only para crear un nuevo doctor con los siguientes campos.
        User::create(
            $request->only('name', 'email', 'cedula', 'address', 'phone')
            + [
                'role' => 'paciente',
                'password' => bcrypt($request->input('password'))
            ]
        );

        $notification = "El paciente se ha registrado correctamente";
        return redirect('pacientes')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paciente = User::patients()->findOrFail($id);
        return view('patients.edit', compact('paciente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name'=>'required|min:3',
            'email' => 'required|email',
            'cedula' => 'required|digits:10',
            'address' => 'nullable|min:6',
            'phone' => 'required'
        ];

        $messages = [
            'name.required' => 'El nombre del paciente es obligatorio.',
            'name.min' => 'El nombre del paciente debe tener más de 3 carácteres.',
            'email.required' => 'El correo eletrónico es obligatorio',
            'email.email' => 'Ingrese una dirección de correo electrónico válido',
            'cedula.required' => 'La cédula es obligatorio',
            'cedula.digits' => 'La cédula debe tener 10 dígitos',
            'address.min' => 'La dirección debe tener al menos 6 carácteres',
            'phone.required' => 'El número de telefono es obligatorio'
        ];
        
        $this->validate($request, $rules, $messages);
        $user = User::patients()->findOrFail($id);

        $data = $request->only('name', 'email', 'cedula', 'address', 'phone');
        $password = $request->input('password');

        if($password)
            $data['password'] = bcrypt($password);

        $user->fill($data);
        $user->save();
        
        $notification = "La información del paciente se actualizó correctamente";
        return redirect('pacientes')->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::patients()->findOrFail($id);
        $pacienteName = $user->name;
        $user->delete();

        $notification = "El paciente $pacienteName se eliminó correctamente";

        return redirect('pacientes')->with(compact('notification'));
    }
}
