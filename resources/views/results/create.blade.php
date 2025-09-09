@extends('layouts.app')
@section('content')

    <div class="min-h-screen bg-gray-100 flex items-center justify-center py-10">
        <div class="bg-white shadow-lg rounded-lg w-full max-w-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Enter Student Result</h2>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('results.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="student_id" class="block mb-1 font-medium text-gray-700">Select Student</label>
                    <select name="student_id" id="student_id"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">-- Select Student --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="subject" class="block mb-1 font-medium text-gray-700">Subject</label>
                    <input type="text" name="subject" id="subject" placeholder="Enter subject"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label for="marks" class="block mb-1 font-medium text-gray-700">Marks Obtained</label>
                    <input type="number" name="marks" id="marks"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label for="total_marks" class="block mb-1 font-medium text-gray-700">Total Marks</label>
                    <input type="number" name="total_marks" id="total_marks"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition-colors">
                    Save Result
                </button>
            </form>
        </div>
    </div>

@endsection
