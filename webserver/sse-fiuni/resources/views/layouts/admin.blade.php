<!DOCTYPE html>
<html lang="en">
<x-header/>
<body class="container-fluid col-10 mt-4">
    <div class="col-12 row">
        <div class="col-lg-2 float-left">
            <x-side_menu/>
        </div>
        <div class="col-lg-10 float-right">
            @yield('content')
        </div>
    </div>
<x-footer/>

</body>
</html>
