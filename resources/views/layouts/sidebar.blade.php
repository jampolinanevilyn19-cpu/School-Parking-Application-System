{{-- File: resources/views/layouts/sidebar.blade.php --}}
@if(session('user'))
@php $user = session('user'); @endphp
<div class="sidebar-header">
    <div class="logo">
        <div class="logo-icon"><i class="fas fa-car"></i></div>
        <h2>ParkSmart</h2>
    </div>
    <div class="user-greeting">
        <i class="fas fa-user-circle"></i> {{ $user['name'] }}<br>
        <small>{{ $user['role'] === 'admin' ? 'Administrator' : 'Student' }}</small>
        @if($user['role'] === 'student')
            <br><small>ID: {{ $user['student_id'] ?? 'N/A' }}</small>
        @endif
    </div>
</div>

<div class="nav-menu">
    <a href="{{ route('dashboard') }}" class="nav-item">
        <i class="fas fa-chart-line"></i> Dashboard
    </a>
    
    @if($user['role'] === 'student')
        <a href="{{ route('apply.form') }}" class="nav-item">
            <i class="fas fa-plus-circle"></i> Apply Permit
        </a>
        <a href="{{ route('my.applications') }}" class="nav-item">
            <i class="fas fa-clipboard-list"></i> My Applications
        </a>
    @endif
    
    @if($user['role'] === 'admin')
        <a href="{{ route('admin.applications') }}" class="nav-item">
            <i class="fas fa-tasks"></i> Review Apps
        </a>
        <a href="{{ route('admin.transactions') }}" class="nav-item">
            <i class="fas fa-receipt"></i> Transactions
        </a>
        <a href="{{ route('admin.parking.spots') }}" class="nav-item">
            <i class="fas fa-parking"></i> Parking Map
        </a>
        <a href="{{ route('admin.reports') }}" class="nav-item">
            <i class="fas fa-chart-pie"></i> Analytics
        </a>
    @endif
    
    <a href="{{ route('system.info') }}" class="nav-item">
        <i class="fas fa-info-circle"></i> Information
    </a>
    
    <a href="{{ route('logout') }}" class="nav-item">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>
@endif