<nav class="navbar" id="navbar">

    <button class="navbar-toggler" id="sidebarToggler" aria-label="Collapse sidebar">
        <i class="bi bi-list"></i>
    </button>

    <div class="navbar-search">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search..." aria-label="Search">
        </div>
    </div>

    <div class="navbar-end">

        <span class="icon-btn" title="SMS balance">
            <i class="bi bi-chat-dots"></i>
            {{ auth('store')->user()->total_sms }}
        </span>

        <div class="nav-divider"></div>

        <div class="dropdown">
            <div class="user-menu" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar">{{ mb_substr(auth('store')->user()->name, 0, 1) }}</div>

                <div class="user-info">
                    <span class="user-name">{{ auth('store')->user()->name }}</span>
                    <span class="user-role">Store Owner</span>
                </div>

                <i class="bi bi-chevron-down ms-1" style="font-size:.65rem;color:var(--muted)"></i>
            </div>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm border" style="border-radius:12px;min-width:180px;font-size:.845rem;">
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('store.login.edit', auth('store')->id()) }}">
                        <i class="bi bi-person-circle" style="color:var(--muted)"></i>
                        Account Settings
                    </a>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger" href="#"
                       onclick="event.preventDefault(); document.getElementById('store-logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        Sign Out
                    </a>
                    <form id="store-logout-form" action="{{ route('store.logout') }}" method="GET" class="d-none"></form>
                </li>
            </ul>
        </div>

    </div>
</nav>
