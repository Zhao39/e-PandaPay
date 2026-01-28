<?php

namespace App\Livewire\Admin\Crm;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Tasks extends Component
{
    use LivewireAlert;

    public $taskMode = false;
    public $newTask = false;
    public $updateTask = true;
    public $title;
    public $priority = 'Immediately';
    public $description;
    public $start_date;
    public $end_date;
    public $user_id;
    public $status = 'pending';
    public $sendEmail = false;
    public $taskId;
    public Task $task;

    #[Computed]
    public function admins(): Collection
    {
        return User::isAdmin()->latest()->get();
    }

    public function render()
    {
        $user = User::find(auth()->user()->id);
        if (! $user->hasRole('Super Admin') && $user->can('view tasks assigned to them')) {
            $tasks = Task::with('user')->where('user_id', $user->id)->latest()->paginate(10);
        } else {
            $tasks = Task::with('user')->latest()->paginate(10);
        }
        return view('livewire.admin.crm.tasks', [
            'tasks' => $tasks,
        ]);
    }

    public function setNew(): void
    {
        Gate::authorize('add new task');
        $this->taskMode = true;
        $this->newTask = true;
        $this->updateTask = false;
    }

    public function setUpdate(string $id): void
    {
        Gate::authorize('edit task');
        $task = $this->task = Task::find($id);
        // modify the start and end date
        $task->start_date = $task->start_date->format('Y-m-d');
        $task->end_date = $task->end_date->format('Y-m-d');
        $this->fill($task);
        $this->taskMode = true;
        $this->updateTask = true;
        $this->newTask = false;
    }

    public function showTaskInfo(string $id): void
    {
        $task = $this->task = Task::find($id);
        $this->fill($task);
        $this->dispatch('show-taskinfo-modal');
    }

    public function resetProps(): void
    {
        $this->reset();
    }

    public function save(): void
    {
        $validated = $this->validate([
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:300'],
            'description' => ['required'],
            'priority' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'status' => ['required'],
        ]);

        if ($this->newTask) {
            Gate::authorize('add new task');
            Task::create($validated);
            $this->alert(type: 'success', message: 'Task created Successfully.');
        }

        if ($this->updateTask) {
            Gate::authorize('edit task');
            $this->task->update($validated);
            $this->alert(type: 'success', message: 'Task updated Successfully.');
        }
        $this->resetProps();
    }

    public function markAs(string $id, string $status): void
    {
        Gate::authorize('mark task as completed');
        Task::find($id)->update(['status' => $status]);
        $this->alert(type: 'success', message: 'Action Successful.');
    }

    public function deleteTask(): void
    {
        Gate::authorize('delete task');
        Task::find($this->taskId)->delete();
        $this->taskId = null;
        $this->alert(type: 'success', message: 'Task deleted Successfully.');
    }
}
