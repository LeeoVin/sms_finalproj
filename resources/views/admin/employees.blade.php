@extends('layouts.app')

@section('title', 'Employees')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center;">
    <h2>Employees</h2>
    <a href="{{ route('admin.employees.create') }}" class="btn-add">+ Add Employee</a>
</div>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Branch</th>
            <th style="text-align:center;">Actions</th>
        </tr>
    </thead>

    <tbody>
    @forelse($employees as $emp)
        <tr>
            <td>{{ $emp->username }}</td>
            <td>{{ $emp->email }}</td>
            <td>{{ ucfirst(str_replace('_',' ', $emp->role)) }}</td>
            <td>{{ $emp->branch }}</td>

            <td style="text-align:center;">
                <a href="{{ route('admin.employees.edit', $emp->id) }}" class="btn-edit">Edit</a>

                <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn-delete" onclick="return confirm('Delete employee?')">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" style="text-align:center;">No employees found</td>
        </tr>
    @endforelse
    </tbody>
</table>

@endsection