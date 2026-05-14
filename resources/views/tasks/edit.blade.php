@extends('layouts.app')
@section('page-title', 'Edit Task')

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
    <form method="POST" action="{{ route('tasks.update', $task->id) }}">
        @csrf @method('PATCH')

        <div class="mb-3">
            <label class="form-label">Project</label>
            <select name="project_id" id="project_select" class="form-select">
                @foreach($projects as $project)
                    <option value="{{ $project->id }}"
                        data-due="{{ $project->due_date }}"
                        {{ $task->project_id == $project->id ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
            <div id="project-due-hint" style="font-size:12px; margin-top:5px; color:#7c6af7;"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Assign To</label>
            <select name="assigned_user_id" class="form-select">
                <option value="">Unassigned</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $task->assigned_user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Task Title</label>
            <input name="title" class="form-control" value="{{ $task->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" style="resize:none;">{{ $task->description }}</textarea>
        </div>

        <div class="row g-3 mb-3">
            <div class="col">
                <label class="form-label">Priority</label>
                <select name="priority" class="form-select">
                    @foreach(['Low','Medium','High'] as $p)
                        <option {{ $task->priority == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label class="form-label">Due Date</label>
                <input type="text" id="due_date_picker" name="due_date" class="form-control"
                    value="{{ $task->due_date }}" placeholder="Select due date" autocomplete="off">
            </div>
        </div>

        <button class="btn-main" type="submit"><i class="ti ti-check"></i> Save Changes</button>
    </form>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Get initial project's due date
    const projectSelect = document.getElementById('project_select');
    const hint = document.getElementById('project-due-hint');

    function getSelectedProjectDue() {
        const selected = projectSelect.options[projectSelect.selectedIndex];
        return selected ? selected.getAttribute('data-due') : null;
    }

    const initialMax = getSelectedProjectDue();

    let duePicker = flatpickr('#due_date_picker', {
        dateFormat: 'Y-m-d',
        defaultDate: '{{ $task->due_date }}',
        maxDate: initialMax || null,
        disableMobile: true,
    });

    if (initialMax) {
        hint.textContent = 'Project due date: ' + initialMax + ' — task cannot exceed this.';
    }

    projectSelect.addEventListener('change', function () {
        const projectDue = getSelectedProjectDue();

        if (projectDue) {
            duePicker.set('maxDate', projectDue);
            hint.textContent = 'Project due date: ' + projectDue + ' — task cannot exceed this.';

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