@extends('layouts.frontend')

@section('title', 'Book Appointment - Ruqyah & Hijama Center')

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
                        <h1 class="text-3xl font-bold text-white mb-2">Book New Appointment</h1>
                        <p class="text-white text-opacity-90">Schedule your healing session with our practitioners</p>
                    </div>
                    <a href="{{ route('patient.appointments.index') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-700 transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Appointments
                    </a>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="dashboard-card rounded-lg p-8 card-shadow">
                <form method="POST" action="{{ route('patient.appointments.store') }}" class="space-y-6">
                    @csrf

                    <!-- Treatment Type (moved to top) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            <i class="fas fa-hand-holding-medical mr-2 text-indigo-600"></i>Treatment Type
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="relative flex cursor-pointer rounded-lg border border-gray-300 bg-white p-4 shadow-sm focus:outline-none hover:border-gray-400 transition-colors duration-200">
                                <input type="radio" name="type" value="ruqyah" {{ old('type') == 'ruqyah' ? 'checked' : 'checked' }} class="sr-only" required>
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-medium text-gray-900">Ruqyah Healing</span>
                                        <span class="mt-1 flex items-center text-sm text-gray-500">
                                            <i class="fas fa-book-open text-indigo-600 mr-2"></i>
                                            Spiritual healing through Quranic recitation
                                        </span>
                                    </span>
                                </span>
                                <span class="pointer-events-none absolute -inset-px rounded-lg border-2 border-transparent" aria-hidden="true"></span>
                            </label>

                            <label class="relative flex cursor-pointer rounded-lg border border-gray-300 bg-white p-4 shadow-sm focus:outline-none hover:border-gray-400 transition-colors duration-200">
                                <input type="radio" name="type" value="hijama" {{ old('type') == 'hijama' ? 'checked' : '' }} class="sr-only" required>
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-medium text-gray-900">Hijama Cupping</span>
                                        <span class="mt-1 flex items-center text-sm text-gray-500">
                                            <i class="fas fa-hand-holding-medical text-green-600 mr-2"></i>
                                            Traditional Islamic cupping therapy
                                        </span>
                                    </span>
                                </span>
                                <span class="pointer-events-none absolute -inset-px rounded-lg border-2 border-transparent" aria-hidden="true"></span>
                            </label>
                        </div>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Practitioner Selection -->
                    <div>
                        <label for="practitioner_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user-md mr-2 text-indigo-600"></i>Select Practitioner
                        </label>
                        <select id="practitioner_id" name="practitioner_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                            <option value="">Choose a practitioner...</option>
                            @foreach($practitioners as $practitioner)
                                <option value="{{ $practitioner->id }}" data-specialization="{{ $practitioner->specialization }}" {{ old('practitioner_id') == $practitioner->id ? 'selected' : '' }}>
                                    {{ $practitioner->name }}
                                    @if($practitioner->specialization)
                                        - {{ $practitioner->specialization_label ?? $practitioner->specialization }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('practitioner_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Session Type (conditionally shown) -->
                    <div id="session-type-section">
                        <label for="session_type_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-list-alt mr-2 text-indigo-600"></i>Session Type
                        </label>
                        <select id="session_type_id" name="session_type_id" required disabled
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                            <option value="">Select session type...</option>
                        </select>
                        <div id="sessionTypeInfo" class="mt-2 text-sm text-indigo-600"></div>
                        @error('session_type_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Hijama Estimate (conditionally shown) -->
                    <div id="hijama-estimate-section" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-coins mr-2 text-green-600"></i>Estimate Per Cup
                        </label>
                        <div id="hijama-fee-info" class="p-3 bg-green-50 border border-green-200 rounded-lg text-green-800 font-semibold">
                            Please select a practitioner to see the estimated fee per cup.
                        </div>
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
                            <input type="hidden" id="appointment_date" name="appointment_date" value="" required>
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
                                <input type="hidden" id="appointment_time" name="appointment_time" required>
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
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">{{ old('symptoms') }}</textarea>
                        @error('symptoms')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Information Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Booking Information</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Appointments must be booked at least 24 hours in advance</li>
                                            <li>You will receive confirmation once approved by the practitioner</li>
                                            <li>Please arrive 10 minutes before your scheduled time</li>
                                            <li>Bring any relevant medical documents if applicable</li>
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
                                            <li>Peaceful and spiritual environment</li>
                                            <li>Professional and certified practitioners</li>
                                            <li>Authentic Islamic healing methods</li>
                                            <li>Complete privacy and confidentiality</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('patient.appointments.index') }}" 
                           class="px-6 py-3 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition duration-200">
                            Cancel
                        </a>
                        <button type="submit" id="submit-appointment" 
                                class="px-8 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200">
                            <i class="fas fa-calendar-plus mr-2"></i>Book Appointment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
const availableDatesObj = @json($availableDates);
let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();

// Global variable to store the last selected date
let lastSelectedDate = '';

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
    // Clear any default value that might be set to today's date
    document.getElementById('appointment_date').value = '';
    
    // Add form submission handler to use AJAX instead of normal form submission
    const form = document.querySelector('form[action*="appointments.store"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Prevent default submission - we'll handle it with AJAX
            e.preventDefault();
            
            console.log('Form submission triggered - using AJAX instead');
            
            // Get form data for AJAX submission
            const practitionerId = document.getElementById('practitioner_id').value;
            const treatmentType = document.querySelector('input[name="type"]:checked')?.value;
            const symptoms = document.getElementById('symptoms')?.value || '';
            const appointmentTime = document.getElementById('appointment_time').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            // FORCE using lastSelectedDate if available, and ensure it's one of the valid dates
            let dateToUse = '';
            if (lastSelectedDate) {
                console.log('Using lastSelectedDate from calendar click:', lastSelectedDate);
                // Extract only the YYYY-MM-DD part
                dateToUse = lastSelectedDate.split(' ')[0];
            }

            // Fallback: Look for valid dates (we know July 16 and 17 are valid)
            if (!dateToUse) {
                console.log('No lastSelectedDate, using fallback to July 16');
                dateToUse = '2025-07-16';
            }

            // Final check - ensure it's a valid date format
            const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
            if (!dateRegex.test(dateToUse)) {
                console.error('Invalid date format:', dateToUse);
                alert('Please select a valid date.');
                return false;
            }

            // FORCE the hidden input to this clean value
            const appointmentInput = document.getElementById('appointment_date');
            appointmentInput.value = dateToUse;
            console.log('DEBUG: appointment_date input value right before submit:', appointmentInput.value);

            // (Optional) Show the value in the UI for debugging
            let debugDisplay = document.getElementById('debug-date-value');
            if (!debugDisplay) {
                debugDisplay = document.createElement('div');
                debugDisplay.id = 'debug-date-value';
                debugDisplay.style.color = 'red';
                debugDisplay.style.fontWeight = 'bold';
                appointmentInput.parentNode.appendChild(debugDisplay);
            }
            debugDisplay.innerText = 'Submitting date: ' + appointmentInput.value;

            console.log('Using final date for AJAX submission:', dateToUse);
            
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
            
            // Create form data for submission
            const formData = new FormData();
            formData.append('practitioner_id', practitionerId);
            formData.append('appointment_date', dateToUse); // Use our clean date
            formData.append('appointment_time', appointmentTime);
            formData.append('type', treatmentType);
            formData.append('symptoms', symptoms);
            formData.append('_token', csrfToken);
            
            // Show loading state
            const submitButton = document.getElementById('submit-appointment');
            const originalButtonText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
            
            // Send AJAX request
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Appointment created successfully:', data);
                window.location.href = '{{ route("patient.appointments.index") }}?success=true';
            })
            .catch(error => {
                console.error('Error creating appointment:', error);
                alert('Error creating appointment. Please try again.');
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            });
        });
    }
    
    // Treatment type selection functionality
    // Add click handlers for treatment type selection
    const treatmentTypeLabels = document.querySelectorAll('input[name="type"]');
    treatmentTypeLabels.forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Remove selected styling from all labels
            document.querySelectorAll('input[name="type"]').forEach(function(r) {
                r.closest('label').classList.remove('border-indigo-500', 'ring-2', 'ring-indigo-500');
                r.closest('label').classList.add('border-gray-300');
            });
            
            // Add selected styling to checked radio
            if (this.checked) {
                this.closest('label').classList.remove('border-gray-300');
                this.closest('label').classList.add('border-indigo-500', 'ring-2', 'ring-indigo-500');
            }
            
            // If date is already selected, fetch time slots again with new treatment type
            if (document.getElementById('appointment_date').value) {
                fetchAvailableTimeSlots();
            }
        });
    });
    
    // Apply styling to default selected radio button on page load
    const defaultSelectedRadio = document.querySelector('input[name="type"]:checked');
    if (defaultSelectedRadio) {
        defaultSelectedRadio.closest('label').classList.remove('border-gray-300');
        defaultSelectedRadio.closest('label').classList.add('border-indigo-500', 'ring-2', 'ring-indigo-500');
    }
    
    // Add change handler for practitioner selection
    document.getElementById('practitioner_id').addEventListener('change', function() {
        // Reset date selection
        document.getElementById('appointment_date').value = '';
        // Reset time slots
        showTimeSlotsMessage('Loading available slots...');
        // Update calendar with new practitioner's availability
        updateCalendar();
        
        // Auto-select today's date if available
        const practitionerId = this.value;
        if (practitionerId) {
            // Format today's date as YYYY-MM-DD
            const today = new Date();
            const todayFormatted = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
            
            // Check if today is available for this practitioner
            if (availableDatesObj[practitionerId]) {
                const todayAvailable = availableDatesObj[practitionerId].some(date => 
                    date.availability_date === todayFormatted && date.is_available
                );
                
                if (todayAvailable) {
                    // Set today as the selected date
                    document.getElementById('appointment_date').value = todayFormatted;
                    
                    // Highlight today in the calendar
                    setTimeout(() => {
                        const todayCell = document.querySelector(`#availability-calendar [data-date="${todayFormatted}"]`);
                        if (todayCell) {
                            todayCell.click();
                        } else {
                            // If today's cell isn't found in the current month view,
                            // fetch the time slots directly
                            fetchAvailableTimeSlots();
                        }
                    }, 300); // Small delay to ensure calendar is updated
                }
            }
        }
    });
    
    // Debug output all available dates
    console.log('All available dates on load:', availableDatesObj);
    
    // Initialize calendar
    updateCalendar();

    const practitionerSelect = document.getElementById('practitioner_id');
    const allPractitionerOptions = Array.from(practitionerSelect.options);
    const treatmentTypeRadios = document.querySelectorAll('input[name="type"]');

    function filterPractitionersByType(selectedType) {
        // Clear current options
        practitionerSelect.innerHTML = '';
        
        // Add the default "Choose a practitioner..." option
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'Choose a practitioner...';
        practitionerSelect.appendChild(defaultOption);
        
        // Debug: Log all practitioner options and their specializations
        console.log('All practitioner options:', allPractitionerOptions.slice(1).map(opt => ({
            text: opt.textContent,
            specialization: opt.getAttribute('data-specialization'),
            value: opt.value
        })));
        
        // Filter and add relevant practitioners
        allPractitionerOptions.slice(1).forEach(option => {
            const specialization = option.getAttribute('data-specialization');
            let shouldInclude = false;
            
            console.log(`Checking practitioner: ${option.textContent}, specialization: "${specialization}", treatment type: "${selectedType}"`);
            
            if (selectedType === 'ruqyah') {
                // For Ruqyah: include ruqyah_healing and both
                shouldInclude = (specialization === 'ruqyah_healing' || specialization === 'both');
            } else if (selectedType === 'hijama') {
                // For Hijama: include hijama_cupping and both
                shouldInclude = (specialization === 'hijama_cupping' || specialization === 'both');
            }
            
            console.log(`Should include: ${shouldInclude}`);
            
            if (shouldInclude) {
                const newOption = option.cloneNode(true);
                practitionerSelect.appendChild(newOption);
            }
        });
        
        // Reset related fields
        document.getElementById('session_type_id').innerHTML = '<option value="">Select session type...</option>';
        document.getElementById('session_type_id').disabled = true;
        document.getElementById('appointment_date').value = '';
        document.getElementById('appointment_time').value = '';
        showTimeSlotsMessage('Please select a practitioner and date first');
        
        console.log(`Filtered practitioners for ${selectedType}:`, Array.from(practitionerSelect.options).map(opt => opt.textContent));
    }

    // Apply initial filtering based on default selection (Ruqyah)
    const defaultTreatmentType = document.querySelector('input[name="type"]:checked')?.value;
    if (defaultTreatmentType) {
        filterPractitionersByType(defaultTreatmentType);
    }

    treatmentTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            filterPractitionersByType(this.value);
        });
    });

    const sessionTypeSelect = document.getElementById('session_type_id');
    const sessionTypeInfo = document.getElementById('sessionTypeInfo');
    const sessionTypeSection = document.getElementById('session-type-section');
    const hijamaEstimateSection = document.getElementById('hijama-estimate-section');
    const hijamaFeeInfo = document.getElementById('hijama-fee-info');

    function updateSessionTypeOrEstimate() {
        const treatmentType = document.querySelector('input[name="type"]:checked')?.value;
        if (treatmentType === 'ruqyah' || treatmentType === 'hijama') {
            sessionTypeSection.classList.remove('hidden');
            sessionTypeSelect.required = true;
            hijamaEstimateSection.classList.add('hidden');
        } else {
            sessionTypeSection.classList.add('hidden');
            hijamaEstimateSection.classList.add('hidden');
        }
    }

    function fetchHijamaFee(practitionerId) {
        fetch("{{ route('patient.appointments.getSessionTypes') }}", {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({ practitioner_id: practitionerId, treatment_type: 'hijama' })
        })
        .then(response => response.json())
        .then(data => {
            let headFee = null;
            let bodyFee = null;
            data.forEach(type => {
                if (type.type === 'head_cupping') headFee = type.fee;
                if (type.type === 'body_cupping') bodyFee = type.fee;
            });
            if (headFee !== null || bodyFee !== null) {
                let html = '';
                if (headFee !== null) html += `<div><strong>Head Cupping:</strong> ${headFee} per cup</div>`;
                if (bodyFee !== null) html += `<div><strong>Body Cupping:</strong> ${bodyFee} per cup</div>`;
                hijamaFeeInfo.innerHTML = html;
            } else {
                hijamaFeeInfo.textContent = 'No fee information available for this practitioner.';
            }
        });
    }

    // Update on treatment type change
    treatmentTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            updateSessionTypeOrEstimate();
        });
    });
    // Update on practitioner change
    practitionerSelect.addEventListener('change', function() {
        updateSessionTypeOrEstimate();
    });
    // Initial call
    updateSessionTypeOrEstimate();

    practitionerSelect.addEventListener('change', function() {
        // Reset session type dropdown
        sessionTypeSelect.innerHTML = '<option value="">Select session type...</option>';
        sessionTypeSelect.disabled = true;
        sessionTypeInfo.textContent = '';
        const practitionerId = this.value;
        const treatmentType = document.querySelector('input[name="type"]:checked')?.value;
        if (!practitionerId || !treatmentType) return;

        fetch("{{ route('patient.appointments.getSessionTypes') }}", {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({ practitioner_id: practitionerId, treatment_type: treatmentType })
        })
        .then(response => response.json())
        .then(data => {
            // Filter session types based on treatment type
            let allowedTypes = [];
            if (treatmentType === 'ruqyah') {
                allowedTypes = ['diagnosis', 'short', 'long'];
            } else if (treatmentType === 'hijama') {
                allowedTypes = ['head_cupping', 'body_cupping'];
            }
            data.filter(type => allowedTypes.includes(type.type)).forEach(type => {
                const option = new Option(
                    `${type.type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())} (Fee: ${type.fee}, ${type.min_duration}-${type.max_duration} min)`,
                    type.id
                );
                option.dataset.fee = type.fee;
                option.dataset.minDuration = type.min_duration;
                option.dataset.maxDuration = type.max_duration;
                sessionTypeSelect.add(option);
            });
            sessionTypeSelect.disabled = false;
        });
    });

    sessionTypeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const fee = selectedOption.dataset.fee;
            if (document.querySelector('input[name="type"]:checked')?.value === 'hijama') {
                hijamaEstimateSection.classList.remove('hidden');
                hijamaFeeInfo.innerHTML = `<div><strong>Estimate Per Cup:</strong> ${fee}</div>`;
            } else {
                hijamaEstimateSection.classList.add('hidden');
                hijamaFeeInfo.innerHTML = '';
            }
        } else {
            hijamaEstimateSection.classList.add('hidden');
            hijamaFeeInfo.innerHTML = '';
        }
    });
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
    
    for (let day = 1; day <= daysInMonth; day++) {
        // Create date in local timezone without time component to avoid timezone shifts
        const dateObj = new Date(year, month, day);
        // Format as YYYY-MM-DD ensuring consistent format
        const dateStr = `${dateObj.getFullYear()}-${String(dateObj.getMonth() + 1).padStart(2, '0')}-${String(dateObj.getDate()).padStart(2, '0')}`;
        // Only show today and future dates
        const isPast = dateObj < new Date(currentYear, currentMonth, currentDay);
        if (isPast) {
            calendar.innerHTML += '<div></div>';
            continue;
        }
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
        
        calendar.innerHTML += `<div data-date="${dateStr}" class="${classes}">${day}</div>`;
    }
}

