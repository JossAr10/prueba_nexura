@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Empleado</h1>

    <form id="empleadoForm" action="{{ route('empleados.update', $empleado->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3 align-items-center">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
            <div class="col-sm-9">
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $empleado->nombre) }}" class="form-control">
                <small id="error-nombre" class="text-danger"></small>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <label for="email" class="col-sm-3 col-form-label">Correo electrónico:</label>
            <div class="col-sm-9">
                <input type="email" name="email" id="email" value="{{ old('email', $empleado->email) }}" class="form-control">
                <small id="error-email" class="text-danger"></small>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <label for="email" class="col-sm-3 col-form-label">Sexo *</label>
            <div class="col-sm-9">
                 <div class="form-check">
                    <input type="radio" name="sexo" value="M" id="sexoM" class="form-check-input"
                    {{ $empleado->sexo == 'M' ? 'checked' : '' }}>
                    <label for="sexoM" class="form-check-label">Masculino</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="sexo" value="F" id="sexoF" class="form-check-input"
                    {{ $empleado->sexo == 'F' ? 'checked' : '' }}>
                    <label for="sexoF" class="form-check-label">Femenino</label>
                </div>
                <small id="error-sexo" class="text-danger"></small>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <label for="area" class="col-sm-3 col-form-label">Área *</label>
            <div class="col-sm-9">
                <select name="area_id" id="area" class="form-select" required>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ $empleado->area_id == $area->id ? 'selected' : '' }}>
                            {{ $area->nombre }}
                        </option>
                    @endforeach
                </select>
                <small id="error-area" class="text-danger"></small>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <label for="descripcion" class="col-sm-3 col-form-label">Descripción *</label>
            <div class="col-sm-9">
                <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $empleado->descripcion) }}</textarea>
            </div>
            <small id="error-descripcion" class="text-danger"></small>
        </div>

        <div class="row mb-3 align-items-center">
            <label for="boletin" class="col-sm-3 col-form-label"></label>
            <div class="col-sm-9">
                <input 
                    type="checkbox" 
                    name="boletin" 
                    id="boletin" 
                    value="1" 
                    class="form-check-input"
                    {{ $empleado->boletin ? 'checked' : '' }}>
                <label for="boletin">Deseo recibir boletín informativo</label>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <label for="roles" class="col-sm-3 col-form-label">Roles *</label>
            <div class="col-sm-9">
                @foreach($roles as $rol)
                    <div class="form-check mb-2">
                        <input 
                            type="checkbox" 
                            name="roles[]" 
                            value="{{ $rol->id }}" 
                            id="rol_{{ $rol->id }}"
                            class="form-check-input"
                            {{ in_array($rol->id, $empleadoRoles) ? 'checked' : '' }}>
                        <label for="rol_{{ $rol->id }}" class="form-check-label">
                            {{ $rol->nombre }}
                        </label>
                    </div>
                @endforeach
                <small id="error-rol" class="text-danger"></small>
            </div>
        </div>

        {{-- <button type="submit" class="btn btn-primary">Actualizar</button> --}}
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>

    <script>
        document.getElementById("empleadoForm").addEventListener("submit", function(e) {
            let nombre = document.getElementById("nombre").value.trim();
            let errorNombre = document.getElementById("error-nombre");
            errorNombre.innerHTML = "";

            let regex = /^[a-zA-ZÀ-ÿ\s]+$/;

            if (nombre === "") {
                e.preventDefault();
                errorNombre.innerHTML = "El nombre es obligatorio.";
            } else if (!regex.test(nombre)) {
                e.preventDefault();
                errorNombre.innerHTML = "El nombre solo puede contener letras y espacios.";
            }

            // === Validar Correo ===
            let email = document.getElementById("email").value.trim();
            let errorEmail = document.getElementById("error-email");
            errorEmail.innerHTML = "";

            // Expresión regular para validar correo
            let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email === "") {
                e.preventDefault();
                errorEmail.innerHTML = "El correo electrónico es obligatorio.";
            } else if (!regexEmail.test(email)) {
                e.preventDefault();
                errorEmail.innerHTML = "El correo electrónico no es válido.";
            }

            // === Validar Sexo ===
            let sexoSeleccionado = document.querySelector('input[name="sexo"]:checked');
            let errorSexo = document.getElementById("error-sexo");
            errorSexo.innerHTML = "";

            if (!sexoSeleccionado) {
                e.preventDefault();
                errorSexo.innerHTML = "Por favor, selecciona un sexo.";
            }

            // === Validar Área ===
            let area = document.getElementById("area").value;
            let errorArea = document.getElementById("error-area");
            errorArea.innerHTML = "";

            if (area === "") {
                e.preventDefault();
                errorArea.innerHTML = "Por favor, selecciona un área.";
            }

            // === Validar Descripción ===
            let descripcion = document.getElementById("descripcion").value.trim();
            let errorDescripcion = document.getElementById("error-descripcion");
            errorDescripcion.innerHTML = "";

            if (descripcion === "") {
                e.preventDefault();
                errorDescripcion.innerHTML = "La descripción es obligatoria.";
            } else if (descripcion.length < 10) {
                e.preventDefault();
                errorDescripcion.innerHTML = "La descripción debe tener al menos 10 caracteres.";
            }

            // === Validar Rol ===
            let checkboxes = document.querySelectorAll('input[name="roles[]"]'); // TODOS los checkboxes
            let errorRol = document.getElementById("error-rol");
            errorRol.innerHTML = "";

            // Verificar si al menos uno está seleccionado
            let unoSeleccionado = Array.from(checkboxes).some(cb => cb.checked);

            if (!unoSeleccionado) {
                e.preventDefault();
                errorRol.innerHTML = "Por favor, selecciona al menos un rol.";
            }
        });
    </script>
</div>
@endsection

@section('scripts')
@if (session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: "{{ session('success') }}",
        confirmButtonText: 'Aceptar'
    });
});
</script>
@endif
@endsection

@if ($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'error',
        title: '¡Error!',
        html: "{!! implode('<br>', $errors->all()) !!}",
        confirmButtonText: 'Aceptar'
    });
});
</script>
@endif


@if (session('error'))
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: "{{ session('error') }}",
            confirmButtonText: 'Aceptar'
        });
    });
    </script>
@endif
