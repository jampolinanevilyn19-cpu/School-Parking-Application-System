{{-- File: resources/views/pages/admin/reports.blade.php --}}
@extends('layouts.app')

@section('title', 'Reports - ParkSmart')

@section('content')
<div class="fade-in">
    <h2><i class="fas fa-chart-line"></i> Financial Reports</h2>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon-bg"><i class="fas fa-chart-line"></i></div>
            <div class="stat-value">₱{{ number_format($totalRevenue ?? 0) }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-bg"><i class="fas fa-car"></i></div>
            <div class="stat-value">₱{{ number_format($carRevenue ?? 0) }}</div>
            <div class="stat-label">Car Permits</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-bg"><i class="fas fa-motorcycle"></i></div>
            <div class="stat-value">₱{{ number_format($motorcycleRevenue ?? 0) }}</div>
            <div class="stat-label">Motorcycle Permits</div>
        </div>
    </div>
    
    <div class="card">
        <h3><i class="fas fa-chart-bar"></i> Monthly Revenue</h3>
        <canvas id="revenueChart" height="300"></canvas>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const monthlyData = @json($monthlyData ?? []);
        const labels = Object.keys(monthlyData);
        const values = Object.values(monthlyData);
        
        const ctx = document.getElementById('revenueChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Revenue (₱)',
                        data: values,
                        backgroundColor: '#3b82f6',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection