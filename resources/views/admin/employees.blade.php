@extends('layouts.app')

@section('title', 'Employees')

@section('content')

<div class="card">

    <!-- HEADER -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
        <h2>Employees</h2>

        <button class="btn"
            onclick="location.href='{{ route('admin.employees.create') }}'">
            + Add Employee
        </button>
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </thead>

        <tbody>
        @forelse($employees as $emp)
            <tr>
                <td>{{ $emp->username }}</td>
                <td>{{ $emp->email }}</td>

                <td>
                    {{ $emp->role == 'store_manager' ? 'Store Manager' : ucfirst($emp->role) }}
                </td>

                <td style="text-align:center;">

                    <!-- EDIT -->
                    <button class="btn"
                        onclick="location.href='{{ route('admin.employees.edit', $emp->id) }}'">
                        Edit
                    </button>

                    <!-- DELETE -->
                    <form method="POST"
                          action="{{ route('admin.employees.destroy', $emp->id) }}"
                          style="display:inline;"
                          onsubmit="return confirm('Delete this employee?');">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn">Delete</button>
                    </form>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align:center; padding:20px;">
                    No employees found.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>

@endsection