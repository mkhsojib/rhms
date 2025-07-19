@extends('layouts.frontend')

@section('title', 'Edit Appointment - Ruqyah & Hijama Center')

@section('navigation-links')
    <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Home</a>
    <a href="{{ route('patient.appointments.index') }}" class="text-gray-700 hover:text-indigo-600 font-medium">My Appointments</a>
@endsection

@section('mobile-navigation-links')
    <a href="{{ url('/') }}" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Home</a>
    <a href="{{ route('patient.appointments.index') }}" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">My Appointments</a>
@endsection

@section('content')
    <div class="min-h-screen pt-20 pb-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Edit Appointment</h1>
                        <p class="text-white text-opacity-90">Update your appointment details</p>
                    </div>
                    <a href="{{ route('patient.appointments.index') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-700 transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Appointments
                    </a>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="dashboard-card rounded-lg p-8 card-shadow">
                <form method="POST" action="{{ route('patient.appointments.update', $appointment) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Practitioner Selection -->
                    <div>
                        <label for="practitioner_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user-md mr-2 text-indigo-600"></i>Select Practitioner
                        </label>
                        <select id="practitioner_id" name="practitioner_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                            <option value="">Choose a practitioner...</option>
                            @foreach($practitioners as $practitioner)
                                <option value="{{ $practitioner->id }}" 
                                    {{ (old('practitioner_id', $appointment->practitioner_id) == $practitioner->id) ? 'selected' : '' }}>
                                    {{ $practitioner->name }} 
                                    @if($practitioner->specialization)
                                        - {{ $practitioner->specialization }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('practitioner_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Treatment Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            <i class="fas fa-hand-holding-medical mr-2 text-indigo-600"></i>Treatment Type
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="relative flex cursor-pointer rounded-lg border border-gray-300 bg-white p-4 shadow-sm focus:outline-none">
                                <input type="radio" name="type" value="ruqyah" 
                                       {{ (old('type', $appointment->type) == 'ruqyah') ? 'checked' : '' }} 
                                       class="sr-only" required>
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-medium text-gray-900">Ruqyah Healing</span>
                                        <span class="mt-1 flex items-center text-sm text-gray-500">
                                            <i class="fas fa-book-open text-indigo-600 mr-2"></i>
                                            Spiritual healing through Quranic recitation
                                        </span>
                                    </span>
                                </span>
                                <span class="pointer-events-none absolute -inset-px rounded-lg border-2" aria-hidden="true"></span>
                            </label>

                            <label class="relative flex cursor-pointer rounded-lg border border-gray-300 bg-white p-4 shadow-sm focus:outline-none">
                                <input type="radio" name="type" value="hijama" 
                                       {{ (old('type', $appointment->type) == 'hijama') ? 'checked' : '' }} 
                                       class="sr-only" required>
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-medium text-gray-900">Hijama (Cupping)</span>
                                        <span class="mt-1 flex items-center text-sm text-gray-500">
                                            <i class="fas fa-hand-holding-medical text-green-600 mr-2"></i>
                                            Traditional Islamic cupping therapy
                                        </span>
                                    </span>
                                </span>
                                <span class="pointer-events-none absolute -inset-px rounded-lg border-2" aria-hidden="true"></span>
                            </label>
                        </div>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date and Time -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div id="date-section">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar mr-2 text-indigo-600"></i>Appointment Date
                            </label>
                            <div id="calendar-controls" class="flex justify-between items-center mb-3 p-2 bg-gray-50 rounded-lg">
                                <button type="button" id="prev-month" class="w-8 h-8 flex items-center justify-center bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">&lt;</button>
                                <span id="calendar-month-label" class="font-bold text-gray-700"></span>
                                <button type="button" id="next-month" class="w-8 h-8 flex items-center justify-center bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">&gt;</button>
                            </div>
                            <div id="availability-calendar" class="grid grid-cols-7 gap-1 text-center bg-white border border-gray-300 rounded-lg p-2"></div>
                            <input type="hidden" id="appointment_date" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date) }}" required>
                            @error('appointment_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div class="mt-2 flex items-center text-xs">
                                <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-1"></span>
                                <span class="text-gray-600 mr-3">Available</span>
                                <span class="inline-block w-3 h-3 bg-gray-300 rounded-full mr-1"></span>
                                <span class="text-gray-600">Not Available</span>
                            </div>
                        </div>
                        <div id="time-section">
                            <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-clock mr-2 text-indigo-600"></i>Available Time Slots
                            </label>
                            <div id="time-slots-container" class="border border-gray-300 rounded-lg p-4 min-h-[200px] max-h-[300px] overflow-y-auto">
                                <div id="time-slots-message" class="text-center py-8 text-gray-500">
                                    <i class="fas fa-info-circle mb-2 text-xl"></i>
                                    <p>Please select a practitioner and date first</p>
                                </div>
                                <div id="time-slots-grid" class="grid grid-cols-2 gap-2 hidden">
                                    <!-- Time slots will be dynamically generated here -->
                                </div>
                                <input type="hidden" id="appointment_time" name="appointment_time" value="{{ old('appointment_time', substr($appointment->appointment_time, 0, 5)) }}" required>
                            </div>
                            @error('appointment_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Symptoms/Notes -->
                    <div>
                        <label for="symptoms" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-notes-medical mr-2 text-indigo-600"></i>Symptoms or Notes (Optional)
                        </label>
                        <textarea id="symptoms" name="symptoms" rows="4" 
                                  placeholder="Please describe your symptoms or any specific concerns you'd like the practitioner to know about..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">{{ old('symptoms', $appointment->symptoms) }}</textarea>
                        @error('symptoms')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Appointment Info -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Current Appointment Details</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
                                    <p><strong>Created:</strong> {{ date('M d, Y \a\t g:i A', strtotime($appointment->created_at)) }}</p>
                                    <p><strong>Last Updated:</strong> {{ date('M d, Y \a\t g:i A', strtotime($appointment->updated_at)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Information Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Editing Information</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>You can only edit pending appointments</li>
                                            <li>Changes will be reviewed by the practitioner</li>
                                            <li>Appointment date must be at least 24 hours in advance</li>
                                            <li>All fields are required except symptoms/notes</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">What to Expect</h3>
                                    <div class="mt-2 text-sm text-green-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Updated appointment details will be saved</li>
                                            <li>Practitioner will be notified of changes</li>
                                            <li>You'll receive confirmation of the update</li>
                                            <li>Original appointment ID remains the same</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <div class="flex space-x-4">
                            <a href="{{ route('patient.appointments.show', $appointment) }}" 
                               class="px-6 py-3 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition duration-200">
                               <i class="fas fa-eye mr-2"></i>View Details
                            </a>
                            <a href="{{ route('patient.appointments.index') }}" 
                               class="px-6 py-3 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition duration-200">
                                Cancel
                            </a>
                        </div>
                        
                        <div id="edit-step">
                            <button type="button" id="continue-btn"
                                    class="px-8 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200">
                                <i class="fas fa-arrow-right mr-2"></i>Continue
                            </button>
                        </div>
                        
                        <div id="confirmation-step" class="hidden">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                <h3 class="font-bold text-green-800 mb-2">Appointment Summary</h3>
                                <div id="summary-details" class="text-sm text-gray-700">
                                    <!-- Summary will be populated here -->
                                </div>
                            </div>
                            
                            <button type="submit" id="submit-btn"
                                    class="px-8 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200">
                                <i class="fas fa-calendar-check mr-2"></i>Confirm Update
                            </button>
                            
                            <button type="button" id="back-btn"
                                    class="mt-2 px-8 py-3 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition duration-200">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Edit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
const availableDatesObj = @json($availableDates);

// Parse the appointment date to set the initial calendar month/year
// Make sure we clean the date string to handle any format issues
let appointmentDateStr = '{{ $appointment->appointment_date }}';

// Clean the date string - remove any time component or duplicated date
if (appointmentDateStr.includes(' ')) {
    appointmentDateStr = appointmentDateStr.split(' ')[0]; // Take only the date part
}

// Ensure the date is in YYYY-MM-DD format
const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
if (!dateRegex.test(appointmentDateStr)) {
    console.error('Invalid appointment date format:', appointmentDateStr);
    // Try to extract a valid date using regex
    const matches = appointmentDateStr.match(/(\d{4}-\d{2}-\d{2})/);
    if (matches && matches[1]) {
        appointmentDateStr = matches[1];
        console.log('Extracted date part:', appointmentDateStr);
    }
}

// Create a proper date object
const appointmentDate = new Date(appointmentDateStr + 'T00:00:00'); // Add time to avoid timezone issues

// Use appointment date for calendar initialization, fallback to today if invalid
let currentYear, currentMonth;
if (!isNaN(appointmentDate.getTime())) {
    currentYear = appointmentDate.getFullYear();
    currentMonth = appointmentDate.getMonth();
    console.log('Using appointment date for calendar initialization:', appointmentDateStr);
} else {
    const today = new Date();
    currentYear = today.getFullYear();
    currentMonth = today.getMonth();
    console.log('Appointment date invalid, using today for calendar initialization');
}

// Set the selected date to the cleaned appointment date
let selectedDate = appointmentDateStr;
let lastSelectedDate = selectedDate;

// Debug the cleaned date
console.log('Cleaned appointment date:', appointmentDateStr);
console.log('Date object created:', appointmentDate);

// Format today's date for comparison (only for visual indicator, not selection)
const today = new Date();
const todayStr = today.toISOString().split('T')[0];

console.log('Initial calendar setup:');
console.log('Appointment date:', appointmentDateStr);
console.log('Calendar year/month:', currentYear, currentMonth);
console.log('Selected date:', selectedDate);
console.log('Today string:', todayStr);

// Debug the available dates object
console.log('Original availableDatesObj:', availableDatesObj);

// Convert the availableDatesObj to a more usable format if needed
function initializeAvailableDates() {
    console.log('Initializing available dates...');
    // Deep log the structure to understand it better
    if (availableDatesObj) {
        for (const practitionerId in availableDatesObj) {
            console.log(`Practitioner ${practitionerId} dates:`, availableDatesObj[practitionerId]);
        }
    }
}

// Call this function on page load
initializeAvailableDates();

// Form submission handler to clean date
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded - initializing form handlers');
    
    // Set the initial value to the current appointment date
    document.getElementById('appointment_date').value = lastSelectedDate;
    console.log('Initial appointment_date set to:', lastSelectedDate);
    
    // Highlight the selected date in the calendar once it's rendered
    setTimeout(() => {
        const selectedDateCell = document.querySelector(`[data-date="${lastSelectedDate}"]`);
        if (selectedDateCell) {
            selectedDateCell.classList.add('bg-indigo-600', 'text-white');
            selectedDateCell.style.fontWeight = 'bold';
            console.log('Highlighted initial selected date in calendar:', lastSelectedDate);
        } else {
            console.warn('Could not find calendar cell for date:', lastSelectedDate);
        }
        
        // Fetch time slots for the initial date
        fetchAvailableTimeSlots();
    }, 500);
    
    // Add handlers for the multi-step form
    const continueBtn = document.getElementById('continue-btn');
    const backBtn = document.getElementById('back-btn');
    const editStep = document.getElementById('edit-step');
    const confirmationStep = document.getElementById('confirmation-step');
    const summaryDetails = document.getElementById('summary-details');
    const form = document.querySelector('form[action*="appointments.update"]');
    
    // Continue button handler - show confirmation step
    if (continueBtn) {
        continueBtn.addEventListener('click', function() {
            // Validate form fields
            const practitionerId = document.getElementById('practitioner_id').value;
            const appointmentDate = document.getElementById('appointment_date').value;
            const appointmentTime = document.getElementById('appointment_time').value;
            const treatmentType = document.querySelector('input[name="type"]:checked')?.value;
            
            // Validate required fields
            if (!practitionerId) {
                alert('Please select a practitioner');
                return;
            }
            
            if (!appointmentDate) {
                alert('Please select an appointment date');
                return;
            }
            
            if (!appointmentTime) {
                alert('Please select at least one time slot');
                return;
            }
            
            if (!treatmentType) {
                alert('Please select a treatment type');
                return;
            }
            
            // Show confirmation step
            editStep.classList.add('hidden');
            confirmationStep.classList.remove('hidden');
            
            // Populate summary details
            const practitionerName = document.getElementById('practitioner_id').options[document.getElementById('practitioner_id').selectedIndex].text;
            const treatmentTypeName = document.querySelector('input[name="type"]:checked').nextElementSibling.textContent.trim();
            const symptoms = document.getElementById('symptoms').value || 'None provided';
            
            // Format date for display
            const dateObj = new Date(appointmentDate);
            const formattedDate = dateObj.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            
            // Create summary HTML
            summaryDetails.innerHTML = `
                <ul class="space-y-2">
                    <li><strong>Practitioner:</strong> ${practitionerName}</li>
                    <li><strong>Date:</strong> ${formattedDate}</li>
                    <li><strong>Time:</strong> ${appointmentTime}</li>
                    <li><strong>Treatment Type:</strong> ${treatmentTypeName}</li>
                    <li><strong>Symptoms/Notes:</strong> ${symptoms}</li>
                </ul>
            `;
        });
    }
    
    // Back button handler - return to edit step
    if (backBtn) {
        backBtn.addEventListener('click', function() {
            editStep.classList.remove('hidden');
            confirmationStep.classList.add('hidden');
        });
    }
    
    // Form submission handler
    if (form) {
        form.addEventListener('submit', function(e) {
            // Prevent default submission - we'll handle it with AJAX
            e.preventDefault();
            
            console.log('Form submission triggered - using AJAX instead');
            
            // Get form data for AJAX submission
            const form = this;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const practitionerId = document.getElementById('practitioner_id').value;
            const treatmentType = document.querySelector('input[name="type"]:checked')?.value;
            const symptoms = document.getElementById('symptoms').value;
            
            // Get the appointment date and time
            let appointmentDate = document.getElementById('appointment_date').value;
            const appointmentTime = document.getElementById('appointment_time').value;
            
            console.log('Form submission - appointment date before cleaning:', appointmentDate);
            
            // CRITICAL: Make sure we're using the lastSelectedDate if it exists
            // This ensures we use the date the user actually clicked on
            if (lastSelectedDate) {
                if (lastSelectedDate !== appointmentDate) {
                    console.warn('Using lastSelectedDate instead of form value');
                    console.log('Form appointmentDate:', appointmentDate);
                    console.log('lastSelectedDate:', lastSelectedDate);
                    appointmentDate = lastSelectedDate;
                } else {
                    console.log('Form date matches lastSelectedDate:', appointmentDate);
                }
            } else {
                console.warn('No lastSelectedDate available, using form value:', appointmentDate);
            }
            
            // Clean the date - remove any double date specification or time component
            if (appointmentDate.includes(' ')) {
                console.warn('Double date specification detected:', appointmentDate);
                appointmentDate = appointmentDate.split(' ')[0];
                console.log('Cleaned date:', appointmentDate);
            }
            
            // Also remove any T component (from ISO string)
            if (appointmentDate.includes('T')) {
                appointmentDate = appointmentDate.split('T')[0];
                console.log('Removed T component:', appointmentDate);
            }
            
            // Final check - ensure it's a valid date format
            const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
            if (!dateRegex.test(appointmentDate)) {
                console.error('Invalid date format:', appointmentDate);
                alert('Please select a valid date.');
                return false;
            }

            // FORCE the hidden input to this clean value
            const appointmentInput = document.getElementById('appointment_date');
            appointmentInput.value = appointmentDate;
            console.log('DEBUG: appointment_date input value right before submit:', appointmentInput.value);
            
            // Show a clear confirmation of the date being submitted
            alert(`Submitting appointment for date: ${appointmentDate}`);

            // Always show the value in the UI for debugging and confirmation
            let debugDisplay = document.getElementById('debug-date-value');
            if (!debugDisplay) {
                debugDisplay = document.createElement('div');
                debugDisplay.id = 'debug-date-value';
                debugDisplay.style.color = 'green';
                debugDisplay.style.fontWeight = 'bold';
                debugDisplay.style.padding = '10px';
                debugDisplay.style.marginTop = '10px';
                debugDisplay.style.border = '1px solid green';
                debugDisplay.style.borderRadius = '5px';
                appointmentInput.parentNode.appendChild(debugDisplay);
            }
            debugDisplay.innerText = 'Submitting appointment for date: ' + appointmentInput.value;

            console.log('Using final date for AJAX submission:', appointmentDate);
            
            // Validate required fields
            if (!practitionerId) {
                alert('Please select a practitioner');
                return false;
            }
            
            if (!appointmentTime) {
                alert('Please select at least one time slot');
                return false;
            }
            
            if (!treatmentType) {
                alert('Please select a treatment type');
                return false;
            }
            
            // Create form data for AJAX
            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('_method', 'PUT'); // For PUT request
            formData.append('practitioner_id', practitionerId);
            formData.append('type', treatmentType);
            formData.append('symptoms', symptoms);
            formData.append('appointment_date', appointmentDate);
            formData.append('appointment_time', appointmentTime);
            
            // Submit the form via AJAX
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect || '{{ route("patient.appointments.index") }}';
                } else {
                    alert(data.message || 'An error occurred while updating the appointment.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the appointment. Please try again.');
            });
            
            return false;
        });
    }
    
    // Treatment type selection functionality
    // Add click handlers for treatment type selection
    const treatmentTypeLabels = document.querySelectorAll('input[name="type"]');
    treatmentTypeLabels.forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Remove selected styling from all labels
            treatmentTypeLabels.forEach(function(r) {
                r.closest('label').classList.remove('border-indigo-500', 'ring-2', 'ring-indigo-500');
                r.closest('label').classList.add('border-gray-300');
            });
            
            // Add selected styling to checked radio
            if (this.checked) {
                this.closest('label').classList.remove('border-gray-300');
                this.closest('label').classList.add('border-indigo-500', 'ring-2', 'ring-indigo-500');
            }
        });
    });

    // Initialize styling for pre-selected radio button
    const checkedRadio = document.querySelector('input[name="type"]:checked');
    if (checkedRadio) {
        checkedRadio.closest('label').classList.remove('border-gray-300');
        checkedRadio.closest('label').classList.add('border-indigo-500', 'ring-2', 'ring-indigo-500');
    }
    
    // Add change handler for practitioner selection
    document.getElementById('practitioner_id').addEventListener('change', function() {
        // Reset date selection
        document.getElementById('appointment_date').value = '';
        // Reset time slots
        showTimeSlotsMessage('Please select a date first');
        // Update calendar with new practitioner's availability
        updateCalendar();
    });
    
    // Function to get available dates for a specific month
    function getAvailableDatesForMonth(year, month) {
        const practitionerId = document.getElementById('practitioner_id').value;
        
        console.log('Getting available dates for practitioner:', practitionerId || 'ALL');
        console.log('Available dates data structure:', availableDatesObj);
        
        // If no practitioner selected, show no available dates (user must select a raqi first)
        if (!practitionerId) {
            console.log('No practitioner selected, please select a raqi to see available dates');
            return [];
        }
        
        // Check if we have data for this practitioner
        if (!availableDatesObj[practitionerId]) {
            console.log('No availability data for practitioner:', practitionerId);
            return [];
        }
        
        // No hardcoded dates - all dates come from database
        
        // Get all dates for this practitioner
        const availableDatesForPractitioner = availableDatesObj[practitionerId];
        console.log('Available dates for practitioner ' + practitionerId + ':', availableDatesForPractitioner);
        
        // Filter dates for the selected month
        const filteredDates = [];
        
        // Loop through each date object
        for (let i = 0; i < availableDatesForPractitioner.length; i++) {
            const dateObj = availableDatesForPractitioner[i];
            
            // Skip if not available
            if (!dateObj.is_available) continue;
            
            // Parse the date string
            const dateParts = dateObj.availability_date.split('-');
            const dateYear = parseInt(dateParts[0]);
            const dateMonth = parseInt(dateParts[1]) - 1; // JavaScript months are 0-indexed
            
            console.log('Checking date:', dateObj.availability_date, 'Year:', dateYear, 'Month:', dateMonth, 'Current year/month:', year, month);
            
            // Check if this date is in the current month
            if (dateYear === year && dateMonth === month) {
                filteredDates.push(dateObj.availability_date);
            }
        }
        
        console.log('Filtered dates for month:', filteredDates);
        return filteredDates;
    }
    
    // Function to update the calendar with available dates
    function updateCalendar() {
        // Get available dates for the current month being displayed
        const availableDates = getAvailableDatesForMonth(currentYear, currentMonth);
        renderCalendar(currentYear, currentMonth, availableDates);
    }

    // Initialize the calendar
    updateCalendar();

    // Force the appointment_date input to have the correct value
    // Make sure it's clean and in YYYY-MM-DD format
    let cleanLastSelectedDate = lastSelectedDate;
    if (cleanLastSelectedDate.includes(' ')) {
        cleanLastSelectedDate = cleanLastSelectedDate.split(' ')[0];
    }
    if (cleanLastSelectedDate.includes('T')) {
        cleanLastSelectedDate = cleanLastSelectedDate.split('T')[0];
    }

    document.getElementById('appointment_date').value = cleanLastSelectedDate;
    console.log('Initial appointment_date value set to:', cleanLastSelectedDate);
    
    // If we have a practitioner selected, fetch available time slots for the current date
    const practitionerId = document.getElementById('practitioner_id').value;
    if (practitionerId && lastSelectedDate) {
        fetchAvailableTimeSlots();
    }
});

