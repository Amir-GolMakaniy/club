<?php

use App\Models\Member;
use Livewire\Volt\Component;

new class extends Component {
	public function delete(Member $member)
	{
		$member->delete();
	}
}; ?>

<flux:container>
    <div class="flex items-center flex-col">
        <img src="{{ asset('apple-touch-icon.png') }}" alt="..." class="w-15">
        <h1 class="pt-4 pb-8">اسم باشگاه شما</h1>

        <div class="overflow-x-auto">
            <table class="text-center text-sm border border-zinc-600">
                <thead class="">
                <tr>
                    <th class="px-6 py-3">نام</th>
                    <th class="px-6 py-3">نام خانوادگی</th>
                    <th class="px-6 py-3">کد ملی</th>
                    <th class="px-6 py-3">تاریخ تولد</th>
                    <th class="px-6 py-3">شماره تلفن</th>
                    <th class="px-6 py-3">ویرایش</th>
                    <th class="px-6 py-3">حذف</th>
                </tr>
                </thead>

                <tbody>
                @foreach(Member::query()->orderByDesc('id')->get() as $member)
                    <tr class="border border-zinc-600">
                        <td class="px-6 py-4">{{ $member->first_name }}</td>
                        <td class="px-6 py-4">{{ $member->last_name }}</td>
                        <td class="px-6 py-4">{{ $member->national_code }}</td>
                        <td class="px-6 py-4">{{ $member->birth_date }}</td>
                        <td class="px-6 py-4">{{ $member->phone }}</td>
                        <td class="px-6 py-4">
                            <flux:link href="{{ route('user-edit',$member->id) }}">
                                <flux:icon.pencil/>
                            </flux:link>
                        </td>
                        <td class="px-6 py-4">
                            <flux:icon.user-minus class="cursor-pointer" wire:click="delete({{ $member->id }})"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</flux:container>
