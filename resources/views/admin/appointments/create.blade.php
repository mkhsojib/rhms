@extends('layouts.app')

@section('title', 'Create Appointment')

@section('page-title', 'Create New Appointment')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.appointments.index') }}">Appointments</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Appointment Details</h3>
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
            
            <form action="{{ route('admin.appointments.store') }}" method="POST">
                @csrf
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
                                <option value="{{ $patient->id }}" {{ old('user_id') == $patient->id ? 'selected' : '' }}>
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
                        <small class="form-text text-muted">You are creating appointments for yourself</small>
                    </div>

                    {{-- Remove the Practitioner (Raqi) field entirely --}}

                    <div class="form-group">
                        <label for="type">Treatment Type</label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                            <option value="">Select Type</option>
                            @foreach($availableTypes as $type)
                                <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
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
                            @foreach($sessionTypes as $type)
                                <option value="{{ $type->id }}" {{ old('session_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->type }} (Fee: {{ $type->fee }})
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
                                <div id="calendar-controls" class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light rounded">
                                    <button type="button" id="prev-month" class="btn btn-outline-secondary btn-sm">&lt;</button>
                                    <span id="calendar-month-label" class="font-weight-bold text-dark"></span>
                                    <button type="button" id="next-month" class="btn btn-outline-secondary btn-sm">&gt;</button>
                                </div>
                                <div id="availability-calendar" style="border: 2px solid #007bff; background: #f8f9fa; padding: 0; width: 100%; min-height: 200px;">
                                    <div id="calendar-days" style="display: grid; grid-template-columns: repeat(7, 1fr); text-align: center; font-weight: bold; background: #f4f4f4;">
                                        <div>Su</div>
                                        <div>Mo</div>
                                        <div>Tu</div>
                                        <div>We</div>
                                        <div>Th</div>
                                        <div>Fr</div>
                                        <div>Sa</div>
                                    </div>
                                    <div id="calendar-grid" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 0; width: 100%; margin: 0; padding: 0;">
                                        <!-- Available dates will be loaded here -->
                                    </div>
                                </div>
                                <input type="hidden" id="appointment_date" name="appointment_date" value="" required>
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
                                <div id="time-slots-container" class="border border-gray-300 rounded-lg p-4 min-h-[200px] max-h-[200px] overflow-y-auto" style="border: 2px solid #28a745; background: #f8f9fa;">
                                    <div id="time-slots-message" class="text-center py-4 text-muted">
                                        <i class="fas fa-info-circle mb-2 text-xl"></i>
                                        <p>Please select a date first</p>
                                        <small style="color: #28a745;">Time Slots Container - Ready</small>
                                    </div>
                                    <div id="time-slots-grid" class="d-none" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0;"></div>
                                    <input type="hidden" id="appointment_time" name="appointment_time" required>
                                </div>
                                @error('appointment_time')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="symptoms">Symptoms (Optional)</label>
                        <textarea name="symptoms" id="symptoms" rows="3" 
                                  class="form-control @error('symptoms') is-invalid @enderror" 
                                  placeholder="Describe patient symptoms...">{{ old('symptoms') }}</textarea>
                        @error('symptoms')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes (Optional)</label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="form-control @error('notes') is-invalid @enderror" 
                                  placeholder="Additional notes...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Create Appointment</button>
                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Information</h3>
            </div>
            <div class="card-body">
                <h6>Treatment Types:</h6>
                <ul>
                    <li><strong>Ruqyah:</strong> Islamic spiritual healing</li>
                    <li><strong>Hijama:</strong> Wet cupping therapy</li>
                </ul>
                
                <h6>Appointment Status:</h6>
                <ul>
                    <li><span class="badge badge-warning">Pending</span> - Awaiting approval</li>
                    <li><span class="badge badge-success">Approved</span> - Confirmed</li>
                    <li><span class="badge badge-danger">Rejected</span> - Cancelled</li>
                    <li><span class="badge badge-info">Completed</span> - Finished</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 

@section('css')
<style>
#availability-calendar {
    display: block !important;
    min-height: 200px !important;
    background: white !important;
    border: 1px solid #dee2e6 !important;
    border-radius: 8px !important;
    padding: 0 !important;
    width: 100% !important;
}
#calendar-grid button.available-date {
    background-color: #28a745 !important;
    color: white !important;
    border-color: #28a745 !important;
    font-weight: bold !important;
}

#calendar-grid {
    display: grid !important;
    grid-template-columns: repeat(7, 1fr) !important;
    gap: 0 !important;
    width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
}
#availability-calendar button {
    width: 100% !important;
    height: 28px !important;
    border: 1px solid #dee2e6 !important;
    outline: none !important;
    cursor: pointer !important;
    border-radius: 0 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    margin: 0 !important;
    padding: 0 !important;
    font-weight: 500 !important;
    transition: all 0.2s ease !important;
    background-color: #f8f9fa !important;
    color: #495057 !important;
    font-size: 12px !important;
    min-width: unset !important;
    min-height: unset !important;
}
#availability-calendar button.available {
    background-color: #28a745 !important;
    color: white !important;
    box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3) !important;
}
#availability-calendar button.available:hover {
    background-color: #218838 !important;
    transform: scale(1.05) !important;
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.4) !important;
}
#availability-calendar button.unavailable {
    background-color: #6c757d !important;
    color: #adb5bd !important;
    cursor: not-allowed !important;
}
#availability-calendar button.past {
    background-color: #e9ecef !important;
    color: #6c757d !important;
    cursor: not-allowed !important;
}
#time-slots-grid {
    display: grid !important;
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 8px !important;
    padding: 8px !important;
}
.time-slot-btn {
    width: 100% !important;
    padding: 12px 8px !important;
    border: 2px solid #dee2e6 !important;
    background-color: #f8f9fa !important;
    border-radius: 8px !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    font-weight: 500 !important;
    text-align: center !important;
    font-size: 14px !important;
}
.time-slot-btn:hover {
    background-color: #007bff !important;
    color: white !important;
    border-color: #007bff !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3) !important;
}
.time-slot-btn.selected {
    background-color: #007bff !important;
    color: white !important;
    border-color: #007bff !important;
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.4) !important;
    transform: translateY(-2px) !important;
}
.time-slot-btn.booked {
    background-color: #dc3545 !important;
    color: white !important;
    border-color: #dc3545 !important;
    cursor: not-allowed !important;
    opacity: 0.7 !important;
}
#time-slots-container {
    border: 1px solid #dee2e6 !important;
    border-radius: 8px !important;
    padding: 16px !important;
    min-height: 120px !important;
    max-height: 250px !important;
    overflow-y: auto !important;
    background: white !important;
}
</style>
@stop

@section('js')
<script>
// Global variables and functions
let availableDatesObj = @json($availableDates);
let practitionerId = {{ $practitioner->id }};
let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();
let lastSelectedDate = '';

console.log('=== CALENDAR DEBUG START ===');
console.log('Script loaded at:', new Date().toLocaleTimeString());
console.log('Available dates object:', availableDatesObj);
console.log('Practitioner ID:', practitionerId);

// Global functions
function getAvailableDates() {
    if (!availableDatesObj[practitionerId]) {
        console.log('No available dates for practitioner:', practitionerId);
        // Add test dates to verify green color system
        const testDates = [
            '2025-07-15',
            '2025-07-16', 
            '2025-07-17',
            '2025-07-18',
            '2025-07-19'
        ];
        console.log('Using test dates for green color verification:', testDates);
        return testDates;
    }
    const dates = availableDatesObj[practitionerId].map(d => d.availability_date);
    console.log('Available dates from database:', dates);
    return dates;
}

function getTimeSlotsForDate(date) {
    console.log('Getting time slots for date:', date);
    
    if (!availableDatesObj[practitionerId]) {
        console.log('No availability data for practitioner');
        return [];
    }
    
    const day = availableDatesObj[practitionerId].find(d => d.availability_date === date);
    if (!day) {
        console.log('No availability data for this date:', date);
        return [];
    }
    
    console.log('Day data:', day);
    
    // Generate slots based on start_time, end_time, slot_duration
    const slots = [];
    const slotDuration = parseInt(day.slot_duration, 10);
    let current = new Date(date + 'T' + day.start_time);
    const end = new Date(date + 'T' + day.end_time);
    
    while (current < end) {
        const slot = current.toTimeString().slice(0,5);
        slots.push(slot);
        current = new Date(current.getTime() + slotDuration * 60000);
    }
    
    // Filter out booked slots
    const bookedTimes = day.booked_times || [];
    const availableSlots = slots.filter(slot => !bookedTimes.includes(slot));
    
    console.log('All slots:', slots);
    console.log('Booked times:', bookedTimes);
    console.log('Available slots:', availableSlots);
    
    return availableSlots;
}

function formatTimeSlot(timeStr) {
    // Convert "20:00" to "8:00 PM - 9:00 PM"
    const [hour, minute] = timeStr.split(':').map(Number);
    const start = new Date(2000, 0, 1, hour, minute);
    const end = new Date(start.getTime() + 60 * 60000); // 1 hour slot
    const format = (d) => {
        let h = d.getHours() % 12;
        if (h === 0) h = 12;
        const m = d.getMinutes().toString().padStart(2, '0');
        const ampm = d.getHours() < 12 ? 'AM' : 'PM';
        return `${h}:${m} ${ampm}`;
    };
    return `${format(start)} - ${format(end)}`;
}

function selectDate(dateStr) {
    console.log('=== SELECT DATE CALLED ===');
    console.log('Date selected:', dateStr);
    
    const dateInput = document.getElementById('appointment_date');
    if (dateInput) {
        dateInput.value = dateStr;
        console.log('Date input updated:', dateInput.value);
    } else {
        console.error('Date input not found!');
    }
    
    lastSelectedDate = dateStr;
    renderTimeSlots(dateStr);
}

function renderTimeSlots(dateStr) {
    console.log('=== RENDER TIME SLOTS CALLED ===');
    console.log('Rendering time slots for date:', dateStr);
    
    const slots = getTimeSlotsForDate(dateStr);
    console.log('Slots to render:', slots);
    
    const grid = document.getElementById('time-slots-grid');
    const message = document.getElementById('time-slots-message');
    const hiddenInput = document.getElementById('appointment_time');
    
    console.log('Grid element found:', !!grid);
    console.log('Message element found:', !!message);
    console.log('Hidden input found:', !!hiddenInput);
    
    if (!grid || !message) {
        console.error('Time slot elements not found!');
        return;
    }
    
    // Clear previous content
    grid.innerHTML = '';
    if (hiddenInput) hiddenInput.value = '';
    
    if (slots.length === 0) {
        console.log('No slots available, showing message');
        grid.classList.add('d-none');
        message.innerHTML = '<i class="fas fa-info-circle mb-2 text-xl"></i><p>No available times for this date</p>';
        message.classList.remove('d-none');
        return;
    }
    
    console.log('Showing grid with', slots.length, 'slots');
    message.classList.add('d-none');
    grid.classList.remove('d-none');
    
    slots.forEach((slot, index) => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = formatTimeSlot(slot);
        btn.className = 'time-slot-btn';
        btn.style.cssText = 'margin: 0; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 4px; background: white; cursor: pointer; transition: all 0.2s; width: 100%;';
        
        btn.onclick = function() {
            console.log('Time slot clicked:', slot);
            // Remove selection from all buttons
            document.querySelectorAll('#time-slots-grid button').forEach(b => {
                b.classList.remove('selected');
                b.style.backgroundColor = 'white';
                b.style.color = '#495057';
                b.style.borderColor = '#dee2e6';
            });
            // Add selection to clicked button
            btn.classList.add('selected');
            btn.style.backgroundColor = '#007bff';
            btn.style.color = 'white';
            btn.style.borderColor = '#007bff';
            btn.style.boxShadow = '0 2px 5px rgba(0, 123, 255, 0.3)';
            // Save the original time format (e.g., "09:00") not the display format
            if (hiddenInput) hiddenInput.value = slot;
            console.log('Time slot selected:', slot, 'Saved as:', slot);
        };
        
        grid.appendChild(btn);
        console.log('Added button for slot:', formatTimeSlot(slot));
    });
    
    console.log('Time slots rendered successfully');
}

