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
                                    <option value="{{ $patient->id }}" {{ old('user_id', $appointment->user_id) == $patient->id ? 'selected' : '' }}>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="appointment_date">Appointment Date *</label>
                            <div class="d-flex align-items-center mb-2">
                                <button type="button" id="prev-month" class="btn btn-outline-secondary btn-sm">&lt;</button>
                                <span id="calendar-month-label" class="mx-3 font-weight-bold"></span>
                                <button type="button" id="next-month" class="btn btn-outline-secondary btn-sm">&gt;</button>
                            </div>

                            <div id="availability-calendar" style="border: 2px solid #007bff; background: #f8f9fa; padding: 0; width: 100%; min-height: 200px;">
                                <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; padding: 8px;">
                                    <div style="text-align: center; font-weight: 600; padding: 8px 4px; color: #495057; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; background-color: #e9ecef; border-radius: 4px;">Sun</div>
                                    <div style="text-align: center; font-weight: 600; padding: 8px 4px; color: #495057; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; background-color: #e9ecef; border-radius: 4px;">Mon</div>
                                    <div style="text-align: center; font-weight: 600; padding: 8px 4px; color: #495057; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; background-color: #e9ecef; border-radius: 4px;">Tue</div>
                                    <div style="text-align: center; font-weight: 600; padding: 8px 4px; color: #495057; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; background-color: #e9ecef; border-radius: 4px;">Wed</div>
                                    <div style="text-align: center; font-weight: 600; padding: 8px 4px; color: #495057; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; background-color: #e9ecef; border-radius: 4px;">Thu</div>
                                    <div style="text-align: center; font-weight: 600; padding: 8px 4px; color: #495057; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; background-color: #e9ecef; border-radius: 4px;">Fri</div>
                                    <div style="text-align: center; font-weight: 600; padding: 8px 4px; color: #495057; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; background-color: #e9ecef; border-radius: 4px;">Sat</div>
                                </div>
                                <div id="calendar-grid" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; padding: 0 8px 8px 8px;"></div>
                            </div>
                            <input type="hidden" name="appointment_date" id="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') : '' ) }}" required>
                            @error('appointment_date')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="appointment_time">Appointment Time *</label>
                            <div id="time-slots-container" style="border: 1px solid #dee2e6; border-radius: 8px; padding: 16px; min-height: 120px; max-height: 250px; overflow-y: auto; background: white;">
                                <p class="text-muted text-center">Select a date to see available times</p>
                            </div>
                            <input type="hidden" name="appointment_time" id="appointment_time" value="{{ old('appointment_time', $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') : '' ) }}" required>
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

@section('css')
<style>
#availability-calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 2px;
    min-height: 40px;
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 12px;
}
#availability-calendar button {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    margin: 2px auto;
    padding: 0;
    font-size: 14px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
#availability-calendar button.available {
    background-color: #28a745 !important;
    color: white !important;
    box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
}
#availability-calendar button.available:hover {
    background-color: #218838 !important;
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.4);
}

#availability-calendar button.selected {
    background-color: #007bff !important;
    color: white !important;
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.4) !important;
    transform: scale(1.1);
    z-index: 10;
    position: relative;
}

