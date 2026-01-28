@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Recycle Bin
</x-slot:title>
<div>
    <x-breadcrumbs title="Recycle Bin">
        <li class="nav-item">
            <a href="#">Recycle Bin</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <h5>
                Only user data will be restored. Any other data associated with the user (deposit, withdrawals records
                etc..)
                cannot be restored
            </h5>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fullname</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Country</th>
                                    <th>Registered</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr wire:key="{{ $user->id }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('dash/images/avatar.svg') }}"
                                                        alt="" srcset="" class="rounded-circle"
                                                        width="27">
                                                </div>
                                                &nbsp;
                                                <div class="text-left">
                                                    {{ $user->name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->country }}</td>
                                        <td>
                                            {{ $user->created_at->format('D, M d, Y') }}
                                        </td>
                                        <td>
                                            <a class='btn btn-danger btn-sm'
                                                wire:confirm="Are you sure you want to permanently delete this user?"
                                                wire:click.prevent="deleteForever('{{ $user->id }}')">
                                                <x-spinner wire:loading
                                                    wire:target="deleteForever('{{ $user->id }}')" />
                                                Delete forever
                                            </a>
                                            <a class='btn btn-success btn-sm'
                                                wire:confirm="Are you sure you want to restore this user?"
                                                wire:click.prevent="restore('{{ $user->id }}')">
                                                <x-spinner wire:loading wire:target="restore('{{ $user->id }}')" />
                                                Restore
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="pt-3 text-center">
                                            No Data Available
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
