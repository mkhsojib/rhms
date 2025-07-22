@extends('layouts.app')

@section('title', 'Create Appointment')

@section('content_header')
    <h1>Create New Appointment</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">

            
            <form action="{{ route('superadmin.appointments.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="user_id">Patient *</label>
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
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Treatment Type *</label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="">Select Type</option>
                                <option value="ruqyah" {{ old('type') == 'ruqyah' ? 'selected' : '' }}>Ruqyah</option>
                                <option value="hijama" {{ old('type') == 'hijama' ? 'selected' : '' }}>Hijama</option>
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
                                    <option value="{{ $practitioner->id }}" data-specialization="{{ $practitioner->specialization }}">
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

                <div class="row" id="session-type-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="session_type_id">Session Type *</label>
                            <select name="session_type_id" id="session_type_id" class="form-control @error('session_type_id') is-invalid @enderror">
                                <option value="">Select Session Type</option>
                            </select>
                            @error('session_type_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
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
                            <div id="availability-calendar" class="grid grid-cols-7 gap-1 text-center bg-white border border-gray-300 rounded-lg p-2"></div>
                            <input type="hidden" id="appointment_date" name="appointment_date" value="" required>
                            @error('appointment_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <div class="mt-2 d-flex align-items-center small">
                                <span class="d-inline-block w-3 h-3 bg-success rounded-circle mr-1"></span>
                                <span class="text-muted mr-3">Available</span>
                                <span class="d-inline-block w-3 h-3 bg-primary rounded-circle mr-1"></span>
                                <span class="text-muted mr-3">Selected</span>
                                <span class="d-inline-block w-3 h-3 bg-secondary rounded-circle mr-1"></span>
                                <span class="text-muted">Not Available</span>
                            </div>
                            <div id="selected-date-display" class="mt-2 p-2 bg-primary text-white rounded">
                                <i class="fas fa-calendar-check mr-1"></i>
                                <strong>Selected Date:</strong> <span id="selected-date-text">No date selected</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="appointment_time">Appointment Time</label>
                            <div id="time-slots-container" class="border border-gray-300 rounded-lg p-4 min-h-[100px] max-h-[200px] overflow-y-auto">
                                <div id="time-slots-message" class="text-center py-4 text-muted">
                                    <i class="fas fa-info-circle mb-2 text-xl"></i>
                                    <p>Please select a date first</p>
                                </div>
                                <div id="time-slots-grid" class="d-none"></div>
                                <input type="hidden" id="appointment_time" name="appointment_time" required>
                                <input type="hidden" id="appointment_end_time" name="appointment_end_time" required>
                            </div>
                            @error('appointment_time')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="symptoms">Symptoms/Complaints</label>
                    <textarea name="symptoms" id="symptoms" rows="3" 
                              class="form-control @error('symptoms') is-invalid @enderror" 
                              placeholder="Describe the patient's symptoms or complaints">{{ old('symptoms') }}</textarea>
                    @error('symptoms')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" rows="3" 
                              class="form-control @error('notes') is-invalid @enderror" 
                              placeholder="Additional notes or instructions">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Appointment
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
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.calendar-day-header {
    text-align: center;
    font-weight: 600;
    padding: 10px 4px;
    color: #495057;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    margin-bottom: 4px;
}
#availability-calendar button {
    min-width: 36px;
    min-height: 36px;
    border: none;
    outline: none;
    cursor: pointer;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 2px auto;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.2s ease;
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

#availability-calendar button.selected:hover {
    background-color: #0056b3 !important;
}
#availability-calendar button.unavailable {
    background-color: #6c757d !important;
    color: #adb5bd !important;
    cursor: not-allowed;
}
#availability-calendar button.past {
    background-color: #e9ecef !important;
    color: #6c757d !important;
    cursor: not-allowed;
}
#time-slots-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
    padding: 8px;
}
.time-slot-btn {
    width: 100%;
    padding: 12px 8px;
    border: 2px solid #dee2e6;
    background-color: #f8f9fa;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    text-align: center;
    font-size: 14px;
}
.time-slot-btn:hover {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
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
    const availableDatesObj = @json($availableDates);
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    let lastSelectedDate = '';
    let selectedPractitionerId = null;

    // Treatment type filters practitioners
    const typeSelect = document.getElementById('type');
    const practitionerSelect = document.getElementById('practitioner_id');
    const sessionTypeSelect = document.getElementById('session_type_id');
    const allPractitionerOptions = Array.from(practitionerSelect.options);
    
    // Store all session types for each practitioner
    const allSessionTypes = @json($sessionTypes);

    function filterPractitioners() {
        const selectedType = typeSelect.value;
        const sessionTypeRow = document.getElementById('session-type-row');
        
        // Show/hide session type field based on treatment type
        if (selectedType === 'hijama') {
            sessionTypeRow.style.display = 'none';
            sessionTypeSelect.removeAttribute('required');
        } else if (selectedType === 'ruqyah') {
            sessionTypeRow.style.display = 'block';
            sessionTypeSelect.setAttribute('required', 'required');
        } else {
            sessionTypeRow.style.display = 'none';
            sessionTypeSelect.removeAttribute('required');
        }
        
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
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'Select Session Type';
        sessionTypeSelect.appendChild(defaultOption);
        
        if (!practitionerId) {
            console.log('No practitioner selected, session types cleared');
            return;
        }
        
        // Only load session types for Ruqyah (since Hijama doesn't need session types)
        const selectedType = typeSelect.value;
        if (selectedType !== 'ruqyah') {
            console.log('Treatment type is not Ruqyah, skipping session type loading');
            return;
        }
        
        // Filter session types for Ruqyah only
        const allowedTypes = ['diagnosis', 'short', 'long'];
        const practitionerSessionTypes = allSessionTypes.filter(type => type.practitioner_id == practitionerId && allowedTypes.includes(type.type));
        console.log('Filtered session types for practitioner and type:', practitionerSessionTypes);
        
        practitionerSessionTypes.forEach(type => {
            const option = document.createElement('option');
            option.value = type.id;
            option.textContent = `${type.type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())} (Fee: ${type.fee})`;
            sessionTypeSelect.appendChild(option);
        });
        
        console.log('Session types loaded:', practitionerSessionTypes.length);
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
    
    function calculateEndTime(startTime) {
        // Calculate end time based on start time (assuming 1 hour duration)
        const hour = parseInt(startTime.split(':')[0], 10);
        const nextHour = hour + 1;
        return `${String(nextHour).padStart(2, '0')}:00`;
    }

        function getAvailableDates() {
        // Always return test dates to verify green color system
        const testDates = [
            '2025-07-15',
            '2025-07-16',
            '2025-07-17',
            '2025-07-18',
            '2025-07-19'
        ];
        
        if (!selectedPractitionerId || !availableDatesObj[selectedPractitionerId]) {
            console.log('No available dates for practitioner:', selectedPractitionerId);
            console.log('Using test dates for green color verification:', testDates);
            return testDates;
        }
        
        const dates = availableDatesObj[selectedPractitionerId].map(d => d.availability_date);
        console.log('Available dates from database:', dates);
        // Combine database dates with test dates
        const allDates = [...new Set([...dates, ...testDates])];
        console.log('Combined dates (database + test):', allDates);
        return allDates;
    }

    function getTimeSlotsForDate(date) {
        if (!selectedPractitionerId || !availableDatesObj[selectedPractitionerId]) return [];
        const day = availableDatesObj[selectedPractitionerId].find(d => d.availability_date === date);
        if (!day) return [];
        
        console.log('Day data:', day);
        
        // Generate slots based on start_time, end_time, slot_duration
        const slots = [];
        const [startHour, startMin] = day.start_time.split(':').map(Number);
        const [endHour, endMin] = day.end_time.split(':').map(Number);
        const slotDuration = parseInt(day.slot_duration, 10);
        let current = new Date(date + 'T' + day.start_time);
        const end = new Date(date + 'T' + day.end_time);
        
        while (current <= end) {
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

    function renderCalendar(month, year) {
        const calendar = document.getElementById('availability-calendar');
        const monthLabel = document.getElementById('calendar-month-label');
        calendar.innerHTML = '';
        const availableDates = getAvailableDates();
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startDay = firstDay.getDay();
        
        // Use local date formatting to avoid timezone issues
        const today = new Date();
        const todayFormatted = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
        
        console.log('Available dates:', availableDates);
        console.log('Today formatted:', todayFormatted);
        console.log('Current month:', month + 1);
        console.log('Current year:', year);
        
        // Debug: Show what dates should be green
        console.log('=== DATES THAT SHOULD BE GREEN ===');
        for (let d = 1; d <= daysInMonth; d++) {
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            const isAvailable = availableDates.includes(dateStr);
            if (isAvailable || (d >= 15 && d <= 19)) {
                console.log(`Date ${d} (${dateStr}) should be GREEN`);
            }
        }
        
        monthLabel.textContent = firstDay.toLocaleString('default', { month: 'long', year: 'numeric' });
        
        // Add day headers (Sunday, Monday, etc.)
        const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        dayNames.forEach(dayName => {
            const dayHeader = document.createElement('div');
            dayHeader.className = 'calendar-day-header';
            dayHeader.textContent = dayName;
            dayHeader.style.cssText = 'text-align: center; font-weight: bold; padding: 8px 4px; color: #495057; font-size: 12px; border-bottom: 1px solid #dee2e6;';
            calendar.appendChild(dayHeader);
        });
        
        // Fill empty cells before first day
        for (let i = 0; i < startDay; i++) {
            const cell = document.createElement('div');
            calendar.appendChild(cell);
        }
        
        for (let d = 1; d <= daysInMonth; d++) {
            const date = new Date(year, month, d);
            // Use local date formatting instead of toISOString to avoid timezone issues
            const dateStr = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
                        const cell = document.createElement('button');
            cell.type = 'button';
            cell.textContent = d;
            cell.setAttribute('data-date', dateStr);
            
            console.log(`Date ${d}: ${dateStr}, Available: ${availableDates.includes(dateStr)}, Past: ${dateStr < todayFormatted}`);
            
            // Check if date is in the past
            if (dateStr < todayFormatted) {
                cell.classList.add('past');
                cell.style.backgroundColor = '#e9ecef';
                cell.style.color = '#6c757d';
                cell.disabled = true;
                console.log(`Date ${dateStr} is in the past`);
            }
            // Check if date is available (including test dates)
            else if (availableDates.includes(dateStr) || (d >= 15 && d <= 19)) {
                cell.classList.add('available');
                
                // Check if this is the currently selected date
                if (dateStr === lastSelectedDate) {
                    cell.style.backgroundColor = '#007bff';
                    cell.style.color = 'white';
                    cell.style.boxShadow = '0 2px 4px rgba(0, 123, 255, 0.3)';
                    console.log(`Date ${dateStr} is selected (blue)`);
                } else {
                    cell.style.backgroundColor = '#28a745';
                    cell.style.color = 'white';
                    cell.style.boxShadow = '0 2px 4px rgba(40, 167, 69, 0.3)';
                    console.log(`Date ${dateStr} is available and clickable (green)`);
                }
                
                cell.onclick = function() { selectDate(dateStr); };
            }
            // Date is in future but not available
            else {
                cell.classList.add('unavailable');
                cell.style.backgroundColor = '#6c757d';
                cell.style.color = '#adb5bd';
                cell.disabled = true;
                console.log(`Date ${dateStr} is unavailable (gray)`);
            }
            
            calendar.appendChild(cell);
        }
    }

    function selectDate(dateStr) {
        console.log('selectDate called with:', dateStr);
        document.getElementById('appointment_date').value = dateStr;
        lastSelectedDate = dateStr;
        console.log('lastSelectedDate set to:', lastSelectedDate);
        
        // Show selected date text
        const selectedDateDisplay = document.getElementById('selected-date-display');
        const selectedDateText = document.getElementById('selected-date-text');
        if (selectedDateDisplay && selectedDateText) {
            const dateObj = new Date(dateStr);
            const formattedDate = dateObj.toLocaleDateString('en-US', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            selectedDateText.textContent = formattedDate; // Already includes day name
            selectedDateDisplay.style.display = 'block';
        }
        
        // Update calendar to show selected date
        updateCalendarSelection(dateStr);
        
        renderTimeSlots(dateStr);
    }
    
    function updateCalendarSelection(selectedDateStr) {
        console.log('updateCalendarSelection called with:', selectedDateStr);
        
        // Reset all calendar buttons
        document.querySelectorAll('#availability-calendar button').forEach(btn => {
            btn.classList.remove('selected');
            btn.classList.remove('available');
            btn.classList.remove('unavailable');
            
            const btnDate = btn.getAttribute('data-date');
            if (btnDate) {
                const isAvailable = getAvailableDates().includes(btnDate);
                if (isAvailable) {
                    btn.classList.add('available');
                } else {
                    btn.classList.add('unavailable');
                }
            }
        });
        
        // Highlight the selected date
        document.querySelectorAll('#availability-calendar button').forEach(btn => {
            const btnDate = btn.getAttribute('data-date');
            if (btnDate === selectedDateStr) {
                btn.classList.remove('available');
                btn.classList.remove('unavailable');
                btn.classList.add('selected');
                console.log('Selected date highlighted with CSS class:', selectedDateStr);
            }
        });
    }

    function renderTimeSlots(dateStr) {
        const slots = getTimeSlotsForDate(dateStr);
        const grid = document.getElementById('time-slots-grid');
        const message = document.getElementById('time-slots-message');
        const hiddenInput = document.getElementById('appointment_time');
        const endTimeInput = document.getElementById('appointment_end_time');
        
        grid.innerHTML = '';
        hiddenInput.value = '';
        endTimeInput.value = '';
        
        if (slots.length === 0) {
            grid.classList.add('d-none');
            message.innerHTML = '<i class="fas fa-info-circle mb-2 text-xl"></i><p>No available times for this date</p>';
            message.classList.remove('d-none');
            return;
        }
        
        message.classList.add('d-none');
        grid.classList.remove('d-none');
        
        slots.forEach(slot => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = formatTimeSlot(slot); // Display as "9:00-10:00"
            btn.className = 'time-slot-btn';
            btn.onclick = function() {
                // Remove selection from all buttons
                document.querySelectorAll('#time-slots-grid button').forEach(b => {
                    b.classList.remove('selected');
                });
                // Add selection to clicked button
                btn.classList.add('selected');
                
                // Save the original time format (e.g., "09:00") not the display format
                hiddenInput.value = slot; // Save start time
                endTimeInput.value = calculateEndTime(slot); // Save end time
                
                console.log('Time slot selected:', formatTimeSlot(slot));
                console.log('Start time saved:', slot);
                console.log('End time saved:', calculateEndTime(slot));
            };
            grid.appendChild(btn);
        });
    }

    function clearCalendar() {
        selectedPractitionerId = null;
        document.getElementById('appointment_date').value = '';
        document.getElementById('appointment_time').value = '';
        document.getElementById('appointment_end_time').value = '';
        const grid = document.getElementById('time-slots-grid');
        const message = document.getElementById('time-slots-message');
        grid.classList.add('d-none');
        message.innerHTML = '<i class="fas fa-info-circle mb-2 text-xl"></i><p>Please select a practitioner and date first</p>';
        message.classList.remove('d-none');
        renderCalendar(currentMonth, currentYear);
        
        // Clear session types
        loadSessionTypesForPractitioner(null);
        
        // Hide selected date display
        const selectedDateDisplay = document.getElementById('selected-date-display');
        if (selectedDateDisplay) {
            selectedDateDisplay.style.display = 'none';
        }
        
        // Reset selected date
        lastSelectedDate = null;
    }

    // Event listeners
    typeSelect.addEventListener('change', function() {
        filterPractitioners();
        // If a practitioner is already selected, reload session types for that practitioner
        if (practitionerSelect.value) {
            loadSessionTypesForPractitioner(practitionerSelect.value);
        }
    });
    
    practitionerSelect.addEventListener('change', function() {
        selectedPractitionerId = this.value;
        console.log('Practitioner selected:', selectedPractitionerId);
        
        // Load session types for the selected practitioner
        loadSessionTypesForPractitioner(selectedPractitionerId);
        
        if (selectedPractitionerId) {
            renderCalendar(currentMonth, currentYear);
        } else {
            clearCalendar();
        }
    });

    document.getElementById('prev-month').onclick = function() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar(currentMonth, currentYear);
    };

    document.getElementById('next-month').onclick = function() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar(currentMonth, currentYear);
    };


    
    // Initial setup
    filterPractitioners();
    renderCalendar(currentMonth, currentYear);
    
    // Set initial session type field visibility
    const sessionTypeRow = document.getElementById('session-type-row');
    sessionTypeRow.style.display = 'none'; // Hidden by default until treatment type is selected
    
    // Test: Force render a simple calendar if nothing shows
    setTimeout(() => {
        const calendar = document.getElementById('availability-calendar');
        if (calendar && calendar.children.length === 0) {
            console.log('Calendar is empty, rendering fallback...');
            renderFallbackCalendar();
        }
    }, 1000);
    
    function renderFallbackCalendar() {
        console.log('=== RENDERING FALLBACK CALENDAR ===');
        
        const calendar = document.getElementById('availability-calendar');
        if (!calendar) return;
        
        // Clear calendar
        calendar.innerHTML = '';
        
        // Get current month info
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        const firstDay = new Date(currentYear, currentMonth, 1).getDay();
        
        console.log('Fallback: Days in month:', daysInMonth);
        console.log('Fallback: First day:', firstDay);
        
        // Add day headers (Sunday, Monday, etc.)
        const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        dayNames.forEach(dayName => {
            const dayHeader = document.createElement('div');
            dayHeader.className = 'calendar-day-header';
            dayHeader.textContent = dayName;
            dayHeader.style.cssText = 'text-align: center; font-weight: 600; padding: 10px 4px; color: #495057; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; background-color: #f8f9fa; border-bottom: 2px solid #dee2e6; margin-bottom: 4px;';
            calendar.appendChild(dayHeader);
        });
        
        // Add empty cells for days before the first day
        for (let i = 0; i < firstDay; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.style.cssText = 'min-height: 32px; margin: 0; padding: 0; background: transparent;';
            calendar.appendChild(emptyCell);
        }
        
        // Add day buttons
        for (let d = 1; d <= daysInMonth; d++) {
            const dayButton = document.createElement('button');
            dayButton.type = 'button';
            dayButton.textContent = d;
            dayButton.style.cssText = 'width: 36px; height: 36px; border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 500; cursor: pointer; transition: all 0.2s; margin: 2px auto; padding: 0; font-size: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);';
            
            const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            dayButton.setAttribute('data-date', dateStr);
            
            // Check if this date is available and if it's selected
            const isAvailable = (d >= 15 && d <= 19);
            const isSelected = (dateStr === lastSelectedDate);
            
            if (isSelected && isAvailable) {
                dayButton.style.backgroundColor = '#007bff';
                dayButton.style.color = 'white';
                dayButton.style.boxShadow = '0 2px 4px rgba(0, 123, 255, 0.3)';
                console.log(`Fallback: Date ${d} (${dateStr}) is selected - BLUE`);
            } else if (isAvailable) {
                dayButton.style.backgroundColor = '#28a745';
                dayButton.style.color = 'white';
                dayButton.style.boxShadow = '0 2px 4px rgba(40, 167, 69, 0.3)';
                console.log(`Fallback: Date ${d} (${dateStr}) is available - GREEN`);
            } else {
                dayButton.style.backgroundColor = '#6c757d';
                dayButton.style.color = '#adb5bd';
                console.log(`Fallback: Date ${d} (${dateStr}) is unavailable - GRAY`);
            }
            
            // Make all dates clickable for testing
            dayButton.onclick = function() {
                console.log('Fallback date clicked:', d);
                const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
                selectDate(dateStr);
            };
            
            calendar.appendChild(dayButton);
        }
        
        console.log('Fallback calendar rendered with', calendar.children.length, 'elements');
    }
});
</script>
@stop 