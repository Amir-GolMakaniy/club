<?php

use App\Models\Member;
use Livewire\Volt\Component;

new class extends Component {
	public $search;
	public $members = [];

	public function updatedSearch()
	{
		$this->members = Member::query()
			->where('first_name', $this->search)
			->orWhere('last_name', $this->search)
			->orWhere('national_code', $this->search)
			->orWhere('phone', $this->search)
			->get();
	}
}; ?>

<div>
    <flux:modal.trigger name="search">
        <flux:navbar.item class="!h-10 [&>div>svg]:size-5" icon="magnifying-glass"/>
    </flux:modal.trigger>

    <flux:modal name="search" class="w-full h-full lg:w-96 lg:h-50">
        <flux:input icon="magnifying-glass" label="جستجو" placeholder="جستجو..." wire:model.live="search"/>

        @foreach($members as $member)
            <ul class="flex items-center flex-col mt-4">
                <li>
                    <flux:link href="{{ route('user-edit',$member->id) }}">
                        {{ $member->first_name }} {{ $member->last_name }}
                    </flux:link>
                </li>
            </ul>
        @endforeach

        @if($members == [])
            <ul class="flex items-center flex-col mt-4">
                <li>چیزی پیدا نشد</li>
            </ul>
        @endif
    </flux:modal>
</div>