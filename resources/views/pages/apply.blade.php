{{-- File: resources/views/pages/apply.blade.php --}}
@extends('layouts.app')

@section('title', 'Apply for Permit - ParkSmart')

@section('content')
<div class="fade-in">
    <h2><i class="fas fa-file-signature"></i> New Permit Application</h2>
    
    <div class="card">
        <form method="POST" action="{{ route('apply.submit') }}">
            @csrf
            <div class="form-group">
                <label><i class="fas fa-car"></i> Plate Number *</label>
                <input type="text" name="plate_number" placeholder="e.g., ABC-1234" required value="{{ old('plate_number') }}">
                <small style="color: #64748b;">Enter your vehicle's plate number</small>
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-motorcycle"></i> Vehicle Type *</label>
                <select name="vehicle_type" required>
                    <option value="">Select vehicle type</option>
                    <option value="Car" {{ old('vehicle_type') == 'Car' ? 'selected' : '' }}>Car</option>
                    <option value="Motorcycle" {{ old('vehicle_type') == 'Motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                </select>
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-truck"></i> Vehicle Model</label>
                <input type="text" name="vehicle_model" placeholder="e.g., Toyota Vios" value="{{ old('vehicle_model') }}">
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-palette"></i> Color</label>
                <input type="text" name="color" placeholder="e.g., White" value="{{ old('color') }}">
            </div>
            
            <div style="background: #f0f9ff; padding: 16px; border-radius: 20px; margin-bottom: 24px;">
                <i class="fas fa-info-circle" style="color: #2563eb;"></i>
                <strong>Important:</strong> Processing takes 2-3 business days. Payment is required after approval.
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Submit Application
            </button>
        </form>
    </div>
</div>
@endsection