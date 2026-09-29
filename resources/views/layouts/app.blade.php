<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DevJournal — Modern Tech Blog & Engineering Journal')</title>
    
    <!-- Google Fonts: Editorial Serif + Clean Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Claude Design System Styling -->
    <style>
        :root {
            --bg-canvas: #FAF9F5;
            --bg-surface: #FFFFFF;
            --bg-subtle: #F3F1EC;
            --bg-elevated: #FFFFFF;
            
            --text-primary: #1E1E1E;
            --text-secondary: #68655E;
            --text-tertiary: #8F8B82;
            --text-inverse: #FFFFFF;
            
            --border-default: #E5E2D9;
            --border-subtle: #ECE9E2;
            --border-focus: #D97757;
            
            --accent-primary: #D97757;
            --accent-hover: #C96646;
            --accent-subtle: #F7ECE6;
            --accent-dark: #8F3A22;
            
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --font-serif: 'Lora', Georgia, serif;
            --font-mono: 'JetBrains Mono', monospace;
            
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 12px 24px -4px rgba(0, 0, 0, 0.08);
            
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --radius-full: 9999px;
            
            --transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Dark Mode Preferences */
        @media (prefers-color-scheme: dark) {
            :root {
                --bg-canvas: #151412;
                --bg-surface: #201F1B;
                --bg-subtle: #292823;
                --bg-elevated: #262521;
                
                --text-primary: #ECEAE5;
                --text-secondary: #AAA69D;
                --text-tertiary: #77736A;
                --text-inverse: #151412;
                
                --border-default: #35332C;
                --border-subtle: #2D2B26;
                --border-focus: #E28C6E;
                
                --accent-primary: #D97757;
                --accent-hover: #E28C6E;
                --accent-subtle: #38241C;
            }
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--bg-canvas);
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: var(--transition);
        }

        /* Header / Navbar */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(250, 249, 245, 0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-default);
            transition: var(--transition);
        }

        @media (prefers-color-scheme: dark) {
            .site-header {
                background: rgba(21, 20, 18, 0.92);
            }
        }

        .header-container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-family: var(--font-serif);
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .brand-logo__mark {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-dark));
            color: white;
            border-radius: var(--radius-sm);
            display: grid;
            place-items: center;
            font-family: var(--font-mono);
            font-size: 1.05rem;
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(217, 119, 87, 0.35);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.55rem 1.15rem;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: var(--radius-md);
            border: 1px solid transparent;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
        }

        .btn-primary {
            background-color: var(--accent-primary);
            color: var(--text-inverse);
            box-shadow: 0 2px 6px rgba(217, 119, 87, 0.25);
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(217, 119, 87, 0.35);
        }

        .btn-outline {
            background: transparent;
            border-color: var(--border-default);
            color: var(--text-primary);
        }

        .btn-outline:hover {
            background: var(--bg-subtle);
            border-color: var(--text-secondary);
        }

        .btn-danger {
            background-color: #EF4444;
            color: #FFFFFF;
        }

        .btn-danger:hover {
            background-color: #DC2626;
        }

        .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-default);
            background: var(--bg-surface);
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-icon:hover {
            color: var(--accent-primary);
            border-color: var(--accent-primary);
            background: var(--accent-subtle);
        }

        .btn-icon--delete:hover {
            color: #EF4444;
            border-color: #F87171;
            background: #FEF2F2;
        }

        /* Main Container */
        .main-content {
            flex: 1;
            max-width: 1180px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem 1.5rem 3.5rem;
        }

        /* Alert Component Styling */
        .c-alert {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.9rem 1.2rem;
            margin-bottom: 1.8rem;
            border-radius: var(--radius-md);
            border: 1px solid;
            font-size: 0.92rem;
            animation: fadeIn 0.3s ease;
        }

        .c-alert__icon {
            font-weight: 700;
            display: grid;
            place-items: center;
            width: 22px;
            height: 22px;
            border-radius: 50%;
        }

        .c-alert__content {
            flex: 1;
            font-weight: 500;
        }

        .c-alert__close {
            background: none;
            border: none;
            font-size: 1.3rem;
            line-height: 1;
            color: inherit;
            opacity: 0.6;
            cursor: pointer;
            padding: 0 0.2rem;
        }

        .c-alert__close:hover {
            opacity: 1;
        }

        .c-alert--success {
            background-color: #ECFDF5;
            border-color: #A7F3D0;
            color: #065F46;
        }

        .c-alert--danger {
            background-color: #FEF2F2;
            border-color: #FECACA;
            color: #991B1B;
        }

        /* Card Component Styling */
        .c-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-default);
            border-radius: var(--radius-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .c-card:hover {
            border-color: var(--border-focus);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .c-card__cover {
            height: 190px;
            width: 100%;
            overflow: hidden;
            background: var(--bg-subtle);
            position: relative;
        }

        .c-card__cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .c-card:hover .c-card__cover img {
            transform: scale(1.04);
        }

        .c-card__cover--placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--bg-subtle) 0%, rgba(217, 119, 87, 0.08) 100%);
        }

        .c-card__placeholder-pattern {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--text-tertiary);
            font-size: 0.85rem;
            font-family: var(--font-mono);
            font-weight: 500;
        }

        .c-card__body {
            padding: 1.35rem 1.45rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .c-card__meta {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.78rem;
            color: var(--text-tertiary);
            margin-bottom: 0.65rem;
            font-weight: 500;
        }

        .c-card__category {
            color: var(--accent-primary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .c-card__title {
            font-family: var(--font-serif);
            font-size: 1.25rem;
            font-weight: 600;
            line-height: 1.35;
            margin-bottom: 0.65rem;
            color: var(--text-primary);
        }

        .c-card__title a:hover {
            color: var(--accent-primary);
        }

        .c-card__excerpt {
            color: var(--text-secondary);
            font-size: 0.88rem;
            line-height: 1.55;
            margin-bottom: 1.25rem;
            flex: 1;
        }

        .c-card__footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid var(--border-subtle);
        }

        .c-card__link {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--accent-primary);
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .c-card__link:hover {
            color: var(--accent-hover);
            gap: 0.55rem;
        }

        .c-card__actions {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .inline-form {
            display: inline-block;
            margin: 0;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 1.35rem;
        }

        .form-label {
            display: block;
            font-size: 0.88rem;
            font-weight: 600;
            margin-bottom: 0.45rem;
            color: var(--text-primary);
        }

        .form-label .required {
            color: #EF4444;
        }

        .form-control {
            width: 100%;
            padding: 0.65rem 0.95rem;
            font-family: var(--font-sans);
            font-size: 0.93rem;
            background-color: var(--bg-surface);
            border: 1px solid var(--border-default);
            border-radius: var(--radius-md);
            color: var(--text-primary);
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(217, 119, 87, 0.15);
        }

        .form-control.is-invalid {
            border-color: #EF4444;
            background-color: #FFFDFD;
        }

        .form-error {
            display: block;
            margin-top: 0.35rem;
            font-size: 0.82rem;
            color: #DC2626;
            font-weight: 500;
        }

        /* Footer */
        .site-footer {
            border-top: 1px solid var(--border-default);
            background-color: var(--bg-surface);
            padding: 2.5rem 1.5rem 2rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-top: auto;
        }

        .footer-container {
            max-width: 1180px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1.2rem;
        }

        .footer-tag {
            font-family: var(--font-mono);
            font-size: 0.78rem;
            background: var(--bg-subtle);
            padding: 0.2rem 0.55rem;
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Header / Nav -->
    <header class="site-header">
        <div class="header-container">
            <a href="{{ route('posts.index') }}" class="brand-logo">
                <span class="brand-logo__mark">DJ</span>
                <span>DevJournal</span>
            </a>

            <div class="header-actions">
                <a href="{{ route('posts.index') }}" class="btn btn-outline" style="border: none;">
                    Beranda
                </a>
                <a href="{{ route('posts.create') }}" class="btn btn-primary" id="btn-create-post">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Tulis Artikel Baru
                </a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="main-content">
        <!-- Flash Session Alert (Requirement 6) -->
        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        @if(session('error'))
            <x-alert type="danger" :message="session('error')" />
        @endif

        <!-- Dynamic Content (Requirement 3: Yield Content Section) -->
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-container">
            <div>
                <strong>DevJournal</strong> &mdash; Tugas Rutin 10 Blog CRUD Laravel.
            </div>
            <div style="display: flex; align-items: center; gap: 0.8rem;">
                <span class="footer-tag">Laravel v{{ Illuminate\Foundation\Application::VERSION }}</span>
                <span class="footer-tag">Repo: TugasWeb-P10-BlogCRUD</span>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
