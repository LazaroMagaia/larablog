<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class BlogController extends Controller
{
    private $blog;
    public function __construct(Blog $blog)
    {
        $this->blog= $blog;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog = Blog::where('title','!=',Null)
        ->orderBy('date',"DESC")
        ->paginate(8);
        return $blog;
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
        $blog = array();
        $validateData = $request->validate([
            "title"=>"required|min:3|max:255|unique:blogs,title",
            "slug"=>"required|",
            "description"=>"required|min:3|",
            "categorie"=>"required|min:3|max:255",
        ],[
          "title.required" => 'O campo titulo deve ser preechido',
          "title.unique" => 'Outro artigo ja tem esse titulo',
          "title.min" => 'o minimo de caracteres deve ser 3',
          "title.max" => 'o maximo de caracteres deve ser 255',
          "description.required" => 'O caampo descrition deve ser preechido',
          "description.min" => 'o minimo de caracteres deve ser 3',
          "description.max" => 'o maximo de caracteres deve ser 255',
          "categorie.required" => 'O campo Categoria deve ser preechido',
          "categorie.min" => 'o minimo de caracteres deve ser 3',
          "categorie.max" => 'o maximo de caracteres deve ser 255',
        ]);
        $blog['image'] = $request->image;
        $blog['title'] = $request->title;
        $blog['slug'] = Str::slug($request->slug);
        $blog['description'] = $request->description;
        $blog['categorie'] = $request->categorie;
        $blog['author'] = $request->author;
        $blog['date'] = date(now());
        $blog['date'] = implode("-",array_reverse(explode("/",$blog['date'])));
        if($blog['image']){
            $position = strpos($blog['image'],';');
            $sub = substr($blog['image'],0,$position);
            $ext = explode('/',$sub)[1];
            $Imagename =time().".".$ext;
            $upload_path = 'backend/images/';
            $image_url =$upload_path.$Imagename;
            $image = Image::make($request->image);
            $image->save($image_url);
            $blog['image'] = $image_url;
            DB::table('blogs')->insert($blog);
            return response()->json(['message'=>'enviado com sucesso']);
        }else{
            $blog['image'] ="";
            DB::table('blogs')->insert($blog);
            return response()->json(['message'=>'enviado com sucesso']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = DB::table('blogs')->where("slug",$id)->first();
        if(!$blog){
            if($blog = DB::table('blogs')->where("id",$id)->first()){
                return response()->json($blog);
            }else{
                return response()->json(['message'=>'O artigo nao existe em nosso banco de dados'],400);
            }
            return response()->json(['message'=>'O artigo nao existe em nosso banco de dados'],400);
        }else
        {
            return response()->json($blog);
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
    {   $validateData = $request->validate([
        "title"=>"required|min:3|max:255|unique:blogs,title,".$id,
        "slug"=>"required|",
        "description"=>"required|min:3|",
        "categorie"=>"required|min:3|max:255",
        ],[
        "title.required" => 'O campo titulo deve ser preechido',
        "title.unique" => 'Outro artigo ja tem esse titulo',
        "title.min" => 'o minimo de caracteres deve ser 3',
        "title.max" => 'o maximo de caracteres deve ser 255',
        "description.required" => 'O caampo descrition deve ser preechido',
        "description.min" => 'o minimo de caracteres deve ser 3',
        "description.max" => 'o maximo de caracteres deve ser 255',
        "categorie.required" => 'O caampo Categoria deve ser preechido',
        "categorie.min" => 'o minimo de caracteres deve ser 3',
        "categorie.max" => 'o maximo de caracteres deve ser 255',
        ]);
        $data = array();
        $data['title'] = $request->title;
        $data['slug'] = $request->slug;
        $data['description'] = $request->description;
        $data['categorie'] = $request->categorie;
        $data['author'] = $request->author;
        $image = $request->newimage;
        $blog['date'] =\DateTime:: createFromFormat('d/m/Y', $request->date);

        if($image)
        {
            $position = strpos($image,';');
            $sub = substr($image,0,$position);
            $ext = explode('/',$sub)[1];
            $name =time().".".$ext;
            $image = Image::make($image);
            $upload_path = 'backend/images/';
            $image_url =$upload_path.$name;
            $success = $image->save($image_url);
            if($success)
            {
                $data['image'] = $image_url;
                $img = DB::table('blogs')->where('id',$id)->first();
                $image_path = $img->image;
                if($image_path == "")
                {
                    $user = DB::table('blogs')->where('id',$id)->update($data);
                }else{
                    $done = unlink($image_path);
                    $user = DB::table('blogs')->where('id',$id)->update($data);
                }
            }
        }else
        {
            $oldphoto = $request->image;
            $data['image'] =$oldphoto;
            $user = DB::table('blogs')->where('id',$id)->update($data);
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
        $blog = DB::table('blogs')->where('id',$id)->first();
        if(!$blog){
            return response()->json(['message'=>'O artigo nao existe em nosso banco de dados'],400);
        }
        $image = $blog->image;
        if($image){
            unlink($image);
            DB::table('blogs')->where('id',$id)->delete();
            return response()->json(['message'=>'Removido com sucesso']);
        }else{
            DB::table('blogs')->where('id',$id)->delete();
            return response()->json(['message'=>'Removido com sucesso']);
        }
    }
    public function search(Request $request)
    {
        $data = $request->KeySearch;

            if($data =='')
            {
                $blog = $this->blog
                ->paginate(8);
            }else{
                $blog = $this->blog
                ->where('title','LIKE',"%{$data}%")
                ->orderBy('date',"DESC")
                ->paginate(8);
            }

        return response()->json($blog);
    }
    public function CategorieSearch(Request $request)
    {
        $data = $request->title;

            if($data =='')
            {
                $blog = $this->blog
                ->paginate(8);
            }else{
                $blog = $this->blog
                ->where('categorie',$data)
                ->orderBy('categorie',"DESC")
                ->paginate(8);
            }

        return response()->json($blog);
    }
}
