<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.header')

<body>

    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <!-- Errors -->
        @error('systemerror')
            @include('errors.errorpop')
        @enderror
        <!-- End Errors -->
        @yield('content')
    </body>

    <span class="small text-muted" style="text-align:right; position:fixed; bottom:4px; right:8px">
        @include('layouts.footer')
    </span>
</body>

</html>
