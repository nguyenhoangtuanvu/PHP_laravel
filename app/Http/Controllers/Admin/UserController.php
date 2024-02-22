<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUsersRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;
    protected $role;

    public function __construct(User $user, Role $role) {
        $this->user = $user;
        $this->role = $role;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->user->latest('id')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->role->all()->groupBy('group');
        // dd($roles);
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request) 
    {
        $dataCreate = $request->all();
        $dataCreate['password'] = Hash::make($request->password);
        $dataCreate['image'] = $this->user->saveImage($request);

        $user = User::create($dataCreate);
        $user->images()->create([ 'url' => $dataCreate['image']]);
        $user->roles()->attach($dataCreate['role_ids']);   // attach gán cho user 1 list roles
        return to_route('user.index')->with(['message' => 'create successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->user->findOrFail($id)->load('roles');  // load quan hệ roles của user;
        $roles = $this->role->all()->groupBy('group');

        return view('admin.users.edit', compact('user', 'roles')); // 42 phút
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsersRequest $request, string $id)
    {
        $user = $this->user->findOrFail($id)->load('roles');
        $dataUpdate = $request->except('password'); // except: lấy hết trừ password
        // dd($request->has('image'));
        if ($request->password) {
            $dataUpdate['password'] = Hash::make($request->password);
        }

        $currentImage = $user?->images?->first()?->url;
        $dataUpdate['image'] = $this->user->updateImage($request, $currentImage); // delete old image and upload new image.
        $user->update($dataUpdate);
        $user->images()->delete();
        $user->images()->create([ 'url' => $dataUpdate['image']]);
        $user->roles()->sync($dataUpdate['role_ids'] ?? []);  // sync đồng bộ lại roles cho user 

        return to_route('user.index')->with(['message' => 'update successfully']);    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = $this->user->findOrFail($id)->load('roles');
        $image = $user?->images?->first()?->url;
        $result = $this->user->deleteImage($image); 
        // dd($result);
        $user->images()->delete();
        $user->delete();
        return to_route('user.index')->with(['message' => 'delete successfully']);
    }
}
