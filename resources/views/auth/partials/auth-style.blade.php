<style>
    :root {
        --auth-blue: #2f80ed;
        --auth-blue-dark: #2368c8;
        --auth-blue-deep: #174ea6;
        --auth-teal: #5cc7b2;
        --auth-bg: #f9fafb;
        --auth-surface: #ffffff;
        --auth-soft: #eef5ff;
        --auth-text: #1f2937;
        --auth-muted: #7b8aa0;
        --auth-border: #e6edf5;
    }

    html,
    body {
        min-height: 100%;
        background: var(--auth-bg) !important;
        font-family: 'Public Sans', sans-serif !important;
    }

    body.aps-auth-dark {
        --auth-bg: #0b1220;
        --auth-surface: #111c31;
        --auth-soft: #17233a;
        --auth-text: #eaf1fb;
        --auth-muted: #94a3b8;
        --auth-border: #24324a;
        background: var(--auth-bg) !important;
        color: var(--auth-text);
    }

    .aps-auth-shell {
        min-height: 100vh;
        display: grid;
        grid-template-columns: minmax(420px, 0.95fr) minmax(420px, 1fr);
        background: var(--auth-bg);
    }

    .aps-auth-hero {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: clamp(2rem, 5vw, 5rem);
        overflow: hidden;
        background:
            radial-gradient(circle at 22% 20%, rgba(255, 255, 255, 0.24), transparent 24%),
            linear-gradient(145deg, #2f80ed 0%, #3aa1f2 46%, #5cc7b2 100%);
        color: #ffffff;
    }

    .aps-auth-hero::before,
    .aps-auth-hero::after {
        content: "";
        position: absolute;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.16);
        pointer-events: none;
    }

    .aps-auth-hero::before {
        width: 300px;
        height: 300px;
        left: -90px;
        top: -80px;
    }

    .aps-auth-hero::after {
        width: 230px;
        height: 230px;
        right: -70px;
        bottom: 12%;
    }

    .aps-auth-hero-content {
        position: relative;
        z-index: 1;
        width: min(520px, 100%);
    }

    .aps-auth-brand-pill {
        display: inline-flex;
        align-items: center;
        justify-content: flex-start;
        gap: 0.85rem;
        margin-bottom: 2.25rem;
        padding: 0;
        border-radius: 0;
        background: transparent;
        box-shadow: none;
    }

    .aps-auth-brand-pill img {
        width: 88px;
        height: auto;
        display: block;
        opacity: 0.98;
        filter: brightness(0) invert(1) drop-shadow(0 12px 20px rgba(23, 78, 166, 0.2));
    }

    .aps-auth-brand-pill span {
        color: #ffffff;
        font-size: 1.18rem;
        font-weight: 780;
        letter-spacing: 0;
        text-shadow: 0 10px 20px rgba(23, 78, 166, 0.16);
    }

    .aps-auth-hero h1 {
        max-width: 460px;
        margin: 0 0 1rem;
        color: #ffffff;
        font-size: clamp(2rem, 4vw, 3.65rem);
        line-height: 1.04;
        font-weight: 760;
        letter-spacing: 0;
    }

    .aps-auth-hero p {
        max-width: 430px;
        margin: 0;
        color: rgba(255, 255, 255, 0.84) !important;
        font-size: 1rem;
        line-height: 1.7;
        font-weight: 500;
    }

    .aps-auth-hero-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.8rem;
        margin-top: 2.4rem;
    }

    .aps-auth-stat {
        padding: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
    }

    .aps-auth-stat strong,
    .aps-auth-stat span {
        display: block;
        color: #ffffff;
    }

    .aps-auth-stat strong {
        font-size: 1.28rem;
        line-height: 1;
        font-weight: 760;
    }

    .aps-auth-stat span {
        margin-top: 0.35rem;
        color: rgba(255, 255, 255, 0.74);
        font-size: 0.72rem;
        font-weight: 650;
    }

    body.aps-auth-dark .aps-auth-hero {
        background:
            radial-gradient(circle at 22% 20%, rgba(143, 194, 255, 0.14), transparent 24%),
            linear-gradient(145deg, #0b1a31 0%, #123e73 48%, #1d6d77 100%);
    }

    body.aps-auth-dark .aps-auth-hero::before,
    body.aps-auth-dark .aps-auth-hero::after {
        background: rgba(255, 255, 255, 0.08);
    }

    body.aps-auth-dark .aps-auth-stat {
        background: rgba(15, 23, 42, 0.2);
        border-color: rgba(255, 255, 255, 0.15);
    }

    .aps-auth-form-side {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: clamp(1.25rem, 5vw, 4rem);
        background: var(--auth-bg);
    }

    .aps-auth-theme {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.22rem;
        padding: 0.22rem;
        border: 1px solid var(--auth-border);
        border-radius: 999px;
        background: var(--auth-surface);
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.07);
    }

    .aps-auth-theme button {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 999px;
        background: transparent;
        color: var(--auth-muted);
        font-size: 1rem;
        transition: background 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
    }

    .aps-auth-theme button.is-active {
        background: #eaf4ff;
        color: var(--auth-blue);
        box-shadow: 0 8px 18px rgba(47, 128, 237, 0.13);
    }

    body.aps-auth-dark .aps-auth-theme button.is-active {
        background: rgba(47, 128, 237, 0.18);
        color: #8fc2ff;
    }

    .aps-auth-card {
        width: min(450px, 100%);
        padding: clamp(1.35rem, 3vw, 2rem);
        border: 1px solid var(--auth-border);
        border-radius: 28px;
        background: var(--auth-surface);
        box-shadow: 0 26px 70px rgba(15, 23, 42, 0.09);
    }

    body.aps-auth-dark .aps-auth-card {
        box-shadow: 0 28px 72px rgba(0, 0, 0, 0.28);
    }

    .aps-auth-card-brand {
        display: inline-flex;
        align-items: center;
        gap: 0.72rem;
        margin-bottom: 1.35rem;
    }

    .aps-auth-card-brand img,
    .aps-auth-logo {
        width: 96px;
        display: block;
        margin: 0;
    }

    .aps-auth-card-brand span {
        color: var(--auth-text);
        font-size: 1.02rem;
        font-weight: 780;
        letter-spacing: 0;
    }

    .aps-auth-card h4 {
        margin-bottom: 0.45rem;
        color: var(--auth-text) !important;
        font-size: clamp(1.45rem, 2vw, 1.82rem);
        font-weight: 760 !important;
        letter-spacing: 0;
    }

    .aps-auth-card p {
        margin-bottom: 1.6rem;
        color: var(--auth-muted) !important;
        font-size: 0.92rem;
        line-height: 1.55;
    }

    .aps-auth-label-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 0.45rem;
    }

    .aps-auth-label,
    .form-label {
        color: var(--auth-muted) !important;
        font-size: 0.72rem;
        font-weight: 750 !important;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .aps-auth-input {
        position: relative;
    }

    .aps-auth-input i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--auth-muted);
        font-size: 1.1rem;
        z-index: 2;
    }

    .aps-auth-input .form-control {
        height: 50px;
        padding: 0.76rem 3rem 0.76rem 2.85rem !important;
        border: 1px solid var(--auth-border) !important;
        border-radius: 15px !important;
        background: var(--auth-soft) !important;
        color: var(--auth-text) !important;
        font-size: 0.94rem;
        font-weight: 600;
        box-shadow: none !important;
        transition: border-color 0.18s ease, background 0.18s ease, box-shadow 0.18s ease;
    }

    .aps-auth-input .form-control::placeholder {
        color: #a7b2c3;
        font-weight: 500;
    }

    .aps-auth-input .form-control:focus {
        background: var(--auth-surface) !important;
        border-color: rgba(47, 128, 237, 0.62) !important;
        box-shadow: 0 0 0 4px rgba(47, 128, 237, 0.12) !important;
    }

    .btn-toggle-password {
        position: absolute;
        right: 0.55rem;
        top: 50%;
        z-index: 3;
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transform: translateY(-50%);
        border: 0;
        border-radius: 999px;
        background: transparent;
        color: var(--auth-muted);
    }

    .btn-toggle-password:hover {
        background: rgba(47, 128, 237, 0.1);
        color: var(--auth-blue);
    }

    .btn-primary {
        min-height: 50px;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        line-height: 1 !important;
        border: 0 !important;
        border-radius: 15px !important;
        background: linear-gradient(135deg, var(--auth-blue), var(--auth-blue-dark)) !important;
        color: #ffffff !important;
        font-size: 0.95rem !important;
        font-weight: 750 !important;
        box-shadow: 0 16px 30px rgba(47, 128, 237, 0.24) !important;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 20px 36px rgba(47, 128, 237, 0.3) !important;
    }

    .aps-auth-link,
    .aps-auth-card a {
        color: var(--auth-blue) !important;
        font-weight: 700;
        text-decoration: none;
    }

    .aps-auth-card a:hover {
        color: var(--auth-blue-dark) !important;
    }

    .alert {
        border: 1px solid transparent !important;
        border-radius: 16px !important;
        font-weight: 600;
        font-size: 0.86rem;
    }

    body.aps-auth-dark .alert-danger {
        background: rgba(239, 68, 68, 0.13) !important;
        color: #fecaca !important;
        border-color: rgba(239, 68, 68, 0.2) !important;
    }

    body.aps-auth-dark .alert-success {
        background: rgba(16, 185, 129, 0.13) !important;
        color: #bbf7d0 !important;
        border-color: rgba(16, 185, 129, 0.2) !important;
    }

    .aps-auth-mobile-brand {
        display: none;
        width: 82px;
        margin: 0;
    }

    @media (max-width: 991.98px) {
        .aps-auth-shell {
            display: flex;
            min-height: 100vh;
        }

        .aps-auth-hero {
            display: none;
        }

        .aps-auth-form-side {
            width: 100%;
            min-height: 100svh;
            padding: 4.4rem 1.2rem 1.4rem;
        }

        .aps-auth-card {
            border-radius: 26px;
        }

        .aps-auth-logo,
        .aps-auth-card-brand {
            display: none;
        }

        .aps-auth-mobile-brand {
            display: block;
            margin: 0 auto 1.1rem;
        }
    }

    @media (max-width: 575.98px) {
        .aps-auth-form-side {
            padding: 4.4rem 1rem 1rem;
            align-items: center;
        }

        .aps-auth-theme {
            top: 1rem;
            right: 1rem;
        }

        .aps-auth-card {
            padding: 1.35rem;
            border-radius: 22px;
            box-shadow: 0 18px 46px rgba(15, 23, 42, 0.08);
        }

        .aps-auth-card h4 {
            font-size: 1.35rem;
        }

        .aps-auth-card p {
            margin-bottom: 1.25rem;
            font-size: 0.88rem;
        }

        .aps-auth-input .form-control {
            height: 48px;
        }
    }
</style>
