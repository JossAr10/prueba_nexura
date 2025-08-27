@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Empleados</h1>
    <a href="{{ route('empleados.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus-fill"></i> Crear
    </a>
</div>

<table class="table table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th><i class="bi bi-person-fill"></i> Nombre</th>
            <th><i class="bi bi-at"></i> Email</th>
            <th><i class="bi bi-gender-ambiguous"></i> Sexo</th>
            <th><i class="bi bi-briefcase-fill"></i> Área</th>
            <th><i class="bi bi-envelope-fill"></i> Boletín</th>
            <th><i class="bi bi-pencil-square"></i> Modificar</th>
            <th><i class="bi bi-trash-fill"></i> Eliminar</th>
        </tr>
    </thead>
    <tbody>
        @forelse($empleados as $empleado)
            <tr>
                <td>{{ $empleado->nombre }}</td>
                <td>{{ $empleado->email }}</td>
                <td>{{ $empleado->sexo == 'M' ? 'Masculino' : 'Femenino' }}</td>
                <td>{{ $empleado->area->nombre ?? 'Sin área' }}</td>
                <td>{{ $empleado->boletin ? 'Sí' : 'No' }}</td>
                <td>
                    <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                </td>
                <td>
                    {{-- <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este empleado?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form> --}}
                    <form id="delete-form-{{ $empleado->id }}" action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $empleado->id }})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No hay empleados registrados</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

@section('scripts')
<script>
function confirmDelete(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>>

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

