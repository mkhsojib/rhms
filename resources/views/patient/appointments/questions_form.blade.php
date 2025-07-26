@extends('layouts.frontend')

@section('title', 'Appointment Questions')

@section('content')
<div class="min-h-screen flex items-center justify-center py-8 px-2">
    <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg p-8 card-shadow">
        <h2 class="text-2xl font-bold text-indigo-700 mb-6 text-center">Please answer the following questions for your appointment</h2>
        <form action="{{ route('patient.appointments.questions.submit', $appointment) }}" method="POST" class="space-y-6">
            @csrf
            @foreach($questions as $question)
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">{{ $question->question_text }}</label>
                    @if($question->input_type === 'text')
                        <input type="text" name="answers[{{ $question->id }}]" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" value="{{ old('answers.' . $question->id, $existingAnswers[$question->id] ?? '') }}">
                    @elseif($question->input_type === 'radio')
                        <div class="flex flex-wrap gap-4">
                        @foreach($question->options as $option)
                            <label class="inline-flex items-center cursor-pointer">
                                <input class="form-radio text-indigo-600 focus:ring-indigo-500" type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" {{ (old('answers.' . $question->id, $existingAnswers[$question->id] ?? '') == $option) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-600">{{ $option }}</span>
                            </label>
                        @endforeach
                        </div>
                    @elseif($question->input_type === 'checkbox')
                        @php
                            $checkedValues = old('answers.' . $question->id, isset($existingAnswers[$question->id]) ? json_decode($existingAnswers[$question->id], true) : []);
                            if (!is_array($checkedValues)) $checkedValues = [];
                        @endphp
                        <div class="flex flex-wrap gap-4">
                        @foreach($question->options as $option)
                            <label class="inline-flex items-center cursor-pointer">
                                <input class="form-checkbox text-indigo-600 focus:ring-indigo-500" type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option }}" {{ in_array($option, $checkedValues) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-600">{{ $option }}</span>
                            </label>
                        @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
            <div class="flex justify-center">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-lg shadow transition duration-200">
                    Submit Answers
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 