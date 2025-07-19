@extends('layouts.app')

@section('title', 'Edit Appointment')

@section('content_header')
    <h1>Edit Appointment</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('superadmin.appointments.update', $appointment) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="user_id">Patient *</label>
                            <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" 
                                            {{ old('user_id', $appointment->user_id) == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->name }} ({{ $patient->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Treatment Type *</label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="">Select Type</option>
                                <option value="ruqyah" {{ old('type', $appointment->type) == 'ruqyah' ? 'selected' : '' }}>Ruqyah</option>
                                <option value="hijama" {{ old('type', $appointment->type) == 'hijama' ? 'selected' : '' }}>Hijama</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="practitioner_id">Practitioner *</label>
                            <select name="practitioner_id" id="practitioner_id" class="form-control @error('practitioner_id') is-invalid @enderror" required>
                                <option value="">Select Practitioner</option>
                                @foreach($practitioners as $practitioner)
                                    <option value="{{ $practitioner->id }}" data-specialization="{{ $practitioner->specialization }}" {{ old('practitioner_id', $appointment->practitioner_id) == $practitioner->id ? 'selected' : '' }}>
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
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="appointment_date">Appointment Date *</label>
                            <input type="text" id="appointment_date_picker" class="form-control" placeholder="Select Date" readonly="readonly" value="{{ old('appointment_date', $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') : '' ) }}">
                            <input type="hidden" name="appointment_date" id="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}">
                            @error('appointment_date')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="appointment_time">Appointment Time *</label>
                            <input type="time" name="appointment_time" id="appointment_time" 
                                   class="form-control @error('appointment_time') is-invalid @enderror" 
                                   value="{{ old('appointment_time', $appointment->appointment_time) }}" required>
                            @error('appointment_time')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="session_type_id">Session Type *</label>
                            <select name="session_type_id" id="session_type_id" class="form-control @error('session_type_id') is-invalid @enderror" required>
                                <option value="">Select Session Type</option>
                                @foreach($sessionTypes as $stype)
                                    <option value="{{ $stype->id }}" data-practitioner="{{ $stype->practitioner_id }}" data-fee="{{ $stype->fee }}" data-min="{{ $stype->min_duration }}" data-max="{{ $stype->max_duration }}" {{ old('session_type_id', $appointment->session_type_id) == $stype->id ? 'selected' : '' }}>
                                        {{ ucfirst($stype->type) }} (Fee: {{ $stype->fee }}, Duration: {{ $stype->min_duration }}-{{ $stype->max_duration }} min)
                                    </option>
                                @endforeach
                            </select>
                            @error('session_type_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <div id="sessionTypeInfo" class="mt-2 text-info"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="symptoms">Symptoms/Complaints</label>
                    <textarea name="symptoms" id="symptoms" rows="3" 
                              class="form-control @error('symptoms') is-invalid @enderror" 
                              placeholder="Describe the patient's symptoms or complaints">{{ old('symptoms', $appointment->symptoms) }}</textarea>
                    @error('symptoms')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" rows="3" 
                              class="form-control @error('notes') is-invalid @enderror" 
                              placeholder="Additional notes or instructions">{{ old('notes', $appointment->notes) }}</textarea>
                    @error('notes')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Appointment
                    </button>
                    <a href="{{ route('superadmin.appointments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop 

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Practitioner filtering by treatment type
        const typeSelect = document.getElementById('type');
        const practitionerSelect = document.getElementById('practitioner_id');
        const allOptions = Array.from(practitionerSelect.options);

        function filterPractitioners() {
            const selectedType = typeSelect.value;
            practitionerSelect.innerHTML = '';
            practitionerSelect.appendChild(allOptions[0]); // 'Select Practitioner'
            allOptions.slice(1).forEach(option => {
                const specialization = option.getAttribute('data-specialization');
                if (
                    selectedType === '' ||
                    specialization === 'both' ||
                    (selectedType === 'ruqyah' && specialization === 'ruqyah_healing') ||
                    (selectedType === 'hijama' && specialization === 'hijama_cupping')
                ) {
                    practitionerSelect.appendChild(option);
                }
            });
        }
        typeSelect.addEventListener('change', filterPractitioners);
        // Initial filter on page load
        filterPractitioners();

        // Session type filtering by practitioner
        const sessionTypeSelect = document.getElementById('session_type_id');
        const allSessionTypeOptions = Array.from(sessionTypeSelect.options);
        const sessionTypeInfo = document.getElementById('sessionTypeInfo');

        function filterSessionTypes() {
            const practitionerId = practitionerSelect.value;
            sessionTypeSelect.innerHTML = '';
            sessionTypeSelect.appendChild(allSessionTypeOptions[0]); // 'Select Session Type'
            allSessionTypeOptions.slice(1).forEach(option => {
                if (option.getAttribute('data-practitioner') === practitionerId) {
                    sessionTypeSelect.appendChild(option);
                }
            });
            sessionTypeInfo.textContent = '';
        }
        practitionerSelect.addEventListener('change', filterSessionTypes);
        // Show info for selected session type
        sessionTypeSelect.addEventListener('change', function() {
            const selected = sessionTypeSelect.selectedOptions[0];
            if (selected && selected.value) {
                sessionTypeInfo.textContent = `Fee: ${selected.getAttribute('data-fee')}, Duration: ${selected.getAttribute('data-min')}-${selected.getAttribute('data-max')} min`;
            } else {
                sessionTypeInfo.textContent = '';
            }
        });
        // Initial filter on page load
        filterSessionTypes();
    });

    let flatpickrInstance;
    function initializeCalendar(practitionerId) {
        fetch("{{ route('superadmin.appointments.getAvailableDates') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({practitioner_id: practitionerId})
        })
        .then(res => res.json())
        .then(dates => {
            flatpickrInstance = flatpickr("#appointment_date_picker", {
                enable: dates,
                dateFormat: "Y-m-d",
                defaultDate: "{{ old('appointment_date', $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') : '' ) }}",
                onChange: function(selectedDates, dateStr, instance) {
                    document.getElementById('appointment_date').value = dateStr;
                    appointmentDateSelect.dispatchEvent(new Event('change'));
                }
            });
        });
    }

    practitionerSelect.addEventListener('change', function() {
        const practitionerId = practitionerSelect.value;
        if (practitionerId) {
            initializeCalendar(practitionerId);
        } else {
            if(flatpickrInstance) flatpickrInstance.clear();
        }
    });

    const appointmentDateSelect = document.getElementById('appointment_date');
    appointmentDateSelect.addEventListener('change', function() {
        // This part of the logic needs to be re-evaluated to ensure it works with Flatpickr
        // For now, it's kept as is, but might need adjustment depending on how Flatpickr interacts with the form.
        // The original code had a time picker that depended on this change.
        // With Flatpickr, the time picker might need to be re-initialized or its value updated.
        // For now, assuming the time picker will be handled by the existing JS or needs no change.
    });
</script>
@stop 