{{-- File: resources/views/pages/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard - ParkSmart')

@section('content')
<div class="fade-in">
    <h2 style="margin-bottom: 24px;"><i class="fas fa-chart-simple"></i> Dashboard Overview</h2>
    
    <div class="stats-grid">
        <div class="stat-card" data-tooltip="Total parking permit applications">
            <div class="stat-icon-bg"><i class="fas fa-car"></i></div>
            <div class="stat-value">{{ $stats['total_applications'] ?? 0 }}</div>
            <div class="stat-label">Total Applications</div>
        </div>
        <div class="stat-card" data-tooltip="Applications waiting for admin review">
            <div class="stat-icon-bg"><i class="fas fa-clock"></i></div>
            <div class="stat-value">{{ $stats['pending'] ?? 0 }}</div>
            <div class="stat-label">Pending Approval</div>
        </div>
        <div class="stat-card" data-tooltip="Successfully approved permits">
            <div class="stat-icon-bg"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value">{{ $stats['approved'] ?? 0 }}</div>
            <div class="stat-label">Approved Permits</div>
        </div>
        <div class="stat-card" data-tooltip="Total collected fees">
            <div class="stat-icon-bg"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-value">₱{{ number_format($stats['total_revenue'] ?? 0) }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>
        <div class="stat-card" data-tooltip="Currently available parking slots">
            <div class="stat-icon-bg"><i class="fas fa-parking"></i></div>
            <div class="stat-value">{{ $stats['available_spots'] ?? 0 }}</div>
            <div class="stat-label">Available Spots</div>
        </div>
        <div class="stat-card" data-tooltip="Permits with completed payment">
            <div class="stat-icon-bg"><i class="fas fa-credit-card"></i></div>
            <div class="stat-value">{{ $stats['paid_permits'] ?? 0 }}</div>
            <div class="stat-label">Paid Permits</div>
        </div>
    </div>
    
    <div class="flex-row">
        <div class="card" style="flex: 2;">
            <div class="card-header">
                <h3><i class="fas fa-chart-pie"></i> Application Status</h3>
            </div>
            <canvas id="statusChart" height="250"></canvas>
        </div>
        
        <div class="card" style="flex: 1;">
            <div class="card-header">
                <h3><i class="fas fa-info-circle"></i> Fee Structure</h3>
            </div>
            <div style="background: #f8fafc; border-radius: 20px; padding: 20px;">
                <div style="margin-bottom: 16px; padding: 12px; background: white; border-radius: 16px;">
                    <i class="fas fa-car" style="color: #2563eb;"></i>
                    <strong>Car Permit:</strong> ₱500 / semester
                </div>
                <div style="margin-bottom: 16px; padding: 12px; background: white; border-radius: 16px;">
                    <i class="fas fa-motorcycle" style="color: #10b981;"></i>
                    <strong>Motorcycle:</strong> ₱300 / semester
                </div>
                <div style="margin-bottom: 16px; padding: 12px; background: white; border-radius: 16px;">
                    <i class="fas fa-clock"></i>
                    <strong>Late Renewal Fee:</strong> +₱100 (Car) / +₱50 (Motorcycle)
                </div>
                <div style="padding: 12px; background: white; border-radius: 16px;">
                    <i class="fas fa-calendar-alt"></i>
                    <strong>Validity:</strong> One Academic Semester
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-history"></i> Recent Applications</h3>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Plate Number</th>
                        <th>Vehicle</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($recentApplications ?? []) as $app)
                    <tr>
                        <td>{{ $app['student_name'] ?? 'N/A' }}</td>
                        <td><strong>{{ $app['plate_number'] ?? 'N/A' }}</strong></td>
                        <td>{{ $app['vehicle_type'] ?? 'N/A' }} {{ $app['vehicle_model'] ?? '' }}</td>
                        <td>
                            <span class="badge {{ ($app['status'] ?? 'Pending') === 'Approved' ? 'badge-approved' : 'badge-pending' }}">
                                {{ $app['status'] ?? 'Pending' }}
                            </span>
                        </td>
                        <td>{{ $app['date'] ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">No applications found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartCanvas = document.getElementById('statusChart');
        if (chartCanvas) {
            new Chart(chartCanvas, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Approved'],
                    datasets: [{
                        data: [{{ $stats['pending'] ?? 0 }}, {{ $stats['approved'] ?? 0 }}],
                        backgroundColor: ['#f59e0b', '#10b981'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection