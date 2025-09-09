@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-100 flex items-center justify-center p-6">
        <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-lg">
            <h2 class="text-2xl font-bold text-center text-indigo-600 mb-6">📚 Add New Course + Lecture</h2>
            
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Course Name -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Course Name</label>
                    <input type="text" name="name"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 outline-none transition" required>
                </div>
                
                <!-- Student Dropdown -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Assign to Student</label>
                    <select name="student_id"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 outline-none transition" required>
                        <option value="">-- Select Student --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Lecture Type Selection -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Lecture Type</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="lecture_type" value="file" checked class="mr-2">
                            <span>Upload Video</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="lecture_type" value="youtube" class="mr-2">
                            <span>YouTube URL</span>
                        </label>
                    </div>
                </div>
                
                <!-- Video Upload -->
                <div id="video-upload-section">
                    <label class="block text-gray-700 font-medium mb-2">Upload Lecture Video</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-indigo-400 transition">
                        <input type="file" name="video" accept="video/*" id="video-upload" class="hidden">
                        <label for="video-upload" class="cursor-pointer">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-sm text-gray-600">Click to upload or drag and drop</p>
                                <p class="text-xs text-gray-500 mt-1">MP4, MKV, AVI up to 30MB</p>
                            </div>
                        </label>
                    </div>
                </div>
                
                <!-- YouTube URL -->
                <div id="youtube-url-section" class="hidden">
                    <label class="block text-gray-700 font-medium mb-2">YouTube URL</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                            </svg>
                        </div>
                        <input type="text" name="youtube_url" id="youtube_url"
                            class="w-full border rounded-lg pl-10 px-4 py-2 focus:ring-2 focus:ring-indigo-400 outline-none transition"
                            placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Paste any YouTube video URL here</p>
                </div>
                
                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    🚀 Upload Lecture
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const videoUploadSection = document.getElementById('video-upload-section');
            const youtubeUrlSection = document.getElementById('youtube-url-section');
            const videoUpload = document.getElementById('video-upload');
            const youtubeUrl = document.getElementById('youtube_url');
            
            // Handle lecture type selection
            document.querySelectorAll('input[name="lecture_type"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'file') {
                        videoUploadSection.classList.remove('hidden');
                        youtubeUrlSection.classList.add('hidden');
                        videoUpload.required = true;
                        youtubeUrl.required = false;
                    } else {
                        videoUploadSection.classList.add('hidden');
                        youtubeUrlSection.classList.remove('hidden');
                        videoUpload.required = false;
                        youtubeUrl.required = true;
                    }
                });
            });
            
            // File upload preview
            videoUpload.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.createElement('div');
                        preview.className = 'mt-2 text-sm text-gray-600';
                        preview.innerHTML = `<strong>Selected:</strong> ${videoUpload.files[0].name}`;
                        
                        const existingPreview = videoUploadSection.querySelector('.mt-2');
                        if (existingPreview) {
                            existingPreview.remove();
                        }
                        
                        videoUploadSection.appendChild(preview);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endsection