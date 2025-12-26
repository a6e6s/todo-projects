<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    @include('partials.head')
</head>
<body
    x-data="{
        currentProjectId: null,
        init() {
            Livewire.on('project-selected', (data) => {
                this.currentProjectId = data.projectId;
            });
        },
        handleKeydown(e) {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.isContentEditable) return;
            if (e.key === 'n' || e.key === 'N') {
                if (this.currentProjectId) {
                    e.preventDefault();
                    this.$dispatch('open-create-task-modal', { projectId: this.currentProjectId });
                }
            }
            if (e.key === 'p' || e.key === 'P') {
                e.preventDefault();
                this.$dispatch('open-create-project-modal');
            }
        }
    }"
    @keydown.window="handleKeydown($event)"
    class="font-sans bg-slate-100 dark:bg-[#101a22] text-slate-900 dark:text-white overflow-hidden h-screen flex flex-col"
>
    {{-- Header --}}
    <header class="h-16 shrink-0 flex items-center justify-between border-b border-slate-200 dark:border-slate-700/50 bg-white dark:bg-[#111518] px-6 z-20">
        <div class="flex items-center gap-8">
            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 text-[#1392ec]">
                <div class="size-8 flex items-center justify-center rounded-lg bg-[#1392ec]/10">
                    <x-lucide-waves class="size-5 text-[#1392ec]" />
                </div>
                <h2 class="text-slate-900 dark:text-white text-xl font-bold tracking-tight">FluxFlow</h2>
            </a>

            {{-- Search - Trigger for Global Search Modal --}}
            <button
                @click="$dispatch('open-global-search')"
                class="hidden md:flex items-center gap-3 relative group w-64 lg:w-96 px-3 py-2 rounded-lg bg-slate-100 dark:bg-[#283239] hover:bg-slate-200 dark:hover:bg-[#323d46] transition-colors cursor-pointer"
            >
                <x-lucide-search class="size-4 text-slate-400 group-hover:text-[#1392ec] transition-colors" />
                <span class="text-sm text-slate-500">{{ __('app.search_placeholder') }}</span>
                <span class="ml-auto text-xs text-slate-500 border border-slate-600 rounded px-1.5 py-0.5">⌘K</span>
            </button>
        </div>

        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                {{-- Language Switcher --}}
                <div x-data="{ open: false }" class="relative">
                    <button
                        @click="open = !open"
                        class="flex items-center justify-center size-9 rounded-lg hover:bg-slate-100 dark:hover:bg-[#283239] text-slate-500 dark:text-slate-400 transition-colors"
                        title="{{ __('app.language') }}"
                    >
                        <x-lucide-languages class="size-5" />
                    </button>
                    <div
                        x-show="open"
                        x-transition
                        @click.away="open = false"
                        class="absolute right-0 top-full mt-2 w-36 bg-white dark:bg-[#1c2630] border border-slate-200 dark:border-[#283239] rounded-lg shadow-xl z-50 py-1"
                    >
                        <a
                            href="{{ route('language.switch', 'en') }}"
                            @class([
                                'flex items-center gap-2 px-3 py-2 text-sm transition-colors',
                                'text-[#1392ec] bg-[#1392ec]/10' => app()->getLocale() === 'en',
                                'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-[#283239]' => app()->getLocale() !== 'en',
                            ])
                        >
                            <span class="text-base">🇺🇸</span>
                            English
                        </a>
                        <a
                            href="{{ route('language.switch', 'ar') }}"
                            @class([
                                'flex items-center gap-2 px-3 py-2 text-sm transition-colors',
                                'text-[#1392ec] bg-[#1392ec]/10' => app()->getLocale() === 'ar',
                                'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-[#283239]' => app()->getLocale() !== 'ar',
                            ])
                        >
                            <span class="text-base">🇸🇦</span>
                            العربية
                        </a>
                    </div>
                </div>

                {{-- Notifications --}}
                <button class="flex items-center justify-center size-9 rounded-lg hover:bg-slate-100 dark:hover:bg-[#283239] text-slate-500 dark:text-slate-400 transition-colors relative">
                    <x-lucide-bell class="size-5" />
                    <span class="absolute top-2 right-2 size-2 bg-red-500 rounded-full border-2 border-white dark:border-[#111518]"></span>
                </button>

                {{-- Settings --}}
                <a href="{{ route('profile.edit') }}" wire:navigate class="flex items-center justify-center size-9 rounded-lg hover:bg-slate-100 dark:hover:bg-[#283239] text-slate-500 dark:text-slate-400 transition-colors">
                    <x-lucide-settings class="size-5" />
                </a>
            </div>

            <div class="h-6 w-px bg-slate-200 dark:bg-slate-700 mx-2"></div>

            {{-- User Dropdown --}}
            <flux:dropdown position="bottom" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                    class="cursor-pointer"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-[#1392ec]/20 text-[#1392ec]">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs text-slate-500">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </div>
    </header>

    {{-- Main Content --}}
    <div class="flex flex-1 min-h-0 overflow-hidden">
        {{-- Sidebar with @persist for SPA-like navigation --}}
        @persist('sidebar')
            <livewire:project-sidebar />
        @endpersist

        {{-- Main Area --}}
        <main class="flex-1 flex flex-col min-w-0 bg-white dark:bg-[#101a22]">
            {{ $slot }}
        </main>
    </div>

    {{-- Modals & Slide-overs --}}
    <livewire:task-details />
    <livewire:global-search />
    <livewire:create-project-modal />
    <livewire:edit-project-modal />
    <livewire:create-task-modal />

    @fluxScripts
</body>
</html>
