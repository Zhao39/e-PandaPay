@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Manage plans
</x-slot:title>
<x-slot:styles>
    <link rel="stylesheet" href="{{ asset('dash/css/style.css') }}">
</x-slot:styles>
<div>
    <x-breadcrumbs title="Investment Plans">
        <li class="nav-item">
            <a href="#">Investment Plans</a>
        </li>
    </x-breadcrumbs>
    <div class="row" x-data="{
        showAlert: false,
        expirationTime: 24 * 60 * 60 * 1000,
        init() {
            const storedData = localStorage.getItem('alertDismissed');
            if (storedData) {
                const { timestamp } = JSON.parse(storedData);
                const now = new Date().getTime();
                if (now - timestamp < this.expirationTime) {
                    this.showAlert = false;
                } else {
                    localStorage.removeItem('alertDismissed');
                    this.showAlert = true;
                }
            } else {
                this.showAlert = true;
            }
        },
        dismissAlert() {
            const now = new Date().getTime();
            const alertData = { timestamp: now };
            localStorage.setItem('alertDismissed', JSON.stringify(alertData));
            this.showAlert = false;
        }
    }">
        <div class="col-12" style="display: none" x-show="showAlert">
            <div class="alert alert-info">
                <i class="fas fa-exclamation-triangle"></i>
                Users cannot invest in an inactive plan.
                Plan status is useful when you want to display to your users a plan but you do not
                want them to invest in it at the moment. Users already subscribed to an inactive plan
                would still receive ROI till the plan expires, but will not be able to purchase it.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="dismissAlert">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>

        @if ($this->plans->count() > 0 && !$updateMode && !$newPlan)
            <div class="col-12">
                <div class="mb-2 text-right">
                    @can('create investment plan')
                        <a href="" class="btn btn-primary" wire:click.prevent="$set('newPlan', true)">
                            <i class="fa fa-plus" wire:loading.remove wire:target='newPlan'></i>
                            <x-spinner wire:loading wire:target="newPlan" />
                            Add New
                        </a>
                    @endcan
                </div>
            </div>
        @endif
        @if ($newPlan)
            <div class="col-12">
                @include('livewire.admin.investment-plan.includes.new-plan')
            </div>
        @endif
        @if (!$newPlan)
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($this->plans->count() === 0)
                            <div class="text-center">
                                <img src="{{ asset('themes/default/assets/media/auth/404.png') }}" alt=""
                                    class="w-25">
                                <div>
                                    @can('create investment plan')
                                        <a href="" class="btn btn-primary"
                                            wire:click.prevent="$set('newPlan', true)">
                                            <i class="fa fa-plus" wire:loading.remove wire:target='newPlan'></i>
                                            <x-spinner wire:loading wire:target="newPlan" />
                                            Add New
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        @endif
                        @if ($this->plans->count() > 0)
                            <div>
                                @if ($updateMode)
                                    <div>
                                        @include('livewire.admin.investment-plan.includes.edit-plan')
                                    </div>
                                @endif
                                @if (!$updateMode)
                                    <div class="table-responsive">
                                        <table class="table mt-3">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Minimum Deposit</th>
                                                    <th scope="col">Maximum Deposit</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($this->plans as $plan)
                                                    <tr>
                                                        <td>{{ $plan->name }}</td>
                                                        <td>{{ Number::currency($plan->price, $settings->s_currency) }}
                                                        </td>
                                                        <td>
                                                            {{ Number::currency($plan->min_price, $settings->s_currency) }}
                                                        </td>
                                                        <td>
                                                            {{ Number::currency($plan->max_price, $settings->s_currency) }}
                                                        </td>
                                                        <td>
                                                            <span
                                                                @class([
                                                                    'badge',
                                                                    'badge-danger' => $plan->status == 'inactive',
                                                                    'badge-success' => $plan->status == 'active',
                                                                ])>{{ Str::ucfirst($plan->status) }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-secondary btn-sm dropdown-toggle"
                                                                    type="button" data-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                    <x-spinner wire:loading
                                                                        wire:target="setUpdateMode({{ $plan->id }})" />
                                                                    Action
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="#"
                                                                        data-toggle="modal" data-target="#infoModal"
                                                                        wire:click.prevent="showInfo({{ $plan->id }})">View
                                                                        More Info
                                                                    </a>
                                                                    @can('edit investment plan')
                                                                        @if ($plan->status == 'active')
                                                                            <a class="dropdown-item" href="#"
                                                                                wire:click.prevent="markAs('{{ $plan->id }}', 'inactive')">Mark
                                                                                as inactive</a>
                                                                        @else
                                                                            <a class="dropdown-item" href="#"
                                                                                wire:click.prevent="markAs('{{ $plan->id }}', 'active')">Mark
                                                                                as active</a>
                                                                        @endif
                                                                        <a class="dropdown-item" href="#"
                                                                            wire:click.prevent="setUpdateMode({{ $plan->id }})">
                                                                            Edit
                                                                        </a>
                                                                    @endcan
                                                                    @can('delete investment plan')
                                                                        <a class="dropdown-item text-danger"
                                                                            data-toggle="modal" data-target="#deleteModal"
                                                                            wire:click.prevent="setPlan({{ $plan->id }})"
                                                                            href="#">Delete</a>
                                                                    @endcan

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        {{ $this->plans->links() }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!--Plan Info Modal -->
    <div wire:ignore.self class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" data-background-color="light">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Plan Info</h5>
                    <button type="button" class="close" data-dismiss="modal" wire:click='resetProps'
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div><x-spinner wire:loading /></div>
                    <div class="pricing-table">
                        <div class="text-center">
                            <h2>{{ $name }}</h2>
                        </div>
                        <!-- Price -->
                        <div class="price-tag">
                            <span class="symbol ">{{ $settings->currency }}</span>
                            <span class="amount ">{{ number_format(floatval($price)) }}</span>
                        </div>
                        <!-- Features -->
                        <div class="pricing-features">
                            <div class="mb-2 feature text-dark">
                                <strong> Minimum Deposit:</strong>
                                <span>{{ Number::currency(floatval($min_price), $settings->s_currency) }}</span>
                            </div>
                            <div class="mb-2 feature text-dark">
                                <strong> Maximum Deposit:</strong>
                                <span>{{ Number::currency(floatval($max_price), $settings->s_currency) }}</span>
                            </div>
                            <div class="mb-2 feature text-dark">
                                <strong> Minimum Return: </strong>
                                <span>{{ Number::percentage(floatval($min_return)) }}</span>
                            </div>
                            <div class="mb-2 feature text-dark">
                                <strong> Maximum Return:</strong>
                                <span>{{ Number::percentage(floatval($min_return)) }}</span>
                            </div>
                            <div class="mb-2 feature text-dark">
                                <strong> Bonus: </strong>
                                <span>{{ Number::currency(floatval($bonus), $settings->s_currency) }}</span>
                            </div>
                            <div class="mb-2 feature text-dark">
                                <strong> Increment Interval: </strong>
                                <span>{{ $increment_interval }}</span>
                            </div>
                            <div class="mb-2 feature text-dark">
                                <strong> Increment Type:</strong>
                                <span>{{ $increment_type }}</span>
                            </div>
                            <div class="mb-2 feature text-dark">
                                <strong> Increment Amount(s):</strong>
                                @php
                                    $values = explode(',', $increment_amount);
                                @endphp
                                @if ($increment_type == 'Fixed')
                                    @foreach ($values as $item)
                                        <span>
                                            {{ Number::currency(floatval($item), $settings->s_currency) }}
                                            @if ($loop->last)
                                                -
                                            @endif
                                        </span>
                                    @endforeach
                                @else
                                    @foreach ($values as $item)
                                        <span>
                                            {{ Number::percentage(floatval($item), 1) }}
                                            @if (!$loop->first)
                                                -
                                            @endif
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="mb-2 feature text-dark">
                                <strong> Plan Duration:</strong>
                                <span>{{ $duration }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click='resetProps' class="btn btn-secondary btn-sm"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Plan Modal -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" data-background-color="light">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Are you sure want to delete this plan?</h4>
                    <p>If a user have bought this plan, it will also be deleted.</p>
                    <div class="float-right text-right">
                        <button type="button" class="btn btn-secondary close-btn"
                            data-dismiss="modal">Close</button>
                        <button type="button" wire:click.prevent="deletePlan" class="btn btn-danger close-modal"
                            data-dismiss="modal">Yes,
                            Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Delete Plan Modal --}}
</div>
