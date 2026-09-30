<?php

namespace App\Http\Controllers;

use App\Models\Candidatura;
use Illuminate\Http\Request;

class CandidaturaController extends Controller
{
    /**
     * O proprio candidato remove a candidatura (o RH nao pode remover).
     */
    public function destroy(Request $request, Candidatura $candidatura)
    {
        abort_unless($candidatura->user_id === $request->user()->id, 403);

        $candidatura->delete();

        return back()->with('success', 'Sua candidatura foi removida.');
    }
}
