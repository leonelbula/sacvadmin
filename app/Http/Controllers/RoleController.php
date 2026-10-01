<?php

namespace App\Http\Controllers;

use App\DTOs\RoleDTO;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(
        protected RoleService $roleService
    ) {}

    public function index(): View
    {
        $roles = $this->roleService->getAll();

        return view('role.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = $this->roleService->getPermissions();

        return view('role.create', compact('permissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:roles,name',
            ],

            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'string',
                Rule::exists('permissions', 'name'),
            ],
        ]);

        $dto = RoleDTO::fromRequest($request);

        $this->roleService->create($dto);
        toastr()->success('Rol creado exitosamente.');
        return redirect()
            ->route('role.index');
    }

    public function show(Role $role): View
    {
        $role = $this->roleService->findById($role->id);

        $usersCount = User::role($role->name)->count();

        return view(
            'role.show',
            compact('role', 'usersCount')
        );
    }

    public function edit(Role $role): View
    {
        $role = $this->roleService->findById($role->id);

        $permissions = $this->roleService->getPermissions();

        return view(
            'role.edit',
            compact('role', 'permissions')
        );
    }

    public function update(
        Request $request,
        Role $role
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')
                    ->ignore($role->id),
            ],

            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'string',
                Rule::exists('permissions', 'name'),
            ],
        ]);

        $dto = RoleDTO::fromRequest($request);

        $this->roleService->update($role, $dto);
        toastr()->success('Rol actualizado exitosamente.');
        return redirect()
            ->route('role.index');
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->name === 'Administrador') {
            toastr()->error('El rol Administrador no puede eliminarse.');
            return redirect()
                ->route('role.index');
        }

        $this->roleService->delete($role);
        toastr()->success('success', 'Rol eliminado exitosamente.');
        return redirect()
            ->route('role.index');
    }
}
