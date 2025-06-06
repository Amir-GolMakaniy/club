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

        {{-- Desktop Table --}}
        <div class="hidden lg:block overflow-x-auto">
            <table class="text-center text-sm border border-zinc-600">
                <thead>
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
                            <flux:button href="{{ route('user-edit',$member->id) }}" variant="ghost">
                                ویرایش
                            </flux:button>
                        </td>

                        <td class="px-6 py-4">
                            <flux:modal.trigger name="d{{ $member->id }}">
                                <flux:button variant="danger" class="cursor-pointer">
                                    حذف
                                </flux:button>
                            </flux:modal.trigger>

                            <flux:modal name="d{{ $member->id }}" class="min-w-[22rem]">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">می خواهید حذف بشود؟</flux:heading>

                                        <flux:text class="mt-2">
                                            <p>به طور کامل حذف می شود</p>
                                        </flux:text>
                                    </div>

                                    <div class="flex gap-2">
                                        <flux:spacer/>

                                        <flux:modal.close>
                                            <flux:button variant="ghost" class="cursor-pointer">لغو</flux:button>
                                        </flux:modal.close>

                                        <flux:modal.close>
                                            <flux:button variant="danger" class="cursor-pointer"
                                                         wire:click="delete({{ $member->id }})">
                                                حذف
                                            </flux:button>
                                        </flux:modal.close>
                                    </div>
                                </div>
                            </flux:modal>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile Table --}}
        <div class="grid lg:hidden gap-4">
            @foreach(Member::query()->orderByDesc('id')->get() as $member)
                <div class="border border-zinc-600 rounded-xl p-4 space-y-2 text-sm">
                    <div><strong>نام:</strong> {{ $member->first_name }}</div>
                    <div><strong>نام خانوادگی:</strong> {{ $member->last_name }}</div>
                    <div><strong>کد ملی:</strong> {{ $member->national_code }}</div>
                    <div><strong>تاریخ تولد:</strong> {{ $member->birth_date }}</div>
                    <div><strong>تلفن:</strong> {{ $member->phone }}</div>

                    <div class="flex gap-2 justify-end pt-2">
                        <flux:button href="{{ route('user-edit', $member->id) }}" variant="ghost">ویرایش</flux:button>

                        <flux:modal.trigger name="m{{ $member->id }}">
                            <flux:button variant="danger">
                                حذف
                            </flux:button>
                        </flux:modal.trigger>

                        <flux:modal name="m{{ $member->id }}" class="min-w-[22rem]">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">می خواهید حذف بشود؟</flux:heading>

                                    <flux:text class="mt-2">
                                        <p>به طور کامل حذف می شود</p>
                                    </flux:text>
                                </div>

                                <div class="flex gap-2">
                                    <flux:spacer/>

                                    <flux:modal.close>
                                        <flux:button variant="ghost" class="cursor-pointer">لغو</flux:button>
                                    </flux:modal.close>

                                    <flux:modal.close>
                                        <flux:button variant="danger" class="cursor-pointer"
                                                     wire:click="delete({{ $member->id }})">
                                            حذف
                                        </flux:button>
                                    </flux:modal.close>
                                </div>
                            </div>
                        </flux:modal>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</flux:container>
