<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue", 'resources/js/jquery.min.js', 'resources/js/dataTables.min.js'])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

<script>
    const getCurrentTheme = localStorage.getItem("hs_theme");
    const getDocumentHtml = document.getElementsByTagName("html");
    const currentTheme = getDocumentHtml[0].classList;

    if (currentTheme.contains("dark") && getCurrentTheme == "dark") {
        currentTheme.add("light");
        currentTheme.remove("dark");
        localStorage.setItem("hs_theme", "light");
    } else {
        currentTheme.add("dark");
        currentTheme.remove("light");
        localStorage.setItem("hs_theme", "dark");
    }
</script>

</html>
