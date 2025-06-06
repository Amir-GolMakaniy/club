<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <link rel="stylesheet" href="https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
    <script src="https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
<flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left"/>

    <a href="{{ route('home') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0"
       wire:navigate>
        <x-app-logo/>
    </a>

    <flux:navbar class="-mb-px max-lg:hidden">
        <flux:navbar.item icon="home" :href="route('home')" :current="request()->is('/')" wire:navigate>
            خانه
        </flux:navbar.item>
        <flux:navbar.item icon="user-plus" :href="route('user-create')" :current="request()->is('user/create')"
                          wire:navigate>
            ساخت یوزر
        </flux:navbar.item>
    </flux:navbar>

    <flux:spacer/>

    <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
        <flux:tooltip content="جستجو" position="bottom" class="">
            <livewire:search/>
        </flux:tooltip>


        <flux:tooltip content="تعییر تم" position="bottom">
            <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" variant="subtle">
                <template x-if="$flux.appearance == 'system'">
                    <flux:icon.computer-desktop/>
                </template>
                <template x-if="$flux.appearance == 'light'">
                    <flux:icon.sun/>
                </template>
                <template x-if="$flux.appearance == 'dark'">
                    <flux:icon.moon/>
                </template>
            </flux:button>
        </flux:tooltip>
    </flux:navbar>

    <!-- Desktop User Menu -->
    {{--<flux:dropdown position="top" align="end">
        <flux:profile
                    class="cursor-pointer"
                    :initials="auth()->user()->initials()"
        />

        <flux:menu>
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <flux:menu.radio.group>
                <flux:menu.item :href="route('settings.profile')" icon="cog"
                                wire:navigate>{{ __('Settings') }}</flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>--}}
</flux:header>

<!-- Mobile Menu -->
<flux:sidebar stashable sticky
              class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>

    <a href="{{ route('dashboard') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
        <x-app-logo/>
    </a>

    <flux:navlist variant="outline">
        <flux:navlist.item icon="home" :href="route('home')" :current="request()->routeIs('dashboard')"
                           wire:navigate.hover>
            خانه
        </flux:navlist.item>
        <flux:navlist.item icon="user-plus" :href="route('user-create')" :current="request()->routeIs('dashboard')"
                           wire:navigate.hover>
            ساخت یوزر
        </flux:navlist.item>
    </flux:navlist>
</flux:sidebar>

{{ $slot }}

@fluxScripts
</body>
</html>