function getAvailableDatesForMonth(year, month) {
    const practitionerId = document.getElementById('practitioner_id').value;
    
    console.log('Getting available dates for practitioner:', practitionerId || 'ALL');
    console.log('Available dates data structure:', availableDatesObj);
    
    // If no practitioner selected, show no available dates (user must select a raqi first)
    if (!practitionerId) {
        console.log('No practitioner selected, please select a raqi to see available dates');
        return [];
    }
    
    // Check if we have data for this practitioner
    if (!availableDatesObj[practitionerId]) {
        console.log('No availability data for practitioner:', practitionerId);
        return [];
    }
    
    // No hardcoded dates - all dates come from database
    
    // Get all dates for this practitioner
    const availableDatesForPractitioner = availableDatesObj[practitionerId];
    console.log('Available dates for practitioner ' + practitionerId + ':', availableDatesForPractitioner);
    
    // Filter dates for the selected month
    const filteredDates = [];
    
    // Loop through each date object
    for (let i = 0; i < availableDatesForPractitioner.length; i++) {
        const dateObj = availableDatesForPractitioner[i];
        
        // Skip if not available
        if (!dateObj.is_available) continue;
        
        // Parse the date string
        const dateParts = dateObj.availability_date.split('-');
        const dateYear = parseInt(dateParts[0]);
        const dateMonth = parseInt(dateParts[1]) - 1; // JavaScript months are 0-indexed
        
        console.log('Checking date:', dateObj.availability_date, 'Year:', dateYear, 'Month:', dateMonth, 'Current year/month:', year, month);
        
        // Check if this date is in the current month
        if (dateYear === year && dateMonth === month) {
            filteredDates.push(dateObj.availability_date);
        }
    }
    
    console.log('Filtered dates for month:', filteredDates);
    return filteredDates;
}

