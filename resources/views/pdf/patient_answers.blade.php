<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patient Answers - {{ $appointment->appointment_no }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #7f8c8d;
        }
        .appointment-info {
            margin-bottom: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .appointment-info h2 {
            margin: 0 0 15px 0;
            color: #2c3e50;
            font-size: 18px;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            font-weight: bold;
            width: 30%;
            padding: 5px 0;
        }
        .info-value {
            display: table-cell;
            padding: 5px 0;
        }
        .questions-section {
            margin-top: 30px;
        }
        .questions-section h2 {
            margin: 0 0 20px 0;
            color: #2c3e50;
            font-size: 18px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .question-item {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .question-text {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .answer-text {
            padding: 10px;
            background-color: #f8f9fa;
            border-left: 3px solid #3498db;
            margin-left: 20px;
        }
        .no-answer {
            color: #95a5a6;
            font-style: italic;
        }
        .checkbox-answer {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 2px 8px;
            margin: 2px;
            border-radius: 3px;
            font-size: 11px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Patient Questionnaire Answers</h1>
        <p>Appointment No: {{ $appointment->appointment_no }}</p>
        <p>Generated on: {{ now()->format('F d, Y \a\t g:i A') }}</p>
    </div>

    <div class="appointment-info">
        <h2>Appointment Information</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Patient Name:</div>
                <div class="info-value">{{ $appointment->patient->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Treatment Type:</div>
                <div class="info-value">{{ ucfirst($appointment->type) }} Treatment</div>
            </div>
            <div class="info-row">
                <div class="info-label">Appointment Date:</div>
                <div class="info-value">{{ date('l, F d, Y', strtotime($appointment->appointment_date)) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Appointment Time:</div>
                <div class="info-value">
                    @if($appointment->appointment_end_time)
                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($appointment->appointment_end_time)->format('g:i A') }}
                    @else
                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Practitioner:</div>
                <div class="info-value">{{ $appointment->practitioner->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value">{{ ucfirst($appointment->status) }}</div>
            </div>
        </div>
    </div>

    <div class="questions-section">
        <h2>Patient Questionnaire Responses</h2>
        
        @if($questions->count() > 0)
            @foreach($questions as $question)
                <div class="question-item">
                    <div class="question-text">
                        {{ $loop->iteration }}. {{ $question->question_text }}
                        @if($question->is_required)
                            <span style="color: #e74c3c;">*</span>
                        @endif
                    </div>
                    <div class="answer-text">
                        @php $answer = $answers[$question->id] ?? null; @endphp
                        @if($answer === null || $answer === '')
                            <span class="no-answer">Not answered</span>
                        @elseif($question->input_type === 'checkbox')
                            @foreach(json_decode($answer, true) ?? [] as $val)
                                <span class="checkbox-answer">{{ $val }}</span>
                            @endforeach
                        @else
                            {{ $answer }}
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="question-item">
                <div class="answer-text">
                    <span class="no-answer">No questions available for this appointment type.</span>
                </div>
            </div>
        @endif
    </div>

    @if($appointment->symptoms)
        <div class="questions-section">
            <h2>Additional Notes</h2>
            <div class="question-item">
                <div class="question-text">Symptoms & Notes:</div>
                <div class="answer-text">{{ $appointment->symptoms }}</div>
            </div>
        </div>
    @endif

    <div class="footer">
        <p>This document was generated automatically by the Ruqyah & Hijama Center Management System.</p>
        <p>For any questions, please contact the center administration.</p>
    </div>
</body>
</html> 