<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Empleado;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        $areas = Area::all();
        $roles = Rol::all();

        return view('empleados.create', compact('areas', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'email'       => 'required|email|unique:empleados',
            'sexo'        => 'required|in:M,F',
            'area_id'     => 'required|integer|exists:areas,id',
            'descripcion' => 'required|string',
            'boletin'     => 'nullable|boolean',
            'roles'       => 'required|array|min:1', // al menos un rol
            'roles.*'     => 'integer|exists:roles,id', // cada rol debe existir en la tabla
        ],[
            'nombre.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El campo email debe ser una dirección de correo válida.',
            'email.unique' => 'El email ya está registrado.',
            'sexo.required' => 'El campo sexo es obligatorio.',
            'sexo.in' => 'El sexo debe ser Masculino o Femenino.',
            'area_id.required' => 'El campo área es obligatorio.',
            'area_id.exists' => 'El área seleccionada no es válida.',
            'descripcion.required' => 'El campo descripción es obligatorio.',
            'roles.required' => 'Debe seleccionar al menos un rol.', // mensaje si no selecciona ninguno
            'roles.array' => 'Los roles seleccionados no son válidos.',
            'roles.*.exists' => 'El rol seleccionado no es válido.', // mensaje si algún rol no existe
        ]);

        // CREAR NUEVO EMPLEADO
        $empleado = Empleado::create([
            'nombre'      => $request->nombre,
            'email'       => $request->email,
            'sexo'        => $request->sexo,
            'area_id'     => $request->area_id,
            'descripcion' => $request->descripcion,
            'boletin'     => $request->has('boletin') ? 1 : 0,
        ]);

        // Guardar roles en la tabla pivot (si la tienes creada)
        if ($request->filled('roles')) {
            $empleado->roles()->sync($request->roles);
        }

        return redirect()->route('empleados.index')
                        ->with('success', 'Empleado creado correctamente.');
    }

    public function show(Empleado $empleado)
    {
        return view('empleados.show', compact('empleado'));
    }

    public function edit(Empleado $empleado)
    {
        $areas = Area::all();
        $roles = Rol::all();

        $empleadoRoles = $empleado->roles->pluck('id')->toArray();
        return view('empleados.edit', compact('empleado', 'areas', 'roles', 'empleadoRoles'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:empleados,email,'.$empleado->id,
            'sexo' => 'required|in:M,F',
            'area_id' => 'required|integer|exists:areas,id',
            'descripcion' => 'required|string',
            'roles' => 'required|array|min:1',
            'roles.*' => 'integer|exists:roles,id',
        ],[
            'nombre.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El campo email debe ser una dirección de correo válida.',
            'email.unique' => 'El email ya está registrado.',
            'sexo.required' => 'El campo sexo es obligatorio.',
            'sexo.in' => 'El sexo debe ser Masculino o Femenino.',
            'area_id.required' => 'El campo área es obligatorio.',
            'area_id.exists' => 'El área seleccionada no es válida.',
            'descripcion.required' => 'El campo descripción es obligatorio.',
            'roles.required' => 'Debe seleccionar al menos un rol.',
            'roles.array' => 'Los roles seleccionados no son válidos.',
            'roles.*.exists' => 'El rol seleccionado no es válido.',
        ]);

        // $empleado->update($request->except('roles'));

        // // sincronizar roles
        // $empleado->roles()->sync($request->input('roles', []));

        // return redirect()->route('empleados.index')
        //                 ->with('success','Empleado actualizado correctamente.');

        try {
            $empleado->update($request->except('roles'));
            
            // Forzar error: sincronizar un rol que no existe
            // $empleado->roles()->sync([999]);

            // sincronizar roles
            $empleado->roles()->sync($request->input('roles', []));

            return redirect()->route('empleados.index')
                            ->with('success','Empleado actualizado correctamente.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Error de base de datos: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un problema: ' . $e->getMessage());
        }
    }

    public function destroy(Empleado $empleado)
    {
        $empleado->roles()->detach(); // si estás usando roles
        $empleado->delete();
        return redirect()->route('empleados.index')
                         ->with('success','Empleado eliminado correctamente.');
    }
}
