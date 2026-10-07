<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CardSession;
use App\Models\Category;
use App\Models\ChoiceCategory;
use App\Models\TestResult;
use App\Models\TestSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function intro($id)
    {
        $kategori = Category::findOrFail($id);
        return view('user.intro', compact('kategori'));
    }

    public function start($id)
    {
        $kategori = Category::findOrFail($id);
        $user     = Auth::guard('web')->user();

        $session = TestSession::firstOrCreate(
            [
                'user_id'     => $user->id,
                'category_id' => $id,
                'status'      => 'ongoing',
            ],
            [
                'duration'   => 0,
                'started_at' => now(),
            ]
        );

        $cards            = Card::where('category_id', $id)->get();
        $choiceCategories = ChoiceCategory::where('category_id', $id)->get();
        $responses        = CardSession::where('session_id', $session->id)->get();

        // Timer hanya dilanjutkan dari DB kalau user pernah klik "Simpan Progres"
        // Tandanya: ada CardSession yang udh tersimpan.
        // Kalau belum pernah simpan → timer mulai dari 0
        $initialDuration = $responses->isNotEmpty() ? $session->duration : 0;

        if ($id == 1) {
            return view('user.tests.career_values', compact(
                'kategori', 'session', 'cards', 'choiceCategories', 'responses', 'initialDuration'
            ));
        }

        if ($id == 2) {
            return view('user.tests.motivated_skills', compact(
                'kategori', 'session', 'cards', 'choiceCategories', 'responses', 'initialDuration'
            ));
        }

        if ($id == 3) {
            return view('user.tests.leisure_retirement', compact(
                'kategori', 'session', 'cards', 'choiceCategories', 'responses', 'initialDuration'
            ));
        }

        if ($id == 4) {
            return view('user.tests.occupational_interest', compact(
                'kategori', 'session', 'cards', 'choiceCategories', 'responses', 'initialDuration'
            ));
        }

        return back()->with('error', 'Tes jenis ini belum tersedia.');
    }

    public function saveProgress(Request $request, $id)
    {
        $user    = Auth::guard('web')->user();
        $session = TestSession::where('user_id', $user->id)
            ->where('category_id', $id)
            ->where('status', 'ongoing')
            ->firstOrFail();

        if ($request->has('duration')) {
            $session->update(['duration' => $request->duration]);
        }

        if ($request->has('cards')) {
            foreach ($request->cards as $cardId => $choiceCategoryId) {
                CardSession::updateOrCreate(
                    ['session_id' => $session->id, 'card_id' => $cardId],
                    ['choice_category_id' => $choiceCategoryId]
                );
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function finish(Request $request, $id)
    {
        $user    = Auth::guard('web')->user();
        $session = TestSession::where('user_id', $user->id)
            ->where('category_id', $id)
            ->where('status', 'ongoing')
            ->firstOrFail();

        if ($request->has('cards')) {
            foreach ($request->cards as $cardId => $choiceCategoryId) {
                CardSession::updateOrCreate(
                    ['session_id' => $session->id, 'card_id' => $cardId],
                    ['choice_category_id' => $choiceCategoryId]
                );
            }
        }

        $isCareerValues = ($id == 1);
        
        $session->update([
            'status'      => $isCareerValues ? 'ongoing' : 'finished',
            'finished_at' => $isCareerValues ? null : now(),
            'duration'    => $request->duration ?? $session->duration,
        ]);

        TestResult::create([
            'session_id'     => $session->id,
            'result_summary' => null,
            'is_reviewed'    => false,
            'is_sent'        => false,
        ]);

        return response()->json([
            'status'     => 'finished',
            'session_id' => $session->id,
        ]);
    }

    public function result($id, $sessionId)
    {
        $user = Auth::guard('web')->user();

        $session = TestSession::with([
            'category',
            'cardSessions.card',
            'cardSessions.choiceCategory',
            'testResult'
        ])
        ->where('user_id', $user->id)
        ->where('category_id', $id)
        ->where('status', 'finished')
        ->findOrFail($sessionId);

        $groupedCards = $session->cardSessions
            ->groupBy('choice_category_id')
            ->map(fn($items) => $items->map(fn($cs) => $cs->card));

        $choiceCategories = ChoiceCategory::where('category_id', $id)
            ->orderBy('id')
            ->get();

        $duration = [
            'hours'   => floor($session->duration / 3600),
            'minutes' => floor(($session->duration % 3600) / 60),
            'seconds' => $session->duration % 60,
        ];

        if ($id == 1) {
            return view('user.tests.result_career_values', compact(
                'session', 'groupedCards', 'choiceCategories', 'duration'
            ));
        }

        if ($id == 2) {
            return view('user.tests.result_motivated_skills', compact(
                'session', 'groupedCards', 'choiceCategories', 'duration'
            ));
        }

        if ($id == 3) {
            return view('user.tests.result_leisure_retirement', compact(
                'session', 'groupedCards', 'choiceCategories', 'duration'
            ));
        }

        if ($id == 4) {
            return view('user.tests.result_occupational_interest', compact(
                'session', 'groupedCards', 'choiceCategories', 'duration'
            ));
        }

        return back()->with('error', 'Halaman hasil tidak tersedia.');
    }

    public function worksheet($id, $sessionId)
    {
        $user = Auth::guard('web')->user();
        $session = TestSession::where('user_id', $user->id)
            ->where('category_id', $id)
            ->findOrFail($sessionId);

        if ($id != 1) {
            return redirect()->route('tests.result', ['id' => $id, 'session' => $session->id]);
        }

        $sortedAlways = CardSession::with('card')
            ->where('session_id', $session->id)
            ->where('choice_category_id', 1) // 1 = Always Valued
            ->get();

        // Ambil profesi dari dream_jobs (atau default)
        $user->profesi_1 = $user->dream_jobs[0] ?? 'Profesi 1';
        $user->profesi_2 = $user->dream_jobs[1] ?? 'Profesi 2';
        $user->profesi_3 = $user->dream_jobs[2] ?? 'Profesi 3';

        $existingWorksheet = $sortedAlways->keyBy('card_id');
        $elapsedSeconds = $session->duration;

        return view('user.tests.career_worksheet', compact(
            'session', 'sortedAlways', 'existingWorksheet', 'user', 'elapsedSeconds'
        ));
    }

    public function saveWorksheet(Request $request, $sessionId)
    {
        $user = Auth::guard('web')->user();
        $session = TestSession::where('user_id', $user->id)
            ->findOrFail($sessionId);

        $scores = $request->input('scores', []);

        foreach ($scores as $cardId => $profesiScores) {
            CardSession::where('session_id', $session->id)
                ->where('card_id', $cardId)
                ->update([
                    'profesi_1_score' => $profesiScores['profesi_1'] ?? null,
                    'profesi_2_score' => $profesiScores['profesi_2'] ?? null,
                    'profesi_3_score' => $profesiScores['profesi_3'] ?? null,
                ]);
        }

        $session->update([
            'status' => 'finished',
            'finished_at' => now(),
            'duration' => $request->input('duration', $session->duration)
        ]);

        return redirect()->route('tests.result', ['id' => $session->category_id, 'session' => $session->id])
            ->with('success', 'Worksheet berhasil disimpan.');
    }

        public function history()
    {
        $user = Auth::guard('web')->user();

        $sessions = TestSession::with('category')
            ->where('user_id', $user->id)
            ->where('status', 'finished')
            ->latest('finished_at')
            ->paginate(20);

        return view('user.tests.history', compact('sessions'));
    }

    public function destroySession($sessionId)
    {
        $user    = Auth::guard('web')->user();
        $session = TestSession::where('user_id', $user->id)
            ->findOrFail($sessionId);

        // Hapus data terkait dulu sebelum hapus sesi
        CardSession::where('session_id', $session->id)->delete();
        TestResult::where('session_id', $session->id)->delete();
        $session->delete();

        return back()->with('status', 'session-deleted');
    }
}
