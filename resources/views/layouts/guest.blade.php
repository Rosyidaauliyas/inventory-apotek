<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - Puskesmas Tarokan</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="font-sans text-gray-900 antialiased bg-slate-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-md mt-6 px-10 py-10 bg-white shadow-2xl shadow-slate-200 overflow-hidden sm:rounded-[2.5rem] border border-slate-100">
                {{ $slot }}
            </div>

            <div class="mt-8 text-center">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.3em]">© 2026 UPTD Puskesmas Tarokan</p>
            </div>
        </div>
    </body>
</html>