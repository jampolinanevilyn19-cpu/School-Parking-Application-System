{{-- Updated File: resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Login - ParkSmart')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div class="card" style="max-width: 460px; width: 100%; padding: 44px 40px; text-align: center;">
        <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #2563eb, #1e40af); border-radius: 28px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
            <i class="fas fa-parking" style="font-size: 32px; color: white;"></i>
        </div>
        <h1 style="font-size: 1.8rem; margin-bottom: 8px;">ParkSmart</h1>
        <p style="color: #64748b; margin-bottom: 32px;">Intelligent School Parking System</p>
        
        <div style="display: flex; gap: 12px; margin-bottom: 28px;">
            <button id="showLoginBtn" class="btn btn-primary" style="flex:1;">Login</button>
            <button id="showRegBtn" class="btn btn-outline" style="flex:1;">Register</button>
        </div>
        
        <div id="loginPanel">
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email address" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">
                    <i class="fas fa-arrow-right-to-bracket"></i> Sign In
                </button>
            </form>
            <div style="background: #f1f5f9; border-radius: 20px; padding: 16px; margin-top: 24px; font-size: 0.75rem;">
                <div><strong>Demo Admin:</strong> admin@parking.edu / admin123</div>
                <div><strong>Student Demo:</strong> maria@student.edu / pass123</div>
                <div><strong>Student Demo:</strong> john@student.edu / pass123</div>
            </div>
        </div>
        
        <div id="registerPanel" style="display: none;">
            <form method="POST" action="{{ route('register.submit') }}">
                @csrf
                <div class="form-group">
                    <input type="text" name="name" placeholder="Full Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
                <div class="form-group">
                    <input type="text" name="course" placeholder="Course (Optional)">
                </div>
                <div class="form-group">
                    <input type="text" name="contact" placeholder="Contact Number (Optional)">
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('showLoginBtn').onclick = () => {
        document.getElementById('loginPanel').style.display = 'block';
        document.getElementById('registerPanel').style.display = 'none';
        document.getElementById('showLoginBtn').classList.add('btn-primary');
        document.getElementById('showLoginBtn').classList.remove('btn-outline');
        document.getElementById('showRegBtn').classList.add('btn-outline');
        document.getElementById('showRegBtn').classList.remove('btn-primary');
    };
    
    document.getElementById('showRegBtn').onclick = () => {
        document.getElementById('loginPanel').style.display = 'none';
        document.getElementById('registerPanel').style.display = 'block';
        document.getElementById('showRegBtn').classList.add('btn-primary');
        document.getElementById('showRegBtn').classList.remove('btn-outline');
        document.getElementById('showLoginBtn').classList.add('btn-outline');
        document.getElementById('showLoginBtn').classList.remove('btn-primary');
    };
</script>
@endpush
@endsection