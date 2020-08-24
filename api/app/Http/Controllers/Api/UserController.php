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
            'password' => 'string|min:6|confirmed|nullable',
            'chat_background' => 'mimes:jpeg,jpg,png|nullable'
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
            $file_name = $this->saveImage('profile_image', $request->image, $request->user()->image);
            $query->image = $file_name; //Guardamos el nombre del archivo
        }

        if($request->chat_background) {
            $file_name = $this->saveImage('chat_background', $request->chat_background, $request->user()->chat_background);
            $query->chat_background = $file_name;
        }

        $query->save();

        return $this->sendResponse(new userResource($query), 'Usuario modificado con éxito');
    }

    //  Type: 'profile_image', 'chat_background' 
    public function saveImage($type, $file, $user_local_file) {

        if($type === 'profile_image') {
            $path = public_path('/users/profile_image');
            $deletedFile = public_path() .  '/' . 'users/profile_image/' . $user_local_file;

        } else if($type === 'chat_background') {
            $path = public_path('/users/chat_background');
            $deletedFile = public_path() .  '/' . 'users/chat_background/' . $user_local_file;
        }

        if($user_local_file !== 'default.png') {
            unlink($deletedFile);
        }

        $file_name = time() . '.' . $file->getClientOriginalExtension();
        $file->move($path, $file_name);
        return $file_name;
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