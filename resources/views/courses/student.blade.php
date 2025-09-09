@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-100 flex items-center justify-center p-6">
        <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-4xl">
            <h2 class="text-2xl font-bold text-center text-indigo-600 mb-6">🎥 My Lectures</h2>
            @if ($lectures->isEmpty())
                <div class="text-center py-12">
                    <div class="inline-block p-4 bg-indigo-100 rounded-full mb-4">
                        <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600">No lectures assigned yet.</p>
                </div>
            @else
                <div class="overflow-x-auto" x-data="lecturePlayer">
                    <table class="w-full border-collapse rounded-lg overflow-hidden shadow-lg">
                        <thead class="bg-indigo-600 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left">#</th>
                                <th class="px-6 py-3 text-left">Course Name</th>
                                <th class="px-6 py-3 text-left">Uploaded By</th>
                                <th class="px-6 py-3 text-left">Video</th>
                                <th class="px-6 py-3 text-left">Uploaded At</th>
                                <th class="px-6 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($lectures as $index => $lecture)
                                <tr id="lecture-{{ $lecture->id }}" class="hover:bg-indigo-50 transition">
                                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $lecture->name }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $lecture->teacher->name }}</td>
                                    <td class="px-6 py-4">
                                        <button
                                            @click="openModal(
                                                '{{ $lecture->id }}', 
                                                '{{ $lecture->name }}', 
                                                '{{ $lecture->teacher->name }}',
                                                '{{ $lecture->video_path ? asset('storage/' . $lecture->video_path) : '' }}',
                                                '{{ $lecture->youtube_url ? $lecture->youtube_url : '' }}',
                                                '{{ $lecture->status }}'
                                            )"
                                            class="text-indigo-600 font-medium hover:underline flex items-center">
                                            @if($lecture->youtube_url)
                                                <svg class="w-4 h-4 mr-1 text-red-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                                </svg>
                                                YouTube Video
                                            @else
                                                <svg class="w-4 h-4 mr-1 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ basename($lecture->video_path) }}
                                            @endif
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">{{ $lecture->created_at->format('d M Y, h:i A') }}</td>
                                    <td class="px-6 py-4 status">
                                        @if ($lecture->status === 'completed')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Completed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Beautiful Modal -->
                    <div x-show="open" x-transition.opacity.duration.300ms
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 z-50" x-cloak
                        @click.self="closeModal">
                        <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-2xl w-full max-w-4xl p-6 relative animate-fadeIn">
                            <!-- Close Button -->
                            <button @click="closeModal" class="absolute top-4 right-4 bg-white rounded-full p-2 shadow-md hover:bg-gray-100 transition">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            
                            <!-- Header -->
                            <div class="mb-6">
                                <h3 class="text-2xl font-bold text-indigo-800" x-text="courseName"></h3>
                                <div class="flex items-center mt-2 text-gray-600">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Uploaded by <span class="font-medium" x-text="teacherName"></span></span>
                                </div>
                            </div>
                            
                            <!-- Video Player -->
                            <div class="rounded-xl overflow-hidden shadow-xl bg-black">
                                <!-- Uploaded Video Player -->
                                <div x-show="!isYoutube" class="relative">
                                    <video x-ref="videoPlayer" x-bind:src="videoSrc" class="w-full max-h-[70vh]" controls autoplay
                                        @ended="markAsCompleted(courseId)"></video>
                                    <div x-show="currentStatus !== 'completed'" class="absolute bottom-4 right-4">
                                        <button @click="markAsCompleted(courseId)" 
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center shadow-lg transition">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Mark as Completed
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- YouTube Player -->
                                <div x-show="isYoutube" class="relative">
                                    <iframe x-ref="youtubePlayer" x-bind:src="youtubeSrc" class="w-full h-[70vh]" frameborder="0" allowfullscreen></iframe>
                                    <div x-show="currentStatus !== 'completed'" class="absolute bottom-4 right-4">
                                        <button @click="markAsCompleted(courseId)" 
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center shadow-lg transition">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Mark as Completed
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Footer -->
                            <div class="mt-6 flex justify-between items-center">
                                <div x-show="currentStatus === 'completed'" class="flex items-center text-green-600">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Completed</span>
                                </div>
                                <button @click="closeModal" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition shadow-md">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('lecturePlayer', () => ({
                open: false,
                videoSrc: '',
                youtubeSrc: '',
                isYoutube: false,
                courseId: '',
                courseName: '',
                teacherName: '',
                currentStatus: '',
                videoElement: null,
                youtubeElement: null,
                
                init() {
                    // Video elements ko reference store karo
                    this.$nextTick(() => {
                        this.videoElement = this.$refs.videoPlayer;
                        this.youtubeElement = this.$refs.youtubePlayer;
                    });
                },
                
                openModal(id, name, teacher, video, youtube, status) {
                    this.courseId = id;
                    this.courseName = name;
                    this.teacherName = teacher;
                    this.currentStatus = status;
                    
                    if (youtube) {
                        this.isYoutube = true;
                        this.youtubeSrc = youtube;
                        this.videoSrc = '';
                    } else {
                        this.isYoutube = false;
                        this.videoSrc = video;
                        this.youtubeSrc = '';
                    }
                    
                    this.open = true;
                },
                
                closeModal() {
                    // Video ko stop karo
                    this.stopVideo();
                    
                    // Modal close karo
                    this.open = false;
                },
                
                stopVideo() {
                    if (this.isYoutube) {
                        // YouTube video ko stop karne ke liye iframe reload karo
                        if (this.youtubeElement) {
                            const src = this.youtubeElement.src;
                            this.youtubeElement.src = '';
                            this.youtubeElement.src = src;
                        }
                    } else {
                        // Regular video ko pause aur reset karo
                        if (this.videoElement) {
                            this.videoElement.pause();
                            this.videoElement.currentTime = 0;
                        }
                    }
                },
                
                markAsCompleted(courseId) {
                    fetch('/lectures/complete', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                course_id: courseId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                this.currentStatus = 'completed';
                                
                                const row = document.querySelector(`#lecture-${courseId} .status`);
                                if (row) {
                                    row.innerHTML = `
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Completed
                                        </span>
                                    `;
                                }
                                
                                this.showNotification('✅ ' + this.courseName + ' marked as completed!');
                            } else {
                                this.showNotification('⚠ Something went wrong.', 'error');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            this.showNotification('⚠ Network error. Please try again.', 'error');
                        });
                },
                
                showNotification(message, type = 'success') {
                    const notification = document.createElement('div');
                    notification.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
                    notification.textContent = message;
                    
                    document.body.appendChild(notification);
                    
                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                }
            }))
        })
    </script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
        
        /* Custom scrollbar for table */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #c7d2fe;
            border-radius: 10px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #a5b4fc;
        }
    </style>
@endsection