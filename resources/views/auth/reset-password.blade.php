@include('layouts.auth.header')
<section class="login-section">
    <div class="form-panel">
        <div class="form-section">
            <figure><img src="{{ asset('assets/img/logo.svg') }}" alt="Logo"></figure>

            <!-- FORM -->
            <h4 class="mb-3">Reset Password</h4>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
        
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>
        
                <div class="mb-3">
                    <label>New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
        
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
        
                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
            </form>
            <!-- /FORM -->
        </div>
    </div>

    <div class="image-panel">
        <div class="image"><img src="{{ asset('assets/img/login-img.png') }}" alt=""></div>
    </div>
</section>

@include('layouts.auth.footer')
