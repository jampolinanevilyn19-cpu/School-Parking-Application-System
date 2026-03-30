{{-- File: resources/views/pages/admin/transactions.blade.php --}}
@extends('layouts.app')

@section('title', 'Transactions - ParkSmart')

@section('content')
<div class="fade-in">
    <h2><i class="fas fa-receipt"></i> Transaction Logs</h2>
    
    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Application ID</th>
                        <th>Student Name</th>
                        <th>Plate Number</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Valid Until</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions ?? [] as $trans)
                    <tr>
                        <td>#{{ $trans['id'] }}</td>
                        <td>#{{ $trans['application_id'] }}</td>
                        <td>{{ $trans['student_name'] ?? 'N/A' }}</td>
                        <td>{{ $trans['plate_number'] ?? 'N/A' }}</td>
                        <td>₱{{ number_format($trans['amount'] ?? 0) }}</td>
                        <td>{{ $trans['payment_method'] ?? 'Pending' }}</td>
                        <td>
                            <span class="badge {{ ($trans['status'] ?? 'Awaiting Payment') === 'Completed' ? 'badge-approved' : 'badge-pending' }}">
                                {{ $trans['status'] ?? 'Awaiting Payment' }}
                            </span>
                        </td>
                        <td>{{ $trans['date'] ?? 'N/A' }}</td>
                        <td>{{ $trans['valid_until'] ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center;">No transactions found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection