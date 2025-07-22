@extends('layouts.app')

@section('title', 'Edit Appointment')

@section('page-title', 'Edit Appointment')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.appointments.index') }}">Appointments</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.appointments.show', $appointment) }}">Details</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Appointment #{{ $appointment->id }}</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Details
                    </a>
                </div>
            </div>
            
            <!-- Debug info -->
            <div class="card-body" style="background: #f8f9fa; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                <small class="text-muted">
                    <strong>Debug Info:</strong><br>
                    Practitioner ID: {{ $practitioner->id }}<br>
                    Available Dates Count: {{ count($availableDates) }}<br>
                    Has Data: {{ !empty($availableDates) ? 'Yes' : 'No' }}<br>
                    <span id="js-debug">JavaScript not loaded yet</span>
                </small>
            </div>
            
            <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
                @csrf
                @method('PUT')
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body">

                    <div class="form-group">
                        <label for="user_id">Patient</label>
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

                    <div class="form-group">
                        <label for="practitioner_name">Practitioner</label>
                        <input type="text" id="practitioner_name" class="form-control" value="{{ $practitioner->name }}" readonly>
                        <input type="hidden" name="practitioner_id" value="{{ $practitioner->id }}">
                        <small class="form-text text-muted">You are editing appointments for yourself</small>
                    </div>

                    {{-- Remove the Practitioner (Raqi) field entirely --}}

                    <div class="form-group">
                        <label for="type">Treatment Type</label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                            <option value="">Select Type</option>
                            @foreach($availableTypes as $type)
                                <option value="{{ $type }}" {{ old('type', $appointment->type) == $type ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $type)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="session_type_id">Session Type</label>
                        <select name="session_type_id" id="session_type_id" class="form-control @error('session_type_id') is-invalid @enderror" required>
                            <option value="">Select Session Type</option>
                            @foreach($sessionTypes as $sessionType)
                                <option value="{{ $sessionType->id }}" {{ old('session_type_id', $appointment->session_type_id) == $sessionType->id ? 'selected' : '' }}>
                                    {{ $sessionType->type }} - Fee: {{ $sessionType->fee }} ({{ $sessionType->duration_min }}-{{ $sessionType->duration_max }} min)
                                </option>
                            @endforeach
                        </select>
                        @error('session_type_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="appointment_date">Appointment Date</label>
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
                                <input type="hidden" name="appointment_date" id="appointment_date" value="{{ old('appointment_date', \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d')) }}" required>
                                @error('appointment_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror

                                <div class="mt-2 d-flex align-items-center small">
                                    <span class="d-inline-block w-3 h-3 bg-success rounded-circle mr-1"></span>
                                    <span class="text-muted mr-3">Available</span>
                                    <span class="d-inline-block w-3 h-3 bg-secondary rounded-circle mr-1"></span>
                                    <span class="text-muted">Not Available</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="appointment_time">Appointment Time</label>
                                <div id="time-slots-container" style="border: 1px solid #dee2e6; border-radius: 8px; padding: 16px; min-height: 120px; max-height: 250px; overflow-y: auto; background: white;">
                                    <p class="text-muted text-center">Select a date to see available times</p>
                                </div>
                                <input type="hidden" name="appointment_time" id="appointment_time" value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}" required>
                                @error('appointment_time')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
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
                        <label for="symptoms">Patient Symptoms/Notes</label>
                        <textarea name="symptoms" id="symptoms" rows="3" 
                                  class="form-control @error('symptoms') is-invalid @enderror"
                                  placeholder="Patient's symptoms or notes...">{{ old('symptoms', $appointment->symptoms) }}</textarea>
                        @error('symptoms')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="notes">Practitioner Notes</label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="form-control @error('notes') is-invalid @enderror"
                                  placeholder="Practitioner's notes...">{{ old('notes', $appointment->notes) }}</textarea>
                        @error('notes')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Appointment
                        </button>
                        <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-secondary">
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
                        <form action="{{ route('admin.appointments.approve', $appointment) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-block" 
                                    onclick="return confirm('Approve this appointment?')">
                                <i class="fas fa-check"></i> Approve
                            </button>
                        </form>

                        <form action="{{ route('admin.appointments.reject', $appointment) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger btn-block" 
                                    onclick="return confirm('Reject this appointment?')">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </form>
                    @endif

                    @if($appointment->status === 'approved')
                        <form action="{{ route('admin.appointments.complete', $appointment) }}" method="POST">
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
@endsection

@section('js')
<script>
// Global variables
let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();
let selectedDate = '{{ old('appointment_date', \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d')) }}';
let selectedTime = '{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}';

// Server today date for comparison
const serverToday = new Date('{{ now()->format('Y-m-d') }}');
serverToday.setHours(0, 0, 0, 0);

function selectDate(dateStr) {
    console.log('Date selected:', dateStr);
    selectedDate = dateStr;
    document.getElementById('appointment_date').value = dateStr;
    
    // Load available times for this date
    loadAvailableTimesForDate(dateStr);
}

function selectTime(timeStr) {
    console.log('Time selected:', timeStr);
    selectedTime = timeStr;
    document.getElementById('appointment_time').value = timeStr;
    
    // Update visual selection
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
    console.log('Loading times for date:', date);
    const container = document.getElementById('time-slots-container');
    
    // Show loading
    container.innerHTML = '<p class="text-center text-muted">Loading available times...</p>';
    
    // Get real available times from server data
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
            
            // Format time display
            const [hour, minute] = time.split(':');
            const hourInt = parseInt(hour);
            const displayTime = hourInt > 12 ? `${hourInt - 12}:${minute} PM` : 
                               hourInt === 12 ? `12:${minute} PM` : 
                               hourInt === 0 ? `12:${minute} AM` : `${hourInt}:${minute} AM`;
            
            timeBtn.textContent = displayTime;
            timeBtn.style.minWidth = '80px';
            
            // Check if this is the currently selected time
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
    }, 500);
}

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
    // Get available dates from server data
    const availableDatesObj = @json($availableDates);
    console.log('Available dates from server:', availableDatesObj);
    
    // Extract dates for the current practitioner
    const practitionerId = '{{ $practitioner->id }}';
    if (availableDatesObj && availableDatesObj[practitionerId]) {
        const dates = availableDatesObj[practitionerId].map(dateObj => dateObj.availability_date);
        console.log('Extracted dates for practitioner:', dates);
        return dates;
    }
    
    console.log('No available dates found for practitioner:', practitionerId);
    return [];
}

function getTimeSlotsForDate(date) {
    console.log('Getting time slots for date:', date);
    const availableDatesObj = @json($availableDates);
    const practitionerId = '{{ $practitioner->id }}';
    
    if (!availableDatesObj || !availableDatesObj[practitionerId]) {
        console.log('No available dates data for practitioner:', practitionerId);
        return [];
    }
    
    // Find the specific date object
    const dateObj = availableDatesObj[practitionerId].find(d => d.availability_date === date);
    if (!dateObj) {
        console.log('No data found for date:', date);
        return [];
    }
    
    console.log('Date object found:', dateObj);
    
    // Generate time slots based on start_time, end_time, and slot_duration
    const startTime = dateObj.start_time; // e.g., "09:00"
    const endTime = dateObj.end_time; // e.g., "17:00"
    const bookedTimes = dateObj.booked_times || [];
    
    const timeSlots = [];
    const [startHour, startMin] = startTime.split(':').map(Number);
    const [endHour, endMin] = endTime.split(':').map(Number);
    
    // Generate hourly slots from start to end time
    for (let hour = startHour; hour < endHour; hour++) {
        const timeStr = `${String(hour).padStart(2, '0')}:00`;
        
        // Skip if this time is already booked
        if (!bookedTimes.includes(timeStr)) {
            timeSlots.push(timeStr);
        }
    }
    
    console.log('Generated time slots:', timeSlots);
    console.log('Booked times:', bookedTimes);
    
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
        
        if (dateObj < serverToday) {
            // Past date, gray and disabled
            dayButton.style.backgroundColor = '#e9ecef';
            dayButton.style.color = '#6c757d';
            dayButton.style.borderColor = '#dee2e6';
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

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== DOM LOADED ===');
    console.log('DOM loaded, initializing calendar...');
    
    // Test if elements exist
    const calendar = document.getElementById('availability-calendar');
    const monthLabel = document.getElementById('calendar-month-label');
    const calendarGrid = document.getElementById('calendar-grid');
    
    console.log('Calendar element found:', !!calendar);
    console.log('Month label found:', !!monthLabel);
    console.log('Calendar grid found:', !!calendarGrid);
    
    if (!calendar) {
        console.error('CALENDAR ELEMENT NOT FOUND!');
        return;
    }
    
    // Update debug info
    const jsDebug = document.getElementById('js-debug');
    if (jsDebug) {
        jsDebug.textContent = 'JavaScript loaded successfully - ' + new Date().toLocaleTimeString();
    }
    
    // Set up navigation buttons
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
    
    // Render available dates
    console.log('Calling renderAvailableDates...');
    renderAvailableDates();
    
    // If we have a selected date, load its times
    if (selectedDate) {
        loadAvailableTimesForDate(selectedDate);
    }
});
</script>
@stop