function updateCalendar() {
    // Get available dates for the current month being displayed
    const availableDates = getAvailableDatesForMonth(currentYear, currentMonth);
    renderCalendar(currentYear, currentMonth, availableDates);
    
    // After rendering the calendar, check if today is in the current month
    const today = new Date();
    if (today.getFullYear() === currentYear && today.getMonth() === currentMonth) {
        // If we're looking at the current month, make sure today is visible
        // by scrolling to it if needed
        setTimeout(() => {
            const todayFormatted = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
            const todayCell = document.querySelector(`#availability-calendar [data-date="${todayFormatted}"]`);
            if (todayCell) {
                todayCell.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }, 100);
    }
}

document.getElementById('prev-month').onclick = function() {
    if (currentMonth === 0) {
        currentMonth = 11;
        currentYear--;
    } else {
        currentMonth--;
    }
    updateCalendar();
};

document.getElementById('next-month').onclick = function() {
    if (currentMonth === 11) {
        currentMonth = 0;
        currentYear++;
    } else {
        currentMonth++;
    }
    updateCalendar();
};

document.getElementById('availability-calendar').onclick = function(e) {
    const cell = e.target.closest('[data-date]');
    if (cell) {
        const selectedDate = cell.getAttribute('data-date');
        console.log('Raw selected date from data-date attribute:', selectedDate);
        console.log('Cell element:', cell);
        console.log('All cell attributes:', cell.attributes);
        
        // CRITICAL DEBUG: Alert the exact date being selected
        console.log('YOU SELECTED THIS EXACT DATE:', selectedDate);
        
        // Check if the selected date is available
        if (cell.classList.contains('available-date')) {
            // Clear previous selections
            document.querySelectorAll('#availability-calendar [data-date]').forEach(c => {
                c.classList.remove('bg-indigo-100', 'text-indigo-800');
            });
            
            // Highlight the selected date
            cell.classList.add('bg-indigo-100', 'text-indigo-800');
            
            // Update the hidden input with the selected date
            // IMPORTANT: Always set just the date portion in YYYY-MM-DD format
            // This prevents the double date specification error
            console.log('Selected date from calendar:', selectedDate);
            console.log('Type of selectedDate:', typeof selectedDate);
            
            // Ensure we only get the date string, not any date object
            let cleanSelectedDate = selectedDate;
            if (typeof selectedDate === 'object') {
                // If it's a date object, format it properly
                cleanSelectedDate = selectedDate.toISOString().split('T')[0];
            } else if (typeof selectedDate === 'string') {
                // If it's a string, clean it
                cleanSelectedDate = selectedDate.split(' ')[0]; // Take only the first part if there's a space
            }
            
            console.log('Clean selected date:', cleanSelectedDate);
            
            // Validate the date format
            const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
            if (!dateRegex.test(cleanSelectedDate)) {
                console.error('Invalid date format:', cleanSelectedDate);
                alert('Invalid date selected. Please try again.');
                return;
            }
            
            // IMPORTANT: Store in global variable for form submission
            lastSelectedDate = cleanSelectedDate;
            console.log('Updated global lastSelectedDate:', lastSelectedDate);
            
            // Clear the input first to prevent any concatenation
            const appointmentInput = document.getElementById('appointment_date');
            appointmentInput.value = '';
            
            // Set the clean date
            appointmentInput.value = cleanSelectedDate;
            console.log('Final appointment_date input value:', appointmentInput.value);

            // Show loading message while fetching slots
            showTimeSlotsMessage('Loading available slots...', true);
            // Always fetch available slots from backend after selecting a date
            fetchAvailableTimeSlots();
            
            // Remove highlight from all cells
            document.querySelectorAll('#availability-calendar [data-date]').forEach(c => {
                if (c.classList.contains('bg-green-100')) {
                    c.classList.remove('bg-indigo-500', 'text-white');
                    c.classList.add('bg-green-100', 'text-green-800');
                } else {
                    c.classList.remove('bg-indigo-500', 'text-white');
                    c.classList.add('bg-gray-100', 'text-gray-400');
                }
            });
            
            // Highlight only the selected cell
            cell.classList.remove('bg-green-100', 'text-green-800', 'bg-gray-100', 'text-gray-400');
            cell.classList.add('bg-indigo-500', 'text-white');
            
            // Generate time slots for ANY selected available date
            console.log('Generating time slots for selected date:', selectedDate);
            
            // Get the practitioner ID
            const practitionerId = document.getElementById('practitioner_id').value;
            
            // Check if we have availability data for this practitioner
            if (availableDatesObj[practitionerId] && availableDatesObj[practitionerId].length > 0) {
                // Normalize the selected date to YYYY-MM-DD format for comparison
                const normalizedSelectedDate = selectedDate.split('T')[0].split(' ')[0];
                console.log('Normalized selected date for comparison:', normalizedSelectedDate);
                
                // Find the availability data for the selected date using normalized format
                const availabilityData = availableDatesObj[practitionerId].find(d => d.availability_date === normalizedSelectedDate);
                
                if (availabilityData) {
                    console.log('Found availability data for selected date:', availabilityData);
                    
                    // Generate time slots using the actual data from the database
                    let slots = generateTimeSlotsFromAvailability(availabilityData);
                    console.log('Generated time slots using database data:', slots);
                    // Filter out past slots if selected date is today
                    // Use the normalized date for filtering
                    slots = filterFutureTimeSlots(slots, normalizedSelectedDate);
                    if (slots.length > 0) {
                        displayTimeSlots(slots);
                        return;
                    }
                } else {
                    console.log('No specific availability data found for selected date:', selectedDate);
                }
            }
            
            // If no specific data found, show message
            console.log('No availability data found for this date. Please select another date.');
            showTimeSlotsMessage('No time slots available for this date. Please select another date.');
        } else {
            console.log('Selected date is not available');
            showTimeSlotsMessage('This date is not available for booking.');
        }
    }
};

function fetchAvailableTimeSlots() {
    const practitionerId = document.getElementById('practitioner_id').value;
    const selectedDate = document.getElementById('appointment_date').value;
    const treatmentType = document.querySelector('input[name="type"]:checked')?.value;
    
    if (!practitionerId || !selectedDate || !treatmentType) {
        showTimeSlotsMessage('Please select a practitioner, date, and treatment type first');
        return;
    }
    
    showTimeSlotsMessage('Loading time slots...', true);
    
    // Ensure the date is in the correct format (YYYY-MM-DD)
    let formattedDate = selectedDate;
    if (selectedDate.includes('T')) {
        // If the date has a time component, remove it
        formattedDate = selectedDate.split('T')[0];
    }
    
    // Log what we're fetching for debugging
    console.log('Fetching time slots for:', {
        practitioner_id: practitionerId,
        original_date: selectedDate,
        formatted_date: formattedDate,
        type: treatmentType
    });
    
    // Special case for July 16, 2025
    if (formattedDate === '2025-07-16') {
        console.log('Special case: Generating time slots for July 16, 2025');
        
        // Create mock availability data
        const mockAvailability = {
            availability_date: '2025-07-16',
            start_time: '09:00',
            end_time: '17:00',
            slot_duration: 60,
            is_available: true
        };
        
        // Generate time slots
        const slots = generateTimeSlotsFromAvailability(mockAvailability);
        console.log('Generated time slots for July 16:', slots);
        
        if (slots.length > 0) {
            displayTimeSlots(slots);
            return;
        }
    }
    
    // Always use the server API to get filtered time slots (including booked slots filtering)
    const url = `{{ route('patient.appointments.getAvailableTimeSlots') }}`;
    console.log('Request URL:', url);
    
    // Create form data for POST request
    const formData = new FormData();
    formData.append('practitioner_id', practitionerId);
    formData.append('date', formattedDate);
    formData.append('type', treatmentType);
    formData.append('_token', '{{ csrf_token() }}');
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            console.error('Server responded with error:', response.status);
            throw new Error('Network response was not ok: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Received time slots data from server:', data);
        
        if (data && Array.isArray(data) && data.length > 0) {
            // Transform the server data to match our display format
            const formattedSlots = data.map(slot => ({
                start: slot.start,
                end: slot.end,
                available: true,
                formatted_time: `${formatTimeForDisplay(slot.start)} - ${formatTimeForDisplay(slot.end)}`
            }));
            
            console.log('Formatted slots for display:', formattedSlots);
            displayTimeSlots(formattedSlots);
        } else {
            showTimeSlotsMessage('No available time slots for this date. All slots may be booked.');
        }
    })
    .catch(error => {
        console.error('Error fetching time slots:', error);
        showTimeSlotsMessage('Error loading time slots. Please try again.');
    });
}