.time-slot-btn {
    min-width: 80px;
    margin: 4px;
    padding: 8px 12px;
    border: 2px solid #28a745;
    background-color: #28a745;
    color: white;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(40, 167, 69, 0.2);
}
.time-slot-btn:hover {
    background-color: #218838;
    border-color: #218838;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
}
.time-slot-btn.selected {
    background-color: #007bff !important;
    color: white !important;
    border-color: #007bff !important;
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.4);
    transform: translateY(-2px);
}
.time-slot-btn.booked {
    background-color: #dc3545 !important;
    color: white !important;
    border-color: #dc3545 !important;
    cursor: not-allowed;
    opacity: 0.7;
}
#time-slots-container {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 16px;
    min-height: 120px;
    max-height: 250px;
    overflow-y: auto;
    background: white;
}
</style>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const availableDatesObj = @json($availableDates ?? []);
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    let lastSelectedDate = '{{ old('appointment_date', $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') : '' ) }}';
    let selectedPractitionerId = '{{ old('practitioner_id', $appointment->practitioner_id) }}';
    let selectedTime = '{{ old('appointment_time', $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') : '' ) }}';
    
    // Get DOM elements
    const typeSelect = document.getElementById('type');
    const practitionerSelect = document.getElementById('practitioner_id');
    const allPractitionerOptions = Array.from(practitionerSelect.options);
    
    // Store all session types for each practitioner
    const allSessionTypes = @json($sessionTypes ?? []);
    const sessionTypeSelect = document.getElementById('session_type_id');
    
    function filterPractitioners() {
        const selectedType = typeSelect.value;
        practitionerSelect.innerHTML = '';
        practitionerSelect.appendChild(allPractitionerOptions[0]);
        allPractitionerOptions.slice(1).forEach(option => {
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
        // Clear calendar when practitioner changes
        clearCalendar();
        // Clear session types when practitioner changes
        loadSessionTypesForPractitioner(null);
    }
    
    function loadSessionTypesForPractitioner(practitionerId) {
        console.log('Loading session types for practitioner:', practitionerId);
        
        // Clear current session types
        sessionTypeSelect.innerHTML = '';
        sessionTypeSelect.appendChild(document.createElement('option')).textContent = 'Select Session Type';
        
        if (!practitionerId || !allSessionTypes) return;
        
        // Get selected treatment type
        const selectedType = typeSelect.value;
        
        // Filter session types for this practitioner and treatment type
        const practitionerSessionTypes = allSessionTypes.filter(type => {
            return type.practitioner_id == practitionerId && 
                   (!selectedType || type.type.includes(selectedType));
        });
        
        console.log('Filtered session types for practitioner and type:', practitionerSessionTypes);
        
        practitionerSessionTypes.forEach(type => {
            const option = document.createElement('option');
            option.value = type.id;
            option.textContent = `${type.type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())} (Fee: ${type.fee})`;
            sessionTypeSelect.appendChild(option);
        });
        
        console.log('Session types loaded:', practitionerSessionTypes.length);
    }
    
    function selectDate(dateStr) {
        console.log('Date selected:', dateStr);
        lastSelectedDate = dateStr;
        document.getElementById('appointment_date').value = dateStr;
        
        // Load available times for this date
        loadTimeSlotsForDate(dateStr);
        
        // Re-render calendar to show selection
        renderCalendar(currentMonth, currentYear);
    }
    
    function selectTime(timeStr) {
        console.log('Time selected:', timeStr);
        selectedTime = timeStr;
        document.getElementById('appointment_time').value = timeStr;
        
        // Update visual selection
        document.querySelectorAll('.time-slot-btn').forEach(btn => {
            btn.classList.remove('selected');
            btn.style.backgroundColor = '#28a745';
            btn.style.borderColor = '#28a745';
        });
        
        const selectedBtn = document.querySelector(`[data-time="${timeStr}"]`);
        if (selectedBtn) {
            selectedBtn.classList.add('selected');
            selectedBtn.style.backgroundColor = '#007bff';
            selectedBtn.style.borderColor = '#007bff';
        }
    }
    
    function loadTimeSlotsForDate(date) {
        console.log('Loading time slots for date:', date);
        const container = document.getElementById('time-slots-container');
        
        if (!selectedPractitionerId) {
            container.innerHTML = '<p class="text-muted text-center">Please select a practitioner first</p>';
            return;
        }
        
        // Show loading
        container.innerHTML = '<p class="text-center text-muted">Loading available times...</p>';
        
        // Get available time slots for the selected date and practitioner
        const availableSlots = getTimeSlotsForDate(date);
        
        setTimeout(() => {
            container.innerHTML = '';
            
            if (availableSlots.length === 0) {
                container.innerHTML = '<p class="text-center text-muted">No available times for this date</p>';
                return;
            }
            
            availableSlots.forEach(slot => {
                const timeBtn = document.createElement('button');
                timeBtn.type = 'button';
                timeBtn.className = 'time-slot-btn';
                timeBtn.setAttribute('data-time', slot.time);
                timeBtn.textContent = slot.display;
                
                // Check if this time is already selected
                if (slot.time === selectedTime) {
                    timeBtn.classList.add('selected');
                    timeBtn.style.backgroundColor = '#007bff';
                    timeBtn.style.borderColor = '#007bff';
                }
                
                timeBtn.onclick = function() {
                    selectTime(slot.time);
                };
                
                container.appendChild(timeBtn);
            });
        }, 300);
    }
    
    function getTimeSlotsForDate(date) {
        if (!selectedPractitionerId || !availableDatesObj[selectedPractitionerId]) return [];
        const day = availableDatesObj[selectedPractitionerId].find(d => d.availability_date === date);
        if (!day) return [];
        
        const slots = [];
        const startTime = parseInt(day.start_time.split(':')[0]);
        const endTime = parseInt(day.end_time.split(':')[0]);
        
        for (let hour = startTime; hour < endTime; hour++) {
            const timeStr = `${String(hour).padStart(2, '0')}:00`;
            const displayTime = hour > 12 ? `${hour - 12}:00 PM` : 
                               hour === 12 ? `12:00 PM` : 
                               hour === 0 ? `12:00 AM` : `${hour}:00 AM`;
            
            slots.push({
                time: timeStr,
                display: displayTime
            });
        }
        
        return slots;
    }
    
    function clearCalendar() {
        const calendarGrid = document.getElementById('calendar-grid');
        if (calendarGrid) {
            calendarGrid.innerHTML = '';
        }
        const timeContainer = document.getElementById('time-slots-container');
        if (timeContainer) {
            timeContainer.innerHTML = '<p class="text-muted text-center">Select a date to see available times</p>';
        }
    }
    
    function renderCalendar(month, year) {
        const calendar = document.getElementById('availability-calendar');
        const monthLabel = document.getElementById('calendar-month-label');
        const calendarGrid = document.getElementById('calendar-grid');
        
        if (!calendarGrid) return;
        
        calendarGrid.innerHTML = '';
        
        // Update month label
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                           'July', 'August', 'September', 'October', 'November', 'December'];
        if (monthLabel) {
            monthLabel.textContent = `${monthNames[month]} ${year}`;
        }
        
        // Get calendar info
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const firstDay = new Date(year, month, 1).getDay();
        
        // Add empty cells for days before the first day
        for (let i = 0; i < firstDay; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.style.cssText = 'min-height: 32px; margin: 0; padding: 0; background: transparent;';
            calendarGrid.appendChild(emptyCell);
        }
        
        // Get available dates
        const availableDates = selectedPractitionerId && availableDatesObj[selectedPractitionerId] ? 
                              availableDatesObj[selectedPractitionerId].map(d => d.availability_date) : [];
        
        // Add day buttons
        for (let d = 1; d <= daysInMonth; d++) {
            const dayButton = document.createElement('button');
            dayButton.type = 'button';
            dayButton.textContent = d;
            dayButton.style.cssText = 'width: 36px; height: 36px; border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 500; cursor: pointer; transition: all 0.2s; margin: 2px auto; padding: 0; font-size: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);';
            
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            const isAvailable = availableDates.includes(dateStr);
            const isSelected = dateStr === lastSelectedDate;
            
            if (isSelected && isAvailable) {
                dayButton.style.backgroundColor = '#007bff';
                dayButton.style.color = 'white';
                dayButton.style.boxShadow = '0 2px 4px rgba(0, 123, 255, 0.3)';
            } else if (isAvailable) {
                dayButton.style.backgroundColor = '#28a745';
                dayButton.style.color = 'white';
                dayButton.style.boxShadow = '0 2px 4px rgba(40, 167, 69, 0.3)';
            } else {
                dayButton.style.backgroundColor = '#6c757d';
                dayButton.style.color = '#adb5bd';
                dayButton.disabled = true;
            }
            
            if (isAvailable) {
                dayButton.onclick = function() {
                    selectDate(dateStr);
                };
            }
            
            calendarGrid.appendChild(dayButton);
        }
    }
    
    // Event listeners
    typeSelect.addEventListener('change', filterPractitioners);
    
    practitionerSelect.addEventListener('change', function() {
        selectedPractitionerId = this.value;
        loadSessionTypesForPractitioner(selectedPractitionerId);
        
        if (selectedPractitionerId) {
            renderCalendar(currentMonth, currentYear);
        } else {
            clearCalendar();
        }
    });
    
    // Navigation buttons
    const prevBtn = document.getElementById('prev-month');
    const nextBtn = document.getElementById('next-month');
    
    if (prevBtn) {
        prevBtn.onclick = function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar(currentMonth, currentYear);
        };
    }
    
    if (nextBtn) {
        nextBtn.onclick = function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar(currentMonth, currentYear);
        };
    }
    
    // Initial setup
    filterPractitioners();
    if (selectedPractitionerId) {
        loadSessionTypesForPractitioner(selectedPractitionerId);
        renderCalendar(currentMonth, currentYear);
        if (lastSelectedDate) {
            loadTimeSlotsForDate(lastSelectedDate);
        }
    }
});
</script>
@stop