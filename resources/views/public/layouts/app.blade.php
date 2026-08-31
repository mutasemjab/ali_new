@php $dir = app()->getLocale() === 'ar' ? 'rtl' : 'ltr'; @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#eef1fb">
    <title>@yield('title', $store->name ?? '')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if($dir === 'rtl')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-1: #6366f1;
            --primary-2: #8b5cf6;
            --primary-3: #06b6d4;
            --ink: #0f172a;
            --muted: #64748b;
            --surface: rgba(255, 255, 255, 0.86);
            --surface-solid: #ffffff;
            --border: rgba(15, 23, 42, 0.06);
            --divider: rgba(15, 23, 42, 0.16);
            --shadow-color: 220 40% 30%;
            --bg-base: #eef1fb;
        }

        * { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--ink);
            background: var(--bg-base);
            margin: 0;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        html[dir="rtl"] body {
            font-family: 'Cairo', 'Inter', -apple-system, sans-serif;
        }

        /* ambient animated background */
        .bg-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(70px);
            opacity: .45;
            z-index: 0;
            pointer-events: none;
            animation: drift 22s ease-in-out infinite;
        }
        .bg-orb--1 { width: 380px; height: 380px; top: -140px; inset-inline-start: -120px; background: radial-gradient(circle, var(--primary-1), transparent 70%); }
        .bg-orb--2 { width: 420px; height: 420px; bottom: -160px; inset-inline-end: -140px; background: radial-gradient(circle, var(--primary-3), transparent 70%); animation-delay: -8s; animation-duration: 26s; }
        .bg-orb--3 { width: 300px; height: 300px; top: 40%; inset-inline-start: 50%; background: radial-gradient(circle, var(--primary-2), transparent 70%); opacity: .3; animation-delay: -14s; animation-duration: 30s; }

        @keyframes drift {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(24px, -18px) scale(1.06); }
            66% { transform: translate(-18px, 14px) scale(0.96); }
        }

        @media (prefers-reduced-motion: reduce) {
            .bg-orb { animation: none; }
            html { scroll-behavior: auto; }
        }

        .public-shell {
            position: relative;
            z-index: 1;
            max-width: 520px;
            margin: 0 auto;
            padding: 28px 18px 48px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* store header */
        .store-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 28px;
            animation: fadeUp .6s cubic-bezier(.22,1,.36,1) both;
        }

        .store-avatar-wrap {
            position: relative;
            width: 220px;
            height: 220px;
            max-width: 60vw;
            max-height: 60vw;
        }

        .store-avatar-ring {
            position: absolute;
            inset: -8px;
            border-radius: 38px;
            background: conic-gradient(from 0deg, var(--primary-1), var(--primary-3), var(--primary-2), var(--primary-1));
            animation: spin 6s linear infinite;
        }

        @media (prefers-reduced-motion: reduce) {
            .store-avatar-ring { animation: none; }
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .store-avatar {
            position: relative;
            width: 100%;
            height: 100%;
            border-radius: 32px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--surface-solid);
            border: 6px solid var(--surface-solid);
            box-shadow: 0 20px 46px -14px hsl(var(--shadow-color) / .45);
        }

        .store-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .store-avatar-fallback {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 4.6rem;
            color: #fff;
            background: linear-gradient(135deg, var(--primary-1), var(--primary-2));
        }

        /* content */
        .public-content {
            flex: 1;
            animation: fadeUp .7s .1s cubic-bezier(.22,1,.36,1) both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .surface-card {
            background: var(--surface);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 20px;
            box-shadow: 0 20px 45px -24px hsl(var(--shadow-color) / .35);
        }

        .product-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 0;
        }
        .product-row:not(:first-child) {
            border-top: 2px dotted var(--divider);
        }

        .social-stack {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 18px;
        }

        .social-row {
            display: flex;
            align-items: center;
            gap: 14px;
            background: var(--surface-solid);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 14px 18px;
            text-decoration: none;
            color: var(--ink);
            box-shadow: 0 12px 26px -20px hsl(var(--shadow-color) / .5);
            transition: transform .25s cubic-bezier(.22,1,.36,1), box-shadow .25s ease;
        }
        .social-row:hover {
            color: var(--ink);
            transform: translateY(-3px);
            box-shadow: 0 16px 30px -16px hsl(var(--shadow-color) / .55);
        }
        .social-row:active { transform: translateY(-1px); }

        .social-row-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 8px 18px -8px hsl(var(--shadow-color) / .5);
        }
        .social-row-icon img { width: 100%; height: 100%; object-fit: cover; display: block; }

        .social-row-title {
            font-weight: 700;
            font-size: .96rem;
            flex: 1;
        }

        .social-row-chevron {
            color: var(--muted);
            font-size: 1.05rem;
            flex-shrink: 0;
        }
        html[dir="rtl"] .social-row-chevron { transform: scaleX(-1); }

        .share-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            background: var(--surface-solid);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 15px 18px;
            font-weight: 700;
            font-size: .95rem;
            color: var(--ink);
            cursor: pointer;
            box-shadow: 0 12px 26px -20px hsl(var(--shadow-color) / .5);
            transition: transform .25s cubic-bezier(.22,1,.36,1), box-shadow .25s ease, background .25s ease, color .25s ease;
        }
        .share-btn:hover {
            transform: translateY(-3px);
            color: #fff;
            background: linear-gradient(135deg, var(--primary-1), var(--primary-2));
            box-shadow: 0 16px 30px -14px hsl(var(--shadow-color) / .6);
        }
        .share-btn:active { transform: translateY(-1px); }

        .section-title {
            font-size: 1.15rem;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .section-sub {
            color: var(--muted);
            font-size: .85rem;
            margin-bottom: 18px;
        }

        .reveal {
            opacity: 0;
            transform: translateY(16px);
            transition: opacity .55s cubic-bezier(.22,1,.36,1), transform .55s cubic-bezier(.22,1,.36,1);
        }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }

        .btn-gradient {
            background: linear-gradient(135deg, var(--primary-1), var(--primary-2));
            color: #fff;
            border: none;
            border-radius: 14px;
            padding: 13px 20px;
            font-weight: 700;
            font-size: .95rem;
            transition: transform .25s cubic-bezier(.22,1,.36,1), box-shadow .25s ease, filter .25s ease;
            box-shadow: 0 14px 28px -12px hsl(var(--shadow-color) / .55);
        }
        .btn-gradient:hover { transform: translateY(-2px); filter: brightness(1.06); color: #fff; }
        .btn-gradient:active { transform: translateY(0) scale(.98); }

        .form-control-modern {
            border-radius: 14px;
            border: 1px solid var(--border);
            background: var(--surface-solid);
            padding: 12px 16px;
            font-size: .95rem;
            transition: border-color .2s ease, box-shadow .2s ease;
        }
        .form-control-modern:focus {
            border-color: var(--primary-1);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .15);
            outline: none;
        }

        .form-label-modern {
            font-size: .82rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 6px;
            display: block;
        }

        .alert-modern {
            border-radius: 14px;
            border: none;
            padding: 12px 16px;
            font-size: .88rem;
            margin-bottom: 16px;
        }
        .alert-modern.alert-success { background: rgba(16, 185, 129, .12); color: #059669; }
        .alert-modern.alert-danger { background: rgba(239, 68, 68, .12); color: #dc2626; }

        .photo-stack {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="bg-orb bg-orb--1"></div>
<div class="bg-orb bg-orb--2"></div>
<div class="bg-orb bg-orb--3"></div>

<div class="public-shell">

    @isset($store)
    <div class="store-header">
        <div class="store-avatar-wrap">
            <div class="store-avatar-ring"></div>
            <div class="store-avatar">
                @if($store->photo)
                    <img src="{{ asset($store->photo) }}" alt="{{ $store->name }}">
                @else
                    <div class="store-avatar-fallback">{{ mb_substr($store->name, 0, 1) }}</div>
                @endif
            </div>
        </div>
    </div>
    @endisset

    <div class="public-content">
        @yield('content')
    </div>

</div>

<script>
    (function () {
        var items = document.querySelectorAll('.reveal');
        if (!items.length) return;

        if (!('IntersectionObserver' in window)) {
            items.forEach(function (el) { el.classList.add('is-visible'); });
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: .15, rootMargin: '0px 0px -40px 0px' });

        items.forEach(function (el) { observer.observe(el); });
    })();

    (function () {
        document.querySelectorAll('.share-btn').forEach(function (btn) {
            var url = btn.getAttribute('data-share-url') || window.location.href;
            var title = btn.getAttribute('data-share-title') || document.title;
            var label = btn.querySelector('.share-btn-label');
            var defaultText = label ? label.textContent : '';

            btn.addEventListener('click', function () {
                if (navigator.share) {
                    navigator.share({ title: title, url: url }).catch(function () {});
                    return;
                }

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(url).then(function () {
                        if (!label) return;
                        label.textContent = 'تم نسخ الرابط';
                        setTimeout(function () { label.textContent = defaultText; }, 2000);
                    }).catch(function () {});
                }
            });
        });
    })();
</script>

@stack('scripts')
</body>
</html>
