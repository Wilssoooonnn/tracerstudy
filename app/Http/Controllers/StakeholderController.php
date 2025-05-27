<?php
// app/Http/Controllers/StakeholderController.php
namespace App\Http\Controllers;

use App\Models\Stakeholder;
use App\Models\Question;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StakeholderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['showForm', 'submitForm']);
    }

    public function index()
    {
        $stakeholders = Stakeholder::all();
        return view('admin.stakeholder.index', [
            'stakeholders' => $stakeholders,
            'type_menu' => 'sidebar'
        ]);
    }

    public function create()
    {
        return view('admin.stakeholder.create', ['type_menu' => 'sidebar']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:stakeholders,email',
        ]);

        Stakeholder::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.data-stakeholder')->with('success', 'Stakeholder berhasil ditambahkan.');
    }

    public function edit(Stakeholder $stakeholder)
    {
        return view('admin.stakeholder.edit', [
            'stakeholder' => $stakeholder,
            'type_menu' => 'sidebar'
        ]);
    }

    public function update(Request $request, Stakeholder $stakeholder)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:stakeholders,email,' . $stakeholder->id,
        ]);

        $stakeholder->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.data-stakeholder')->with('success', 'Stakeholder berhasil diperbarui.');
    }

    public function destroy(Stakeholder $stakeholder)
    {
        $stakeholder->delete();
        return redirect()->route('admin.data-stakeholder')->with('success', 'Stakeholder berhasil dihapus.');
    }

    public function generateLink(Stakeholder $stakeholder)
    {
        if (!$stakeholder->survey_token) {
            $stakeholder->update(['survey_token' => Str::random(32)]);
        }

        $link = route('penggunalulusan.form.show', $stakeholder->survey_token);
        return redirect()->route('admin.data-stakeholder')->with('success', 'Link survei: ' . $link);
    }

    public function showForm($token)
    {
        $stakeholder = Stakeholder::where('survey_token', $token)->firstOrFail();
        if ($stakeholder->survey_completed) {
            return view('penggunalulusan.completed', ['type_menu' => '']);
        }

        $questions = Question::where('survey_type', 'penggunalulusan')->get();
        return view('penggunalulusan.form-penggunalulusan', [
            'stakeholder' => $stakeholder,
            'questions' => $questions,
            'token' => $token,
            'type_menu' => ''
        ]);
    }

    public function submitForm(Request $request, $token)
    {
        $stakeholder = Stakeholder::where('survey_token', $token)->firstOrFail();
        if ($stakeholder->survey_completed) {
            return redirect()->route('penggunalulusan.form.show', $token);
        }

        $questions = Question::where('survey_type', 'penggunalulusan')->get();
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
                    'stakeholder_id' => $stakeholder->id,
                    'question_id' => $question->id,
                    'answer' => $answer,
                ]);
            }
        }

        $stakeholder->update(['survey_completed' => true]);
        return redirect()->route('penggunalulusan.form.show', $token)->with('success', 'Survei berhasil disubmit.');
    }
}