{{-- File: resources/views/pages/system-info.blade.php --}}
@extends('layouts.app')

@section('title', 'System Information - ParkSmart')

@section('content')
<div class="fade-in">
    <h2><i class="fas fa-info-circle"></i> System Information</h2>
    
    <div class="card">
        <h3><i class="fas fa-chart-simple"></i> Parking Statistics</h3>
        <div class="stats-grid" style="margin-top: 20px;">
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total_spots'] ?? 0 }}</div>
                <div class="stat-label">Total Parking Spots</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['car_spots'] ?? 0 }}</div>
                <div class="stat-label">Car Spots</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['motorcycle_spots'] ?? 0 }}</div>
                <div class="stat-label">Motorcycle Spots</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['utilization_rate'] ?? 0 }}%</div>
                <div class="stat-label">Utilization Rate</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total_users'] ?? 0 }}</div>
                <div class="stat-label">Registered Students</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['active_permits'] ?? 0 }}</div>
                <div class="stat-label">Active Permits</div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <h3><i class="fas fa-gavel"></i> Parking Rules & Regulations</h3>
        <ul style="margin: 20px 0 0 20px; line-height: 1.8;">
            <li>Permit must be displayed prominently on the windshield or handlebar at all times</li>
            <li>Park only in your assigned parking slot</li>
            <li>Speed limit within campus: 15 km/h</li>
            <li>No parking in fire lanes, loading zones, or handicapped spots without authorization</li>
            <li>Violations may result in fines or permit revocation</li>
            <li>Permit is non-transferable</li>
            <li>Lost permits must be reported immediately (replacement fee applies)</li>
        </ul>
    </div>
    
    <div class="card">
        <h3><i class="fas fa-phone-alt"></i> Contact Information</h3>
        <div style="margin-top: 20px;">
            <p><i class="fas fa-envelope"></i> <strong>Email:</strong> parking@parksmart.edu</p>
            <p><i class="fas fa-phone"></i> <strong>Phone:</strong> (02) 8123-4567</p>
            <p><i class="fas fa-clock"></i> <strong>Office Hours:</strong> Monday - Friday, 8:00 AM - 5:00 PM</p>
            <p><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> Parking Services Office, Ground Floor, Admin Building</p>
        </div>
    </div>
</div>
@endsection