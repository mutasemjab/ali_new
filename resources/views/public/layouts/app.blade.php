@php $dir = app()->getLocale() === 'ar' ? 'rtl' : 'ltr'; @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $store->name ?? '')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @if($dir === 'rtl')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', -apple-system, sans-serif; background: #f8fafc; }
        .public-wrap { max-width: 560px; margin: 0 auto; padding: 24px 16px 80px; }
        .public-footer {
            max-width: 560px; margin: 0 auto; padding: 16px;
            display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;
            font-size: .82rem; color: #64748b;
        }
        .public-footer a { color: #2563eb; text-decoration: none; }
    </style>
</head>
<body>

<div class="public-wrap">
    @yield('content')
</div>

@isset($store)
<div class="public-footer">
    <a href="{{ route('public.stores.privacy', $store->id) }}">سياسة الخصوصية</a>
    <a href="{{ route('public.stores.feedback.create', $store->id) }}">اترك ملاحظة</a>
    @if($store->facebook_link)
        <a href="{{ $store->facebook_link }}" target="_blank"><i class="bi bi-facebook"></i> فيسبوك</a>
    @endif
</div>
@endisset

</body>
</html>
