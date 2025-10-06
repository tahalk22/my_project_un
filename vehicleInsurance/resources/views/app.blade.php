<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
        <link rel="icon" href="{{ asset('logo/logo.png') }}" type="image/png">
        
        {{-- =====================   my meta --}}
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- SEO Meta Tags -->
        <meta name="description" content="الملتقى الليبي الدولي للتأمين التكافلي 2025 - أول ملتقى للتأمين الإسلامي في شمال إفريقيا">
        <meta name="keywords" content="التأمين التكافلي, الملتقى الليبي, التأمين الإسلامي, ليبيا, شركات التأمين, التأمين الدولي">
        <meta name="author" content="الاتحاد الليبي للتأمين">
    
        <!-- Open Graph (for social sharing) -->
        <meta property="og:title" content="الملتقى الليبي للتأمين التكافلي 2025">
        <meta property="og:description" content="انضم إلى نخبة من الخبراء وصنّاع القرار في أول ملتقى دولي للتأمين التكافلي في شمال أفريقيا.">
        <meta property="og:image" content="{{ asset('logo/logo.png') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">
    
        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="الملتقى الليبي للتأمين التكافلي 2025">
        <meta name="twitter:description" content="أول ملتقى دولي للتأمين الإسلامي في شمال أفريقيا.">
        <meta name="twitter:image" content="{{ asset('logo/logo.png') }}">
        
        {{-- =====================  --}}
        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.cdnfonts.com/css/tajawal" rel="stylesheet">
 

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
