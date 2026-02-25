<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    public function index(): View
    {
        $admin = Auth::guard('admin')->user();

        return view('admin.perfil.index', compact('admin'));
    }

    public function update(Request $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name'   => ['required', 'string', 'max:100'],
            'email'  => ['required', 'email', 'unique:admin_users,email,' . $admin->id],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
        ], [
            'name.required'  => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.unique'   => 'Este email já está em uso.',
        ]);

        if ($request->hasFile('avatar')) {
            // Remove old avatar if it's a stored file
            if ($admin->avatar && str_starts_with($admin->avatar, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $admin->avatar);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = Storage::disk('public')->url($path);
        }

        $admin->fill(array_filter($validated, fn ($v) => $v !== null));
        $admin->save();

        return back()->with('success', 'Perfil atualizado com sucesso.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'current_password' => [
                'required',
                function (string $attribute, mixed $value, \Closure $fail) use ($admin) {
                    if (! Hash::check($value, $admin->password)) {
                        $fail('A senha atual está incorreta.');
                    }
                },
            ],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'A senha atual é obrigatória.',
            'new_password.required'     => 'A nova senha é obrigatória.',
            'new_password.min'          => 'A nova senha deve ter pelo menos 8 caracteres.',
            'new_password.confirmed'    => 'As senhas não coincidem.',
        ]);

        $admin->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Senha alterada com sucesso.');
    }
}
