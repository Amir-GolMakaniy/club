<?php

use App\Models\Member;
use Livewire\Volt\Component;

new class extends Component {
	public ?Member $member;

	public $first_name;
	public $last_name;
	public $national_code;
	public $birth_date;
	public $phone;

	public $amount;
	public $month;

	public function rules()
	{
		return [
			'first_name' => 'required|string',
			'last_name' => 'required|string',
			'national_code' => 'required|numeric|unique:members,national_code,' . $this->member?->id,
			'birth_date' => 'required|date',
			'phone' => 'required|numeric|min:11',

			'amount' => 'required|numeric',
			'month' => 'required|numeric',
		];
	}

	public function mount()
	{
		$this->first_name = $this->member->first_name;
		$this->last_name = $this->member->last_name;
		$this->national_code = $this->member->national_code;
		$this->birth_date = $this->member->birth_date;
		$this->phone = $this->member->phone;

		if ($this->member->payments()->whereDate('month', now()->startOfMonth())->exists()) {
			$this->amount = $this->member->payments()->whereDate('month', now()->startOfMonth())->get()->amount;
			$this->month = $this->member->payments()->whereDate('month', now()->startOfMonth())->get()->month;
		}
	}

	public function save()
	{
		$this->validate();

		if ($this->member->exists) {
			$this->member->update([
				'first_name' => $this->first_name,
				'last_name' => $this->last_name,
				'national_code' => $this->national_code,
				'birth_date' => $this->birth_date,
				'phone' => $this->phone,
			]);
		} else {
			Member::create([
				'first_name' => $this->first_name,
				'last_name' => $this->last_name,
				'national_code' => $this->national_code,
				'birth_date' => $this->birth_date,
				'phone' => $this->phone,
			]);
		}

		if ($this->member->payments()->whereDate('month', now()->startOfMonth())->exists()) {
			$this->member->payments->update([
				'amount' => $this->amount,
				'month' => $this->month,
			]);
		} else {
			$this->member->payments()->create([
				'amount' => $this->amount,
				'month' => $this->month,
			]);
		}

		return redirect()->route('home');
	}
}; ?>

<flux:container>
    <div clss="flex justify-center">
        <form wire:submit="save()">
            <flux:fieldset class="grid grid-cols-3 gap-4">
                <flux:input label="نام" wire:model.live="first_name"/>
                <flux:input label="نام خانوادگی" wire:model.live="last_name"/>
                <flux:input label="کد ملی" wire:model.live="national_code"/>
            </flux:fieldset>

            <flux:fieldset class="grid grid-cols-2 gap-4">
                <flux:input label="تاریخ تولد" wire:model.live="birth_date"/>
                <flux:input label="شماره تلفن" wire:model.live="phone"/>
            </flux:fieldset>

            <flux:fieldset class="grid grid-cols-2 gap-4">
                <flux:input label="مبلغ" wire:model.live="amount"/>
                <flux:input label="ماه" wire:model.live="month"/>
            </flux:fieldset>
            <flux:button type="submit">ذخیره</flux:button>
        </form>

        <div class="flex justify-center">
            <div class="overflow-x-auto">
                <table class="text-center text-sm border border-zinc-600">
                    <thead class="">
                    <tr>
                        <th class="px-6 py-3">مبلغ</th>
                        <th class="px-6 py-3">ماه</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($member->payments as $payment)
                        <tr class="border border-zinc-600">
                            <td class="px-6 py-4">{{ $payment->amount }}</td>
                            <td class="px-6 py-4">{{ $payment->month }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</flux:container>