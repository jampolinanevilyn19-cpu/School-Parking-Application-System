{{-- File: resources/views/pages/admin/parking-spots.blade.php --}}
@extends('layouts.app')

@section('title', 'Parking Spots - ParkSmart')

@section('content')
<div class="fade-in">
    <h2><i class="fas fa-map-pin"></i> Parking Spots Management</h2>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon-bg"><i class="fas fa-parking"></i></div>
            <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
            <div class="stat-label">Total Spots</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-bg"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value">{{ $stats['available'] ?? 0 }}</div>
            <div class="stat-label">Available Spots</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-bg"><i class="fas fa-car"></i></div>
            <div class="stat-value">{{ $stats['occupied'] ?? 0 }}</div>
            <div class="stat-label">Occupied Spots</div>
        </div>
    </div>
    
    <div class="card">
        <h3><i class="fas fa-map"></i> Parking Map</h3>
        <div class="spots-grid">
            @forelse($parkingSpots ?? [] as $spot)
            <div class="spot-card {{ $spot['status'] === 'Available' ? 'spot-available' : 'spot-occupied' }}">
                <i class="fas {{ $spot['type'] === 'Car' ? 'fa-car' : 'fa-motorcycle' }}"></i>
                <div><strong>{{ $spot['id'] }}</strong></div>
                <div style="font-size: 0.75rem;">{{ $spot['type'] }}</div>
                <div class="badge {{ $spot['status'] === 'Available' ? 'badge-approved' : 'badge-pending' }}" style="margin-top: 8px;">
                    {{ $spot['status'] }}
                </div>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center;">No parking spots configured</div>
            @endforelse
        </div>
    </div>
</div>
@endsection