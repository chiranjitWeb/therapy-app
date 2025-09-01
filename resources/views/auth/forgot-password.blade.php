@include('layouts.auth.header')

    <!-- Forget -->
    <section class="login-section">
        <div class="form-panel">
            <div class="form-section">
                <figure><img src="{{ asset('assets/img/logo.svg') }}" alt="Logo"></figure>

                <!-- FORM -->
                <h4 class="mb-3">Reset Password</h4>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                        </form>
                <!-- /FORM -->
            </div>
        </div>

        <div class="image-panel">
            <div class="image"><img src="{{ asset('assets/img/login-img.png') }}" alt=""></div>
        </div>
    </section>
    <!-- Forget -->
    @include('layouts.auth.footer')
