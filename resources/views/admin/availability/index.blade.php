@extends('layouts.app')

@section('title', 'Manage Availability')

@section('content_header')
    <h1>Manage Availability</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Your Availability Calendar</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.availability.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Set New Availability
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> You can set your availability for the next 30 days. Patients will only be able to book appointments on days you've marked as available.
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Time Range</th>
                                    <th>Slot Duration</th>
                                    <th>Appointments</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($availabilities as $availability)
                                    <tr>
                                        <td>
                                            <strong>{{ $availability->availability_date->format('D, M d, Y') }}</strong>
                                        </td>
                                        <td>
                                            @if($availability->is_available)
                                                <span class="badge badge-success">Available</span>
                                            @else
                                                <span class="badge badge-danger">Not Available</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($availability->start_time)->format('h:i A') }} - 
                                            {{ \Carbon\Carbon::parse($availability->end_time)->format('h:i A') }}
                                        </td>
                                        <td>
                                            {{ $availability->slot_duration }} minutes
                                        </td>
                                        <td>
                                            @php
                                                $dateKey = $availability->availability_date->format('Y-m-d');
                                                $appointmentCount = isset($appointments[$dateKey]) ? count($appointments[$dateKey]) : 0;
                                            @endphp
                                            
                                            @if($appointmentCount > 0)
                                                <span class="badge badge-info">{{ $appointmentCount }} booked</span>
                                            @else
                                                <span class="badge badge-secondary">No appointments</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ Str::limit($availability->notes, 30) ?? 'No notes' }}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.availability.edit', $availability) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if(!isset($appointments[$availability->availability_date->format('Y-m-d')]) || count($appointments[$availability->availability_date->format('Y-m-d')]) === 0)
                                                    <form action="{{ route('admin.availability.destroy', $availability) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this availability?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <p class="my-3">You haven't set any availability for the next 30 days.</p>
                                            <a href="{{ route('admin.availability.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Set Your Availability
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Calendar View</h3>
                </div>
                <div class="card-body">
                    <div id="availability-calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.0/main.min.css">
<style>
    .fc-event-available {
        background-color: #28a745;
        border-color: #28a745;
    }
    .fc-event-unavailable {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .fc-event-booked {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
</style>
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.0/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
        
        // Initialize FullCalendar
        var calendarEl = document.getElementById('availability-calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            events: [
                @foreach($availabilities as $availability)
                {
                    title: '{{ $availability->is_available ? "Available" : "Not Available" }}',
                    start: '{{ $availability->availability_date->format("Y-m-d") }}',
                    classNames: ['fc-event-{{ $availability->is_available ? "available" : "unavailable" }}'],
                    extendedProps: {
                        startTime: '{{ \Carbon\Carbon::parse($availability->start_time)->format("h:i A") }}',
                        endTime: '{{ \Carbon\Carbon::parse($availability->end_time)->format("h:i A") }}',
                        slotDuration: '{{ $availability->slot_duration }} minutes'
                    }
                },
                @endforeach
                
                @foreach($appointments as $date => $dateAppointments)
                    @foreach($dateAppointments as $appointment)
                    {
                        title: 'Booked: {{ $appointment->type }}',
                        start: '{{ $date }}T{{ $appointment->appointment_time }}',
                        classNames: ['fc-event-booked'],
                        extendedProps: {
                            patientName: '{{ $appointment->user ? $appointment->user->name : 'No Patient' }}',
                            appointmentType: '{{ $appointment->type }}',
                            status: '{{ $appointment->status }}'
                        }
                    },
                    @endforeach
                @endforeach
            ],
            eventClick: function(info) {
                let eventDetails = '';
                
                if (info.event.classNames.includes('fc-event-booked')) {
                    eventDetails = `
                        <p><strong>Patient:</strong> ${info.event.extendedProps.patientName}</p>
                        <p><strong>Type:</strong> ${info.event.extendedProps.appointmentType}</p>
                        <p><strong>Status:</strong> ${info.event.extendedProps.status}</p>
                    `;
                } else {
                    eventDetails = `
                        <p><strong>Time:</strong> ${info.event.extendedProps.startTime} - ${info.event.extendedProps.endTime}</p>
                        <p><strong>Slot Duration:</strong> ${info.event.extendedProps.slotDuration}</p>
                    `;
                }
                
                // You can use a modal or tooltip to show this information
                alert(info.event.title + '\n\n' + eventDetails);
            }
        });
        
        calendar.render();
    });
</script>
@stop
