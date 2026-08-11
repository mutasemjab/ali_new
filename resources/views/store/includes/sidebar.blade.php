<aside class="sidebar" id="sidebar">

    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-shop"></i>
        </div>
        <span class="brand-text">{{ auth('store')->user()->name }}</span>
    </div>

    <nav class="sidebar-nav">

        <div class="nav-label">Home</div>
        <ul>
            <li class="nav-item">
                <a href="{{ route('store.dashboard') }}"
                    class="nav-link {{ request()->routeIs('store.dashboard') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>

        <div class="nav-label">Management</div>
        <ul>
            <li class="nav-item">
                <a href="{{ route('store.clients.index') }}"
                    class="nav-link {{ request()->routeIs('store.clients.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-people"></i>
                    <span>Clients</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('store.messages.index') }}"
                    class="nav-link {{ request()->routeIs('store.messages.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-chat-dots"></i>
                    <span>Messages</span>
                </a>
            </li>
        </ul>

        <div class="nav-label">Store</div>
        <ul>
            <li class="nav-item">
                <a href="{{ route('store.categories.index') }}"
                    class="nav-link {{ request()->routeIs('store.categories.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-folder"></i>
                    <span>Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('store.products.index') }}"
                    class="nav-link {{ request()->routeIs('store.products.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-box-seam"></i>
                    <span>Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('store.ads.index') }}"
                    class="nav-link {{ request()->routeIs('store.ads.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-megaphone"></i>
                    <span>Ads</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('store.feedback.index') }}"
                    class="nav-link {{ request()->routeIs('store.feedback.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-chat-square-text"></i>
                    <span>Feedback</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('store.pages.edit') }}"
                    class="nav-link {{ request()->routeIs('store.pages.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-file-earmark-text"></i>
                    <span>Public Page</span>
                </a>
            </li>
        </ul>

    </nav>

    {{-- Sidebar Footer --}}
    <div class="sidebar-footer">
        <ul>
            <li class="nav-item">
                <a href="{{ route('store.login.edit', auth('store')->id()) }}" class="nav-link">
                    <i class="nav-icon bi bi-gear"></i>
                    <span>Account Settings</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"
                    onclick="event.preventDefault(); document.getElementById('store-logout-form').submit();">
                    <i class="nav-icon bi bi-box-arrow-right"></i>
                    <span>Sign Out</span>
                </a>
            </li>
        </ul>
        <button class="sidebar-collapse-btn" id="sidebarCollapseBtn" title="Collapse sidebar">
            <i class="bi bi-arrow-bar-left"></i>
        </button>
    </div>

</aside>
