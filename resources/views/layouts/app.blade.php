@vite(['resources/scss/app.scss', 'resources/js/app.js'])
@include('layouts.partials.header')
<main class="">
        @yield('content')
</main>
@include('layouts.partials.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