function renderCalendar(year, month, availableDates = []) {
    const calendar = document.getElementById('availability-calendar');
    const label = document.getElementById('calendar-month-label');
    calendar.innerHTML = '';
    label.textContent = new Date(year, month).toLocaleString('default', { month: 'long', year: 'numeric' });

    console.log('Rendering calendar for:', year, month);
    console.log('Available dates for this month:', availableDates);

    // Add day headers
    const dayHeaders = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    dayHeaders.forEach(day => {
        calendar.innerHTML += `<div class="text-xs font-semibold text-gray-600 p-1">${day}</div>`;
    });

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    // Fill in blanks for first week
    for (let i = 0; i < firstDay; i++) {
        calendar.innerHTML += '<div></div>';
    }

    // Get today's date
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();
    const currentDay = currentDate.getDate();
    console.log('Available dates for this month:', availableDates);
    
    for (let day = 1; day <= daysInMonth; day++) {
        // Create date in local timezone without time component to avoid timezone shifts
        const dateObj = new Date(year, month, day);
        // Format as YYYY-MM-DD ensuring consistent format
        const dateStr = `${dateObj.getFullYear()}-${String(dateObj.getMonth() + 1).padStart(2, '0')}-${String(dateObj.getDate()).padStart(2, '0')}`;
        
        // Check if this date is in the available dates array from database
        const isAvailable = availableDates.includes(dateStr);
        console.log(`Date ${dateStr}: Available = ${isAvailable}`);
        
        // Check if this is today
        const isToday = (year === currentYear && month === currentMonth && day === currentDay);
        
        let classes = 'cursor-pointer rounded p-2 text-sm font-medium transition-colors duration-200';
        if (isAvailable) {
            classes += ' bg-green-100 hover:bg-green-200 text-green-800 available-date';
            console.log(`Marking ${dateStr} as available (green)`);
        } else {
            classes += ' bg-gray-100 text-gray-400 not-available';
        }
        if (isToday) {
            classes += ' ring-2 ring-blue-500';
            console.log(`Marking ${dateStr} as today (blue ring)`);
        }
        
        // Check if this is the selected date (from the appointment)
        // Make sure we're comparing clean date strings (YYYY-MM-DD format)
        const selectedDateYMD = selectedDate.split(' ')[0].split('T')[0]; // Handle any format
        if (dateStr === selectedDateYMD) {
            classes += ' bg-indigo-500 text-white';
            console.log('Highlighting selected date in calendar:', dateStr, '(matches', selectedDateYMD, ')');
        }
        
        calendar.innerHTML += `<div data-date="${dateStr}" class="${classes}">${day}</div>`;
    }
}

