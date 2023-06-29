<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\DetalhesPedidoEmail;
use App\Models\Cliente;

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

        // Envio de e-mail
        $cliente = Cliente::find($pedido->cliente_id);

        // Construção dos detalhes do pedido
        $detalhesPedido = [
            'pedido_id' => $pedido->id,
            'cliente_nome' => $cliente->nome,
            // Outras informações do pedido...
        ];

        // Envio do e-mail utilizando a classe de e-mail personalizada DetalhesPedidoEmail
        Mail::to($cliente->email)->send(new DetalhesPedidoEmail($detalhesPedido));

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
