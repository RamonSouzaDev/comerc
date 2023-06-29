<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }

    public function show($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }
        return response()->json($cliente);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:clientes',
            'telefone' => 'required',
            'data_nascimento' => 'required|date',
            'endereco' => 'required',
            'complemento' => 'nullable',
            'bairro' => 'nullable',
            'cep' => 'required',
            'data_cadastro' => 'nullable|date',
        ]);

        $cliente = Cliente::create($validatedData);
        return response()->json($cliente, 201);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }

        $validatedData = $request->validate([
            'nome' => 'required',
            'email' => ['required', 'email', Rule::unique('clientes')->ignore($cliente->id)],
            'telefone' => 'required',
            'data_nascimento' => 'required|date',
            'endereco' => 'required',
            'complemento' => 'nullable',
            'bairro' => 'nullable',
            'cep' => 'required',
            'data_cadastro' => 'nullable|date',
        ]);

        $cliente->update($validatedData);
        return response()->json($cliente);
    }

    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }
        $cliente->delete();
        return response()->json(['message' => 'Cliente excluído com sucesso']);
    }
}
