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
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover' => 'nullable|image',
            'banner' => 'nullable|image',
            'map' => 'nullable|image',
            'date' => 'required|date',
        ], [
            'name.required' => 'O nome do evento é obrigatório.',
            'date.required' => 'A data do evento é obrigatória.',
            'cover.image' => 'A capa precisa ser uma imagem válida.',
            'banner.image' => 'O banner precisa ser uma imagem válida.',
            'map.image' => 'O mapa precisa ser uma imagem válida.',
        ]);
    
        // Adiciona o ID do usuário autenticado no array de dados
        $data['user_id'] = auth()->user()->id;
    
        // Processar as imagens, se houver
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('public/images');
        }
        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('public/images');
        }
        if ($request->hasFile('map')) {
            $data['map'] = $request->file('map')->store('public/images');
        }
    
        // Cria o evento com os dados validados e o user_id
        $event = Event::create($data);
    
        return response()->json($event, 201);
    }
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
        // Verifica se o usuário autenticado é o criador do evento
        if ($event->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        // Validação dos dados, com cada campo sendo opcional
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'cover_image' => 'sometimes|nullable|image',
            'banner_image' => 'sometimes|nullable|image',
            'date' => 'sometimes|required|date',
        ]);
    
        // Preenche o evento com os dados recebidos
        $event->fill($data)->save();
    
        return response()->json($event, 200);
    }

    public function destroy($id)
{
    // Localiza o evento para excluir
    $event = Event::find($id);

    if (!$event) {
        return response()->json(['error' => 'Event not found'], 404);
    }

    // Verifica se o usuário autenticado é o criador do evento
    if ($event->user_id !== Auth::id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
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
        public function myEvents()
        {
            $user = Auth::user();
    
            // Buscar eventos criados pelo usuário logado
            $events = Event::where('user_id', $user->id)->get();
    
            return response()->json($events, 200);
        }
    
        /**
         * Display events the logged-in user is subscribed to.
         *
         * @return \Illuminate\Http\Response
         */
        public function subscribedEvents()
        {
            $user = Auth::user();
    
            // Buscar os eventos nos quais o usuário está inscrito
            $events = $user->events; // Relação definida no modelo User
    
            return response()->json($events, 200);
        }
    
        /**
         * Display available events the user can subscribe to.
         *
         * @return \Illuminate\Http\Response
         */
        public function availableEvents()
        {
            $user = Auth::user();
    
            // Buscar eventos que o usuário não criou e não está inscrito
            $events = Event::whereDoesntHave('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('user_id', '!=', $user->id)->get();
    
            return response()->json($events, 200);
        }
}
