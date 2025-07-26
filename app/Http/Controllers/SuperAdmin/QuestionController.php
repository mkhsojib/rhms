<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:super_admin');
    }

    public function index()
    {
        $questions = Question::orderByDesc('id')->get();
        return view('superadmin.questions.index', compact('questions'));
    }

    public function create()
    {
        return view('superadmin.questions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question_text' => 'required|string',
            'input_type' => 'required|in:text,radio,checkbox',
            'options' => 'nullable|array',
            'category' => 'required|in:ruqyah,hijama',
        ]);
        $data['is_active'] = $request->has('is_active');
        if (isset($data['options']) && is_array($data['options'])) {
            $data['options'] = array_values(array_filter($data['options']));
        }
        Question::create($data);
        return redirect()->route('superadmin.questions.index')->with('success', 'Question created successfully.');
    }

    public function edit(Question $question)
    {
        return view('superadmin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $data = $request->validate([
            'question_text' => 'required|string',
            'input_type' => 'required|in:text,radio,checkbox',
            'options' => 'nullable|array',
            'category' => 'required|in:ruqyah,hijama',
        ]);
        $data['is_active'] = $request->has('is_active');
        if (isset($data['options']) && is_array($data['options'])) {
            $data['options'] = array_values(array_filter($data['options']));
        }
        $question->update($data);
        return redirect()->route('superadmin.questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('superadmin.questions.index')->with('success', 'Question deleted successfully.');
    }
} 