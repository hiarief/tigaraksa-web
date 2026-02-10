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

<style>
    /* ===================== FOOTER STYLING ===================== */
    .main-footer {
        background: linear-gradient(135deg, #343a40 0%, #1f2529 100%);
        border-top: 3px solid #ffc107;
        padding: 1.5rem 1rem;
        margin-left: 250px;
        /* Sesuai lebar sidebar AdminLTE */
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    /* Shine Effect */
    .main-footer::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -100%;
        width: 200%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #ffc107, transparent);
        animation: footerShine 3s infinite;
    }

    @keyframes footerShine {
        0% {
            left: -100%;
        }

        100% {
            left: 100%;
        }
    }

    /* Footer Wrapper */
    .footer-wrapper {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        gap: 2rem;
        max-width: 100%;
    }

    /* ===================== BRAND SECTION ===================== */
    .footer-brand {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .brand-logo {
        background: #ffffff;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(255, 193, 7, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .footer-logo {
        max-height: 28px;
        width: auto;
        object-fit: contain;
    }

    .brand-info {
        display: flex;
        flex-direction: column;
    }

    .company-name {
        font-size: 1.1rem;
        font-weight: 700;
        letter-spacing: 2px;
        color: #ffc107;
        margin: 0;
        text-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
    }

    .company-full {
        font-size: 0.7rem;
        color: #adb5bd;
        margin: 0.2rem 0 0 0;
        font-weight: 400;
    }

    /* ===================== CENTER SECTION ===================== */
    .footer-center {
        display: flex;
        justify-content: center;
    }

    .page-badge {
        background: rgba(255, 193, 7, 0.1);
        border: 1px solid rgba(255, 193, 7, 0.3);
        padding: 0.5rem 1.25rem;
        border-radius: 20px;
        color: #ffc107;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        font-weight: 500;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .page-badge:hover {
        background: rgba(255, 193, 7, 0.15);
        border-color: rgba(255, 193, 7, 0.5);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);
    }

    .page-badge i {
        font-size: 0.7rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.6;
        }
    }

    /* ===================== RIGHT SECTION ===================== */
    .footer-right {
        text-align: right;
    }

    .copyright-text {
        color: #dee2e6;
        font-size: 0.8rem;
        margin: 0 0 0.25rem 0;
        font-weight: 400;
    }

    .copyright-text i {
        color: #ffc107;
        margin-right: 0.25rem;
    }

    .copyright-text .divider {
        color: #6c757d;
        margin: 0 0.5rem;
    }

    .copyright-text strong {
        color: #ffc107;
    }

    .powered-by {
        font-size: 0.65rem;
        color: #6c757d;
        margin: 0;
        font-style: italic;
    }

    /* ===================== RESPONSIVE ===================== */
    @media (max-width: 991px) {
        .main-footer {
            margin-left: 0;
            /* Remove sidebar margin on mobile */
        }
    }

    @media (max-width: 768px) {
        .footer-wrapper {
            grid-template-columns: 1fr;
            gap: 1.25rem;
            text-align: center;
        }

        .footer-brand {
            justify-content: center;
        }

        .footer-right {
            text-align: center;
        }

        .page-badge {
            display: inline-flex;
        }
    }

    /* Sidebar collapsed state */
    @media (min-width: 992px) {
        body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer {
            margin-left: 250px;
        }

        body.sidebar-collapse .main-footer {
            margin-left: 4.6rem;
        }
    }

    /* Control sidebar open */
    body.control-sidebar-slide-open .main-footer {
        margin-right: 250px;
    }
</style>
