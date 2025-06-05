<?php

use App\Models\Member;
use Livewire\Volt\Component;
use Morilog\Jalali\Jalalian;

new class extends Component {
	public ?Member $member = null;

	public $first_name;
	public $last_name;
	public $national_code;
	public $birth_date;
	public $phone;
	public $amount;
	public $date;

	public function rules()
	{
		return [
			'first_name' => 'required|string',
			'last_name' => 'required|string',
			'national_code' => 'required|numeric|unique:members,national_code,' . $this->member?->id,
				'birth_date' => 'required|string',
				'phone' => 'required|numeric|',
			'amount' => 'required|numeric',
				'date' => 'required',
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

			$this->date = Jalalian::now()->format('Y-m-01');
			$this->updatedDate();
		}
	}

	public function updatedDate()
	{
		if ($this->member) {
			$payment = $this->member->payments()->where('date', $this->date)->first();
			$this->amount = $payment?->amount;
		}
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
			$payment = $member->payments()->where('date', $this->date)->first();

			if ($payment) {
				$payment->update([
						'amount' => $this->amount,
				]);
			} else {
				$member->payments()->create([
						'amount' => $this->amount,
						'date' => $this->date,
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
				<flux:select label="ماه پرداخت" wire:model.live="date">
					<flux:select.option selected value="{{ New Jalalian(Jalalian::now()->getYear(),'01','01') }}">
						فروردین
					</flux:select.option>
					<flux:select.option value="{{ New Jalalian(Jalalian::now()->getYear(),'02','01') }}">
						اردیبهشت
					</flux:select.option>
					<flux:select.option value="{{ New Jalalian(Jalalian::now()->getYear(),'03','01') }}">
						خرداد
					</flux:select.option>
					<flux:select.option value="{{ New Jalalian(Jalalian::now()->getYear(),'04','01') }}">
						تیر
					</flux:select.option>
					<flux:select.option value="{{ New Jalalian(Jalalian::now()->getYear(),'05','01') }}">
						مرداد
					</flux:select.option>
					<flux:select.option value="{{ New Jalalian(Jalalian::now()->getYear(),'06','01') }}">
						شهریور
					</flux:select.option>
					<flux:select.option value="{{ New Jalalian(Jalalian::now()->getYear(),'07','01') }}">
						مهر
					</flux:select.option>
					<flux:select.option value="{{ New Jalalian(Jalalian::now()->getYear(),'08','01') }}">
						آبان
					</flux:select.option>
					<flux:select.option value="{{ New Jalalian(Jalalian::now()->getYear(),'09','01') }}">
						آذر
					</flux:select.option>
					<flux:select.option value="{{ New Jalalian(Jalalian::now()->getYear(),'10','01') }}">
						دی
					</flux:select.option>
					<flux:select.option value="{{ New Jalalian(Jalalian::now()->getYear(),'11','01') }}">
						بهمن
					</flux:select.option>
					<flux:select.option value="{{ New Jalalian(Jalalian::now()->getYear(),'12','01') }}">
						اسفند
					</flux:select.option>
				</flux:select>
            </flux:fieldset>
            <flux:button type="submit">ذخیره</flux:button>
        </form>
    </div>
</flux:container>