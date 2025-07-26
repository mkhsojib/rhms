@extends('layouts.frontend')

@section('title', 'Appointment Details - Ruqyah & Hijama Center')

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
                        <h1 class="text-3xl font-bold text-white mb-2">Appointment Details</h1>
                        <p class="text-white text-opacity-90">View your appointment information</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('patient.appointments.index') }}" 
                           class="bg-gray-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-700 transition duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Appointments
                        </a>
                    </div>
                </div>
            </div>

            <!-- Appointment Details -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Details -->
                <div class="lg:col-span-2">
                    <div class="dashboard-card rounded-lg p-6 card-shadow">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">Appointment Information</h2>
                                <p class="text-sm text-gray-600 mt-1">Appointment No: <span class="font-semibold text-indigo-600">{{ $appointment->appointment_no }}</span></p>
                            </div>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                @switch($appointment->status)
                                    @case('pending')
                                        bg-yellow-100 text-yellow-800
                                        @break
                                    @case('approved')
                                        bg-green-100 text-green-800
                                        @break
                                    @case('completed')
                                        bg-blue-100 text-blue-800
                                        @break
                                    @case('rejected')
                                        bg-red-100 text-red-800
                                        @break
                                    @default
                                        bg-gray-100 text-gray-800
                                @endswitch">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>

                        <div class="space-y-6">
                            <!-- Treatment Type -->
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center
                                        {{ $appointment->type === 'ruqyah' ? 'bg-indigo-100' : 'bg-green-100' }}">
                                        <i class="fas {{ $appointment->type === 'ruqyah' ? 'fa-book-open text-indigo-600' : 'fa-hand-holding-medical text-green-600' }} text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ ucfirst($appointment->type) }} Treatment
                                    </h3>
                                    <p class="text-gray-600">
                                        @if($appointment->type === 'ruqyah')
                                            Spiritual healing through Quranic recitation and supplications
                                        @else
                                            Traditional Islamic cupping therapy for physical wellness
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Session Type -->
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-indigo-50">
                                        <i class="fas fa-layer-group text-indigo-600 text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Session Type</h3>
                                    @php
                                        $stypeName = $appointment->session_type_name ?? $appointment->sessionType->type ?? null;
                                        $stypeFee = $appointment->session_type_fee ?? $appointment->sessionType->fee ?? null;
                                        $stypeMin = $appointment->session_type_min_duration ?? $appointment->sessionType->min_duration ?? null;
                                        $stypeMax = $appointment->session_type_max_duration ?? $appointment->sessionType->max_duration ?? null;
                                    @endphp
                                    @if($appointment->type === 'hijama')
                                        {{-- Display Head Cupping pricing from appointments table --}}
                                        @if($appointment->head_cupping_fee)
                                            <div class="mb-2">
                                                <strong>Head Cupping:</strong> <span class="text-green-700 font-semibold">{{ number_format($appointment->head_cupping_fee, 2) }}</span> per cup
                                            </div>
                                        @endif
                                        
                                        {{-- Display Body Cupping pricing from appointments table --}}
                                        @if($appointment->body_cupping_fee)
                                            <div class="mb-2">
                                                <strong>Body Cupping:</strong> <span class="text-green-700 font-semibold">{{ number_format($appointment->body_cupping_fee, 2) }}</span> per cup
                                            </div>
                                        @endif
                                        
                                        {{-- Fallback if no Hijama pricing is stored --}}
                                        @if(!$appointment->head_cupping_fee && !$appointment->body_cupping_fee)
                                            <p class="text-gray-500">No Hijama pricing available</p>
                                        @endif
                                    @else
                                        @if($stypeName)
                                            <p class="text-gray-600 mb-1">
                                                <strong>{{ ucwords(str_replace('_', ' ', $stypeName)) }}</strong>
                                                @if($stypeFee)
                                                    &mdash; Fee: <span class="text-green-700">{{ $stypeFee }}</span>
                                                @endif
                                                @if($stypeMin && $stypeMax)
                                                    &mdash; Duration: <span class="text-blue-700">{{ $stypeMin }}-{{ $stypeMax }} min</span>
                                                @endif
                                            </p>
                                        @else
                                            <p class="text-gray-500">Not specified</p>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <!-- Date and Time -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar text-indigo-600 mr-3"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Appointment Date</p>
                                            <p class="text-lg font-semibold text-gray-900">
                                                {{ date('l, F d, Y', strtotime($appointment->appointment_date)) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-indigo-600 mr-3"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Appointment Time</p>
                                            <p class="text-lg font-semibold text-gray-900">
                                                @if($appointment->appointment_end_time)
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($appointment->appointment_end_time)->format('g:i A') }}
                                                @else
                                                    @php
                                                        // Fallback for existing appointments without end time
                                                        $startTime = \Carbon\Carbon::parse($appointment->appointment_time);
                                                        $endTime = $startTime->copy();
                                                        
                                                        // Get the availability record for this appointment to find the actual slot duration
                                                        $availability = \App\Models\RaqiMonthlyAvailability::where('practitioner_id', $appointment->practitioner_id)
                                                            ->where('availability_date', $appointment->appointment_date)
                                                            ->where('is_available', true)
                                                            ->first();
                                                        
                                                        if ($availability) {
                                                            // Use the actual slot duration from availability (usually 60 minutes)
                                                            $endTime->addMinutes($availability->slot_duration);
                                                        } else {
                                                            // Fallback to session duration if availability not found
                                                            if ($appointment->session_type_min_duration) {
                                                                $endTime->addMinutes($appointment->session_type_min_duration);
                                                            } elseif ($appointment->sessionType && $appointment->sessionType->min_duration) {
                                                                $endTime->addMinutes($appointment->sessionType->min_duration);
                                                            } else {
                                                                // Default to 60 minutes if no duration specified
                                                                $endTime->addMinutes(60);
                                                            }
                                                        }
                                                    @endphp
                                                    {{ $startTime->format('g:i A') }} - {{ $endTime->format('g:i A') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Symptoms/Notes -->
                            @if($appointment->symptoms)
                                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <div class="flex items-start">
                                        <i class="fas fa-notes-medical text-blue-600 mr-3 mt-1"></i>
                                        <div>
                                            <h4 class="text-sm font-medium text-blue-800 mb-2">Symptoms & Notes</h4>
                                            <p class="text-blue-700">{{ $appointment->symptoms }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Status-specific Information -->
                            @if($appointment->status === 'pending')
                                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <div class="flex items-start">
                                        <i class="fas fa-clock text-yellow-600 mr-3 mt-1"></i>
                                        <div>
                                            <h4 class="text-sm font-medium text-yellow-800 mb-2">Awaiting Approval</h4>
                                            <p class="text-yellow-700">
                                                Your appointment is pending approval from the practitioner. You will receive a notification once it's approved or if any changes are needed.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($appointment->status === 'approved')
                                <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-start">
                                        <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                                        <div>
                                            <h4 class="text-sm font-medium text-green-800 mb-2">Appointment Confirmed</h4>
                                            <p class="text-green-700">
                                                Your appointment has been approved! Please arrive 10 minutes before your scheduled time. 
                                                @if($appointment->type === 'hijama')
                                                    For Hijama treatment, please avoid eating 2-3 hours before the session.
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($appointment->status === 'completed')
                                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <div class="flex items-start">
                                        <i class="fas fa-check-double text-blue-600 mr-3 mt-1"></i>
                                        <div>
                                            <h4 class="text-sm font-medium text-blue-800 mb-2">Treatment Completed</h4>
                                            <p class="text-blue-700">
                                                Your treatment has been completed. Please follow any post-treatment instructions provided by your practitioner.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($appointment->status === 'rejected')
                                <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="flex items-start">
                                        <i class="fas fa-times-circle text-red-600 mr-3 mt-1"></i>
                                        <div>
                                            <h4 class="text-sm font-medium text-red-800 mb-2">Appointment Rejected</h4>
                                            <p class="text-red-700">
                                                Unfortunately, your appointment request has been rejected. Please contact the center for more information or book a new appointment.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

       

                    <!-- Treatment Details (if completed) -->
                    @if($appointment->status === 'completed' && $appointment->treatment)
                        <div class="dashboard-card rounded-lg p-6 card-shadow mt-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Treatment Details</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Treatment Date</p>
                                        <p class="text-lg font-semibold text-gray-900">
                                            {{ $appointment->treatment->treatment_date->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Duration</p>
                                        <p class="text-lg font-semibold text-gray-900">
                                            {{ $appointment->treatment->duration }} minutes
                                        </p>
                                    </div>
                                </div>
                                
                                @if($appointment->treatment->notes)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-2">Treatment Notes</p>
                                        <p class="text-gray-700">{{ $appointment->treatment->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($questions->count())
                        <div class="dashboard-card rounded-lg p-6 card-shadow mt-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Your Appointment Questionnaire</h3>
                            <table class="min-w-full divide-y divide-gray-200 mb-4">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Question</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Answer</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($questions as $question)
                                    <tr>
                                        <td class="px-4 py-2 text-gray-700">{{ $question->question_text }}</td>
                                        <td class="px-4 py-2">
                                            @php $answer = $answers[$question->id] ?? null; @endphp
                                            @if($answer === null || $answer === '')
                                                <span class="text-gray-400">Not answered</span>
                                            @elseif($question->input_type === 'checkbox')
                                                @foreach(json_decode($answer, true) ?? [] as $val)
                                                    <span class="inline-block bg-indigo-100 text-indigo-700 rounded px-2 py-1 mr-1 text-xs">{{ $val }}</span>
                                                @endforeach
                                            @else
                                                {{ $answer }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if($appointment->status !== 'completed')
                                <div class="flex justify-center mt-4">
                                    <a href="{{ route('patient.appointments.questions.form', $appointment) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition duration-200">
                                        Edit Answers
                                    </a>
                                </div>
                            @endif
                            <div class="flex justify-center mt-4 space-x-3">
                                <a href="{{ route('patient.appointments.questions.download', $appointment) }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition duration-200" target="_blank">
                                    <i class="fas fa-file-pdf mr-2"></i>Download Answers PDF
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Practitioner Information -->
                    <div class="dashboard-card rounded-lg p-6 card-shadow mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Practitioner</h3>
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-user-md text-indigo-600 text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">{{ $appointment->practitioner->name }}</h4>
                                <p class="text-gray-600">
                                    {{ $appointment->practitioner->specialization ?? 'Islamic Healing Practitioner' }}
                                </p>
                            </div>
                        </div>
                        
                        @if($appointment->practitioner->phone)
                            <div class="flex items-center mb-2">
                                <i class="fas fa-phone text-gray-400 mr-3"></i>
                                <span class="text-gray-700">{{ $appointment->practitioner->phone }}</span>
                            </div>
                        @endif
                        
                        @if($appointment->practitioner->email)
                            <div class="flex items-center mb-2">
                                <i class="fas fa-envelope text-gray-400 mr-3"></i>
                                <span class="text-gray-700">{{ $appointment->practitioner->email }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Quick Actions -->
                    <div class="dashboard-card rounded-lg p-6 card-shadow">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            @if($questions->count() && $appointment->status !== 'completed')
                                <a href="{{ route('patient.appointments.questions.form', $appointment) }}"
                                   class="w-full flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200">
                                    <i class="fas fa-question-circle mr-2"></i>Answer Questionnaire
                                </a>
                            @endif
                            @if($questions->count())
                                <a href="{{ route('patient.appointments.questions.download', $appointment) }}"
                                   class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200" target="_blank">
                                    <i class="fas fa-file-pdf mr-2"></i>Download Answers PDF
                                </a>
                            @endif
                            @if($appointment->invoice && $appointment->invoice->transactions()->count() > 0)
                                <a href="{{ route('patient.appointments.invoice.download', $appointment) }}"
                                   class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200" target="_blank">
                                    <i class="fas fa-file-pdf mr-2"></i>Download PDF
                                </a>
                            @endif
                            @if($appointment->status === 'pending')
                                <form action="{{ route('patient.appointments.destroy', $appointment) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to cancel this appointment? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">
                                        <i class="fas fa-times mr-2"></i>Cancel Appointment
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('patient.appointments.index') }}" 
                               class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                                <i class="fas fa-list mr-2"></i>View All Appointments
                            </a>
                            <a href="{{ route('patient.appointments.create') }}" 
                               class="w-full flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200">
                                <i class="fas fa-plus mr-2"></i>Book New Appointment
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 