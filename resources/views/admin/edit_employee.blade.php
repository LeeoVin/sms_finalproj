@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')

<h2>Edit Employee</h2>

<form method="POST" action="{{ route('admin.employees.update', $employee->id) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="name" value="{{ $employee->username }}" required>
    </div>

    <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" value="{{ $employee->email }}" required>
    </div>

    <div class="form-group">
        <label>Role</label>
        <select name="role">
            <option value="store_manager" {{ $employee->role == 'store_manager' ? 'selected' : '' }}>
                Store Manager
            </option>
            <option value="supervisor" {{ $employee->role == 'supervisor' ? 'selected' : '' }}>
                Supervisor
            </option>
        </select>
    </div>

    <div class="form-group">
        <label>Branch</label>
        <input type="text" name="branch" value="{{ $employee->branch }}" required>
    </div>

    <div class="form-group">
        <label>Password (leave blank if unchanged)</label>
        <input type="password" name="password">
    </div>

    <button type="submit" class="btn-submit">Update Employee</button>

</form>

@endsection