<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-100 dark:bg-[#101a22] antialiased">
        <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="w-full max-w-md bg-[#1c2630] rounded-2xl shadow-2xl border border-[#283239] p-8">
                {{-- Logo --}}
                <div class="flex flex-col items-center gap-4 mb-8">
                    <div class="size-12 flex items-center justify-center rounded-lg bg-[#1392ec]/10">
                        <x-lucide-waves class="size-8 text-[#1392ec]" />
                    </div>
                    <h1 class="text-2xl font-bold text-white tracking-tight">FluxFlow</h1>
                </div>
                
                {{ $slot }}
            </div>
        </div>
        @fluxScripts
    </body>
</html>
