<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/favicon.ico') }}" />
        <link rel="mask-icon" href="{{ asset('/favicon.ico') }}" color="#ff2d20" />

        {{-- Currency --}}
        <script
            type="text/javascript"
            src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js"
        ></script>

        {{-- ChartJS --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

        {{-- Flatpickr --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        {{-- Cropper.js --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />

        {{-- Sortable.js --}}
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.1/Sortable.min.js"></script>

        {{-- TinyMCE --}}
        <script
            src="https://cdn.tiny.cloud/1/kecao1uumzo3qt3o90pztdtlp82b4ctv8tkvsrjgcx34ock5/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"
        ></script>

        {{-- PhotoSwipe --}}
        <script src="https://cdn.jsdelivr.net/npm/photoswipe@5.4.3/dist/umd/photoswipe.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/photoswipe@5.4.3/dist/umd/photoswipe-lightbox.umd.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/photoswipe@5.4.3/dist/photoswipe.min.css" rel="stylesheet" />

        {{-- DIFF2HTML --}}
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.7.1/styles/github.min.css"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="https://cdn.jsdelivr.net/npm/diff2html/bundles/css/diff2html.min.css"
        />
        <script
            type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/diff2html/bundles/js/diff2html-ui.min.js"
        ></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
        @yield('styles')
    </head>
    <body class="min-h-screen bg-base-200/50 font-sans antialiased">
        {{-- The navbar with `sticky` and `full-width` --}}
        <x-nav
            sticky
            full-width
            class="supports-backdrop-blur:bg-white/95 backdrop-blur transition-colors duration-500 dark:border-slate-50/[0.06] lg:border-slate-900/10 lg:bg-inherit"
        >
            <x-slot:brand>
                {{-- Drawer toggle for "main-drawer" --}}
                <label for="main-drawer" class="mr-3 lg:hidden">
                    <x-icon name="o-bars-3" class="cursor-pointer" />
                </label>

                {{-- Brand --}}
                <x-brand />
            </x-slot>

            {{-- Right side actions --}}
            <x-slot:actions>
                <x-button label="Messages" icon="o-envelope" link="###" class="btn-ghost btn-sm" responsive />
                <x-button label="Notifications" icon="o-bell" link="###" class="btn-ghost btn-sm" responsive />
                <x-header.user-menu />
            </x-slot>
        </x-nav>

        <x-main full-width with-nav>
            <x-slot:sidebar
                drawer="main-drawer"
                collapsible
                class="border-r border-r-gray-200 bg-base-100 dark:border-r-slate-50/[0.06] lg:bg-inherit"
            >
                <x-vertical-menu />
            </x-slot>

            {{-- The `$slot` goes here --}}
            <x-slot:content class="relative">
                {{ $slot }}

                <div class="mt-5 flex">
                    <x-button
                        label="Source code"
                        icon="o-code-bracket"
                        link="https://github.com/iurigustavo/laravel-havitkit"
                        class="btn-ghost"
                        external
                    />
                    <x-button
                        label="Built with maryUI"
                        icon="o-heart"
                        link="https://mary-ui.com"
                        class="btn-ghost !text-pink-500"
                        external
                    />
                </div>
            </x-slot>
        </x-main>

        {{-- Toast --}}
        <x-toast />

        {{-- Spotlight --}}
        <x-spotlight search-text="Users, roles or any action ..." />

        {{-- Theme Toggle --}}
        <x-theme-toggle class="hidden" />
        @stack('scripts')
    </body>
</html>
