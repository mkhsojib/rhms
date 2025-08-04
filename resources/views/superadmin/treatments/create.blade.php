@extends('layouts.app')

@section('title', 'Create Treatment')

@section('content_header')
    <h1>Create New Treatment</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('superadmin.treatments.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="appointment_id">Appointment *</label>
                            <select name="appointment_id" id="appointment_id" class="form-control @error('appointment_id') is-invalid @enderror" required>
                                <option value="">Select Approved Appointment</option>
                                @foreach($appointments as $appointment)
                                    <option value="{{ $appointment->id }}" {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>
                                        #{{ $appointment->appointment_no }} - {{ $appointment->patient->name }} 
                                        ({{ ucfirst($appointment->type) }}) - 
                                        {{ $appointment->formatDate('M d, Y') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('appointment_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Only approved appointments without existing treatments are shown</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="treatment_date">Treatment Date *</label>
                            <input type="date" name="treatment_date" id="treatment_date" 
                                   class="form-control @error('treatment_date') is-invalid @enderror" 
                                   value="{{ old('treatment_date', date('Y-m-d')) }}" required>
                            @error('treatment_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>



                <!-- Symptoms Section -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Symptoms Addressed</h4>
                    </div>
                    <div class="card-body">
                        <div id="symptoms-container">
                            <div class="symptom-row mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Symptom</label>
                                        <select name="symptoms[]" class="form-control symptom-select">
                                            <option value="">Select Symptom</option>
                                            @foreach($symptoms as $symptom)
                                                <option value="{{ $symptom->id }}">{{ $symptom->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Severity</label>
                                        <select name="symptom_severity[]" class="form-control">
                                            <option value="mild">Mild</option>
                                            <option value="moderate" selected>Moderate</option>
                                            <option value="severe">Severe</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Notes</label>
                                        <input type="text" name="symptom_notes[]" class="form-control" placeholder="Additional notes">
                                    </div>
                                    <div class="col-md-1">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-sm d-block remove-symptom">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-sm" id="add-symptom">
                            <i class="fas fa-plus"></i> Add Another Symptom
                        </button>
                    </div>
                </div>

                <!-- Medicines Section -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Prescribed Medicines</h4>
                    </div>
                    <div class="card-body">
                        <div id="medicines-container">
                            <div class="medicine-row mb-4 border-bottom pb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Medicine</label>
                                        <select name="medicines[]" class="form-control medicine-select">
                                            <option value="">Select Medicine</option>
                                            @foreach($medicines as $medicine)
                                                <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Dosage</label>
                                        <input type="text" name="medicine_dosage[]" class="form-control" placeholder="e.g., 500mg">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Duration (days)</label>
                                        <input type="number" name="medicine_duration[]" class="form-control" value="7" min="1">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Timing</label>
                                        <div class="form-check-inline">
                                            <input type="checkbox" name="medicine_timing[0][]" value="morning" class="form-check-input" id="morning_0">
                                            <label class="form-check-label" for="morning_0">Morning</label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input type="checkbox" name="medicine_timing[0][]" value="noon" class="form-check-input" id="noon_0">
                                            <label class="form-check-label" for="noon_0">Noon</label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input type="checkbox" name="medicine_timing[0][]" value="afternoon" class="form-check-input" id="afternoon_0">
                                            <label class="form-check-label" for="afternoon_0">Afternoon</label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input type="checkbox" name="medicine_timing[0][]" value="night" class="form-check-input" id="night_0">
                                            <label class="form-check-label" for="night_0">Night</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-sm d-block remove-medicine">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-11">
                                        <label>Special Instructions</label>
                                        <input type="text" name="medicine_instructions[]" class="form-control" placeholder="e.g., Take with food, avoid alcohol">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-sm" id="add-medicine">
                            <i class="fas fa-plus"></i> Add Another Medicine
                        </button>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <label for="notes">Treatment Notes</label>
                    <textarea name="notes" id="notes" rows="4" 
                              class="form-control @error('notes') is-invalid @enderror" 
                              placeholder="Describe the treatment procedure, observations, and recommendations">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mt-4">
                    <label for="creation_notes">Creation Notes</label>
                    <textarea name="creation_notes" id="creation_notes" rows="3" 
                              class="form-control @error('creation_notes') is-invalid @enderror" 
                              placeholder="Add any notes about the creation of this treatment record">{{ old('creation_notes') }}</textarea>
                    @error('creation_notes')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Treatment
                    </button>
                    <a href="{{ route('superadmin.treatments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Selected Appointment Details -->
    <div class="card mt-4" id="appointment-details" style="display: none;">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-info-circle"></i> Selected Appointment Details</h3>
        </div>
        <div class="card-body">
            <div id="appointment-info"></div>
        </div>
    </div>
@stop

@section('js')
<script>
$(document).ready(function() {
    let symptomIndex = 1;
    let medicineIndex = 1;

    // Add new symptom row
    $('#add-symptom').click(function() {
        const symptomRow = `
            <div class="symptom-row mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <label>Symptom</label>
                        <select name="symptoms[]" class="form-control symptom-select">
                            <option value="">Select Symptom</option>
                            @foreach($symptoms as $symptom)
                                <option value="{{ $symptom->id }}">{{ $symptom->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Severity</label>
                        <select name="symptom_severity[]" class="form-control">
                            <option value="mild">Mild</option>
                            <option value="moderate" selected>Moderate</option>
                            <option value="severe">Severe</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Notes</label>
                        <input type="text" name="symptom_notes[]" class="form-control" placeholder="Additional notes">
                    </div>
                    <div class="col-md-1">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm d-block remove-symptom">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        $('#symptoms-container').append(symptomRow);
        symptomIndex++;
    });

    // Remove symptom row
    $(document).on('click', '.remove-symptom', function() {
        if ($('.symptom-row').length > 1) {
            $(this).closest('.symptom-row').remove();
        } else {
            alert('At least one symptom is required.');
        }
    });

    // Add new medicine row
    $('#add-medicine').click(function() {
        const medicineRow = `
            <div class="medicine-row mb-4 border-bottom pb-3">
                <div class="row">
                    <div class="col-md-3">
                        <label>Medicine</label>
                        <select name="medicines[]" class="form-control medicine-select">
                            <option value="">Select Medicine</option>
                            @foreach($medicines as $medicine)
                                <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Dosage</label>
                        <input type="text" name="medicine_dosage[]" class="form-control" placeholder="e.g., 500mg">
                    </div>
                    <div class="col-md-2">
                        <label>Duration (days)</label>
                        <input type="number" name="medicine_duration[]" class="form-control" value="7" min="1">
                    </div>
                    <div class="col-md-4">
                        <label>Timing</label>
                        <div class="form-check-inline">
                            <input type="checkbox" name="medicine_timing[${medicineIndex}][]" value="morning" class="form-check-input" id="morning_${medicineIndex}">
                            <label class="form-check-label" for="morning_${medicineIndex}">Morning</label>
                        </div>
                        <div class="form-check-inline">
                            <input type="checkbox" name="medicine_timing[${medicineIndex}][]" value="noon" class="form-check-input" id="noon_${medicineIndex}">
                            <label class="form-check-label" for="noon_${medicineIndex}">Noon</label>
                        </div>
                        <div class="form-check-inline">
                            <input type="checkbox" name="medicine_timing[${medicineIndex}][]" value="afternoon" class="form-check-input" id="afternoon_${medicineIndex}">
                            <label class="form-check-label" for="afternoon_${medicineIndex}">Afternoon</label>
                        </div>
                        <div class="form-check-inline">
                            <input type="checkbox" name="medicine_timing[${medicineIndex}][]" value="night" class="form-check-input" id="night_${medicineIndex}">
                            <label class="form-check-label" for="night_${medicineIndex}">Night</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm d-block remove-medicine">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-11">
                        <label>Special Instructions</label>
                        <input type="text" name="medicine_instructions[]" class="form-control" placeholder="e.g., Take with food, avoid alcohol">
                    </div>
                </div>
            </div>
        `;
        $('#medicines-container').append(medicineRow);
        medicineIndex++;
    });

    // Remove medicine row
    $(document).on('click', '.remove-medicine', function() {
        if ($('.medicine-row').length > 1) {
            $(this).closest('.medicine-row').remove();
        } else {
            alert('At least one medicine is required.');
        }
    });

    // Show appointment details when selected
    $('#appointment_id').change(function() {
        const appointmentId = $(this).val();
        const detailsCard = $('#appointment-details');
        const infoDiv = $('#appointment-info');
        
        if (appointmentId) {
            const selectedOption = $(this).find('option:selected');
            const optionText = selectedOption.text();
            
            // Parse the appointment details from the option text
            // Format: #ID - Patient Name (Type) - Date
            const parts = optionText.split(' - ');
            if (parts.length >= 3) {
                const appointmentNumber = parts[0]; // #ID
                const patientName = parts[1]; // Patient Name
                const typeAndDate = parts[2]; // (Type) - Date
                const dateMatch = typeAndDate.match(/\) - (.+)$/);
                const appointmentDate = dateMatch ? dateMatch[1] : '';
                
                infoDiv.html(`
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Appointment Number:</strong><br>
                            <span class="text-primary">${appointmentNumber}</span>
                        </div>
                        <div class="col-md-4">
                            <strong>Patient Name:</strong><br>
                            <span class="text-info">${patientName}</span>
                        </div>
                        <div class="col-md-4">
                            <strong>Appointment Date:</strong><br>
                            <span class="text-success">${appointmentDate}</span>
                        </div>
                    </div>
                `);
            } else {
                infoDiv.html('<p><strong>Selected:</strong> ' + optionText + '</p>');
            }
            detailsCard.show();
        } else {
            detailsCard.hide();
        }
     });
});
</script>
@stop