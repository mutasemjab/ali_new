<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FlyerAll') — FlyerAll</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --c-primary: #2563eb;
            --c-primary-2: #4f46e5;
            --c-danger: #e11d48;
            --c-purple: #7c3aed;
            --c-orange: #f97316;
            --c-success: #16a34a;
            --c-warning: #eab308;
            --ink: #0f172a;
            --muted: #64748b;
            --bg-soft: #f8fafc;
            --border: rgba(15, 23, 42, .08);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--ink);
            margin: 0;
            background: #fff;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; }

        .container-xl { max-width: 1140px; margin: 0 auto; padding: 0 20px; }

        /* ── Navbar ───────────────────────────────────────────── */
        .lp-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            padding: 18px 0;
        }

        .lp-brand {
            font-size: 1.6rem;
            font-weight: 900;
            color: var(--ink);
            display: flex;
            align-items: baseline;
        }

        .lp-brand span { background: linear-gradient(135deg, var(--c-primary), var(--c-purple)); -webkit-background-clip: text; background-clip: text; color: transparent; }

        .lp-nav-links { display: flex; align-items: center; gap: 28px; list-style: none; margin: 0; padding: 0; }

        .lp-nav-links a {
            color: var(--ink);
            font-weight: 600;
            font-size: .95rem;
            padding-bottom: 4px;
            border-bottom: 2px solid transparent;
        }

        .lp-nav-links a.active, .lp-nav-links a:hover { color: var(--c-primary); border-color: var(--c-primary); }

        .lp-nav-toggle { display: none; background: none; border: none; font-size: 1.5rem; color: var(--ink); }

        @media (max-width: 860px) {
            .lp-nav-links {
                position: absolute;
                top: 100%;
                inset-inline: 0;
                background: #fff;
                border-bottom: 1px solid var(--border);
                flex-direction: column;
                align-items: flex-start;
                gap: 0;
                padding: 8px 20px 16px;
                display: none;
            }
            .lp-nav-links.is-open { display: flex; }
            .lp-nav-links li { width: 100%; padding: 10px 0; border-bottom: 1px solid var(--border); }
            .lp-nav-toggle { display: block; }
            .lp-nav { position: relative; }
        }

        .lp-btn-cta {
            background: linear-gradient(135deg, var(--c-primary), var(--c-purple));
            color: #fff;
            font-weight: 700;
            font-size: .9rem;
            padding: 11px 22px;
            border-radius: 999px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 24px -10px rgba(79, 70, 229, .55);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .lp-btn-cta:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 14px 28px -10px rgba(79, 70, 229, .65); }

        /* ── Generic section helpers ─────────────────────────── */
        .lp-section { padding: 56px 0; }
        .lp-section-tight { padding: 32px 0; }

        .lp-h1 { font-size: 2.6rem; font-weight: 900; line-height: 1.12; margin: 0 0 16px; }
        .lp-h1 .accent { background: linear-gradient(135deg, var(--c-primary), var(--c-purple)); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .lp-lead { color: var(--muted); font-size: 1.1rem; line-height: 1.6; max-width: 640px; }

        @media (max-width: 767px) {
            .lp-h1 { font-size: 2rem; }
        }

        /* ── Color tokens for admin-selectable "color" field ─── */
        .lp-c-primary { color: var(--c-primary); } .lp-bg-primary { background: var(--c-primary); } .lp-grad-primary { background: linear-gradient(135deg, var(--c-primary), #3b82f6); }
        .lp-c-danger { color: var(--c-danger); } .lp-bg-danger { background: var(--c-danger); } .lp-grad-danger { background: linear-gradient(135deg, var(--c-danger), #f43f5e); }
        .lp-c-purple { color: var(--c-purple); } .lp-bg-purple { background: var(--c-purple); } .lp-grad-purple { background: linear-gradient(135deg, var(--c-purple), #a855f7); }
        .lp-c-orange { color: var(--c-orange); } .lp-bg-orange { background: var(--c-orange); } .lp-grad-orange { background: linear-gradient(135deg, var(--c-orange), #fb923c); }
        .lp-c-success { color: var(--c-success); } .lp-bg-success { background: var(--c-success); } .lp-grad-success { background: linear-gradient(135deg, var(--c-success), #22c55e); }
        .lp-c-warning { color: var(--c-warning); } .lp-bg-warning { background: var(--c-warning); } .lp-grad-warning { background: linear-gradient(135deg, var(--c-warning), #facc15); }

        .lp-soft-primary { background: rgba(37, 99, 235, .1); } .lp-soft-danger { background: rgba(225, 29, 72, .1); }
        .lp-soft-purple { background: rgba(124, 58, 237, .1); } .lp-soft-orange { background: rgba(249, 115, 22, .1); }
        .lp-soft-success { background: rgba(22, 163, 74, .1); } .lp-soft-warning { background: rgba(234, 179, 8, .1); }

        /* ── Footer ───────────────────────────────────────────── */
        .lp-footer {
            background: var(--ink);
            color: rgba(255, 255, 255, .7);
            padding: 36px 0;
            margin-top: 40px;
        }

        .lp-footer a { color: rgba(255, 255, 255, .7); }
        .lp-footer a:hover { color: #fff; }
    </style>

    @stack('styles')
</head>

<body>

    <header class="container-xl">
        <nav class="lp-nav">
            <a href="{{ route('landing.home') }}" class="lp-brand">Flyer<span>All</span></a>

            <button type="button" class="lp-nav-toggle" id="lpNavToggle"><i class="bi bi-list"></i></button>

            <ul class="lp-nav-links" id="lpNavLinks">
                <li><a href="{{ route('landing.home') }}" class="{{ request()->routeIs('landing.home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('landing.features') }}" class="{{ request()->routeIs('landing.features') ? 'active' : '' }}">Features</a></li>
                <li><a href="{{ route('landing.plans') }}" class="{{ request()->routeIs('landing.plans') ? 'active' : '' }}">Plans</a></li>
                <li><a href="{{ route('landing.how-it-works') }}" class="{{ request()->routeIs('landing.how-it-works') ? 'active' : '' }}">How It Works</a></li>
                <li><a href="{{ route('landing.about') }}" class="{{ request()->routeIs('landing.about') ? 'active' : '' }}">About</a></li>
                <li><a href="{{ route('landing.contact') }}" class="{{ request()->routeIs('landing.contact') ? 'active' : '' }}">Contact</a></li>
                <li class="d-md-none mt-2"><a href="{{ $setting->cta_url ?: '#' }}" class="lp-btn-cta">{{ $setting->cta_text ?: 'Get Started' }} <i class="bi bi-arrow-right"></i></a></li>
            </ul>

            <a href="{{ $setting->cta_url ?: '#' }}" class="lp-btn-cta d-none d-md-inline-flex">{{ $setting->cta_text ?: 'Get Started' }} <i class="bi bi-arrow-right"></i></a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="lp-footer">
        <div class="container-xl d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="fw-bold text-white">FlyerAll</div>
            <div class="d-flex gap-3 small">
                <a href="{{ route('landing.about') }}">About</a>
                <a href="{{ route('landing.contact') }}">Contact</a>
                <a href="{{ route('landing.plans') }}">Plans</a>
            </div>
            <div class="small">&copy; {{ date('Y') }} FlyerAll. All rights reserved.</div>
        </div>
    </footer>

    <script>
        document.getElementById('lpNavToggle').addEventListener('click', function () {
            document.getElementById('lpNavLinks').classList.toggle('is-open');
        });
    </script>

    @stack('scripts')
</body>

</html>
