@extends('layouts.app')

@section('title', 'Employees')
@section('headbar', 'Employee Management')

@section('content')
<div class="card">
    <div class="card-header">Employees List</div>
    <button class="btn" onclick="location.href='{{ route('admin.employees.create') }}'">Add Employee</button>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        @foreach($employees as $employee)
        <tr>
            <td>{{ $employee->name }}</td>
            <td>{{ $employee->email }}</td>
            <td>{{ $employee->role }}</td>
            <td>
                <button class="btn" onclick="location.href='{{ route('admin.employees.edit', $employee->id) }}'">Edit</button>
                <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection