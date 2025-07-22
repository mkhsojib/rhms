@extends('layouts.app')

@section('title', 'Edit Appointment')

@section('content_header')
    <h1>Edit Appointment</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">

            
            <form action="{{ route('superadmin.appointments.update', $appointment) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="user_id">Patient *</label>
                            <input type="text" class="form-control" value="{{ $patients->where('id', old('user_id', $appointment->user_id))->first()->name ?? 'Not selected' }} ({{ $patients->where('id', old('user_id', $appointment->user_id))->first()->email ?? '' }})" readonly>
                            <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id', $appointment->user_id) }}">
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
                            <input type="text" class="form-control" value="{{ ucfirst(old('type', $appointment->type)) }}" readonly>
                            <input type="hidden" name="type" id="type" value="{{ old('type', $appointment->type) }}">
                            @error('type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="practitioner_id">Practitioner *</label>
                            <input type="text" class="form-control" value="{{ $practitioners->where('id', old('practitioner_id', $appointment->practitioner_id))->first()->name ?? 'Not selected' }}" readonly>
                            <input type="hidden" name="practitioner_id" id="practitioner_id" value="{{ old('practitioner_id', $appointment->practitioner_id) }}">
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
                            <div id="availability-calendar" style="border: 1px solid #dee2e6; background: white; border-radius: 8px; padding: 0; width: 100%; min-height: 200px;">
                                <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; padding: 8px;">
                                    <div style="text-align: center; font-weight: 600; padding: 4px; color: #495057; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; width: 36px; margin: 0 auto;">Sun</div>
                                    <div style="text-align: center; font-weight: 600; padding: 4px; color: #495057; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; width: 36px; margin: 0 auto;">Mon</div>
                                    <div style="text-align: center; font-weight: 600; padding: 4px; color: #495057; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; width: 36px; margin: 0 auto;">Tue</div>
                                    <div style="text-align: center; font-weight: 600; padding: 4px; color: #495057; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; width: 36px; margin: 0 auto;">Wed</div>
                                    <div style="text-align: center; font-weight: 600; padding: 4px; color: #495057; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; width: 36px; margin: 0 auto;">Thu</div>
                                    <div style="text-align: center; font-weight: 600; padding: 4px; color: #495057; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; width: 36px; margin: 0 auto;">Fri</div>
                                    <div style="text-align: center; font-weight: 600; padding: 4px; color: #495057; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; width: 36px; margin: 0 auto;">Sat</div>
                                </div>
                                <div id="calendar-grid" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; padding: 0 8px 8px 8px; justify-items: center;"></div>
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
                                    <option value="{{ $stype->id }}" 
                                        data-practitioner="{{ $stype->practitioner_id }}" 
                                        data-fee="{{ $stype->fee }}" 
                                        data-min="{{ $stype->min_duration }}" 
                                        data-max="{{ $stype->max_duration }}" 
                                        {{ old('session_type_id', $appointment->session_type_id) == $stype->id ? 'selected' : '' }}
                                        style="display: {{ $stype->practitioner_id == $appointment->practitioner_id ? 'block' : 'none' }}">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="pending" {{ old('status', $appointment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ old('status', $appointment->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status', $appointment->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
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
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Current Information</h3>
            </div>
            <div class="card-body">
                <p><strong>Patient:</strong> {{ $appointment->patient->name }}</p>
                <p><strong>Practitioner:</strong> {{ $appointment->practitioner->name }}</p>
                <p><strong>Type:</strong> {{ ucfirst($appointment->type) }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</p>
                <p><strong>Time:</strong> 
                    @php
                        $startTime = \Carbon\Carbon::parse($appointment->appointment_time);
                        $endTime = $startTime->copy()->addHour(); // Add 1 hour for appointment duration
                    @endphp
                    {{ $startTime->format('g:i A') }} - {{ $endTime->format('g:i A') }}
                </p>
                <p><strong>Status:</strong> 
                    @switch($appointment->status)
                        @case('pending')
                            <span class="badge badge-warning">Pending</span>
                            @break
                        @case('approved')
                            <span class="badge badge-success">Approved</span>
                            @break
                        @case('rejected')
                            <span class="badge badge-danger">Rejected</span>
                            @break
                        @case('completed')
                            <span class="badge badge-info">Completed</span>
                            @break
                    @endswitch
                </p>
                <p><strong>Created:</strong> {{ $appointment->created_at ? \Carbon\Carbon::parse($appointment->created_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                <p><strong>Last Updated:</strong> {{ $appointment->updated_at ? \Carbon\Carbon::parse($appointment->updated_at)->format('M d, Y g:i A') : 'N/A' }}</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($appointment->status === 'pending')
                        <form action="{{ route('superadmin.appointments.approve', $appointment) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-block" 
                                    onclick="return confirm('Approve this appointment?')">
                                <i class="fas fa-check"></i> Approve
                            </button>
                        </form>

                        <form action="{{ route('superadmin.appointments.reject', $appointment) }}" method="POST" class="mt-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger btn-block" 
                                    onclick="return confirm('Reject this appointment?')">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </form>
                    @endif

                    @if($appointment->status === 'approved')
                        <form action="{{ route('superadmin.appointments.complete', $appointment) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-info btn-block" 
                                    onclick="return confirm('Mark as completed?')">
                                <i class="fas fa-check-double"></i> Mark as Completed
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop 

@section('css')
<style>
#availability-calendar {
    display: flex;
    flex-direction: column;
    min-height: 40px;
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 12px;
}
#availability-calendar button {
    width: 36px;
    height: 36px;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    margin: 2px auto;
    padding: 0;
    font-size: 14px;
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
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    let selectedDate = '{{ old('appointment_date', $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') : '' ) }}';
    let selectedTime = '{{ old('appointment_time', $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') : '' ) }}';
    let selectedPractitionerId = '{{ old('practitioner_id', $appointment->practitioner_id) }}';
    const availableDatesObj = @json($availableDates ?? []);

    function updateCalendarNavigation() {
        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        const monthLabel = document.getElementById('calendar-month-label');
        if (monthLabel) {
            monthLabel.textContent = `${monthNames[currentMonth]} ${currentYear}`;
        }
    }

    function getAvailableDates() {
        if (!selectedPractitionerId || !availableDatesObj[selectedPractitionerId]) return [];
        return availableDatesObj[selectedPractitionerId].map(dateObj => dateObj.availability_date);
    }

    function getTimeSlotsForDate(date) {
        if (!selectedPractitionerId || !availableDatesObj[selectedPractitionerId]) return [];
        const dateObj = availableDatesObj[selectedPractitionerId].find(d => d.availability_date === date);
        if (!dateObj) return [];
        const startTime = dateObj.start_time;
        const endTime = dateObj.end_time;
        const bookedTimes = dateObj.booked_times || [];
        const timeSlots = [];
        const [startHour, startMin] = startTime.split(':').map(Number);
        const [endHour, endMin] = endTime.split(':').map(Number);
        for (let hour = startHour; hour < endHour; hour++) {
            const timeStr = `${String(hour).padStart(2, '0')}:00`;
            if (!bookedTimes.includes(timeStr)) {
                timeSlots.push(timeStr);
            }
        }
        return timeSlots;
    }

    function renderAvailableDates() {
        console.log('=== RENDERING CALENDAR ===');
        console.log('Current month:', currentMonth, 'Year:', currentYear);
        
        const calendarGrid = document.getElementById('calendar-grid');
        if (!calendarGrid) {
            console.error('Calendar grid not found!');
            return;
        }
        
        // Clear calendar
        calendarGrid.innerHTML = '';
        
        // Update month label
        updateCalendarNavigation();
        
        // Get calendar info
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        const firstDay = new Date(currentYear, currentMonth, 1).getDay();
        
        console.log('Days in month:', daysInMonth, 'First day:', firstDay);
        
        // Add empty cells for days before the first day
            for (let i = 0; i < firstDay; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.style.cssText = 'min-height: 28px; margin: 0; padding: 0; background: transparent;';
                calendarGrid.appendChild(emptyCell);
            }
        
        // Get available dates
        const availableDates = getAvailableDates();
        
        // Use serverToday for all comparisons
        for (let d = 1; d <= daysInMonth; d++) {
            const dayButton = document.createElement('button');
            dayButton.type = 'button';
            dayButton.textContent = d;
            dayButton.style.cssText = 'width: 100%; height: 36px; border: 1px solid #dee2e6; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-weight: 700; cursor: pointer; transition: all 0.2s; margin: 2px; padding: 4px; font-size: 14px;';
            
            const dateObj = new Date(currentYear, currentMonth, d);
            const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            const isAvailable = availableDates.includes(dateStr);
            const isSelected = dateStr === selectedDate;
            
            if (!selectedPractitionerId) {
                // No practitioner selected
                dayButton.style.backgroundColor = '#f8f9fa';
                dayButton.style.color = '#adb5bd';
                dayButton.disabled = true;
            } else if (isSelected && isAvailable) {
                // Selected date
                dayButton.classList.add('selected-date');
                dayButton.disabled = false;
                dayButton.style.setProperty('background-color', '#007bff', 'important');
                dayButton.style.setProperty('color', 'white', 'important');
                dayButton.style.setProperty('border-color', '#007bff', 'important');
                dayButton.onclick = function() {
                    selectDate(dateStr);
                    renderAvailableDates(); // Re-render to update selection
                };
            } else if (isAvailable) {
                dayButton.classList.add('available-date');
                dayButton.disabled = false;
                dayButton.style.setProperty('background-color', '#28a745', 'important');
                dayButton.style.setProperty('color', 'white', 'important');
                dayButton.style.setProperty('border-color', '#28a745', 'important');
                dayButton.onclick = function() {
                    selectDate(dateStr);
                    renderAvailableDates(); // Re-render to update selection
                };
            } else {
                dayButton.style.backgroundColor = '#f8f9fa'; // Gray
                dayButton.style.color = '#6c757d';
                dayButton.style.borderColor = '#dee2e6';
                dayButton.disabled = true;
            }
            
            calendarGrid.appendChild(dayButton);
        }
    }

    function selectDate(dateStr) {
        selectedDate = dateStr;
        document.getElementById('appointment_date').value = dateStr;
        loadAvailableTimesForDate(dateStr);
    }

    function selectTime(timeStr) {
        selectedTime = timeStr;
        document.getElementById('appointment_time').value = timeStr;
        document.querySelectorAll('.time-slot-btn').forEach(btn => {
            btn.classList.remove('selected');
            btn.style.backgroundColor = '#28a745';
            btn.style.color = 'white';
        });
        const selectedBtn = document.querySelector(`[data-time="${timeStr}"]`);
        if (selectedBtn) {
            selectedBtn.classList.add('selected');
            selectedBtn.style.backgroundColor = '#007bff';
            selectedBtn.style.color = 'white';
        }
    }

    function loadAvailableTimesForDate(date) {
        const container = document.getElementById('time-slots-container');
        container.innerHTML = '<p class="text-center text-muted">Loading available times...</p>';
        const availableTimes = getTimeSlotsForDate(date);
        setTimeout(() => {
            container.innerHTML = '';
            if (availableTimes.length === 0) {
                container.innerHTML = '<p class="text-center text-muted">No available times for this date</p>';
                return;
            }
            availableTimes.forEach(time => {
                const timeBtn = document.createElement('button');
                timeBtn.type = 'button';
                timeBtn.className = 'time-slot-btn btn btn-outline-success btn-sm mr-2 mb-2';
                timeBtn.setAttribute('data-time', time);
                const [hour, minute] = time.split(':');
                const hourInt = parseInt(hour);
                const displayTime = hourInt > 12 ? `${hourInt - 12}:${minute} PM` : 
                                   hourInt === 12 ? `12:${minute} PM` : 
                                   hourInt === 0 ? `12:${minute} AM` : `${hourInt}:${minute} AM`;
                timeBtn.textContent = displayTime;
                timeBtn.style.minWidth = '80px';
                if (time === selectedTime) {
                    timeBtn.classList.add('selected');
                    timeBtn.style.backgroundColor = '#007bff';
                    timeBtn.style.color = 'white';
                }
                timeBtn.onclick = function() {
                    selectTime(time);
                };
                container.appendChild(timeBtn);
            });
        }, 300);
    }

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
            renderAvailableDates();
        };
    }
    if (nextBtn) {
        nextBtn.onclick = function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderAvailableDates();
        };
    }
    // Set the selected practitioner ID from the hidden input
    selectedPractitionerId = document.getElementById('practitioner_id').value;
    // Ensure form always submits the selected date/time and warn if missing
    document.querySelector('form').addEventListener('submit', function(e) {
        // Update hidden fields with current selections
        if (selectedDate) {
            document.getElementById('appointment_date').value = selectedDate;
        }
        if (selectedTime) {
            document.getElementById('appointment_time').value = selectedTime;
        }
        
        // Get current values from hidden fields (may be pre-filled from existing appointment)
        const currentDate = document.getElementById('appointment_date').value;
        const currentTime = document.getElementById('appointment_time').value;
        
        let warn = '';
        if (!currentDate) warn += 'Please select an appointment date.\n';
        if (!currentTime) warn += 'Please select an appointment time.';
        if (warn) {
            alert(warn);
            e.preventDefault();
        }
    });
    // Initial render
    renderAvailableDates();
    if (selectedDate) {
        loadAvailableTimesForDate(selectedDate);
    }
});
</script>
@stop