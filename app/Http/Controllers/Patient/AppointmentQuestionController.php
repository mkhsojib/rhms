<?php
namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Question;
use App\Models\QuestionAnswer;

class AppointmentQuestionController extends Controller
{
    public function showForm(Appointment $appointment)
    {
        $this->authorize('view', $appointment);
        $questions = Question::where('category', $appointment->type)
            ->where('is_active', true)
            ->get();
        $existingAnswers = QuestionAnswer::where('appointment_id', $appointment->id)->pluck('answer', 'question_id');
        return view('patient.appointments.questions_form', compact('appointment', 'questions', 'existingAnswers'));
    }

    public function submitAnswers(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);
        $questions = Question::where('category', $appointment->type)
            ->where('is_active', true)
            ->get();
        $data = $request->validate([
            'answers' => 'required|array',
        ]);
        foreach ($questions as $question) {
            $answer = $data['answers'][$question->id] ?? null;
            if ($answer !== null) {
                QuestionAnswer::updateOrCreate(
                    [
                        'appointment_id' => $appointment->id,
                        'question_id' => $question->id,
                    ],
                    [
                        'answer' => is_array($answer) ? json_encode($answer) : $answer,
                    ]
                );
            }
        }
        return redirect()->route('patient.appointments.show', $appointment)->with('success', 'Your answers have been submitted.');
    }
} 