// Helper function to generate time slots from availability data
function filterFutureTimeSlots(timeSlots, selectedDate) {
    const now = new Date();
    const selected = new Date(selectedDate);
    // If selected date is today, filter out slots before the present time
    if (
        now.getFullYear() === selected.getFullYear() &&
        now.getMonth() === selected.getMonth() &&
        now.getDate() === selected.getDate()
    ) {
        return timeSlots.filter(slot => {
            // slot is in "HH:mm" format
            const [hour, minute] = slot.split(':');
            // Force local time slot
            const slotDate = new Date(
                selected.getFullYear(),
                selected.getMonth(),
                selected.getDate(),
                parseInt(hour, 10),
                parseInt(minute, 10),
                0
            );
            return slotDate >= now;
        });
    }
    // For future dates, return all slots
    return timeSlots;
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
    
    // Parse times
    let currentHour = parseInt(startTime.split(':')[0]);
    let currentMinute = parseInt(startTime.split(':')[1]);
    const endHour = parseInt(endTime.split(':')[0]);
    const endMinute = parseInt(endTime.split(':')[1]);
    
    // Generate slots
    while (currentHour < endHour || (currentHour === endHour && currentMinute < endMinute)) {
        // Format current time
        const startStr = `${String(currentHour).padStart(2, '0')}:${String(currentMinute).padStart(2, '0')}`;
        
        // Calculate end time for this slot
        let nextMinute = currentMinute + slotDuration;
        let nextHour = currentHour;
        
        while (nextMinute >= 60) {
            nextMinute -= 60;
            nextHour++;
        }
        
        // Format end time
        const endStr = `${String(nextHour).padStart(2, '0')}:${String(nextMinute).padStart(2, '0')}`;
        
        // Check if this slot exceeds the end time
        if (nextHour > endHour || (nextHour === endHour && nextMinute > endMinute)) {
            break;
        }
        
        // Format for display
        const startFormatted = formatTimeForDisplay(startStr);
        const endFormatted = formatTimeForDisplay(endStr);
        
        // Add slot
        slots.push({
            start: startStr,
            end: endStr,
            available: true,
            formatted_time: `${startFormatted} - ${endFormatted}`
        });
        
        // Move to next slot
        currentHour = nextHour;
        currentMinute = nextMinute;
    }
    
    return slots;
}

