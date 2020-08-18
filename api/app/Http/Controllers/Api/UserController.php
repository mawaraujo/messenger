<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Models\User as UserResource;
use App\Http\Resources\Collections\UserCollection;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::orderBy('created_at', 'desc');

        UserCollection::withoutWrapping();
        
        return $this->sendCollectionResource(
            new UserCollection($query->paginate($request->get('limit', 15))),
            'Usuarios encontrados'
        );
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
    public function show(User $user)
    {
        UserResource::withoutWrapping();
        return $this->sendResponse(new UserResource($user), 'User found');
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
        if($request->user()->id != $id) {
            return $this->sendError('No puedes modificar este usuario', 422);
        }

        $validator = Validator::make($request->all(), [
            'image' => 'mimes:jpeg,jpg,png|nullable',
            'name' => 'string|nullable',
            'chat_status' => 'string|nullable',
            'password' => 'string|min:6|confirmed|nullable'
        ]);

        if($validator->fails()) {
            return $this->sendError($validator->errors()->all(), 422);
        }

        $query = $request->user();
       
        if($request->name) {
            $query->name = $request->name;
        }

        if($request->password) {
            $query->password = Hash::make($request->password);
        }

        if($request->chat_status) {
            $query->chat_status = $request->chat_status;
        }

        if($request->image) {
            $file = $request->image;
            $path = public_path('/users');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $file_name);

            //Eliminamos el archivo anterior utilizado por el usuario
            $deletedFile = public_path() .  '/' . 'users/' . $request->user()->image;
            unlink($deletedFile);

            //Guardamos el nombre del archivo
            $query->image = $file_name;
        }

        $query->save();

        return $this->sendResponse(new userResource($query), 'Usuario modificado con éxito');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
