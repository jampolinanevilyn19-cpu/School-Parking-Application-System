{{-- File: resources/views/pages/admin/applications.blade.php --}}
@extends('layouts.app')

@section('title', 'Manage Applications - ParkSmart')

@section('content')
<div class="fade-in">
    <h2><i class="fas fa-tasks"></i> Manage Applications</h2>
    
    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Plate Number</th>
                        <th>Vehicle</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications ?? [] as $app)
                    <tr>
                        <td>#{{ $app['id'] }}</td>
                        <td>{{ $app['student_name'] ?? 'N/A' }}</td>
                        <td><strong>{{ $app['plate_number'] ?? 'N/A' }}</strong></td>
                        <td>{{ $app['vehicle_type'] ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ ($app['status'] ?? 'Pending') === 'Approved' ? 'badge-approved' : 'badge-pending' }}">
                                {{ $app['status'] ?? 'Pending' }}
                            </span>
                        </td>
                        <td>{{ $app['date'] ?? 'N/A' }}</td>
                        <td>
                            @if(($app['status'] ?? 'Pending') === 'Pending')
                                <form method="POST" action="{{ route('admin.approve', $app['id']) }}" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.delete', $app['id']) }}" style="display: inline-block;" onsubmit="return confirm('Delete this application?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            @else
                                <span class="badge badge-approved">Already Approved</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">No applications found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection