<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    {{-- SEO --}}
    <title>{{ $page['props']['seo']['title'] ?? 'Персональный онлайн-тренер' }}</title>
    <meta name="description" content="{{ $page['props']['seo']['description'] ?? 'Онлайн-ведение по всей стране. Запишитесь на пробное занятие.' }}" />
    <meta name="robots" content="index, follow" />
    <link rel="canonical" href="{{ url()->current() }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- Open Graph --}}
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="{{ $page['props']['seo']['title'] ?? 'Персональный онлайн-тренер' }}" />
    <meta property="og:description" content="{{ $page['props']['seo']['description'] ?? 'Онлайн-ведение по всей стране.' }}" />
    <meta property="og:locale" content="ru_RU" />

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />

    {{-- Preconnects --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    @routes
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="antialiased bg-white text-gray-900 font-inter">

    {{-- Yandex Metrica --}}
    @php $ymId = config('services.yandex_metrica.id'); @endphp
    @if($ymId)
    <script type="text/javascript">
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
        ym({{ (int)$ymId }}, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/{{ (int)$ymId }}" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    @endif

    @inertia
</body>
</html>