const serverTodayStr = @json($serverToday); // e.g., "2025-07-19"
const serverToday = new Date(serverTodayStr + 'T00:00:00');

function renderAvailableDates() {
    const calendarGrid = document.getElementById('calendar-grid');
    const monthLabel = document.getElementById('calendar-month-label');
    if (!calendarGrid) return;
    // Update month label
    if (monthLabel) {
        const date = new Date(currentYear, currentMonth, 1);
        monthLabel.textContent = date.toLocaleString('default', { month: 'long', year: 'numeric' });
    }
    // Clear grid
    calendarGrid.innerHTML = '';
    // Get days in current month
    const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    const firstDay = new Date(currentYear, currentMonth, 1).getDay();
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
        if (dateObj < serverToday) {
            // Past date, gray and disabled
            dayButton.style.backgroundColor = '#e9ecef';
            dayButton.style.color = '#6c757d';
            dayButton.style.borderColor = '#dee2e6';
            dayButton.disabled = true;
        } else if (isAvailable) {
            dayButton.classList.add('available-date');
            dayButton.disabled = false;
            dayButton.style.setProperty('background-color', '#28a745', 'important');
            dayButton.style.setProperty('color', 'white', 'important');
            dayButton.style.setProperty('border-color', '#28a745', 'important');
            dayButton.onclick = function() {
                selectDate(dateStr);
                document.querySelectorAll('#calendar-grid button').forEach(btn => {
                    if (btn.classList.contains('available-date')) {
                        btn.style.setProperty('background-color', '#28a745', 'important');
                        btn.style.setProperty('color', 'white', 'important');
                        btn.style.setProperty('border-color', '#28a745', 'important');
                    }
                });
                dayButton.style.setProperty('background-color', '#007bff', 'important');
                dayButton.style.setProperty('color', 'white', 'important');
                dayButton.style.setProperty('border-color', '#007bff', 'important');
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
    
    // Treatment type change handler for Session Type visibility (matching patient behavior)
    const treatmentTypeSelect = document.getElementById('type');
    const sessionTypeGroup = document.querySelector('div:has(> label[for="session_type_id"])');
    const sessionTypeSelect = document.getElementById('session_type_id');
    
    function updateSessionTypeVisibility() {
        const selectedType = treatmentTypeSelect.value;
        
        if (selectedType === 'hijama') {
            // Hide session type for Hijama (matching patient behavior)
            if (sessionTypeGroup) {
                sessionTypeGroup.style.display = 'none';
            }
            if (sessionTypeSelect) {
                sessionTypeSelect.removeAttribute('required');
            }
        } else if (selectedType === 'ruqyah') {
            // Show session type for Ruqyah
            if (sessionTypeGroup) {
                sessionTypeGroup.style.display = 'block';
            }
            if (sessionTypeSelect) {
                sessionTypeSelect.setAttribute('required', 'required');
            }
        } else {
            // Default: hide session type
            if (sessionTypeGroup) {
                sessionTypeGroup.style.display = 'none';
            }
            if (sessionTypeSelect) {
                sessionTypeSelect.removeAttribute('required');
            }
        }
    }
    
    // Add event listener for treatment type changes
    if (treatmentTypeSelect) {
        treatmentTypeSelect.addEventListener('change', updateSessionTypeVisibility);
        // Initial call to set correct visibility
        updateSessionTypeVisibility();
    }
    
    // Render available dates
    console.log('Calling renderAvailableDates...');
    renderAvailableDates();
    
    // Removed all force/guaranteed render calls and their functions
    // Only use renderAvailableDates for all calendar updates
});
</script>
@stop 