// Previous month button
document.getElementById('prev-month').onclick = function() {
    if (currentMonth === 0) {
        currentMonth = 11;
        currentYear--;
    } else {
        currentMonth--;
    }
    updateCalendar();
};

// Next month button
document.getElementById('next-month').onclick = function() {
    if (currentMonth === 11) {
        currentMonth = 0;
        currentYear++;
    } else {
        currentMonth++;
    }
    updateCalendar();
};

// Click handler for calendar cells
document.getElementById('availability-calendar').addEventListener('click', function(e) {
    const cell = e.target.closest('[data-date]');
    if (!cell) return;
    
    const selectedDate = cell.getAttribute('data-date');
    console.log('Raw selected date from data-date attribute:', selectedDate);
    
    // Check if this date is available
    if (cell.classList.contains('available-date')) {
        // Clean the date to ensure it's in YYYY-MM-DD format
        let cleanSelectedDate = selectedDate;
        if (cleanSelectedDate.includes(' ')) {
            cleanSelectedDate = cleanSelectedDate.split(' ')[0];
        }
        if (cleanSelectedDate.includes('T')) {
            cleanSelectedDate = cleanSelectedDate.split('T')[0];
        }
        
        console.log('Clean selected date:', cleanSelectedDate);
        
        // Validate the date format
        const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
        if (!dateRegex.test(cleanSelectedDate)) {
            console.error('Invalid date format:', cleanSelectedDate);
            alert('Invalid date selected. Please try again.');
            return;
        }
        
        // Update global variable for form submission
        lastSelectedDate = cleanSelectedDate;
        console.log('Updated global lastSelectedDate:', lastSelectedDate);
        
        // Update the hidden input
        document.getElementById('appointment_date').value = cleanSelectedDate;
        console.log('Updated appointment_date input value:', document.getElementById('appointment_date').value);
        
        // Remove highlight from all cells
        document.querySelectorAll('#availability-calendar [data-date]').forEach(c => {
            if (c.classList.contains('available-date')) {
                c.classList.remove('bg-indigo-500', 'text-white');
                c.classList.add('bg-green-100', 'text-green-800');
            }
        });
        
        // Add strong highlight to the selected cell
        cell.classList.remove('bg-green-100', 'text-green-800');
        cell.classList.add('bg-indigo-500', 'text-white');
        
        // Show the selected date in the UI for confirmation
        let debugDisplay = document.getElementById('debug-date-display');
        if (!debugDisplay) {
            debugDisplay = document.createElement('div');
            debugDisplay.id = 'debug-date-display';
            debugDisplay.className = 'mt-2 text-sm font-medium text-indigo-600 p-2 bg-indigo-50 rounded border border-indigo-200';
            const calendarContainer = document.querySelector('#date-section');
            calendarContainer.appendChild(debugDisplay);
        }
        debugDisplay.textContent = `Selected date: ${cleanSelectedDate}`;
        
        // Fetch available time slots for this date
        fetchAvailableTimeSlots();
        } else {
            console.log('Selected date is not available');
            showTimeSlotsMessage('This date is not available for booking.');
        }
    }
};

