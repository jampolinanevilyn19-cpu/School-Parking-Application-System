{{-- File: resources/views/pages/my-applications.blade.php --}}
@extends('layouts.app')

@section('title', 'My Applications - ParkSmart')

@section('content')
<div class="fade-in">
    <h2><i class="fas fa-list-ul"></i> My Applications</h2>
    
    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Plate Number</th>
                        <th>Vehicle Type</th>
                        <th>Model</th>
                        <th>Color</th>
                        <th>Status</th>
                        <th>Parking Slot</th>
                        <th>Payment</th>
                        <th>Date Applied</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($myApplications ?? [] as $app)
                    <tr>
                        <td><strong>{{ $app['plate_number'] ?? 'N/A' }}</strong></td>
                        <td>{{ $app['vehicle_type'] ?? 'N/A' }}</td>
                        <td>{{ $app['vehicle_model'] ?? '—' }}</td>
                        <td>{{ $app['color'] ?? '—' }}</td>
                        <td>
                            <span class="badge {{ ($app['status'] ?? 'Pending') === 'Approved' ? 'badge-approved' : 'badge-pending' }}">
                                {{ $app['status'] ?? 'Pending' }}
                            </span>
                        </td>
                        <td>{{ $app['parking_slot'] ?? '—' }}</td>
                        <td>
                            <span class="badge {{ ($app['payment_status'] ?? 'Unpaid') === 'Paid' ? 'badge-approved' : 'badge-pending' }}">
                                {{ $app['payment_status'] ?? 'Unpaid' }}
                            </span>
                        </td>
                        <td>{{ $app['date'] ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center;">No applications found. <a href="{{ route('apply.form') }}">Apply now!</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection