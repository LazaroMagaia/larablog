<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Mail\Message;
use Symfony\Component\CssSelector\Node\FunctionNode;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','signup','forgot','reset']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validataData = $request->validate([
            'email' => "required",
            'password' => "required"
        ],
        [
            'email.required'=>'O campo Email deve ser preenchido',
            'password.required'=>'O campo senha deve ser preenchido',
            'password.min'=>'O campo senha deve ter pelo menos 8 caracteres',
            'password.confirmed'=>'O campo senha deve ser igual ao da confirmacao da senha'
        ]);
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email ou senha invalida'], 401);
        }

        return $this->respondWithToken($token);
    }
    public function signup(Request $request)
    {
        $validataData = $request->validate(
            [
                'email' => 'required|unique:users|max:255',
                'name' => 'required|min:3',
                'password' => 'required|min:8|confirmed'
            ],        [
                'email.required'=>'O campo Email deve ser preenchido',
                'name.required'=>'O campo Nome deve ser preenchido',
                'password.required'=>'O campo senha deve ser preenchido',
                'password.min'=>'O campo senha deve ter pelo menos 8 caracteres',
                'password.confirmed'=>'O campo senha deve ser igual ao da confirmacao da senha'
            ]);
        $data =array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['image'] = $request->image;
        if(!$data['image']){
            $data['image']="";
            $data['password'] = Hash::make($request->password);
            DB::table('users')->insert($data);
            return $this->login($request);
        }
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'saiu com sucesso']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
            'email' => auth()->user()->email,
        ]);
    }

    public function forgot(Request $request)
    {
        $validataData = $request->validate(
        [
            'email' => 'required|max:255|email',
        ],['email.required' => "O campo Email deve ser preenchido",
            'email.email' => "Insira um email valido"
        ]);

        $email = $request->email;
        if(User::where('email',$email)->doesntExist())
        {
            return response()->json(['errors' => 'o email não existe'],400);
        }else{
        $token =Str::random(10);
        try{
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token
            ]);
            Mail::send('Mails.forgot',['token'=> $token],function(Message $message) use ($email){
                $message->to($email);
                $message->subject('Resetar sua senha');
            });
            return response()->json([
                'message' => 'Visite seu email'
            ]);
            }catch(\Exception $e)
            {
                return response()->json([
                    'message' => 'Erro no envio de email'
                ]);
            }
        }
    }

    public function reset(Request $request)
    {
        $validataData = $request->validate(
            [
                'token' => 'required',
                'password' => 'required|min:8|confirmed'
            ],[
                'password.required'=>'O campo senha deve ser preenchido',
                'password.min'=>'O campo senha deve ter pelo menos 8 caracteres',
                'password.confirmed'=>'O campo senha deve ser igual ao da confirmacao da senha'
            ]);
        $token = $request->token;

        /*@var User $user *///para poder ler a variavel $user como User
        if(!$passreset = DB::table('password_resets')->where('token',$token)->first()){
            return response()->json([
                "message" => "Token invalido"
            ],400);
        }
        if(!$user = User::where('email',$passreset->email)->first())
        {
            return response()->json([
                'message' => 'O email nao existe'
            ],400);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            "message" => "Senha trocada com sucesso"
        ],200);
    }
}