function fetchAvailableTimeSlots() {
    const practitionerId = document.getElementById('practitioner_id').value;
    let selectedDate = document.getElementById('appointment_date').value;
    const treatmentType = document.querySelector('input[name="type"]:checked')?.value || 'ruqyah';
    
    // Clean the date to ensure it's in YYYY-MM-DD format
    if (selectedDate.includes(' ')) {
        selectedDate = selectedDate.split(' ')[0];
    }
    if (selectedDate.includes('T')) {
        selectedDate = selectedDate.split('T')[0];
    }
    
    if (!practitionerId || !selectedDate) {
        showTimeSlotsMessage('Please select a practitioner and date first');
        return;
    }
    
    console.log('Fetching time slots for:', {
        practitioner: practitionerId,
        date: selectedDate,
        type: treatmentType
    });
    
    // Update the hidden input with the clean date
    document.getElementById('appointment_date').value = selectedDate;
    
    showTimeSlotsMessage('Loading available time slots...');
    
    // Fetch available time slots from the server
    fetch(`{{ route('patient.appointments.getAvailableTimeSlots') }}?practitioner_id=${practitionerId}&date=${selectedDate}&type=${treatmentType}`)
        .then(response => response.json())
        .then(data => {
            console.log('Time slots API response:', data);
            
            if (data.available && data.slots && data.slots.length > 0) {
                // Display the time slots from the API response
                displayTimeSlots(data.slots.map(slot => slot.start));
            } else if (data.availability) {
                // Fallback to generating time slots from availability
                console.log('Using fallback availability data:', data.availability);
                const timeSlots = generateTimeSlotsFromAvailability(data.availability);
                
                if (timeSlots.length > 0) {
                    displayTimeSlots(timeSlots);
                } else {
                    showTimeSlotsMessage('No time slots available for this date.');
                }
            } else {
                console.error('No time slots available:', data.message || 'Unknown error');
                showTimeSlotsMessage(data.message || 'No time slots available for this date.');
            }
        })
        .catch(error => {
            console.error('Error fetching time slots:', error);
            showTimeSlotsMessage('Error loading time slots. Please try again.');
        });
}

