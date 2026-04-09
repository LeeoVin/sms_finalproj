@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')

<div class="card" style="max-width:500px; margin:auto;">

    <h2 style="margin-bottom:20px;">Edit Employee</h2>

    <form method="POST" action="{{ route('admin.employees.update', $employee->id) }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom:15px;">
            <label>Name</label>
            <input type="text" name="name" value="{{ $employee->username }}" required style="width:100%;">
        </div>

        <div style="margin-bottom:15px;">
            <label>Email</label>
            <input type="email" name="email" value="{{ $employee->email }}" required style="width:100%;">
        </div>

        <div style="margin-bottom:20px;">
            <label>Role</label>
            <select name="role" style="width:100%;">
                <option value="store_manager" {{ $employee->role=='store_manager'?'selected':'' }}>Store Manager</option>
                <option value="supervisor" {{ $employee->role=='supervisor'?'selected':'' }}>Supervisor</option>
            </select>
        </div>

        <button type="submit" class="btn" style="width:100%;">Update Employee</button>

    </form>

</div>

@endsection