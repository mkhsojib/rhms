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
        $validated = $request->validate([
            'question_text' => 'required|string|max:255',
            'input_type' => 'required|in:text,radio,checkbox',
            'options' => 'nullable|array',
            'category' => 'required|in:ruqyah,hijama',
            'is_active' => 'boolean',
            'is_required' => 'boolean',
        ]);

        $validated['is_active'] = $request->input('is_active') == '1';
        $validated['is_required'] = $request->input('is_required') == '1';

        Question::create($validated);

        return redirect()->route('superadmin.questions.index')
            ->with('success', 'Question created successfully.');
    }

    public function edit(Question $question)
    {
        return view('superadmin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question_text' => 'required|string|max:255',
            'input_type' => 'required|in:text,radio,checkbox',
            'options' => 'nullable|array',
            'category' => 'required|in:ruqyah,hijama',
            'is_active' => 'boolean',
            'is_required' => 'boolean',
        ]);

        $validated['is_active'] = $request->input('is_active') == '1';
        $validated['is_required'] = $request->input('is_required') == '1';

        $question->update($validated);

        return redirect()->route('superadmin.questions.index')
            ->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('superadmin.questions.index')->with('success', 'Question deleted successfully.');
    }
} 