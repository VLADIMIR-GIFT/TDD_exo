<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chirp;

class ChirpController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $chirp = Chirp::create([
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
        ]);

        return response()->json($chirp, 201);
    }
    Schema::create('chirps', function (Blueprint $table) {
        $table->id();
        $table->string('content');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });

}
