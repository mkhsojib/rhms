<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Question;
use App\Models\QuestionAnswer;

class AppointmentQuestionController extends Controller
{
    public function editForm(Appointment $appointment)
    {
        $this->authorize('update', $appointment); // SuperAdmin can update if allowed by policy
        if ($appointment->status === 'completed') {
            return redirect()->route('superadmin.appointments.show', $appointment)
                ->with('error', 'You cannot edit answers after the session is completed.');
        }
        $questions = Question::where('category', $appointment->type)
            ->where('is_active', true)
            ->get();
        $existingAnswers = QuestionAnswer::where('appointment_id', $appointment->id)->pluck('answer', 'question_id');
        return view('superadmin.appointments.questions_form', compact('appointment', 'questions', 'existingAnswers'));
    }

    public function updateAnswers(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);
        if ($appointment->status === 'completed') {
            return redirect()->route('superadmin.appointments.show', $appointment)
                ->with('error', 'You cannot edit answers after the session is completed.');
        }
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
        return redirect()->route('superadmin.appointments.show', $appointment)->with('success', 'Answers have been updated.');
    }
} 