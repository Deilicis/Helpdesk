<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Flasher\Prime\FlasherInterface;
use Illuminate\View\View;
use App\Models\Problem;



class ProblemController extends Controller
{
    /**
     * Store the problem data in the database.
     */
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
        ]);
        $problem = new Problem();
        $problem->nozare = $request->input('nozare');
        $problem->virsraksts = $request->input('virsraksts');
        $problem->apraksts = $request->input('apraksts');
        $problem->laiks = $request->input('laiks');
        $problem->epasts = $request->input('epasts');
        $problem->save();
    
        return redirect()->back()->with('success', 'Problēma nosūtīta!');
    }
    public function index(): View
    {
        $problems = Problem::paginate(15);
        return view('dash.dashboard', compact('problems'));
    }
    public function destroy($id)
    {
        $problem = Problem::findOrFail($id);
        $problem->delete();

        return redirect()->route('dashboard')->with('success', 'Problēma izdzēsta!');
    }
}
