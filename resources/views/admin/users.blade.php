@extends('layouts.app')

@section('content')
    <div class="p-6 bg-white shadow-lg rounded-lg ml-96">
        <h2 class="text-2xl font-bold mb-4">Manage Users</h2>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse border  border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Role</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="border p-2">{{ $user->name }}</td>
                        <td class="border p-2">{{ $user->email }}</td>
                        <td class="border p-2">{{ $user->role }}</td>
                        <td class="border p-2">
                            <span class="{{ $user->status === 'approved' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="border p-2 flex gap-2">
                            <!-- Edit -->
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded">Edit</a>

                            <!-- Delete -->
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-3 py-1 rounded"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
