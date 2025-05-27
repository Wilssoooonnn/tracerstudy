<?php
// app/Http/Controllers/QuestionController.php
namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $questions = Question::all();
        return view('admin.questions.index', ['questions' => $questions, 'type_menu' => 'sidebar']);
    }

    public function create()
    {
        return view('admin.questions.create', ['type_menu' => 'sidebar']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'type' => 'required|in:text,radio,checkbox',
            'options' => 'required_if:type,radio,checkbox|array|min:2',
            'options.*' => 'required|string',
            'is_required' => 'boolean',
        ]);

        Question::create([
            'content' => $request->content,
            'type' => $request->type,
            'options' => $request->type !== 'text' ? $request->options : null,
            'is_required' => $request->boolean('is_required', true),
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'Question added successfully.');
    }

    public function show(Question $question)
    {
        return view('admin.questions.show', ['question' => $question, 'type_menu' => 'sidebar']);
    }

    public function edit(Question $question)
    {
        return view('admin.questions.edit', ['question' => $question, 'type_menu' => 'sidebar']);
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'content' => 'required|string',
            'type' => 'required|in:text,radio,checkbox',
            'options' => 'required_if:type,radio,checkbox|array|min:2',
            'options.*' => 'required|string',
            'is_required' => 'boolean',
        ]);

        $question->update([
            'content' => $request->content,
            'type' => $request->type,
            'options' => $request->type !== 'text' ? $request->options : null,
            'is_required' => $request->boolean('is_required', true),
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Question deleted successfully.');
    }
}