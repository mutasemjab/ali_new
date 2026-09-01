<aside class="sidebar" id="sidebar">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <span class="brand-text">Ali Market</span>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">

        <div class="nav-label">Main</div>
        <ul>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>

        <div class="nav-label">Stores</div>
        <ul>
            <li class="nav-item">
                <a href="{{ route('admin.stores.index') }}"
                    class="nav-link {{ request()->routeIs('admin.stores.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-shop"></i>
                    <span>Stores</span>
                </a>
            </li>
        </ul>

        <div class="nav-label">System</div>
        <ul>
            <li class="nav-item">
                <a href="{{ route('admin.role.index') }}"
                    class="nav-link {{ request()->routeIs('admin.role.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-shield-check"></i>
                    <span>Roles &amp; Permissions</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.employee.index') }}"
                    class="nav-link {{ request()->routeIs('admin.employee.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-people"></i>
                    <span>Employees</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.settings.privacy.edit') }}"
                    class="nav-link {{ request()->routeIs('admin.settings.privacy.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-shield-lock"></i>
                    <span>Privacy Policy</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.settings.terms.edit') }}"
                    class="nav-link {{ request()->routeIs('admin.settings.terms.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-file-text"></i>
                    <span>Terms of Service</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.settings.anti-spam.edit') }}"
                    class="nav-link {{ request()->routeIs('admin.settings.anti-spam.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-envelope-slash"></i>
                    <span>Anti-Spam Policy</span>
                </a>
            </li>
        </ul>

    </nav>

    {{-- Sidebar Footer --}}
    <div class="sidebar-footer">
        <ul>
            <li class="nav-item">
                <a href="{{ route('admin.login.edit', auth('admin')->id()) }}" class="nav-link">
                    <i class="nav-icon bi bi-gear"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"
                    onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
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
