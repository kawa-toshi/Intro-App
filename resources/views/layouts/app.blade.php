<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ secure_asset('css/reset.css') }}">
        <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
        <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
        <link rel="stylesheet" href="{{ asset('css/varia.css') }}">
        <link rel="stylesheet" href="{{ asset('css/mixin.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="//code.jquery.com/jquery-3.3.1.min.js" defer></script>
        <script src="{{ mix('js/ajaxlike.js') }}" defer></script>
        <script src="{{ mix('js/ajaxComment.js') }}" defer></script>
        <script src="{{ mix('js/ajaxCommentDelete.js') }}" defer></script>
        <script src="{{ mix('js/imagePreview.js') }}" defer></script>
        <script src="{{ mix('js/profile_image_preview.js') }}" defer></script>
        <script src="{{ mix('js/cover_image_preview.js') }}" defer></script>
        <script src="{{ mix('js/introduction_pop.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-dropdown')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <!-- <x-slot name=”header”>のx-slotタグで囲まれたコンテンツを表示させることができる。名前付きスロット -->
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <!-- x-app-layoutで囲んだ部分が入る -->
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
