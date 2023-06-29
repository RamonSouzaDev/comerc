<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::all();
        return response()->json($pedidos);
    }

    public function show($id)
    {
        $pedido = Pedido::find($id);
        if (!$pedido) {
            return response()->json(['error' => 'Pedido não encontrado'], 404);
        }
        return response()->json($pedido);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required',
            'produto_id' => 'required',
            'data_criacao' => 'required|date',
        ]);

        $pedido = Pedido::create($validatedData);
        // Lógica para enviar e-mail ao cliente com os detalhes do pedido
        return response()->json($pedido, 201);
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::find($id);
        if (!$pedido) {
            return response()->json(['error' => 'Pedido não encontrado'], 404);
        }

        $validatedData = $request->validate([
            'cliente_id' => 'required',
            'produto_id' => 'required',
            'data_criacao' => 'required|date',
        ]);

        $pedido->update($validatedData);
        return response()->json($pedido);
    }

    public function destroy($id)
    {
        $pedido = Pedido::find($id);
        if (!$pedido) {
            return response()->json(['error' => 'Pedido não encontrado'], 404);
        }
        $pedido->delete();
        return response()->json(['message' => 'Pedido excluído com sucesso']);
    }
}