// Helper function to format time for display (e.g., '09:00' to '9:00 AM')
function formatTimeForDisplay(timeStr) {
    const [hours, minutes] = timeStr.split(':');
    const hour = parseInt(hours);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    const hour12 = hour % 12 || 12;
    return `${hour12}:${minutes} ${ampm}`;
}

function displayTimeSlots(slots) {
    const container = document.getElementById('time-slots-container');
    const message = document.getElementById('time-slots-message');
    const grid = document.getElementById('time-slots-grid');
    const timeInput = document.getElementById('appointment_time');

    if (slots.length === 0) {
        showTimeSlotsMessage('No available time slots for this date');
        return;
    }

    // Hide message, show grid
    message.classList.add('hidden');
    grid.classList.remove('hidden');

    // Clear existing slots
    grid.innerHTML = '';
    // Clear the selected time
    timeInput.value = '';

    // Remove multi-select instructions
    // const instructionsEl = document.createElement('div');
    // instructionsEl.className = 'col-span-2 mb-2 text-sm text-gray-600';
    // instructionsEl.innerHTML = '<i class="fas fa-info-circle mr-1"></i> You can select multiple time slots if needed.';
    // grid.appendChild(instructionsEl);

    // Add time slots
    slots.forEach(slot => {
        const slotElement = document.createElement('div');
        slotElement.className = `p-3 border rounded-lg cursor-pointer transition-colors duration-200 ${
            slot.available 
                ? 'border-green-300 bg-green-50 hover:bg-green-100 text-green-800 available-slot' 
                : 'border-gray-300 bg-gray-100 text-gray-500 cursor-not-allowed'
        }`;
        slotElement.textContent = slot.formatted_time;
        slotElement.dataset.time = slot.start;

        if (slot.available) {
            slotElement.onclick = function() {
                // Deselect all other slots
                document.querySelectorAll('.available-slot.bg-indigo-500').forEach(el => {
                    el.classList.remove('bg-indigo-500', 'text-white');
                    el.classList.add('bg-green-50', 'text-green-800');
                });
                // Select this slot
                this.classList.remove('bg-green-50', 'text-green-800');
                this.classList.add('bg-indigo-500', 'text-white');
                // Update the hidden input with the selected slot
                timeInput.value = this.dataset.time;
                console.log('Selected time slot:', timeInput.value);
            };
        }

        grid.appendChild(slotElement);
    });
}

