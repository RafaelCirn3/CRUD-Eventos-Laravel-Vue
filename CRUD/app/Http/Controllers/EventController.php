<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource (List).
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna a lista de todos os eventos
        $events = Event::all();
        return response()->json($events, 200);
    }

    /**
     * Store a newly created resource in storage (Create).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valida os dados
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'cover' => 'nullabe|image',
            'banner' => 'nullabe|image',
            'map' => 'nullabe|string',
            'date' => 'required|date',
        ]);

        $event = Event::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'cover' => $request->file('cover')->store('covers'),
            'banner' => $request->file('banner')->store('banners'),
            'map' => $data['map'],
            'date' => $data['date'],
            'user_id' => Auth::id(), // ID do organizador
        ]);
    
        return response()->json($event, 201);
    }

    /**
     * Display the specified resource (View by ID).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Exibe os detalhes de um evento específico
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        return response()->json($event, 200);
    }

    /**
     * Update the specified resource in storage (Update).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Localiza o evento
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        // Valida os dados
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'cover' => 'nullable|image',
            'banner' => 'nullable|image',
            'map' => 'nullabe|string',
            'date' => 'required|date',
        ]);

        // Atualiza os campos do evento
        $event->name = $data['name'];
        $event->description = $data['description'];
        $event->event_map = $data['map'];
        $event->date = $data['date'];

        // Atualiza as imagens se fornecidas
        if ($request->hasFile('cover')) {
            $event->cover = $request->file('cover')->store('covers');
        }
        if ($request->hasFile('banner')) {
            $event->banner = $request->file('banner')->store('banners');
        }

        $event->save();
        return response()->json($event, 200);
    }

    /**
     * Remove the specified resource from storage (Delete).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Localiza o evento para excluir
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        // Exclui o evento
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully'], 200);
    }

    /**
     * Display a listing of participants for the specified event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function participants($id)
    {
        // Localiza o evento
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        // Obtém a lista de participantes
        $participants = $event->participants; // Certifique-se de que você tenha um relacionamento 'participants' no seu modelo Event

        return response()->json($participants, 200);
    }

    /**
     * Register a user for the specified event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function register($id)
    {
        // Localiza o evento
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        // Registra o usuário
        $event->participants()->attach(Auth::id());

        return response()->json(['message' => 'Registration successful.'], 200);
    }

    /**
     * Unregister a user from the specified event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unregister($id)
    {
        // Localiza o evento
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        // Cancela a inscrição do usuário
        $event->participants()->detach(Auth::id());

        return response()->json(['message' => 'Registration canceled.'], 200);
    }
}
