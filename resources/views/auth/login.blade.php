@include('layouts.auth.header')
<!-- LOGIN SECTION -->
    <section class="login-section">
        <div class="form-panel">
            <div class="form-section">
                <figure><img src="{{ asset('assets/img/logo.svg') }}" alt="Logo"></figure>

                <!-- FORM -->
                <form method="POST" action="{{ route('login.attempt') }}">
                    @csrf

                    <div class="filed">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" placeholder="Wpisz" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="filed">
                        <label for="password">Hasło</label>
                        <input type="password" name="password" id="password" placeholder="Wpisz" required>
                        @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="forgot-password-links">
                        <a href="{{ route('password.request') }}">Zapomniałem/am hasła</a>
                    </div>

                    <div class="checkbox">
                        <input type="checkbox" name="remember" id="remember" value="1" 
                        {{ old('remember') == '1' ? 'checked' : '' }}>
                       <label for="remember">Zapamiętaj mnie</label>
                    </div>

                    <div class="filed text-center">
                        <button type="submit">Zaloguj</button>
                    </div>
                </form>
                <!-- /FORM -->
            </div>
        </div>

        <div class="image-panel">
            <div class="image"><img src="{{ asset('assets/img/login-img.png') }}" alt=""></div>
        </div>
    </section>
    @include('layouts.auth.footer')