function generateTimeSlotsFromAvailability(availability) {
    if (!availability || !availability.start_time || !availability.end_time || !availability.slot_duration) {
        console.error('Invalid availability data:', availability);
        return [];
    }
    
    const slots = [];
    const startTime = availability.start_time;
    const endTime = availability.end_time;
    const slotDuration = parseInt(availability.slot_duration);
    
    console.log('Generating time slots from:', {
        startTime,
        endTime,
        slotDuration
    });
    
    try {
        // Parse start and end times
        const startDate = new Date(`2000-01-01T${startTime}`);
        const endDate = new Date(`2000-01-01T${endTime}`);
        
        // Generate slots
        let currentSlot = new Date(startDate);
        
        while (currentSlot < endDate) {
            const hour = currentSlot.getHours().toString().padStart(2, '0');
            const minute = currentSlot.getMinutes().toString().padStart(2, '0');
            const timeStr = `${hour}:${minute}`;
            
            slots.push(timeStr);
            
            // Move to next slot
            currentSlot.setMinutes(currentSlot.getMinutes() + slotDuration);
        }
        
        console.log('Generated time slots:', slots);
        return slots;
    } catch (error) {
        console.error('Error generating time slots:', error);
        return [];
    }
}

function displayTimeSlots(timeSlots) {
    const container = document.getElementById('time-slots-container');
    const grid = document.getElementById('time-slots-grid');
    const message = document.getElementById('time-slots-message');
    
    if (!container || !grid || !message) return;
    
    // Hide message, show grid
    message.classList.add('hidden');
    grid.classList.remove('hidden');
    
    // Clear previous time slots
    grid.innerHTML = '';
    
    // Get current selected time slots (might be multiple, comma-separated)
    const currentSelectedTimes = document.getElementById('appointment_time').value.split(',');
    console.log('Current selected times:', currentSelectedTimes);
    
    // Add time slots to grid
    timeSlots.forEach(time => {
        const slot = document.createElement('div');
        const formattedTime = formatTimeDisplay(time);
        
        slot.className = 'available-slot border border-gray-300 rounded-lg p-2 text-center cursor-pointer hover:bg-indigo-50 transition-colors duration-200';
        slot.textContent = formattedTime;
        slot.setAttribute('data-time', time);
        
        // Check if this slot is currently selected (support for multiple selections)
        const isSelected = currentSelectedTimes.some(selectedTime => {
            // Check if the time matches exactly or if it's the first part of the time
            return time === selectedTime || 
                   (selectedTime && time === selectedTime.substring(0, 5)) ||
                   (time && selectedTime === time.substring(0, 5));
        });
        
        if (isSelected) {
            slot.classList.add('bg-indigo-500', 'text-white');
            console.log('Highlighting selected time slot:', time);
        }
        
        // Add click handler
        slot.addEventListener('click', function() {
            // Toggle selection
            this.classList.toggle('bg-indigo-500');
            this.classList.toggle('text-white');
            
            // Update hidden input with selected time slots
            updateSelectedTimeSlots();
            
            // Show visual confirmation of selection
            const selectedCount = document.querySelectorAll('.available-slot.bg-indigo-500').length;
            let selectionInfo = document.getElementById('time-selection-info');
            if (!selectionInfo) {
                selectionInfo = document.createElement('div');
                selectionInfo.id = 'time-selection-info';
                selectionInfo.className = 'mt-3 text-sm font-medium text-indigo-600';
                grid.parentNode.appendChild(selectionInfo);
            }
            selectionInfo.textContent = `${selectedCount} time slot${selectedCount !== 1 ? 's' : ''} selected`;
        });
        
        grid.appendChild(slot);
    });
    
    // Show count of initially selected slots
    const selectedCount = document.querySelectorAll('.available-slot.bg-indigo-500').length;
    if (selectedCount > 0) {
        let selectionInfo = document.getElementById('time-selection-info');
        if (!selectionInfo) {
            selectionInfo = document.createElement('div');
            selectionInfo.id = 'time-selection-info';
            selectionInfo.className = 'mt-3 text-sm font-medium text-indigo-600';
            grid.parentNode.appendChild(selectionInfo);
        }
        selectionInfo.textContent = `${selectedCount} time slot${selectedCount !== 1 ? 's' : ''} selected`;
    }
}

