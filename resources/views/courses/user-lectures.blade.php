@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">
                            @if (Auth::user()->role === 'student')
                                My Lectures
                            @else
                                My Uploaded Lectures
                            @endif
                        </h3>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($lectures->count() > 0)
                            <div class="row">
                                @foreach ($lectures as $lecture)
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title">{{ $lecture->name }}</h5>

                                                <div class="mb-3 flex-grow-1">
                                                    @if ($lecture->video_path)
                                                        <video width="100%" height="200" controls class="rounded">
                                                            <source src="{{ asset('storage/' . $lecture->video_path) }}"
                                                                type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    @elseif($lecture->youtube_url)
                                                        <div class="ratio ratio-16x9">
                                                            <iframe src="{{ $lecture->youtube_url }}" allowfullscreen
                                                                class="rounded"></iframe>
                                                        </div>
                                                    @else
                                                        <div class="bg-light p-5 text-center rounded">
                                                            <i class="bi bi-film display-1 text-muted"></i>
                                                            <p class="mt-2 text-muted">No video available</p>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                                    <div>
                                                        @if (Auth::user()->role === 'student')
                                                            <span class="text-muted">
                                                                <i class="bi bi-person-circle"></i>
                                                                {{ $lecture->teacher->name }}
                                                                @if (isset($lecture->status))
                                                                    <span
                                                                        class="badge bg-{{ $lecture->status === 'completed' ? 'success' : 'warning' }} ms-2">
                                                                        {{ $lecture->status === 'completed' ? 'Completed' : 'Pending' }}
                                                                    </span>
                                                                @endif
                                                            </span>
                                                        @else
                                                            <span class="text-muted">
                                                                <i class="bi bi-person"></i> {{ $lecture->student->name }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    @if (Auth::user()->role === 'student')
                                                        <form action="{{ route('courses.markComplete') }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="course_id"
                                                                value="{{ $lecture->id }}">
                                                            <button type="submit" class="btn btn-sm btn-success"
                                                                {{ $lecture->status === 'completed' ? 'disabled' : '' }}>
                                                                <i class="bi bi-check-circle"></i>
                                                                {{ $lecture->status === 'completed' ? 'Completed' : 'Mark Complete' }}
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-journal-text display-1 text-muted"></i>
                                <h4 class="mt-3 text-muted">No Lectures Found</h4>
                                <p class="text-muted">
                                    @if (Auth::user()->role === 'student')
                                        You don't have any lectures assigned to you yet.
                                    @else
                                        You haven't uploaded any lectures yet.
                                    @endif
                                </p>
                                @if (Auth::user()->role === 'teacher')
                                    <a href="{{ route('add.course') }}" class="btn btn-primary mt-3">
                                        <i class="bi bi-plus-circle"></i> Upload Your First Lecture
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