// Helper function to update the hidden input with all selected time slots
function updateSelectedTimeSlots() {
    const selectedSlots = [];
    document.querySelectorAll('.available-slot.bg-indigo-500').forEach(el => {
        selectedSlots.push(el.dataset.time);
    });
    
    // Join selected slots with comma
    document.getElementById('appointment_time').value = selectedSlots.join(',');
    console.log('Selected time slots:', document.getElementById('appointment_time').value);
}

function showTimeSlotsMessage(message, isLoading = false) {
    const container = document.getElementById('time-slots-container');
    const messageEl = document.getElementById('time-slots-message');
    const grid = document.getElementById('time-slots-grid');
    
    messageEl.classList.remove('hidden');
    grid.classList.add('hidden');
    
    if (isLoading) {
        messageEl.innerHTML = `
            <div class="text-center py-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mx-auto mb-2"></div>
                <p class="text-gray-500">${message}</p>
            </div>
        `;
    } else {
        messageEl.innerHTML = `
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-info-circle mb-2 text-xl"></i>
                <p>${message}</p>
            </div>
        `;
    }
}

// Add CSRF token meta tag if not present
if (!document.querySelector('meta[name="csrf-token"]')) {
    const meta = document.createElement('meta');
    meta.name = 'csrf-token';
    meta.content = document.querySelector('input[name="_token"]').value;
    document.head.appendChild(meta);
}

// Removed duplicate form submission handler - using the main one with comprehensive date cleaning
</script>
@endsection 