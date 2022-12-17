
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <link rel="icon" type="image/x-icon" href="./icon.png">

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

{{--    <link rel="stylesheet" href="{{asset("/plugins/fontawesome-free/css/all.min.css")}}">--}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <link rel="stylesheet" href="{{asset("/dist/css/adminlte.min.css?v=3.2.0")}}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    @yield('style')

<body class="hold-transition sidebar-mini">

<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" role="button">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </li>

        </ul>
    </nav>


    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="#" class="brand-link">
            <img src="{{asset("/img/logonp.png")}}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Admin</span>
        </a>

        <div class="sidebar">

            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{asset('/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
                </div>
            </div>



            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item ">
                        <a href="{{ route('dashboard') }}" class="nav-link @yield('nav-dashboard')">
                            <i class="nav-icon fa-solid fa-house"></i>
                            <p>
                                Trang chủ
                            </p>
                        </a>
                    </li>

                    @if(Auth::user()->hasRole('admin'))
                        <li class="nav-item ">
                            <a href="{{ route('user.index') }}" class="nav-link @yield('nav-user')">
                                <i class="nav-icon fa-solid fa-users"></i>
                                <p>
                                    Tài khoản
                                </p>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ route('catalog.index') }}" class="nav-link @yield('nav-catalog')">
                                <i class="nav-icon fa-solid fa-bars"></i>
                                <p>
                                    Danh mục
                                </p>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ route('report.index') }}" class="nav-link @yield('nav-report')">
                                <i class="nav-icon fa-solid fa-magnifying-glass-chart"></i>
                                <p>
                                    Báo cáo
                                </p>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item ">
                        <a href="{{route('product-index')}}" class="nav-link @yield('nav-products')">
                            <i class="nav-icon fa-solid fa-box-open"></i>
                            <p>
                                Kho
                            </p>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a href="{{route('invoice-index')}}" class="nav-link @yield('nav-invoice')">
                            <i class="nav-icon fa-solid fa-shopping-cart"></i>
                            <p>
                                Bán hàng
                            </p>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a href="{{route('invoice-list')}}" class="nav-link @yield('nav-invoice-list')">
                            <i class="nav-icon fa-solid fa-file-invoice-dollar"></i>
                            <p>
                                Hóa đơn
                            </p>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a href="{{ route('customer.index') }}" class="nav-link @yield('nav-customer')">
                            <i class="nav-icon fa-solid fa-user-tie"></i>
                            <p>
                                Khách hàng
                            </p>
                        </a>
                    </li>

                </ul>
            </nav>

        </div>

    </aside>

    <div class="content-wrapper">

        <section class="content">
            @yield('content')
        </section>

    </div>

    <footer class="main-footer">
        <strong>Cửa hàng thuốc thú y <a href="#">Ngân Phát</a>.</strong>
    </footer>


</div>
<div hidden id="loading_spinner" class="spinner-border position-absolute" style="right:5%; bottom: 10%; z-index: 99999" role="status">
    <span class="sr-only">Loading...</span>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{asset("/plugins/jquery/jquery.min.js")}}"></script>

<script src="{{asset("/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>

<script src="{{asset("/dist/js/adminlte.min.js?v=3.2.0")}}"></script>

<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
{{--<script src="{{asset("/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")}}"></script>--}}
{{--<script src="{{asset("/plugins/datatables-responsive/js/dataTables.responsive.min.js")}}"></script>--}}
{{--<script src="{{asset("/plugins/datatables-responsive/js/responsive.bootstrap4.min.js")}}"></script>--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>

    // return redirect()->back()->with('error', 'Văn bằng không hợp lệ');
    @if(session('success'))
    Swal.fire(
        'Thành công!',
        '{{session('success')}}',
        'success'
    )
    @elseif(session('error'))
    Swal.fire(
        'Thất bại!',
        '{{session('error')}}',
        'error'
    )
    @endif

        var datatable

    $(document).ready(function (){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })
</script>

@yield('script')

</body>
</html>
