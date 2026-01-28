@use('\Illuminate\Support\Str', 'Str')
@use('\Carbon\Carbon', 'Carbon')
<x-slot:title>
    Tasks
</x-slot:title>
<div>
    <x-breadcrumbs title="Tasks">
        <li class="nav-item">
            <a href="#">Tasks</a>
        </li>
    </x-breadcrumbs>
    <div class="row" x-data="{ taskMode: @entangle('taskMode'), newTask: @entangle('newTask'), updateTask: @entangle('updateTask') }">
        <div class="py-5 col-12" x-show="taskMode" style="display: none">
            @include('livewire.admin.crm.task')
        </div>


        <div class="col-12" x-show="!taskMode">
            @can('add new task')
                <div class="mb-3 text-right">
                    <x-ui.button type="button" @click="taskMode = true; newTask = true; updateTask = false ">
                        Create New
                    </x-ui.button>
                </div>
            @endcan
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Assigned To</th>
                                    <th>Started At</th>
                                    <th>Ended At</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tasks as $task)
                                    <tr wire:key="{{ $task->id }}">
                                        <td>{{ Str::limit($task->title, 80, '...') }}</td>
                                        <td>{{ $task->user->name ?? 'Not Assigned' }}</td>
                                        <td>{{ $task->start_date->format('d M, Y') }}</td>
                                        <td>{{ $task->end_date->format('d M, Y') }}</td>
                                        <td>
                                            <span @class([
                                                'badge',
                                                'badge-danger' => $task->status == 'pending',
                                                'badge-success' => $task->status == 'completed',
                                            ])>{{ Str::ucfirst($task->status) }}</span>
                                        </td>
                                        <td>{{ $task->created_at->toDayDateTimeString() }}</td>
                                        <td x-data="{ confirmDelete: false }">
                                            <div x-show='confirmDelete' style="display: none">
                                                <div class="mb-2">
                                                    <a href="" @click.prevent="confirmDelete = false">
                                                        <span class="p-2 bg-light">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                                <a href="" wire:click.prevent='deleteTask'
                                                    class="btn btn-danger btn-sm">Confirm
                                                    Delete</a>
                                            </div>
                                            <div x-show='!confirmDelete'>
                                                @can('view tasks assigned to them')
                                                    <a href=""
                                                        wire:click.prevent="showTaskInfo('{{ $task->id }}')"
                                                        class="m-1 btn btn-secondary btn-sm">
                                                        <x-spinner wire:loading
                                                            wire:target="showTaskInfo('{{ $task->id }}')" />
                                                        View Info
                                                    </a>
                                                @endcan
                                                @if ($task->status == 'pending')
                                                    @can('edit task')
                                                        <a class="m-1 text-white btn btn-primary btn-sm"
                                                            wire:click.prevent="setUpdate('{{ $task->id }}')">
                                                            <x-spinner wire:loading
                                                                wire:target="setUpdate('{{ $task->id }}')" />
                                                            Edit
                                                        </a>
                                                    @endcan
                                                    @can('mark task as completed')
                                                        <a href=""
                                                            wire:click.prevent="markAs('{{ $task->id }}', 'completed')"
                                                            class="m-1 btn btn-success btn-sm">Completed</a>
                                                    @endcan
                                                @else
                                                    @if (auth()->user()->hasRole('Super Admin'))
                                                        <a href=""
                                                            wire:click.prevent="markAs('{{ $task->id }}', 'pending')"
                                                            class="m-1 btn btn-warning btn-sm">Pending</a>
                                                    @endif
                                                @endif

                                                @can('delete task')
                                                    <a href=""
                                                        @click.prevent="$wire.taskId = '{{ $task->id }}'; confirmDelete = true"
                                                        class="m-1 btn btn-danger btn-sm">Delete</a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <p class="text-center">No Data Available</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" data-background-color="light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Task Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-12">
                                <label>Title</label>
                                <h5>{{ $title }}</h5>
                            </div>
                            <div class="form-group col-12">
                                <label>Description</label>
                                <p>{{ $description }}</p>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Start Date</label>
                                <p>{{ $start_date ? Carbon::parse($start_date)->format('d M, Y') : '' }}</p>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>End Date</label>
                                <p>{{ $end_date ? Carbon::parse($end_date)->format('d M, Y') : '' }}</p>
                            </div>
                            <div class="form-group col-12">
                                <label>Priority</label>
                                <p>{{ $priority }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-slot:scripts>
    @script
        <script>
            $wire.on('show-taskinfo-modal', () => {
                $('#infoModal').modal('show')
            });
        </script>
    @endscript
</x-slot:scripts>
