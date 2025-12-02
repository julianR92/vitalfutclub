<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Persona;
use App\Models\Sede;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Notificaciones;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;






class UserController extends Controller
{
    public function index()
    {
        $sedes = Sede::all();
        return view('livewire/users.index', compact('sedes'));
    }

    public function getData()
    {

        $profes = User::with(['people', 'sedes'])
            ->select('id', 'name', 'email', 'persona_id', 'rol', 'estado')
            ->where('rol', 'profesor')
            ->where('estado', 1)
            ->get();

        return response()->json(['data' => $profes]);
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'tipo_doc' => 'required',
            'documento' => 'required|max:15|unique:personas,documento,' . $request->id,
            'nombres' => 'required|max:20',
            'apellidos' => 'required|max:20',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'required|max:100',
            'telefono' => 'required|numeric|max:999999999999999',
            'correo' => [
                'required',
                'email',
                Rule::unique('users', 'email')->where(function ($query) use ($request) {
                    return $query->where('persona_id', $request->id);
                })->ignore($request->id, 'persona_id'),
            ],
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'


        ]);

        if ($validator->fails()) {
            //devuelve errores a la vista
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }
        $fotoPath = null;
        if (!$request->id) {

            DB::beginTransaction();

            try {

                if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                    $foto = $request->file('photo');

                    $extension = $foto->getClientOriginalExtension();
                    $uuid = (string) Str::uuid(); // genera un UUID como nombre único
                    $fotoName = $uuid . '.' . $extension;
                    $fotoPath = $foto->storeAs('fotos', $fotoName, 'public');
                }
                $fotoUrl = $fotoPath ? asset('storage/' . $fotoPath) : null;

                $persona_id =  DB::table('personas')->insertGetId([
                    'tipo_doc' => $request->tipo_doc,
                    'documento' => $request->documento,
                    'nombres' => $request->nombres,
                    'apellidos' => $request->apellidos,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                    'direccion' => $request->direccion,
                    'telefono' => $request->telefono,
                    'correo' => $request->correo,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),


                ]);
                $password = 'Cc' . $request->documento . '*';
                DB::table('users')->insert([
                    'persona_id' => $persona_id,
                    'name' => $request->nombres . ' ' . $request->apellidos,
                    'email' => $request->correo,
                    'estado' => 1,
                    'rol' => 'profesor',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'password' => Hash::make($password),
                    'profile_photo_path' => $fotoUrl,
                ]);

                $currentUrl = (isset($_SERVER['HTTPS']) ? "https://" : "http://") .
                    $_SERVER['HTTP_HOST'];

                //send Mail
                $detalleCorreo = [
                    'nombres' => $request->nombres . ' ' . $request->apellidos,
                    'documento' => $request->documento,
                    'sede' => $password,
                    'plan' => $request->correo,
                    'Subject' => 'Creacion de Usuario Profesor',
                    'adjunto' => 'NO',
                    'numero_factura' => $currentUrl,
                    'mensaje' => 'PROFESOR',

                ];

                $destinatarios = [$request->correo];
                Mail::to($destinatarios)->queue(new Notificaciones($detalleCorreo));


                DB::commit();
                return response()->json(['success' => true, 'message' => 'Profesor Creado Exitosamente', 'addMessage' => 'La contraseña fue enviada al correo registrado!']);
                // all good
            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
            }
        } else {

            DB::beginTransaction();

            try {
                if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                    $foto = $request->file('photo');

                    $extension = $foto->getClientOriginalExtension();
                    $uuid = (string) Str::uuid(); // genera un UUID como nombre único
                    $fotoName = $uuid . '.' . $extension;
                    $fotoPath = $foto->storeAs('fotos', $fotoName, 'public');
                }
                $fotoUrl = $fotoPath ? config('app.url').'storage/public/fotos/' . $fotoName . '': null;

                $persona_id =  DB::table('personas')->where('id', $request->id)->update([
                    'tipo_doc' => $request->tipo_doc,
                    'documento' => $request->documento,
                    'nombres' => $request->nombres,
                    'apellidos' => $request->apellidos,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                    'direccion' => $request->direccion,
                    'telefono' => $request->telefono,
                    'correo' => $request->correo,
                    'updated_at' => date('Y-m-d H:i:s'),


                ]);
                DB::table('users')->where('persona_id', $request->id)->update([
                    'name' => $request->nombres . ' ' . $request->apellidos,
                    'email' => $request->correo,
                    'profile_photo_path' => $fotoUrl,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);



                DB::commit();
                return response()->json(['success' => true, 'message' => 'Profesor Editado Exitosamente', 'addMessage' => 'Actualizado en el sistema!']);
            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
            }
        }
    }

    public function edit($id)
    {
        $persona = Persona::findOrFail($id);
        return response()->json(['data' => $persona]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->estado = 0;
        $user->save();
        return response()->json(['success' => true, 'message' => 'Usuario Desactivado']);
    }
    public function getSedes($id)
    {

        $user = User::find($id);
        $sedes = $user->sedes;

        if ($user) {
            $data = [
                'user' => $user,
                'sedes' => $user->sedes,
            ];
        } else {
            $data = null; // O maneja el caso de que el usuario no exista
        }
        return response()->json(['data' => $data]);
    }
    public function storeSedes(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'sedes' => 'array'

        ]);

        if ($validator->fails()) {
            //devuelve errores a la vista
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }

        $user = User::find($request->user_id);
        $user->sedes()->sync($request->sedes);
        return response()->json(['success' => true, 'message' => 'Sedes Actualizadas para el profesor ' . $user->name]);
    }

    public function getStaff()
    {

        $domain = config('app.url');

            $profeSergio = (object) [
                'id' => 1,
                'name' => 'Sergio Andres Becerra',
                'profile_photo_path' => $domain . '/assets/img/vitalfut/profe-sergio.jpg'
            ];

        $otrosProfesores  = User::select('id', 'profile_photo_path', 'name')
            ->where('rol', 'profesor')
            ->orderBy('name', 'asc')
            ->where('estado', 1)
            ->get();

        $profes = collect([$profeSergio])->merge($otrosProfesores);

        return response()->json(['members' => $profes]);
    }
}
