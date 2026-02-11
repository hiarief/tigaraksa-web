<footer class="main-footer">
    <div class="footer-wrapper">
        <!-- Brand Section -->
        <div class="footer-brand">
            <div class="brand-logo">
                <img src="{{ asset('assets/img/siode.png') }}" alt="SIODE" class="footer-logo">
            </div>
            <div class="brand-info">
                <h5 class="company-name">SAIN</h5>
                <p class="company-full">Samudera Intermedia Sejahtera</p>
            </div>
        </div>

        <!-- Current Page -->
        <div class="footer-center">
            <div class="page-badge">
                <i class="fas fa-map-marker-alt"></i>
                <span>@yield('title')</span>
            </div>
        </div>

        <!-- Copyright -->
        <div class="footer-right">
            <p class="copyright-text">
                <i class="far fa-copyright"></i> 2025-{{ date('Y') }}
                <span class="divider">|</span>
                <strong>All Rights Reserved</strong>
            </p>
            <p class="powered-by">Powered by SIODE System</p>
        </div>
    </div>
</footer>
