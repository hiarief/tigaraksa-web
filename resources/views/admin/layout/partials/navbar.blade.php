<nav class="main-header navbar navbar-expand navbar-custom text-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link nav-link-custom" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <div class="page-title-wrapper">
                <i class="fas fa-layer-group"></i>
                <span class="page-title">@yield('title')</span>
            </div>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Clock Display -->
        <li class="nav-item d-none d-md-inline-block">
            <div class="clock-display">
                <i class="far fa-clock"></i>
                <span id="current-time"></span>
            </div>
        </li>

        <!-- User Dropdown -->
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle user-link" data-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar-wrapper">
                    <div class="user-initial-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="status-indicator"></div>
                </div>
                <span class="d-none d-md-inline user-name-text">{{ Auth::user()->name }}</span>
                <i class="fas fa-chevron-down ml-1"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right dropdown-custom"
                style="left: inherit; right: 0px;">
                <!-- User Header -->
                <li class="user-header-custom">
                    <div class="user-header-bg"></div>
                    <div class="user-header-content">
                        <div class="user-initial-avatar-large">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="user-info-text">
                            <h5 class="user-fullname">{{ Auth::user()->name }}</h5>
                            <p class="user-role">
                                <i class="fas fa-user-shield"></i>
                                {{ Auth::user()->roles->pluck('name')[0] ?? 'User' }}
                            </p>
                            <p class="user-date">
                                <i class="far fa-calendar-alt"></i>
                                {{ Carbon\Carbon::now()->isoFormat('DD MMMM YYYY') }}
                            </p>
                        </div>
                    </div>
                </li>

                <!-- Menu Items -->
                <li>
                    <a href="#" class="dropdown-item dropdown-item-custom">
                        <i class="fas fa-user-circle mr-2"></i>
                        <span>Profil Saya</span>
                        <i class="fas fa-angle-right ml-auto"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="dropdown-item dropdown-item-custom">
                        <i class="fas fa-key mr-2"></i>
                        <span>Ganti Password</span>
                        <i class="fas fa-angle-right ml-auto"></i>
                    </a>
                </li>

                <!-- Logout -->
                <li class="user-footer-custom">
                    @auth
                        <button type="button" onclick="confirmLogout()" class="btn btn-logout-custom btn-block">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Keluar dari Sistem
                        </button>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                            @csrf
                        </form>
                    @endauth
                </li>
            </ul>
        </li>
    </ul>
</nav>


<script>
    // Real-time clock (Vanilla JavaScript)
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeString = hours + ':' + minutes + ':' + seconds;

        const clockElement = document.getElementById('current-time');
        if (clockElement) {
            clockElement.textContent = timeString;
        }
    }

    // Update clock every second
    setInterval(updateClock, 1000);
    updateClock(); // Initial call

    // Logout confirmation
    function confirmLogout() {
        Swal.fire({
            title: 'Apakah Anda yakin ingin keluar?',
            text: "Anda akan keluar dari sesi ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            background: '#ffffff',
            color: '#343a40'
        }).then(function(result) {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }

    // Wait for DOM and jQuery to be ready
    document.addEventListener('DOMContentLoaded', function() {
        // Check if jQuery is available
        if (typeof jQuery !== 'undefined') {

            // Manual dropdown handler as backup
            jQuery('.user-link').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var dropdown = jQuery(this).next('.dropdown-menu');
                var parent = jQuery(this).parent();

                // Close other dropdowns
                jQuery('.dropdown-menu').not(dropdown).removeClass('show');
                jQuery('.dropdown').not(parent).removeClass('show');

                // Toggle this dropdown
                dropdown.toggleClass('show');
                parent.toggleClass('show');
            });

            // Close dropdown when clicking outside
            jQuery(document).on('click', function(e) {
                if (!jQuery(e.target).closest('.user-menu').length) {
                    jQuery('.dropdown-menu').removeClass('show');
                    jQuery('.user-menu').removeClass('show');
                }
            });

        } else {
            // Vanilla JS fallback
            var userLink = document.querySelector('.user-link');
            if (userLink) {
                userLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var dropdown = this.nextElementSibling;
                    var parent = this.parentElement;

                    dropdown.classList.toggle('show');
                    parent.classList.toggle('show');
                });
            }

            // Close when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.user-menu')) {
                    var dropdowns = document.querySelectorAll('.dropdown-menu');
                    dropdowns.forEach(function(dropdown) {
                        dropdown.classList.remove('show');
                    });
                    var parents = document.querySelectorAll('.user-menu');
                    parents.forEach(function(parent) {
                        parent.classList.remove('show');
                    });
                }
            });
        }
    });
</script>
