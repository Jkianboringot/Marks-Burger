<x-guest-layout>

    <div class="login-page">
        <div class="login-card">

            {{-- Brand --}}
            <div class="login-brand">
                <div class="login-brand-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.5 2 2 6 2 10c0 .6.1 1.1.2 1.6.1.5.5.9 1 1h17.6c.5-.1.9-.5 1-1 .1-.5.2-1 .2-1.6C22 6 17.5 2 12 2z"/>
                        <rect x="2" y="14" width="20" height="2.5" rx="1.25"/>
                        <rect x="2" y="18" width="20" height="2.5" rx="1.25"/>
                        <rect x="5" y="11.5" width="14" height="2.5" rx="1.25"/>
                    </svg>
                </div>
                <div class="login-brand-name">{{ config('app.name', 'BurgerPOS') }}</div>
                <div class="login-brand-sub">Sign in to your account</div>
            </div>

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="login-errors">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Session status --}}
            @session('status')
                <div class="login-status">{{ $value }}</div>
            @endsession

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="login-form-group">
                    <label class="login-label" for="email">Email Address</label>
                    <input
                        id="email"
                        class="login-input {{ $errors->has('email') ? 'error' : '' }}"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        required
                        autofocus
                        autocomplete="username"
                    />
                </div>

                <div class="login-form-group">
                    <label class="login-label" for="password">Password</label>
                    <input
                        id="password"
                        class="login-input {{ $errors->has('password') ? 'error' : '' }}"
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    />
                </div>

                <div class="login-remember">
                    <input id="remember_me" class="login-checkbox" type="checkbox" name="remember" />
                    <label for="remember_me" class="login-remember-label">Remember me</label>
                </div>

                <button type="submit" class="login-btn">Sign In</button>
            </form>

            {{-- Forgot password --}}
            @if (Route::has('password.request'))
                <div class="login-footer">
                    <a href="{{ route('password.request') }}" class="login-forgot">
                        Forgot your password?
                    </a>
                </div>
            @endif

        </div>
    </div>

</x-guest-layout>