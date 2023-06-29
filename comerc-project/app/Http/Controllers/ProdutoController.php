<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return response()->json($produtos);
    }

    public function show($id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }
        return response()->json($produto);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required',
            'preco' => 'required',
            'foto' => 'required',
        ]);

        $produto = Produto::create($validatedData);
        return response()->json($produto, 201);
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        $validatedData = $request->validate([
            'nome' => 'required',
            'preco' => 'required',
            'foto' => 'required',
        ]);

        $produto->update($validatedData);
        return response()->json($produto);
    }

    public function destroy($id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }
        $produto->delete();
        return response()->json(['message' => 'Produto excluído com sucesso']);
    }
}
