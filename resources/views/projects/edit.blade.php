@extends('layouts.app')
@section('page-title', 'Edit Project')

@section('topbar-actions')
    <a href="{{ route('projects.index') }}" class="btn-ghost">
        <i class="ti ti-arrow-left"></i> Back
    </a>
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .flatpickr-calendar { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,0.5); }
    .flatpickr-day { color: #ccc; border-radius: 6px; }
    .flatpickr-day:hover { background: #2d2650; color: #fff; }
    .flatpickr-day.selected { background: #7c6af7; border-color: #7c6af7; color: #fff; }
    .flatpickr-months { background: #111; border-radius: 10px 10px 0 0; }
    .flatpickr-month, .flatpickr-current-month { color: #f0f0f0; }
    .flatpickr-current-month select { color: #f0f0f0; background: #111; }
    .flatpickr-weekday { color: #555; }
    .numInputWrapper span svg { fill: #888; }
    .flatpickr-prev-month svg, .flatpickr-next-month svg { fill: #888; }
    .flatpickr-day.today { border-color: #7c6af7; }
</style>

<div style="max-width:600px;">
<div class="card">
    <form method="POST" action="{{ route('projects.update', $project->id) }}">
        @csrf @method('PATCH')

        <div class="mb-3">
            <label class="form-label">Project Name</label>
            <input name="name" class="form-control" value="{{ $project->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" style="resize:none;">{{ $project->description }}</textarea>
        </div>

        <div class="row g-3 mb-3">
            <div class="col">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach(['Planning','Active','On Hold','Completed'] as $s)
                        <option {{ $project->status == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label class="form-label">Priority</label>
                <select name="priority" class="form-select">
                    @foreach(['Low','Medium','High'] as $p)
                        <option {{ $project->priority == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Due Date</label>
            <input type="text" id="due_date_picker" name="due_date" class="form-control"
                value="{{ $project->due_date }}" placeholder="Select due date" autocomplete="off">
        </div>

        <button class="btn-main" type="submit"><i class="ti ti-check"></i> Save Changes</button>
    </form>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr('#due_date_picker', {
        dateFormat: 'Y-m-d',
        defaultDate: '{{ $project->due_date }}',
        disableMobile: true,
    });
</script>

@endsection