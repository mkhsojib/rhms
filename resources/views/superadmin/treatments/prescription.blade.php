<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Prescription - Treatment #{{ $treatment->id }}</title>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; padding: 10px; }
            .prescription-container { box-shadow: none; }
        }
        
        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.4;
            color: #000;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        
        .prescription-container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            border: 2px solid #000;
            min-height: 297mm;
        }
        
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1000;
        }
        
        .print-btn:hover {
            background: #0056b3;
        }
        
        /* Header Section */
        .prescription-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
            border-bottom: 2px solid #000;
        }
        
        .doctor-info {
            flex: 1;
        }
        
        .doctor-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .doctor-qualification {
            font-size: 14px;
            margin-bottom: 3px;
        }
        
        .doctor-reg {
            font-size: 12px;
            color: #666;
        }
        
        .medical-symbol {
            text-align: center;
            margin: 0 20px;
        }
        
        .caduceus {
            font-size: 40px;
            color: #0066cc;
        }
        
        .clinic-info {
            flex: 1;
            text-align: right;
        }
        
        .clinic-name {
            font-size: 18px;
            font-weight: bold;
            color: #0066cc;
            margin-bottom: 5px;
        }
        
        .clinic-address {
            font-size: 12px;
            line-height: 1.3;
            margin-bottom: 10px;
        }
        
        .clinic-contact {
            font-size: 11px;
            line-height: 1.3;
        }
        
        /* Patient Info Section */
        .patient-section {
            padding: 15px 20px;
            border-bottom: 1px solid #ccc;
        }
        
        .date-section {
            text-align: right;
            margin-bottom: 10px;
            font-size: 12px;
        }
        
        .patient-details {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            font-size: 12px;
        }
        
        .patient-item {
            margin-right: 30px;
        }
        
        .patient-label {
            font-weight: bold;
        }
        
        /* Main Content */
        .prescription-content {
            padding: 20px;
        }
        
        .content-section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ccc;
        }
        
        .complaints-section {
            display: flex;
            gap: 40px;
        }
        
        .chief-complaints, .clinical-findings {
            flex: 1;
        }
        
        .complaint-list, .finding-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .complaint-list li, .finding-list li {
            margin-bottom: 5px;
            font-size: 12px;
        }
        
        .complaint-list li:before {
            content: "• ";
            font-weight: bold;
        }
        
        .finding-list li:before {
            content: "• ";
            font-weight: bold;
        }
        
        .diagnosis-section {
            margin: 20px 0;
        }
        
        .diagnosis-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .diagnosis-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .diagnosis-list li {
            font-size: 12px;
            margin-bottom: 3px;
        }
        
        .diagnosis-list li:before {
            content: "• ";
            font-weight: bold;
        }
        
        /* Medicine Table */
        .medicine-section {
            margin: 20px 0;
        }
        
        .medicine-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .medicine-table th {
            background: #f8f9fa;
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
        }
        
        .medicine-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 11px;
            vertical-align: top;
        }
        
        .medicine-name {
            font-weight: bold;
        }
        
        .medicine-composition {
            font-size: 10px;
            color: #666;
            font-style: italic;
        }
        
        /* Advice Section */
        .advice-section {
            margin: 20px 0;
        }
        
        .advice-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .advice-list li {
            margin-bottom: 5px;
            font-size: 12px;
        }
        
        .advice-list li:before {
            content: "• ";
            font-weight: bold;
        }
        
        /* Follow-up */
        .followup-section {
            margin: 20px 0;
            font-size: 12px;
        }
        
        .followup-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        /* Footer */
        .prescription-footer {
            position: absolute;
            bottom: 20px;
            right: 20px;
            text-align: center;
            font-size: 10px;
        }
        
        .signature-line {
            width: 200px;
            border-bottom: 1px solid #000;
            margin: 20px auto 5px;
        }
        
        .footer-note {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 10px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <button class="print-btn no-print" onclick="printPrescription()">🖨️ Print Prescription</button>
    
    <div class="prescription-container">
        <!-- Header -->
        <div class="prescription-header">
            <div class="doctor-info">
                <div class="doctor-name">{{ $treatment->appointment->practitioner->name }}</div>
                <div class="doctor-qualification">Islamic Medicine Practitioner</div>
                <div class="doctor-reg">Reg. No: {{ $treatment->appointment->practitioner->license_number ?? 'RHMS-' . str_pad($treatment->appointment->practitioner->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
            
            <div class="medical-symbol">
                <div class="caduceus">⚕️</div>
            </div>
            
            <div class="clinic-info">
                <div class="clinic-name">RHMS Clinic</div>
                <div class="clinic-address">
                    Ruqyah & Hijama Medical Center<br>
                    Islamic Healthcare Services<br>
                    - Wellness Through Faith -
                </div>
                <div class="clinic-contact">
                    Ph: +1234567890, Timing: 09:00 AM -<br>
                    01:00 PM, 06:00 PM - 08:00 PM |<br>
                    Closed: Sunday
                </div>
            </div>
        </div>
        
        <!-- Patient Info -->
        <div class="patient-section">
            <div class="date-section">
                <strong>Date:</strong> {{ $treatment->created_at->format('d-M-Y') }}
            </div>
            
            <div class="patient-details">
                <div class="patient-item">
                    <span class="patient-label">ID:</span> {{ $treatment->appointment->patient->id }} - {{ strtoupper($treatment->appointment->patient->name) }} ({{ strtoupper(substr($treatment->appointment->patient->gender, 0, 1)) }}) / {{ $treatment->appointment->patient->age ?? 'N/A' }} Y
                </div>
                <div class="patient-item">
                    <span class="patient-label">Mob. No.:</span> {{ $treatment->appointment->patient->phone ?? 'N/A' }}
                </div>
            </div>
            
            <div class="patient-details" style="margin-top: 5px;">
                <div class="patient-item">
                    <span class="patient-label">Address:</span> {{ $treatment->appointment->patient->address ?? 'N/A' }}
                </div>
            </div>
            
            <div class="patient-details" style="margin-top: 5px;">
                <div class="patient-item">
                    <span class="patient-label">Weight (Kg):</span> {{ $treatment->appointment->patient->weight ?? 'N/A' }}, 
                    <span class="patient-label">Height (Cm):</span> {{ $treatment->appointment->patient->height ?? 'N/A' }} 
                    (B.M.I. = {{ $treatment->appointment->patient->weight && $treatment->appointment->patient->height ? number_format(($treatment->appointment->patient->weight / (($treatment->appointment->patient->height/100) * ($treatment->appointment->patient->height/100))), 2) : 'N/A' }}), 
                    <span class="patient-label">BP:</span> {{ $treatment->appointment->patient->blood_pressure ?? 'N/A' }}
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="prescription-content">
            <!-- Chief Complaints and Clinical Findings -->
            <div class="complaints-section">
                <div class="chief-complaints">
                    <div class="section-title">Chief Complaints</div>
                    <ul class="complaint-list">
                        @if(count($patientQuestionnaire) > 0)
                            @foreach($patientQuestionnaire as $qa)
                                <li>{{ strtoupper($qa['answer']) }}</li>
                            @endforeach
                        @else
                            <li>GENERAL CONSULTATION</li>
                        @endif
                    </ul>
                </div>
                
                <div class="clinical-findings">
                    <div class="section-title">Clinical Findings</div>
                    <ul class="finding-list">
                        @if($treatment->symptoms->count() > 0)
                            @foreach($treatment->symptoms as $symptom)
                                <li>{{ strtoupper($symptom->name) }} ({{ strtoupper($symptom->pivot->severity) }})</li>
                            @endforeach
                        @else
                            <li>CLINICAL EXAMINATION FINDINGS</li>
                            <li>ASSESSMENT AND EVALUATION</li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <!-- Diagnosis -->
            <div class="diagnosis-section">
                <div class="diagnosis-title">Diagnosis:</div>
                <ul class="diagnosis-list">
                    @if($treatment->appointment->type === 'ruqyah')
                        <li>SPIRITUAL AILMENT REQUIRING RUQYAH TREATMENT</li>
                    @elseif($treatment->appointment->type === 'hijama')
                        <li>CONDITION REQUIRING HIJAMA THERAPY</li>
                    @else
                        <li>GENERAL ISLAMIC MEDICAL CONSULTATION</li>
                    @endif
                </ul>
            </div>
            
            <!-- Medicines -->
            @if($treatment->medicines->count() > 0)
            <div class="medicine-section">
                <div class="section-title">Medicine Prescription</div>
                <table class="medicine-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;"></th>
                            <th style="width: 35%;">Medicine Name</th>
                            <th style="width: 25%;">Dosage</th>
                            <th style="width: 35%;">Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($treatment->medicines as $index => $medicine)
                        <tr>
                            <td>{{ $index + 1 }})</td>
                            <td>
                                <div class="medicine-name">{{ strtoupper($medicine->name) }}</div>
                                @if($medicine->composition)
                                <div class="medicine-composition">{{ $medicine->composition }}</div>
                                @endif
                            </td>
                            <td>{{ $medicine->pivot->dosage ?? '1 Morning' }}</td>
                            <td>
                                {{ $medicine->pivot->duration ?? '7 Days' }}
                                @if($medicine->pivot->total_quantity)
                                <br>(Tot: {{ $medicine->pivot->total_quantity }})
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            
            <!-- Advice -->
            <div class="advice-section">
                <div class="section-title">Advice:</div>
                <ul class="advice-list">
                    @if($treatment->notes)
                        <li>{{ strtoupper($treatment->notes) }}</li>
                    @endif
                    <li>MAINTAIN REGULAR PRAYERS AND QURAN RECITATION</li>
                    <li>FOLLOW ISLAMIC DIETARY GUIDELINES</li>
                    @if($treatment->appointment->type === 'hijama')
                        <li>KEEP HIJAMA SITES CLEAN AND DRY FOR 24 HOURS</li>
                        <li>AVOID HEAVY PHYSICAL ACTIVITY FOR 24-48 HOURS</li>
                    @endif
                    @if($treatment->prescription)
                        <li>{{ strtoupper($treatment->prescription) }}</li>
                    @endif
                </ul>
            </div>
            
            <!-- Follow Up -->
            <div class="followup-section">
                <div class="followup-title">Follow Up: {{ now()->addDays(7)->format('d-m-Y') }}</div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="prescription-footer">
            <div class="signature-line"></div>
            <div>Doctor's Signature</div>
        </div>
        
        <div class="footer-note">
            Substitute with equivalent Generics as required.
        </div>
    </div>
    
    <script>
    function printPrescription() {
        window.print();
    }
    </script>
</body>
</html>