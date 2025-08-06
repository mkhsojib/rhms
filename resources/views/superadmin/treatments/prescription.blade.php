<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Prescription - {{ $treatment->appointment->practitioner->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
            padding: 20px;
        }

        .prescription-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .clinic-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .clinic-details h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .clinic-details .subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .clinic-contact {
            font-size: 12px;
            opacity: 0.9;
            line-height: 1.4;
        }

        .medical-symbol {
            font-size: 48px;
            opacity: 0.8;
        }

        .doctor-info {
            background: rgba(255, 255, 255, 0.15);
            padding: 15px;
            border-radius: 8px;
            backdrop-filter: blur(10px);
        }

        .doctor-info h2 {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .doctor-info .credentials {
            font-size: 14px;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .patient-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #667eea;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .patient-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .patient-item {
            display: flex;
            flex-direction: column;
        }

        .patient-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .patient-value {
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }

        .symptoms-section, .medicines-section {
            margin-bottom: 25px;
        }

        .symptoms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .symptom-card {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 8px;
            padding: 15px;
        }

        .symptom-name {
            font-weight: 600;
            color: #c53030;
            margin-bottom: 5px;
        }

        .symptom-severity {
            font-size: 12px;
            background: #c53030;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 8px;
        }

        .symptom-notes {
            font-size: 13px;
            color: #666;
            font-style: italic;
        }

        .medicines-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .medicines-table th {
            background: #667eea;
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        .medicines-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
        }

        .medicines-table tr:hover {
            background: #f7fafc;
        }

        .medicine-name {
            font-weight: 600;
            color: #2d3748;
        }

        .timing-badges {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .timing-badge {
            background: #e6fffa;
            color: #234e52;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }

        .notes-section {
            background: #f0fff4;
            border: 1px solid #9ae6b4;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .notes-content {
            font-size: 14px;
            line-height: 1.6;
            color: #2f855a;
        }

        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #666;
        }

        .prescription-date {
            font-weight: 600;
        }

        .signature-section {
            text-align: right;
        }

        .signature-line {
            border-top: 1px solid #ccc;
            width: 200px;
            margin: 20px 0 5px auto;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .prescription-container {
                box-shadow: none;
                border-radius: 0;
            }
        }

        .questionnaire-section {
            margin-bottom: 25px;
        }

        .questionnaire-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
        }

        .questionnaire-item {
            background: #fefefe;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
        }

        .question-text {
            font-size: 13px;
            color: #4a5568;
            margin-bottom: 5px;
        }

        .answer-text {
            font-size: 14px;
            font-weight: 500;
            color: #2d3748;
        }
    </style>
</head>
<body>
    <div class="prescription-container">
        <!-- Header Section -->
        <div class="header">
            <div class="clinic-info">
                <div class="clinic-details">
                    <h1>{{ \App\Models\Setting::getValue('site_name', 'Ruqyah & Hijama Management System') }}</h1>
                    <div class="subtitle">{{ \App\Models\Setting::getValue('site_tagline', 'Comprehensive Healthcare Services') }}</div>
                    <div class="clinic-contact">
                        📍 {{ \App\Models\Setting::getValue('contact_address', '123 Health Street, Medical District, City 12345') }}<br>
                        📞 {{ \App\Models\Setting::getValue('contact_phone', '+1 (555) 123-4567') }} | 📧 {{ \App\Models\Setting::getValue('contact_email', 'info@wellnessmedical.com') }}<br>
                        🌐 {{ \App\Models\Setting::getValue('site_name', 'www.wellnessmedical.com') }}
                    </div>
                </div>
                <div class="medical-symbol">⚕️</div>
            </div>
            
            <div class="doctor-info">
                <h2>Dr. {{ $treatment->appointment->practitioner->name }}</h2>
                <div class="credentials">M.B.B.S., M.D. | Reg. No: AMC-{{ str_pad($treatment->appointment->practitioner->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content">
            <!-- Patient Information -->
            <div class="patient-section">
                <h3 class="section-title">Patient Information</h3>
                <div class="patient-grid">
                    <div class="patient-item">
                        <div class="patient-label">Patient Name</div>
                        <div class="patient-value">{{ $treatment->appointment->patient->name }}</div>
                    </div>
                    <div class="patient-item">
                        <div class="patient-label">Patient ID</div>
                        <div class="patient-value">#{{ str_pad($treatment->appointment->patient->id, 6, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="patient-item">
                        <div class="patient-label">Age</div>
                        <div class="patient-value">{{ $treatment->appointment->patient->age ?? 'N/A' }} years</div>
                    </div>
                    <div class="patient-item">
                        <div class="patient-label">Gender</div>
                        <div class="patient-value">{{ ucfirst($treatment->appointment->patient->gender ?? 'N/A') }}</div>
                    </div>
                    <div class="patient-item">
                        <div class="patient-label">Contact</div>
                        <div class="patient-value">{{ $treatment->appointment->patient->phone ?? 'N/A' }}</div>
                    </div>
                    <div class="patient-item">
                        <div class="patient-label">Treatment Date</div>
                        <div class="patient-value">{{ $treatment->treatment_date ? \Carbon\Carbon::parse($treatment->treatment_date)->format('d M Y') : 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <!-- Patient Questionnaire -->
            @if(!empty($patientQuestionnaire))
            <div class="questionnaire-section">
                <h3 class="section-title">Patient Assessment</h3>
                <div class="questionnaire-grid">
                    @foreach($patientQuestionnaire as $qa)
                    <div class="questionnaire-item">
                        <div class="question-text">{{ $qa['question'] }}</div>
                        <div class="answer-text">{{ $qa['answer'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Symptoms/Chief Complaints -->
            @if($treatment->symptoms->count() > 0)
            <div class="symptoms-section">
                <h3 class="section-title">Chief Complaints & Symptoms</h3>
                <div class="symptoms-grid">
                    @foreach($treatment->symptoms as $symptom)
                    <div class="symptom-card">
                        <div class="symptom-name">{{ $symptom->name }}</div>
                        <div class="symptom-severity">{{ ucfirst($symptom->pivot->severity ?? 'moderate') }}</div>
                        @if($symptom->pivot->notes)
                        <div class="symptom-notes">{{ $symptom->pivot->notes }}</div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Prescription/Medicines -->
            @if($treatment->medicines->count() > 0)
            <div class="medicines-section">
                <h3 class="section-title">Prescription</h3>
                <table class="medicines-table">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Dosage</th>
                            <th>Timing</th>
                            <th>Duration</th>
                            <th>Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($treatment->medicines as $medicine)
                        <tr>
                            <td>
                                <div class="medicine-name">{{ $medicine->name }}</div>
                                @if($medicine->generic_name)
                                <div style="font-size: 11px; color: #666;">{{ $medicine->generic_name }}</div>
                                @endif
                            </td>
                            <td>{{ $medicine->pivot->dosage ?? 'As directed' }}</td>
                            <td>
                                <div class="timing-badges">
                                    @if($medicine->pivot->morning)
                                    <span class="timing-badge">Morning</span>
                                    @endif
                                    @if($medicine->pivot->noon)
                                    <span class="timing-badge">Noon</span>
                                    @endif
                                    @if($medicine->pivot->afternoon)
                                    <span class="timing-badge">Afternoon</span>
                                    @endif
                                    @if($medicine->pivot->night)
                                    <span class="timing-badge">Night</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $medicine->pivot->duration_days ?? 7 }} days</td>
                            <td>{{ $medicine->pivot->instructions ?? 'Take as prescribed' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Treatment Notes -->
            @if($treatment->notes)
            <div class="notes-section">
                <h3 class="section-title">Treatment Notes & Advice</h3>
                <div class="notes-content">
                    {{ $treatment->notes }}
                </div>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="prescription-date">
                Prescription Date: {{ $treatment->created_at->format('d M Y, h:i A') }}
            </div>
            <div class="signature-section">
                <div class="signature-line"></div>
                <div>Dr. {{ $treatment->appointment->practitioner->name }}</div>
                <div>Digital Signature</div>
            </div>
        </div>
    </div>

    <script>
        // Auto-print functionality
        window.onload = function() {
            // Uncomment the line below if you want auto-print
            // window.print();
        }
    </script>
</body>
</html>