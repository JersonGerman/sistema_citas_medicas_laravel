<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = User::doctors()->paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctors.create');
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
            'name.required' => 'El nombre del médico es obligatorio.',
            'name.min' => 'El nombre del médico debe tener más de 3 carácteres.',
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
                'role' => 'doctor',
                'password' => bcrypt($request->input('password'))
            ]
        );

        $notification = "El médico se ha registrado correctamente";
        return redirect('medicos')->with(compact('notification'));
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
        $doctor = User::doctors()->findOrFail($id);
        return view('doctors.edit', compact('doctor'));
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
            'name.required' => 'El nombre del médico es obligatorio.',
            'name.min' => 'El nombre del médico debe tener más de 3 carácteres.',
            'email.required' => 'El correo eletrónico es obligatorio',
            'email.email' => 'Ingrese una dirección de correo electrónico válido',
            'cedula.required' => 'La cédula es obligatorio',
            'cedula.digits' => 'La cédula debe tener 10 dígitos',
            'address.min' => 'La dirección debe tener al menos 6 carácteres',
            'phone.required' => 'El número de telefono es obligatorio'
        ];
        
        $this->validate($request, $rules, $messages);
        $user = User::doctors()->findOrFail($id);

        $data = $request->only('name', 'email', 'cedula', 'address', 'phone');
        $password = $request->input('password');

        if($password)
            $data['password'] = bcrypt($password);

        $user->fill($data);
        $user->save();
        
        $notification = "La información del médico se actualizó correctamente";
        return redirect('medicos')->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::doctors()->findOrFail($id);
        $doctorName = $user->name;
        $user->delete();

        $notification = "El médico $doctorName se eliminó correctamente";

        return redirect('medicos')->with(compact('notification'));
    }
}
