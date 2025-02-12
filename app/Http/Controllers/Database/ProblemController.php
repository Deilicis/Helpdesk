<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Flasher\Prime\FlasherInterface;
use Illuminate\View\View;
use App\Models\Problem;
use Illuminate\Support\Facades\Cache;

class ProblemController extends Controller
{
    // Atgriež view ar formu problēmas izveidošanai.
    public function create(): View
    {
        return view('form'); // Parāda formu
    }

    // Saglabā problēmas datus datubāzē pēc validācijas.
    public function store(Request $request, FlasherInterface $flasher)
    {
        // Validē ienākošos datus
        $request->validate([
            'nozare' => ['required', 'string'],
            'virsraksts' => ['required', 'string', 'max:255'],
            'apraksts' => ['required', 'string'],
            'laiks' => ['nullable', 'string'],
            'epasts' => ['required', 'email'],
            'customNozare' => ['nullable', 'string', 'max:255'],
        ]);
    
        // Pārbauda, vai "nozare" lauks ir "Cits", un izmanto customNozare vērtību, ja tā ir
        $nozare = $request->input('nozare');
        if ($nozare === 'Cits') {
            $nozare = $request->input('customNozare');
        }
    
        // Izveido jaunu problēmas ierakstu un saglabā to datu bāzē.
        $problem = new Problem();
        $problem->nozare = $nozare;
        $problem->virsraksts = $request->input('virsraksts');
        $problem->apraksts = $request->input('apraksts');
        $problem->laiks = $request->input('laiks');
        $problem->epasts = $request->input('epasts');
        $problem->save();
    
        // Izņem problēmu no kešatmiņas
        Cache::forget('problem_' . $problem->id);
    
        // Atgriež lietotāju uz iepriekšējo lapu
        return redirect()->back()->with('success', 'Problēma nosūtīta!');
    }

    // Parāda problēmu tabulu ar pagination
    public function index(): View
    {
        // Iegūst problēmas ar kārtošanu un pagination.
        $problems = Problem::sortable()->paginate(15);
        return view('dash.dashboard', compact('problems')); // Atgriež dashboard skatījumu ar problēmām.
    }

    // Parāda konkrētas problēmas detaļas.
    public function show($id)
    {
        $cacheKey = 'problem_' . $id;

        // Mēģina iegūt problēmu no kešatmiņas, vai arī iegūst to no datubāzes
        $problem = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($id) {
            return Problem::findOrFail($id);
        });

        // Atgriež problēmas detaļas kā JSON atbildi.
        return response()->json($problem);
    }

    // Atjaunina problēmas prioritāti.
    public function updatePriority(Request $request, $id)
    {
        // Validē prioritātes ievadi.
        $request->validate([
            'priority' => ['required', 'in:low,high,critical'],
        ]);

        // Iegūst problēmu un atjaunina prioritāti.
        $problem = Problem::findOrFail($id);
        $problem->priority = $request->input('priority');
        $problem->save();

        // Atgriež lietotāju uz iepriekšējo lapu
        return redirect()->back()->with('success', 'Prioritāte atjaunināta!');
    }

    // Atjaunina problēmas statusu.
    public function updateStatus(Request $request, $id)
    {
        // Validē statusa ievadi
        $request->validate([
            'status' => ['required', 'in:open,closed'],
        ]);

        // Iegūst problēmu un atjaunina statusu.
        $problem = Problem::findOrFail($id);
        $problem->status = $request->input('status');
        $problem->save();

        // Atgriež lietotāju uz iepriekšējo lapu
        return redirect()->back()->with('success', 'Statuss atjaunināts!');
    }

    // Dzēš problēmu no datu bāzes.
    public function destroy($id)
    {
        // Iegūst problēmu un dzēš to.
        $problem = Problem::findOrFail($id);
        $problem->delete();

        // Izņem problēmu no kešatmiņas
        Cache::forget('problem_' . $id);

        // Atgriež JSON atbildi
        return response()->json(['message' => 'Problēma izdzēsta!'], 200);
    }
}
