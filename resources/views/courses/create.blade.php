@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-100 flex items-center justify-center p-6">
        <div
            class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-lg transform transition-all duration-300 hover:scale-[1.02]">
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C3 20.447 3.553 21 4.253 21h6.494c.668 0 1.298-.282 1.743-.771.445-.49.705-1.129.705-1.814V6.253z" />
                    </svg>
                </div>
                <h2
                    class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-2">
                    Add New Course</h2>
                <p class="text-gray-600">Create a new course and lecture for your students</p>
            </div>

            @if (session('success'))
                <div
                    class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm flex items-center animate-fadeIn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Course Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C3 20.447 3.553 21 4.253 21h6.494c.668 0 1.298-.282 1.743-.771.445-.49.705-1.129.705-1.814V6.253z" />
                        </svg>
                        Course Name
                    </label>
                    <input type="text" name="name"
                        class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:border-transparent outline-none transition shadow-sm"
                        placeholder="Enter course name" required>
                </div>

                <!-- Student Dropdown -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a3 3 0 015-3m0 0a3 3 0 015-3m0 0a3 3 0 015-3m6 3a3 3 0 01-3 3m6 0a3 3 0 00-3-3m0 0a3 3 0 00-3-3" />
                        </svg>
                        Assign to Student
                    </label>
                    <div class="relative">
                        <select name="student_id"
                            class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:border-transparent outline-none transition shadow-sm appearance-none bg-white"
                            required>
                            <option value="" disabled selected>-- Select Student --</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Lecture Type Selection -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Lecture Type
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label
                            class="flex items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer transition-all duration-200 hover:border-indigo-300 radio-option">
                            <input type="radio" name="lecture_type" value="file" checked class="sr-only peer">
                            <div class="text-center">
                                <div
                                    class="w-12 h-12 mx-auto mb-2 rounded-full bg-indigo-100 flex items-center justify-center peer-checked:bg-indigo-500 peer-checked:text-white transition">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-indigo-500 peer-checked:text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-700 peer-checked:text-indigo-600">Upload Video</span>
                            </div>
                        </label>
                        <label
                            class="flex items-center justify-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer transition-all duration-200 hover:border-indigo-300 radio-option">
                            <input type="radio" name="lecture_type" value="youtube" class="sr-only peer">
                            <div class="text-center">
                                <div
                                    class="w-12 h-12 mx-auto mb-2 rounded-full bg-red-100 flex items-center justify-center peer-checked:bg-red-500 peer-checked:text-white transition">
                                    <svg class="h-6 w-6 text-red-500 peer-checked:text-white"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-700 peer-checked:text-red-600">YouTube URL</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Video Upload -->
                <div id="video-upload-section">
                    <label class="block text-gray-700 font-semibold mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Upload Lecture Video
                    </label>
                    <div
                        class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-indigo-400 transition duration-300 bg-gray-50 hover:bg-indigo-50">
                        <input type="file" name="video" accept="video/*" id="video-upload" class="hidden">
                        <label for="video-upload" class="cursor-pointer">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <p class="text-lg font-medium text-gray-700 mb-1">Click to upload video</p>
                                <p class="text-sm text-gray-500">or drag and drop</p>
                                <p class="text-xs text-gray-400 mt-1">MP4, MKV, AVI up to 30MB</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- YouTube URL -->
                <div id="youtube-url-section" class="hidden">
                    <label class="block text-gray-700 font-semibold mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        YouTube URL
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                            </svg>
                        </div>
                        <input type="text" name="youtube_url" id="youtube_url"
                            class="w-full border-2 border-gray-200 rounded-lg pl-10 pr-4 py-3 focus:ring-2 focus:ring-red-400 focus:border-transparent outline-none transition shadow-sm"
                            placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Paste any YouTube video URL here</p>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-300 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Upload Lecture
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
                        preview.className =
                            'mt-3 p-3 bg-green-50 text-green-700 rounded-lg flex items-center';
                        preview.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Selected:</span> ${videoUpload.files[0].name}
                        `;

                        const existingPreview = videoUploadSection.querySelector('.mt-3');
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

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

        .radio-option {
            transition: all 0.2s ease;
        }

        .radio-option:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        input[type="radio"]:checked+.radio-option {
            border-color: currentColor;
            background-color: rgba(99, 102, 241, 0.05);
        }
    </style>
@endsection
