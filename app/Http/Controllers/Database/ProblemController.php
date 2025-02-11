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
     // Store the problem data in the database.
    public function create(): View
    {
        return view('form');
    }
    public function store(Request $request, FlasherInterface $flasher)
    {
        $request->validate([
            'nozare' => ['required', 'string'],
            'virsraksts' => ['required', 'string', 'max:255'],
            'apraksts' => ['required', 'string'],
            'laiks' => ['nullable', 'string'],
            'epasts' => ['required', 'email'],
            'customNozare' => ['nullable', 'string', 'max:255'],
        ]);
    
        $nozare = $request->input('nozare');
        if ($nozare === 'Cits') {
            $nozare = $request->input('customNozare');
        }
    
        $problem = new Problem();
        $problem->nozare = $nozare;
        $problem->virsraksts = $request->input('virsraksts');
        $problem->apraksts = $request->input('apraksts');
        $problem->laiks = $request->input('laiks');
        $problem->epasts = $request->input('epasts');
        $problem->save();
    
        Cache::forget('problem_' . $problem->id);
    
        return redirect()->back()->with('success', 'Problēma nosūtīta!');
    }
    
    public function index(): View
    {
        $problems = Problem::sortable()->paginate(15);
        return view('dash.dashboard', compact('problems'));
    }


    public function show($id)
    {
        $cacheKey = 'problem_' . $id;
        $problem = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($id) {
            return Problem::findOrFail($id);
        });

        return response()->json($problem);
    }

    public function updatePriority(Request $request, $id){
    $request->validate([
        'priority' => ['required', 'in:low,high,critical'],
    ]);

    $problem = Problem::findOrFail($id);
    $problem->priority = $request->input('priority');
    $problem->save();

    return redirect()->back()->with('success', 'Prioritāte atjaunināta!');
}

public function updateStatus(Request $request, $id){
    $request->validate([
        'status' => ['required', 'in:open,closed'],
    ]);

    $problem = Problem::findOrFail($id);
    $problem->status = $request->input('status');
    $problem->save();

    return redirect()->back()->with('success', 'Statuss atjaunināts!');
}


    public function destroy($id)
    {
        $problem = Problem::findOrFail($id);
        $problem->delete();

        Cache::forget('problem_' . $id);

        return response()->json(['message' => 'Problēma izdzēsta!'], 200);
    }
}
