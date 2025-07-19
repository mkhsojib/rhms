@extends('layouts.app')

@section('title', 'Edit Availability')

@section('content_header')
    <h1>Edit Availability</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Availability for {{ $availability->availability_date->format('l, F j, Y') }}</h3>
                </div>
                
                <form method="POST" action="{{ route('admin.availability.update', $availability) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> You're editing your availability for <strong>{{ $availability->availability_date->format('l, F j, Y') }}</strong>.
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_time">Start Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="start_time" name="start_time" 
                                           value="{{ old('start_time', \Carbon\Carbon::parse($availability->start_time)->format('H:i')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_time">End Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="end_time" name="end_time" 
                                           value="{{ old('end_time', \Carbon\Carbon::parse($availability->end_time)->format('H:i')) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="slot_duration">Appointment Slot Duration (minutes) <span class="text-danger">*</span></label>
                            <select class="form-control" id="slot_duration" name="slot_duration" required>
                                <option value="30" {{ old('slot_duration', $availability->slot_duration) == 30 ? 'selected' : '' }}>30 minutes</option>
                                <option value="45" {{ old('slot_duration', $availability->slot_duration) == 45 ? 'selected' : '' }}>45 minutes</option>
                                <option value="60" {{ old('slot_duration', $availability->slot_duration) == 60 ? 'selected' : '' }}>60 minutes (1 hour)</option>
                                <option value="90" {{ old('slot_duration', $availability->slot_duration) == 90 ? 'selected' : '' }}>90 minutes (1.5 hours)</option>
                                <option value="120" {{ old('slot_duration', $availability->slot_duration) == 120 ? 'selected' : '' }}>120 minutes (2 hours)</option>
                            </select>
                            <small class="form-text text-muted">This determines how long each appointment slot will be.</small>
                        </div>

                        <div class="form-group">
                            <label for="is_available">Availability Status</label>
                            <select class="form-control" id="is_available" name="is_available">
                                <option value="1" {{ old('is_available', $availability->is_available) == true || old('is_available', $availability->is_available) == '1' ? 'selected' : '' }}>Available for Booking</option>
                                <option value="0" {{ old('is_available', $availability->is_available) == false || old('is_available', $availability->is_available) == '0' ? 'selected' : '' }}>Not Available (Blocked)</option>
                            </select>
                            <small class="form-text text-muted">Set to "Not Available" if you want to block this date from being booked.</small>
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" 
                                      placeholder="Add any notes about this availability...">{{ old('notes', $availability->notes) }}</textarea>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.availability.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Availability
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Availability
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Preview Generated Time Slots</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> This is a preview of the time slots that will be generated based on your settings.
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered" id="time-slots-preview">
                            <thead>
                                <tr>
                                    <th>Slot</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Time slots will be dynamically generated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Generate time slots preview
        function generateTimeSlots() {
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;
            const slotDuration = parseInt(document.getElementById('slot_duration').value);
            const isAvailable = document.getElementById('is_available').value === '1';
            
            if (!startTime || !endTime || !slotDuration) {
                return;
            }
            
            const tableBody = document.querySelector('#time-slots-preview tbody');
            tableBody.innerHTML = '';
            
            if (!isAvailable) {
                tableBody.innerHTML = '<tr><td colspan="3" class="text-center text-danger">This date is marked as unavailable</td></tr>';
                return;
            }
            
            const start = new Date(`2000-01-01T${startTime}`);
            const end = new Date(`2000-01-01T${endTime}`);
            
            if (start >= end) {
                tableBody.innerHTML = '<tr><td colspan="3" class="text-center text-danger">End time must be after start time</td></tr>';
                return;
            }
            
            let currentTime = new Date(start);
            let slotNumber = 1;
            
            // Get existing appointments (this would need to be populated from the server)
            // For now, we'll just show all slots as available
            const bookedSlots = [];
            
            while (currentTime < end) {
                const slotStart = currentTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                
                currentTime = new Date(currentTime.getTime() + slotDuration * 60000);
                
                if (currentTime <= end) {
                    const slotEnd = currentTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    const isBooked = bookedSlots.includes(slotStart);
                    
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${slotNumber}</td>
                        <td>${slotStart} - ${slotEnd}</td>
                        <td>
                            ${isBooked ? 
                              '<span class="badge badge-danger">Booked</span>' : 
                              '<span class="badge badge-success">Available</span>'}
                        </td>
                    `;
                    tableBody.appendChild(row);
                    
                    slotNumber++;
                }
            }
            
            if (slotNumber === 1) {
                tableBody.innerHTML = '<tr><td colspan="3" class="text-center text-warning">No slots available with current settings</td></tr>';
            }
        }
        
        // Initial generation
        generateTimeSlots();
        
        // Update on input changes
        document.getElementById('start_time').addEventListener('change', generateTimeSlots);
        document.getElementById('end_time').addEventListener('change', generateTimeSlots);
        document.getElementById('slot_duration').addEventListener('change', generateTimeSlots);
        document.getElementById('is_available').addEventListener('change', generateTimeSlots);
    });
</script>
@stop
