<div class="col-12" x-data="{ addNew: @entangle('addRef').live }">
    <div class="card">
        <div class="card-body">
            <div x-show="!addNew">
                @if (count($this->referrals) > 0)
                    <div class="mb-3 text-right">
                        <x-ui.button type='button' class="btn-sm" @click="addNew = true">
                            Add New
                        </x-ui.button>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <th>Member Name</th>
                            {{-- <th>Earned</th> --}}
                            <th>Created At</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($this->referrals as $referral)
                                <tr>
                                    <td>{{ $referral->name }}</td>
                                    {{-- <td></td> --}}
                                    <td>{{ $referral->created_at->format('d M Y') }}</td>
                                    <th>
                                        <a href="" wire:click.prevent="removeRef('{{ $referral->id }}')"
                                            class="btn btn-sm btn-danger"> <x-spinner wire:loading
                                                wire:target="removeRef('{{ $referral->id }}')" />Remove</a>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        {{ $this->referrals->links() }}
                    </div>
                @else
                    <div class="text-center">
                        <x-no-data />
                        <h4 class="mb-2 font-weight-bold">No Referred Member</h4>
                        <x-ui.button type='button' @click="addNew = true">
                            Add Member
                        </x-ui.button>
                    </div>
                @endif
            </div>
            <div x-show="addNew">
                <form action="" wire:submit='addRefMember'>
                    <div class="row">
                        <div class="mb-3 col-12">
                            <div wire:ignore>
                                <x-form.label label="Select Member" />
                                <select class="select2 form-control" style="width: 100%">
                                    <option selected disabled>Select Member..</option>
                                    @foreach ($this->users as $member)
                                        <option wire:key='{{ $member->id }}' value="{{ $member->id }}">
                                            {{ $member->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                @error('referree')
                                    <small class="text-xs text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <small class="text-muted">
                                This indicates that the selected user was referred by {{ $user->name }}
                            </small>
                        </div>
                        <div class="col-12">
                            <x-ui.button type='button' @click="addNew = false">
                                Cancel
                            </x-ui.button>
                            <x-ui.button class="btn-info">
                                <x-spinner wire:loading wire:target="addRefMember" />
                                Add Member
                            </x-ui.button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        const selects = $('.select2');
        selects.select2({
            placeholder: "Select member",
            allowClear: true
        });
        selects.on('change', function() {
            $wire.member = this.value;
        });
    </script>
@endscript