function updateSelectedTimeSlots() {
    const selectedSlots = [];
    document.querySelectorAll('.available-slot.bg-indigo-500').forEach(el => {
        selectedSlots.push(el.dataset.time);
    });
    
    document.getElementById('appointment_time').value = selectedSlots.join(',');
    console.log('Selected time slots:', selectedSlots);
}

function formatTimeDisplay(timeStr) {
    // Handle different time formats
    if (!timeStr) return '';
    
    // Extract hours and minutes, handling different formats
    let hours, minutes;
    if (timeStr.includes(':')) {
        [hours, minutes] = timeStr.split(':');
    } else if (timeStr.length >= 4) {
        // Handle format like "0900"
        hours = timeStr.substring(0, 2);
        minutes = timeStr.substring(2, 4);
    } else {
        console.error('Invalid time format:', timeStr);
        return timeStr; // Return as-is if we can't parse it
    }
    
    // Convert to integers
    const hour = parseInt(hours);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    const hour12 = hour % 12 || 12;
    
    // Ensure minutes has leading zero if needed
    const formattedMinutes = minutes.padStart(2, '0');
    
    return `${hour12}:${formattedMinutes} ${ampm}`;
}

function showTimeSlotsMessage(message) {
    const container = document.getElementById('time-slots-container');
    const grid = document.getElementById('time-slots-grid');
    const messageEl = document.getElementById('time-slots-message');
    
    if (!container || !grid || !messageEl) return;
    
    // Show message, hide grid
    messageEl.classList.remove('hidden');
    grid.classList.add('hidden');
    
    // Update message
    messageEl.querySelector('p').textContent = message;
}
</script>
@endsection 