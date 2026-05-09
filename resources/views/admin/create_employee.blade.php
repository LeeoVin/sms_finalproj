@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')

<div class="form-container">

    <h2 class="page-title">Add Employee</h2>

    <form method="POST" action="{{ route('admin.employees.store') }}">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role">
                <option value="store_manager">Store Manager</option>
                <option value="supervisor">Supervisor</option>
            </select>
        </div>

        <div class="form-group">
            <label>Branch</label>
            <input type="text" name="branch" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button class="btn-submit full-width">Save Employee</button>
    </form>

</div>

@endsection