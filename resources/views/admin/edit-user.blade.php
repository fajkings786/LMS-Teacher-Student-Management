@extends('layouts.app')

@section('content')
    <div class="p-6 bg-white shadow-lg rounded-lg max-w-lg mx-auto">
        <h2 class="text-xl font-bold mb-4">Edit User</h2>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="block">Role</label>
                <select name="role" class="w-full border p-2 rounded">
                    <option value="Admin" {{ $user->role === 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Teacher" {{ $user->role === 'Teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="Student" {{ $user->role === 'Student' ? 'selected' : '' }}>Student</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="block">Status</label>
                <select name="status" class="w-full border p-2 rounded">
                    <option value="pending" {{ $user->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $user->status === 'approved' ? 'selected' : '' }}>Approved</option>
                </select>
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
@endsection
