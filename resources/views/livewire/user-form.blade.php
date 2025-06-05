<?php

use App\Models\Member;
use Livewire\Volt\Component;

new class extends Component {
	public ?Member $member = null;

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
				'birth_date' => 'required|string',
				'phone' => 'required|numeric|',
			'amount' => 'required|numeric',
				'month' => 'required',
		];
	}

	public function mount()
	{
		if ($this->member) {
			$this->first_name = $this->member->first_name;
			$this->last_name = $this->member->last_name;
			$this->national_code = $this->member->national_code;
			$this->birth_date = $this->member->birth_date;
			$this->phone = $this->member->phone;
		}
	}

	public function updatedMonth()
	{
		$month = $this->member->payments()->where('month', $this->month);
		$this->amount = $month->exists() ? $month->first()->amount : null;
	}

	public function save()
	{
		$this->validate();

		$member = $this->member;

		if ($member && $member->exists) {
			$member->update([
				'first_name' => $this->first_name,
				'last_name' => $this->last_name,
				'national_code' => $this->national_code,
				'birth_date' => $this->birth_date,
				'phone' => $this->phone,
			]);
		} else {
			$member = Member::create([
				'first_name' => $this->first_name,
				'last_name' => $this->last_name,
				'national_code' => $this->national_code,
				'birth_date' => $this->birth_date,
				'phone' => $this->phone,
			]);
		}

		if ($member) {
			if ($this->member->payments()->where('month', $this->month)->exists()) {
				$member->payments()->update([
						'amount' => $this->amount,
						'month' => $this->month,
				]);
			} else {
				$member->payments()->create([
						'amount' => $this->amount,
						'month' => $this->month,
				]);
			}
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
				<flux:input mask="9999-99-99" label="تاریخ تولد" wire:model.live="birth_date"/>
                <flux:input label="شماره تلفن" wire:model.live="phone"/>
            </flux:fieldset>

            <flux:fieldset class="grid grid-cols-2 gap-4">
                <flux:input label="مبلغ" wire:model.live="amount"/>
				<flux:select label="ماه پرداخت" wire:model.live="month">
					<flux:select.option value="1">فروردین</flux:select.option>
					<flux:select.option value="2">اردیبهشت</flux:select.option>
					<flux:select.option value="3">خرداد</flux:select.option>
					<flux:select.option value="4">تیر</flux:select.option>
					<flux:select.option value="5">مرداد</flux:select.option>
					<flux:select.option value="6">شهریور</flux:select.option>
					<flux:select.option value="7">مهر</flux:select.option>
					<flux:select.option value="8">آبان</flux:select.option>
					<flux:select.option value="9">آذر</flux:select.option>
					<flux:select.option value="10">دی</flux:select.option>
					<flux:select.option value="11">بهمن</flux:select.option>
					<flux:select.option value="12">اسفند</flux:select.option>
				</flux:select>
            </flux:fieldset>
            <flux:button type="submit">ذخیره</flux:button>
        </form>
    </div>
</flux:container>