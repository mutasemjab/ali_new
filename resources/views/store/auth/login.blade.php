@php $dir = 'ltr'; @endphp
<!DOCTYPE html>
<html lang="en" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
        }
        .r-wrap { width: 100%; max-width: 400px; padding: 32px; }
        .l-brand { display: flex; align-items: center; gap: 12px; justify-content: center; margin-bottom: 28px; }
        .l-brand-icon {
            width: 44px; height: 44px;
            background: linear-gradient(145deg, #0f172a 0%, #1d4ed8 100%);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: #fff;
        }
        .l-brand-name { font-size: 1.15rem; font-weight: 700; color: #0f172a; }
        .r-header { text-align: center; margin-bottom: 28px; }
        .r-title { font-size: 1.4rem; font-weight: 800; color: #0f172a; }
        .r-sub { font-size: .855rem; color: #64748b; margin-top: 6px; }
        .alert-err {
            background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px;
            padding: 12px 16px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;
            font-size: .845rem; color: #dc2626; font-weight: 500;
        }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: .82rem; font-weight: 600; color: #374151; margin-bottom: 7px; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: .95rem; }
        .form-input {
            width: 100%; padding: 11px 14px 11px 42px; border: 1.5px solid #e5e7eb; border-radius: 10px;
            font-size: .875rem; font-family: inherit; color: #111827; background: #fff; outline: none;
        }
        .form-input:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.12); }
        .invalid-feedback { font-size: .78rem; color: #ef4444; margin-top: 5px; display: block; }
        .btn-login {
            width: 100%; padding: 12px; background: #2563eb; color: #fff; border: none; border-radius: 10px;
            font-size: .9rem; font-weight: 600; font-family: inherit; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-login:hover { background: #1d4ed8; }
        .r-footer { margin-top: 28px; text-align: center; font-size: .78rem; color: #9ca3af; }
    </style>
</head>
<body>

<div class="r-wrap">

    <div class="l-brand">
        <div class="l-brand-icon"><i class="bi bi-shop"></i></div>
        <span class="l-brand-name">Store Panel</span>
    </div>

    <div class="r-header">
        <h2 class="r-title">Welcome Back</h2>
        <p class="r-sub">Sign in to manage your store</p>
    </div>

    @if($errors->any() || session('error'))
    <div class="alert-err">
        <i class="bi bi-exclamation-circle-fill"></i>
        {{ $errors->first() ?: session('error') }}
    </div>
    @endif

    <form method="POST" action="{{ route('store.login') }}" autocomplete="off">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <div class="input-wrap">
                <i class="input-icon bi bi-envelope"></i>
                <input id="email" name="email" type="email" class="form-input"
                       placeholder="example@store.com" value="{{ old('email') }}" required autofocus>
            </div>
            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="input-wrap">
                <i class="input-icon bi bi-lock"></i>
                <input id="password" name="password" type="password" class="form-input" required>
            </div>
            @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="btn-login">
            <i class="bi bi-box-arrow-in-right"></i> Sign In
        </button>
    </form>

    <div class="r-footer">&copy; {{ date('Y') }} All rights reserved.</div>

</div>
</body>
</html>
