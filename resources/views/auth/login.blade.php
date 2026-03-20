<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --orange:       hsl(30, 100%, 50%);
            --orange-hover: hsl(30, 100%, 44%);
            --orange-light: hsl(30, 100%, 65%);
            --cream:        #f5ede0;
            --cream-dark:   #eedfc8;
            --white:        #ffffff;
            --text-dark:    #1a1a1a;
            --text-mid:     #555;
            --text-light:   #999;
            --green:        #38a169;
            --red:          #e53e3e;
            --border:       2px solid hsl(30, 94%, 45%);
            --shadow:       0 2px 12px hsla(30, 97%, 15%, 0.14);
            --shadow-lg:    0 12px 40px hsla(30, 97%, 15%, 0.18);
        }

        body {
            font-family: "Poppins", sans-serif;
            background: var(--cream);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* ── Decorative background blobs ── */
        body::before {
            content: '';
            position: fixed;
            top: -120px;
            right: -120px;
            width: 420px;
            height: 420px;
            background: radial-gradient(circle, hsla(30,100%,50%,0.18) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -100px;
            left: -100px;
            width: 360px;
            height: 360px;
            background: radial-gradient(circle, hsla(30,100%,65%,0.13) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        /* ── Card ── */
        .card {
            background: var(--white);
            border-radius: 1.5rem;
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 420px;
            padding: 2.5rem 2.25rem 2rem;
            position: relative;
            z-index: 1;
            animation: cardIn 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }
        @keyframes cardIn {
            from { transform: translateY(20px) scale(0.97); opacity: 0; }
            to   { transform: translateY(0)    scale(1);    opacity: 1; }
        }

        /* ── Top accent bar ── */
        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--orange), var(--orange-light));
            border-radius: 1.5rem 1.5rem 0 0;
        }

        /* ── Logo / brand ── */
        .brand {
            text-align: center;
            margin-bottom: 1.75rem;
        }
        .brand-icon {
            width: 62px;
            height: 62px;
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            border-radius: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 18px hsla(30, 97%, 15%, 0.22);
            margin-bottom: 0.85rem;
        }
        .brand-icon svg {
            width: 34px;
            height: 34px;
            fill: var(--white);
        }
        .brand-title {
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.02em;
            line-height: 1.2;
        }
        .brand-sub {
            font-size: 0.8rem;
            color: var(--text-light);
            font-weight: 500;
            margin-top: 0.2rem;
        }

        /* ── Alerts ── */
        .alert-error {
            background: #fff5f5;
            border-left: 4px solid var(--red);
            border-radius: 0.6rem;
            padding: 0.7rem 0.9rem;
            font-size: 0.8rem;
            color: #c53030;
            margin-bottom: 1.25rem;
            font-weight: 500;
        }
        .alert-success {
            background: #f0fff4;
            border-left: 4px solid var(--green);
            border-radius: 0.6rem;
            padding: 0.7rem 0.9rem;
            font-size: 0.8rem;
            color: #276749;
            margin-bottom: 1.25rem;
            font-weight: 500;
        }

        /* ── Form fields ── */
        .field { margin-bottom: 1.1rem; }

        label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-mid);
            margin-bottom: 0.38rem;
            letter-spacing: 0.01em;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.65rem 0.95rem;
            border: 1.5px solid #e0d0c0;
            border-radius: 0.75rem;
            font-size: 0.87rem;
            font-family: "Poppins", sans-serif;
            color: var(--text-dark);
            background: #fdfaf7;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--orange);
            background: var(--white);
            box-shadow: 0 0 0 3px hsla(30, 100%, 50%, 0.13);
        }
        input::placeholder { color: #ccc; }

        /* ── Remember me ── */
        .remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.4rem;
        }
        .remember input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            accent-color: var(--orange);
            cursor: pointer;
            border-radius: 4px;
        }
        .remember span {
            font-size: 0.8rem;
            color: var(--text-light);
            font-weight: 500;
        }

        /* ── Submit button ── */
        .btn-login {
            width: 100%;
            padding: 0.72rem;
            background: var(--orange);
            color: var(--white);
            border: none;
            border-radius: 0.75rem;
            font-family: "Poppins", sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            cursor: pointer;
            box-shadow: 0 4px 14px hsla(30, 97%, 15%, 0.22);
            transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
        }
        .btn-login:hover {
            background: var(--orange-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px hsla(30, 97%, 15%, 0.28);
        }
        .btn-login:active {
            transform: translateY(0) scale(0.98);
        }

        /* ── Footer link ── */
        .footer-link {
            text-align: center;
            margin-top: 1.1rem;
        }
        .footer-link a {
            font-size: 0.78rem;
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s;
        }
        .footer-link a:hover {
            color: var(--orange);
            text-decoration: underline;
        }

        /* ── Divider ── */
        .divider {
            border: none;
            border-top: 1px solid #f0e8dc;
            margin: 1.5rem 0 1.25rem;
        }
    </style>
</head>
<body>

<div class="card">

    {{-- Brand --}}
    <div class="brand">
        <div class="brand-icon">
            {{-- Burger / food stall icon --}}
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 13h18a1 1 0 0 1 0 2H3a1 1 0 0 1 0-2zm0 4h18v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1zm7.18-6A5 5 0 0 1 7 7.1V7a5 5 0 0 1 10 0v.1A5 5 0 0 1 13.82 11H10.18z"/>
            </svg>
        </div>
        <div class="brand-title">Welcome Back</div>
        <div class="brand-sub">Sign in to your account</div>
    </div>

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="alert-error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- Session status --}}
    @if (session('status'))
        <div class="alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
            <label for="email">Email Address</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="you@example.com"
                required
                autofocus
                autocomplete="username"
            />
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                placeholder="••••••••"
                required
                autocomplete="current-password"
            />
        </div>

        <div class="remember">
            <input type="checkbox" id="remember_me" name="remember" />
            <span>Remember me</span>
        </div>

        <button type="submit" class="btn-login">Log In</button>

        @if (Route::has('password.request'))
            <div class="footer-link">
                <a href="{{ route('password.request') }}">Forgot your password?</a>
            </div>
        @endif

    </form>
</div>

</body>
</html>