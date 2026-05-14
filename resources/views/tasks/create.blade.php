@extends('layouts.app')
@section('page-title', 'Create Task')

@section('topbar-actions')
    <a href="{{ route('tasks.index') }}" class="btn-ghost">
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
    .flatpickr-day.disabled { color: #444; }
    .flatpickr-months { background: #111; border-radius: 10px 10px 0 0; }
    .flatpickr-month { color: #f0f0f0; }
    .flatpickr-current-month { color: #f0f0f0; }
    .flatpickr-current-month select { color: #f0f0f0; background: #111; }
    .flatpickr-weekday { color: #555; }
    .numInputWrapper span { border-color: #333; }
    .numInputWrapper span svg { fill: #888; }
    .flatpickr-prev-month svg, .flatpickr-next-month svg { fill: #888; }
    .flatpickr-prev-month:hover svg, .flatpickr-next-month:hover svg { fill: #fff; }
    .flatpickr-day.today { border-color: #7c6af7; }
    .flatpickr-day.flatpickr-disabled { color: #333; cursor: not-allowed; }
</style>

<div style="max-width:600px;">
<div class="card">
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Project</label>
            <select name="project_id" id="project_select" class="form-select" required>
                <option value="">Select a project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" data-due="{{ $project->due_date }}">
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
            <div id="project-due-hint" style="font-size:12px; color:#555; margin-top:5px;"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Assign To</label>
            <select name="assigned_user_id" class="form-select">
                <option value="">Unassigned</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Task Title</label>
            <input name="title" class="form-control" placeholder="Enter task title" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Optional description" style="resize:none;"></textarea>
        </div>

        <div class="row g-3 mb-3">
            <div class="col">
                <label class="form-label">Priority</label>
                <select name="priority" class="form-select">
                    <option>Low</option>
                    <option selected>Medium</option>
                    <option>High</option>
                </select>
            </div>
            <div class="col">
                <label class="form-label">Due Date</label>
                <input type="text" id="due_date_picker" name="due_date" class="form-control" placeholder="Select due date" required autocomplete="off">
            </div>
        </div>

        <button class="btn-main" type="submit"><i class="ti ti-plus"></i> Create Task</button>
    </form>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    let duePicker = flatpickr('#due_date_picker', {
        dateFormat: 'Y-m-d',
        minDate: 'today',
        disableMobile: true,
    });

    const projectSelect = document.getElementById('project_select');
    const hint = document.getElementById('project-due-hint');

    projectSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const projectDue = selected.getAttribute('data-due');

        if (projectDue) {
            duePicker.set('maxDate', projectDue);
            hint.textContent = 'Project due date: ' + projectDue + ' — task cannot exceed this.';
            hint.style.color = '#7c6af7';

            // Clear selected date if it exceeds new max
            const current = duePicker.selectedDates[0];
            if (current && current > new Date(projectDue)) {
                duePicker.clear();
            }
        } else {
            duePicker.set('maxDate', null);
            hint.textContent = '';
        }
    });
</script>

@endsection