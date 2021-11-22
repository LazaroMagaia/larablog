<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return response()->json($user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(["message" => "O usuario nao existe em nosso banco de dados"]);
        }else{
            return response()->json($user);
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
        /*$validateData = $request->validate([
            'email' => "required|email|unique",
            'name'=>'required|min:3|max:255',
            'password'=>'required|min:8|confirmed',
        ],[
            'email.required'=>'O campo email deve ser preenchido',
            'email.email'=>'Intoduza um email valido',
            'email.unique'=>'Este email ja esta em uso, tente outro',
            'name.required'=>'O campo nome deve ser preenchido',
            'name.min'=>'o minimo de carateres deve ser superior a 3',
            'name.max'=>'o minimo de carateres deve ser inferior a 255',
            'password.required'=>'O campo senha deve ser preenchido',
            'password.min'=>'o minimo de carateres deve ser superior a 8',
            'password.confirmed'=>'confirme a senha porfavor',
        ]);*/
        $user = array();
        $user['name'] = $request->name;
        $user['email'] = $request->email;
        $user['password'] = $request->password;
        $image = $request->image;
        if($image)
        {
            $position = strpos($image,';');
            $sub = substr($image,0,$position);
            $ext = explode('/',$sub)[1];
            $name =time().".".$ext;
            $upload_path = 'backend/images/';
            $image_url =$upload_path.$name;
            $success = $image->save($image_url);
            if($user['password'])
            {
                $user['password'] = Hash::make($request->password);
            }
            if($success)
            {
                $user['image'] = $image_url;
                $img = DB::table('users')->where('id',$id)->first();
                $image_path = $img->image;
                $done = unlink($image_path);
                $articles = DB::table('blogs')->where('id',$id)->update($user);
                return response()->json(['message'=>'Editado com sucesso']);
            }
        }else
        {
            $oldphoto = $request->image;
            $user['image'] =$oldphoto;
            $articles = DB::table('users')->where('id',$id)->update($user);
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
        $user = User::find($id);
        if(!$user){
            return response()->json(["message"=>"O usuario nao esxiste em nosso banco de dados"]);
        }else
        {
            $user->delete();
            return response()->json(["message"=>"usuario removido com sucesso"]);
        }
    }
}
