<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title' ?? 'Divisima')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	@include ('parts.header.head')

    <script>
        var enviroment = "{{ env('APP_ENV') }}";
    </script>
</head>
<body>
    <!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>
    @include ('parts.header.header')

    @yield('content')

    @include ('parts.footer.footer')
	@include('parts.messages.success')
    
	</body>
</html>
