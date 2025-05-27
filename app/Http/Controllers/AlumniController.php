<?php
// app/Http/Controllers/LulusanController.php
namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Question;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlumniController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['showForm', 'submitForm']);
    }

    public function index()
    {
        $lulusan = Alumni::all();
        return view('admin.lulusan.index', [
            'alumni' => $lulusan,
            'type_menu' => 'sidebar'
        ]);
    }

    public function create()
    {
        return view('admin.lulusan.create', ['type_menu' => 'sidebar']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:lulusan,email',
        ]);

        Alumni::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.data-lulusan')->with('success', 'Lulusan berhasil ditambahkan.');
    }

    public function edit(Alumni $lulusan)
    {
        return view('admin.lulusan.edit', [
            'alumni' => $lulusan,
            'type_menu' => 'sidebar'
        ]);
    }

    public function update(Request $request, Alumni $lulusan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:lulusan,email,' . $lulusan->id,
        ]);

        $lulusan->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.data-lulusan')->with('success', 'Lulusan berhasil diperbarui.');
    }

    public function destroy(Alumni $lulusan)
    {
        $lulusan->delete();
        return redirect()->route('admin.data-lulusan')->with('success', 'Lulusan berhasil dihapus.');
    }

    public function generateLink(Alumni $lulusan)
    {
        if (!$lulusan->survey_token) {
            $lulusan->update(['survey_token' => Str::random(32)]);
        }

        $link = route('lulusan.form.show', $lulusan->survey_token);
        return redirect()->route('admin.data-lulusan')->with('success', 'Link survei: ' . $link);
    }

    public function showForm($token)
    {
        $lulusan = Alumni::where('survey_token', $token)->firstOrFail();
        if ($lulusan->survey_completed) {
            return view('lulusan.completed', ['type_menu' => '']);
        }

        $questions = Question::where('survey_type', 'lulusan')->get();
        return view('lulusan.form-lulusan', [
            'alumni' => $lulusan,
            'questions' => $questions,
            'token' => $token,
            'type_menu' => ''
        ]);
    }

    public function submitForm(Request $request, $token)
    {
        $lulusan = Alumni::where('survey_token', $token)->firstOrFail();
        if ($lulusan->survey_completed) {
            return redirect()->route('lulusan.form.show', $token);
        }

        $questions = Question::where('survey_type', 'lulusan')->get();
        $rules = [];
        foreach ($questions as $question) {
            if ($question->is_required) {
                $rules["answer.{$question->id}"] = 'required';
            }
        }

        $request->validate($rules);

        foreach ($questions as $question) {
            $answer = $request->input("answer.{$question->id}");
            if ($answer) {
                if (is_array($answer)) {
                    $answer = implode(', ', $answer);
                }
                SurveyResponse::create([
                    'lulusan_id' => $lulusan->id,
                    'question_id' => $question->id,
                    'answer' => $answer,
                ]);
            }
        }

        $lulusan->update(['survey_completed' => true]);
        return redirect()->route('lulusan.form.show', $token)->with('success', 'Survei berhasil disubmit.');
    }
}
