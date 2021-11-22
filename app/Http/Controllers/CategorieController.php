<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categories::all();
        return response()->json($categorias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'=>'required|min:3|max:255|unique:categories,name'
        ],[
            'name.required'=>'O campo nome deve ser preechido',
            'name.unique'=>'ja tem um artigo com o mesmo titulo, escolha outro',
            'name.min' => 'O campo  nome deve no minimo ter tres caracteres'
        ]);
        $categorie = array();
        $categorie['name'] = $request->name;
        DB::table('categories')->insert($categorie);
        return response()->json(['message'=>'categoria criada com sucesso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $name = Categories::find($id);
        if(!$name)
        {
            return response()->json(['error' => 'a categoria nao existe'],400);
        }else
        {
            return response()->json($name);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validate = $request->validate([
            'name'=>'required|min:3|max:255|unique:categories,name,'.$id
        ],[
            'name.required'=>'O campo nome deve ser preechido',
            'name.unique'=>'ja tem um artigo com o mesmo titulo, escolha outro',
            'name.min' => 'O campo  nome deve no minimo ter tres caracteres'
        ]);
        $name = array();
        $name['name'] = $request->name;
        if(DB::table('categories')->where('id',$id)->doesntExist()){
            return response()->json(['errors' => 'O artigo nao existe em nosso banco e dados'],400);
        }else{
            DB::table('categories')->where('id',$id)->update($name);
            return response()->json(['message'=>'Editado com sucesso']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $name = DB::table('categories')->where('id',$id)->first();
        if(!$name){
            return response()->json(['message'=>'O artigo nao existe em nosso banco e dados'],400);
        }else
        {
            DB::table('categories')->where('id',$id)->delete();
            return response()->json(['message'=>'Artigo removido com sucesso']);
        }
    }
}
