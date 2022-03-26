<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ url('setting/'.logoimage('favicon icon')) }}" type="image/x-icon">
    <title>@yield('title')</title>

    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assets/custom_auth') }}/bootstrap.min.css">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <!--  poppins font -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- style -->
    <link rel="stylesheet" href="{{ asset('assets/custom_auth') }}/style.css">

    @yield('styles')
</head>

<body>
    <section class="main-log-in">
        @yield('content')
    </section>


    <script src="{{asset('assets/js/jquery-3.5.1.min.js')}}"></script>
    
    <script src="{{ asset('assets/custom_auth') }}/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/custom_auth') }}/pwd.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @stack('scripts')

</body>

</html>
