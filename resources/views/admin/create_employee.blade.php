@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')

<div class="card" style="max-width:500px; margin:auto;">

    <h2 style="margin-bottom:20px;">Add Employee</h2>

    <form method="POST" action="{{ route('admin.employees.store') }}">
        @csrf

        <div style="margin-bottom:15px;">
            <label>Name</label>
            <input type="text" name="name" required style="width:100%;">
        </div>

        <div style="margin-bottom:15px;">
            <label>Email</label>
            <input type="email" name="email" required style="width:100%;">
        </div>

        <div style="margin-bottom:15px;">
            <label>Role</label>
            <select name="role" style="width:100%;">
                <option value="store_manager">Store Manager</option>
                <option value="supervisor">Supervisor</option>
            </select>
        </div>

        <div style="margin-bottom:20px;">
            <label>Password</label>
            <input type="password" name="password" required style="width:100%;">
        </div>

        <button type="submit" class="btn" style="width:100%;">Save Employee</button>

    </form>

</div>

@endsection