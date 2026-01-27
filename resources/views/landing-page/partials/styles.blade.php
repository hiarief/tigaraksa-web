<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        overflow-x: hidden;
        background: #f8f9fa;
    }

    /* Header */
    header {
        position: fixed;
        top: 0;
        width: 100%;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        transition: all 0.3s ease;
    }

    nav {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.5rem;
        font-weight: bold;
        color: #2c5f2d;
    }

    .logo-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #4CAF50, #2c5f2d);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .nav-links {
        display: flex;
        gap: 2rem;
        list-style: none;
    }

    .nav-links a {
        text-decoration: none;
        color: #333;
        font-weight: 500;
        transition: color 0.3s;
    }

    .nav-links a:hover {
        color: #4CAF50;
    }

    .btn-login {
        padding: 0.7rem 1.5rem;
        background: linear-gradient(135deg, #4CAF50, #2c5f2d);
        color: white;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-weight: 600;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(76, 175, 80, 0.4);
    }

    /* Hero Section */
    .hero {
        margin-top: 80px;
        min-height: 90vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        background-size: 50px 50px;
        animation: moveBackground 20s linear infinite;
    }

    @keyframes moveBackground {
        0% {
            transform: translate(0, 0);
        }

        100% {
            transform: translate(50px, 50px);
        }
    }

    .hero-content {
        max-width: 1200px;
        padding: 2rem;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .hero h1 {
        font-size: 4rem;
        color: white;
        margin-bottom: 1rem;
        animation: fadeInUp 1s ease;
    }

    .hero .tagline {
        font-size: 2rem;
        color: #ffd700;
        margin-bottom: 1.5rem;
        font-weight: 600;
        animation: fadeInUp 1s ease 0.2s backwards;
    }

    .hero p {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 2rem;
        animation: fadeInUp 1s ease 0.4s backwards;
    }

    .stats {
        display: flex;
        justify-content: center;
        gap: 3rem;
        flex-wrap: wrap;
        animation: fadeInUp 1s ease 0.6s backwards;
    }

    .stat-item {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 1.5rem 2rem;
        border-radius: 15px;
        min-width: 150px;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: white;
    }

    .stat-label {
        color: rgba(255, 255, 255, 0.9);
        margin-top: 0.5rem;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* TOP 6 KEY METRICS */
    .key-metrics {
        padding: 4rem 2rem;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .key-metrics-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .section-title {
        text-align: center;
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 1rem;
    }

    .section-subtitle {
        text-align: center;
        color: #666;
        margin-bottom: 3rem;
        font-size: 1.1rem;
    }

    .key-metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
    }

    .key-metric-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .key-metric-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #4CAF50, #2c5f2d);
    }

    .key-metric-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .key-metric-card.priority {
        border: 2px solid #f44336;
    }

    .key-metric-card.priority::before {
        background: linear-gradient(90deg, #f44336, #d32f2f);
    }

    .key-metric-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .key-metric-value {
        font-size: 3rem;
        font-weight: bold;
        color: #4CAF50;
        margin: 1rem 0;
    }

    .key-metric-card.priority .key-metric-value {
        color: #f44336;
    }

    .key-metric-label {
        font-size: 1.1rem;
        color: #555;
        font-weight: 600;
    }

    .key-metric-desc {
        font-size: 0.9rem;
        color: #777;
        margin-top: 0.5rem;
    }

    .priority-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #f44336;
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Statistics Section */
    .statistics-section {
        padding: 5rem 2rem;
        max-width: 1200px;
        margin: 0 auto;
        background: #fff;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card-title {
        font-size: 1.1rem;
        color: #555;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .stat-card-icon {
        font-size: 1.5rem;
    }

    .stat-card-content {
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .stat-value {
        text-align: center;
    }

    .stat-value-number {
        font-size: 2rem;
        font-weight: bold;
        color: #4CAF50;
    }

    .stat-value-label {
        font-size: 0.9rem;
        color: #666;
        margin-top: 0.3rem;
    }

    /* Chart Container */
    .chart-container {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .chart-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    /* Bar Chart */
    .bar-chart {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .bar-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
    }

    .bar-label {
        min-width: 200px;
        max-width: 200px;
        font-size: 0.9rem;
        color: #555;
        line-height: 1.3;
        padding-right: 1rem;
        word-wrap: break-word;
    }

    .bar-wrapper {
        flex: 1;
        background: #e0e0e0;
        border-radius: 10px;
        overflow: visible;
        /* CHANGED: Allow overflow untuk angka */
        height: 40px;
        /* INCREASED: Lebih tinggi */
        position: relative;
        min-width: 100px;
    }

    .bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #4CAF50, #2c5f2d);
        border-radius: 10px;
        transition: width 1s ease;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 12px;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        min-width: fit-content;
        /* ADDED: Prevent text overflow */
        position: relative;
    }

    .bar-fill[style*="width: 0%"],
    .bar-fill[style*="width: 1%"],
    .bar-fill[style*="width: 2%"],
    .bar-fill[style*="width: 3%"],
    .bar-fill[style*="width: 4%"],
    .bar-fill[style*="width: 5%"] {
        color: transparent;
        /* Hide white text inside */
    }

    .bar-fill[style*="width: 0%"]::after,
    .bar-fill[style*="width: 1%"]::after,
    .bar-fill[style*="width: 2%"]::after,
    .bar-fill[style*="width: 3%"]::after,
    .bar-fill[style*="width: 4%"]::after,
    .bar-fill[style*="width: 5%"]::after {
        content: attr(data-value);
        position: absolute;
        right: -60px;
        color: #555;
        font-weight: 600;
        white-space: nowrap;
    }

    .bar-value-outside {
        position: absolute;
        right: -70px;
        top: 50%;
        transform: translateY(-50%);
        color: #555;
        font-weight: 600;
        font-size: 0.9rem;
        white-space: nowrap;
        display: none;
        /* Show only for small bars */
    }

    .bar-item.small-bar .bar-fill {
        color: transparent;
    }

    .bar-item.small-bar .bar-value-outside {
        display: block;
    }

    @media (max-width: 768px) {
        .bar-label {
            min-width: 120px;
            max-width: 120px;
            font-size: 0.8rem;
        }

        .bar-wrapper {
            height: 35px;
        }

        .bar-fill {
            font-size: 0.8rem;
            padding-right: 8px;
        }

        .bar-fill::after,
        .bar-value-outside {
            right: -50px;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 480px) {
        .bar-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .bar-label {
            min-width: 100%;
            max-width: 100%;
        }

        .bar-wrapper {
            width: 100%;
        }
    }

    /* For different chart types */
    .bar-fill.color-danger {
        background: linear-gradient(90deg, #f44336, #d32f2f);
    }

    .bar-fill.color-warning {
        background: linear-gradient(90deg, #FF9800, #F57C00);
    }

    .bar-fill.color-info {
        background: linear-gradient(90deg, #2196F3, #1976D2);
    }

    .bar-fill.color-success {
        background: linear-gradient(90deg, #4CAF50, #2c5f2d);
    }


    .bar-wrapper {
        flex: 1;
        background: #e0e0e0;
        border-radius: 10px;
        overflow: visible;
        height: 40px;
        position: relative;
    }

    /* Villages Section */
    .villages {
        padding: 5rem 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .villages-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
    }

    .village-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .village-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #4CAF50, #2c5f2d);
        transform: scaleX(0);
        transition: transform 0.3s;
    }

    .village-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .village-card:hover::before {
        transform: scaleX(1);
    }

    .village-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #4CAF50, #2c5f2d);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .village-name {
        font-size: 1.3rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
    }

    .village-stats {
        display: flex;
        justify-content: space-between;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #eee;
    }

    .village-stat {
        text-align: center;
    }

    .village-stat-number {
        font-size: 1.3rem;
        font-weight: bold;
        color: #4CAF50;
    }

    .village-stat-label {
        font-size: 0.8rem;
        color: #666;
        margin-top: 0.3rem;
    }

    /* Loading Skeleton */
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
        border-radius: 10px;
    }

    @keyframes loading {
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }

    .skeleton-text {
        height: 20px;
        margin-bottom: 10px;
    }

    .skeleton-number {
        height: 40px;
        width: 100px;
        margin: 0 auto;
    }

    /* Insight Box */
    .insight-box {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        border-left: 5px solid #ff9800;
        padding: 1.5rem;
        border-radius: 10px;
        margin: 2rem 0;
    }

    .insight-box h4 {
        color: #e65100;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .insight-box p {
        color: #555;
        line-height: 1.6;
    }

    /* Loading Indicator */
    .loading-indicator {
        text-align: center;
        padding: 2rem;
        color: #666;
    }

    .spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #4CAF50;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Footer */
    footer {
        background: #2c3e50;
        color: white;
        padding: 3rem 2rem;
        text-align: center;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .nav-links {
            display: none;
        }

        .hero h1 {
            font-size: 2.5rem;
        }

        .hero .tagline {
            font-size: 1.5rem;
        }

        .stats {
            gap: 1rem;
        }

        .bar-label {
            min-width: 100px;
            font-size: 0.8rem;
        }

        .key-metric-value {
            font-size: 2.5rem;
        }
    }
</style>
