<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
            'description' => 'nullable|string', 
            'cover' => 'nullable|string',         
            'banner' => 'nullable|string',        
            'map' => 'nullable|string',           
            'date' => 'required|date',
        ]);
    
        // Adicionando o ID do usuário autenticado ao array de dados
        $data['user_id'] = auth()->id();
    
        // Cria um novo evento
        $event = Event::create($data);
    
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
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        // Valida os dados
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image',
            'banner_image' => 'nullable|image',
            'date' => 'required|date',
        ]);

        // Atualiza o evento
        $event->update($data);
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
    public function subscribe($id){
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }
    
        $user = Auth::user();
        // Verifica se o usuário está autenticado
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    
        // Verifica se o usuário já está inscrito no evento
        if ($event->users()->find($user->id)) {
            return response()->json(['error' => 'User already subscribed'], 400);
        }
    
        $event->users()->attach($user->id);
        return response()->json(['message' => 'Subscribed successfully'], 200);}
        public function unsubscribe($id){
            $event = Event::find($id);
        
            if (!$event) {
                return response()->json(['error' => 'Event not found'], 404);
            }
        
            $user = Auth::user();
            
            // Verifica se o usuário está autenticado
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }
        
            // Verifica se o usuário não está inscrito no evento
            if (!$event->users()->find($user->id)) {
                return response()->json(['error' => 'User not subscribed'], 400);
            }
        
            $event->users()->detach($user->id);
        
            return response()->json(['message' => 'Unsubscribed successfully'], 200);
        }
}
