<?php

namespace App\Http\Controllers;

use App\DTOs\UserDTO;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index(): View
    {
        $users = $this->userService->getAll(10);

        return view('user.index', compact('users'));
    }

    public function create(): View
    {
        $roles = $this->userService->getRoles();
        return view('user.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'type' => [
                'required',
                Rule::in([
                    'admin',
                    'vendor',
                    'uservendor',
                ]),
            ],

            'state' => [
                'required',
                'boolean',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name'),
            ],
        ]);



        $dto = UserDTO::fromRequest($request);

        $this->userService->create($dto);
        toastr()->success('Usuario creado exitosamente.');
        return redirect()
            ->route('user.index');
    }

    public function show(User $user): View
    {
        $user = $this->userService->findById($user->id);

        return view('user.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $user = $this->userService->findById($user->id);
        $roles = $this->userService->getRoles();
        return view('user.edit', compact('user', 'roles'));
    }


    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'type' => [
                'required',
                Rule::in([
                    'admin',
                    'vendor',
                    'uservendor',
                ]),
            ],

            'state' => [
                'required',
                'boolean',
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name'),
            ],
        ]);

        $dto = UserDTO::fromRequest($request);

        $this->userService->update($user, $dto);
        toastr()->success('Usuario actualizado exitosamente.');
        return redirect()
            ->route('user.index');
    }



    public function destroy(User $user): RedirectResponse
    {
        $this->userService->delete($user);
        toastr()->success('Usuario eliminado exitosamente.');
        return redirect()
            ->route('user.index');
    }
}
