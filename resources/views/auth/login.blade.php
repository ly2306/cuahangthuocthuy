
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập hệ thống</title>

    <link rel="icon" type="image/x-icon" href="">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{asset("/plugins/fontawesome-free/css/all.min.css")}}">

    <link rel="stylesheet" href="{{asset("/plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}">

    <link rel="stylesheet" href="{{asset("/dist/css/adminlte.min.css?v=3.2.0")}}">

<body class="hold-transition login-page">
<div class="login-box" style="width: 400px">

    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <img src="{{asset("/img/logonp.png")}}" alt="Logo" style=" height: 100px">
        </div>
        <div class="card-body">
            <h4 class="text-center">CỬA HÀNG THUỐC THÚ Y</h4>
            <form class="mt-4" action="{{ route('login') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Mật khẩu" name="password" value="{{ old('password') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>


                <div class="social-auth-links text-center mt-2 mb-3">
                    <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                </div>

            </form>
        </div>

    </div>

</div>


<script src="{{asset("/plugins/jquery/jquery.min.js")}}"></script>

<script src="{{asset("/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>

<script src="{{asset("/dist/js/adminlte.min.js?v=3.2.0")}}"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire(
        'Đăng nhập thành công!',
        '{{session('success')}}',
        'success'
    )
    @elseif(session('error'))
    Swal.fire(
        'Đăng nhập thất bại!',
        '{{session('error')}}',
        'error'
    )
    @endif
</script>

</body>
</html>
