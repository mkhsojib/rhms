@extends('adminlte::page')

@section('title', 'Edit Appointment Answers')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white font-weight-bold">Edit Patient Answers</div>
                <div class="card-body">
                    <form action="{{ route('superadmin.appointments.questions.update', $appointment) }}" method="POST">
                        @csrf
                        @foreach($questions as $question)
                            <div class="mb-4">
                                <label class="font-weight-bold">
                                    {{ $question->question_text }}
                                    @if($question->is_required)
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>
                                @if($question->input_type === 'text')
                                    <input type="text" name="answers[{{ $question->id }}]" class="form-control" value="{{ old('answers.' . $question->id, $existingAnswers[$question->id] ?? '') }}" {{ $question->is_required ? 'required' : '' }}>
                                @elseif($question->input_type === 'radio')
                                    <div>
                                    @foreach($question->options as $option)
                                        <label class="mr-3">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" {{ (old('answers.' . $question->id, $existingAnswers[$question->id] ?? '') == $option) ? 'checked' : '' }} {{ $question->is_required ? 'required' : '' }}> {{ $option }}
                                        </label>
                                    @endforeach
                                    </div>
                                @elseif($question->input_type === 'checkbox')
                                    @php
                                        $checkedValues = old('answers.' . $question->id, isset($existingAnswers[$question->id]) ? json_decode($existingAnswers[$question->id], true) : []);
                                        if (!is_array($checkedValues)) $checkedValues = [];
                                    @endphp
                                    <div>
                                    @foreach($question->options as $option)
                                        <label class="mr-3">
                                            <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option }}" {{ in_array($option, $checkedValues) ? 'checked' : '' }} {{ $question->is_required ? 'required' : '' }}> {{ $option }}
                                        </label>
                                    @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        <div class="text-center">
                            <button type="submit" class="btn btn-success px-5">Update Answers</button>
                            <a href="{{ route('superadmin.appointments.show', $appointment) }}" class="btn btn-secondary ml-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 