@extends('layouts.app')

@section('title', 'Add Raqi Availability')

@section('content_header')
    <h1>Add New Raqi Availability</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('superadmin.raqi-availability.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="practitioner_id">Raqi/Practitioner *</label>
                            <select name="practitioner_id" id="practitioner_id" class="form-control @error('practitioner_id') is-invalid @enderror" required>
                                <option value="">Select Raqi</option>
                                @foreach($practitioners as $practitioner)
                                    <option value="{{ $practitioner->id }}" {{ old('practitioner_id') == $practitioner->id ? 'selected' : '' }}>
                                        {{ $practitioner->name }} 
                                        @if($practitioner->specialization)
                                            ({{ $practitioner->specialization_label }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('practitioner_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="availability_date">Availability Date *</label>
                            <input type="date" name="availability_date" id="availability_date" 
                                   class="form-control @error('availability_date') is-invalid @enderror" 
                                   value="{{ old('availability_date') }}" 
                                   min="{{ date('Y-m-d') }}" required>
                            @error('availability_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_time">Start Time *</label>
                            <input type="time" name="start_time" id="start_time" 
                                   class="form-control @error('start_time') is-invalid @enderror" 
                                   value="{{ old('start_time') }}" required>
                            @error('start_time')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_time">End Time *</label>
                            <input type="time" name="end_time" id="end_time" 
                                   class="form-control @error('end_time') is-invalid @enderror" 
                                   value="{{ old('end_time') }}" required>
                            @error('end_time')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="slot_duration">Slot Duration (minutes) *</label>
                            <select name="slot_duration" id="slot_duration" class="form-control @error('slot_duration') is-invalid @enderror" required>
                                <option value="">Select Duration</option>
                                <option value="15" {{ old('slot_duration') == '15' ? 'selected' : '' }}>15 minutes</option>
                                <option value="30" {{ old('slot_duration') == '30' ? 'selected' : '' }}>30 minutes</option>
                                <option value="45" {{ old('slot_duration') == '45' ? 'selected' : '' }}>45 minutes</option>
                                <option value="60" {{ old('slot_duration') == '60' ? 'selected' : '' }}>1 hour</option>
                                <option value="90" {{ old('slot_duration') == '90' ? 'selected' : '' }}>1.5 hours</option>
                                <option value="120" {{ old('slot_duration') == '120' ? 'selected' : '' }}>2 hours</option>
                            </select>
                            @error('slot_duration')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_available" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_available">Available on this date</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" rows="3" 
                              class="form-control @error('notes') is-invalid @enderror" 
                              placeholder="Any additional notes about this availability">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Availability
                    </button>
                    <a href="{{ route('superadmin.raqi-availability.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview Card -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Time Slots Preview</h3>
        </div>
        <div class="card-body">
            <div id="time-slots-preview" class="alert alert-info">
                <i class="fas fa-info-circle"></i> Fill in the form above to see the generated time slots.
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    const slotDurationSelect = document.getElementById('slot_duration');
    const previewDiv = document.getElementById('time-slots-preview');

    function updateTimeSlotsPreview() {
        const startTime = startTimeInput.value;
        const endTime = endTimeInput.value;
        const slotDuration = slotDurationSelect.value;

        if (!startTime || !endTime || !slotDuration) {
            previewDiv.innerHTML = '<i class="fas fa-info-circle"></i> Fill in the form above to see the generated time slots.';
            previewDiv.className = 'alert alert-info';
            return;
        }

        // Parse times
        const start = new Date(`2000-01-01T${startTime}`);
        const end = new Date(`2000-01-01T${endTime}`);
        const duration = parseInt(slotDuration);

        if (end <= start) {
            previewDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> End time must be after start time.';
            previewDiv.className = 'alert alert-warning';
            return;
        }

        // Generate slots
        const slots = [];
        let current = new Date(start);
        
        while (current < end) {
            const slotEnd = new Date(current.getTime() + duration * 60000);
            if (slotEnd <= end) {
                slots.push({
                    start: current.toTimeString().slice(0, 5),
                    end: slotEnd.toTimeString().slice(0, 5)
                });
            }
            current = slotEnd;
        }

        if (slots.length === 0) {
            previewDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> No time slots can be generated with the current settings.';
            previewDiv.className = 'alert alert-warning';
            return;
        }

        // Display slots
        let html = '<strong>Generated Time Slots:</strong><br>';
        html += '<div class="row mt-2">';
        slots.forEach((slot, index) => {
            html += `<div class="col-md-3 mb-2">
                        <span class="badge badge-primary">${slot.start} - ${slot.end}</span>
                     </div>`;
        });
        html += '</div>';
        html += `<small class="text-muted">Total: ${slots.length} slots</small>`;

        previewDiv.innerHTML = html;
        previewDiv.className = 'alert alert-success';
    }

    // Add event listeners
    startTimeInput.addEventListener('change', updateTimeSlotsPreview);
    endTimeInput.addEventListener('change', updateTimeSlotsPreview);
    slotDurationSelect.addEventListener('change', updateTimeSlotsPreview);
});
</script>
@stop 