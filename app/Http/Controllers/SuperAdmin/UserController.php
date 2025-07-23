<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\RaqiSessionType;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Search by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        // Search by email
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Filter by specialization
        if ($request->filled('specialization')) {
            $query->where('specialization', $request->specialization);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active');
        }
        
        $users = $query->paginate(10);
        
        // Preserve query parameters in pagination links
        $users->appends($request->all());
        
        return view('superadmin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Default fees for new user
        $diagnosisFee = 1500;
        $shortFee = 1000;
        $longFee = 3000;
        $headCuppingFee = 500;
        $bodyCuppingFee = 300;
        return view('superadmin.users.create', compact('diagnosisFee', 'shortFee', 'longFee', 'headCuppingFee', 'bodyCuppingFee'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin,patient',
            'specialization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'diagnosis_fee' => 'nullable|integer|min:0',
            'short_fee' => 'nullable|integer|min:0',
            'long_fee' => 'nullable|integer|min:0',
            'head_cupping_fee' => 'nullable|integer|min:0',
            'body_cupping_fee' => 'nullable|integer|min:0',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        // Save session fees if Raqi
        if ($user->role === 'admin' && $user->specialization) {
            if ($request->filled('diagnosis_fee')) {
                RaqiSessionType::updateOrCreate([
                    'practitioner_id' => $user->id,
                    'type' => 'diagnosis',
                ], [
                    'fee' => $request->diagnosis_fee,
                    'min_duration' => 30,
                    'max_duration' => 60,
                ]);
            }
            if ($request->filled('short_fee')) {
                RaqiSessionType::updateOrCreate([
                    'practitioner_id' => $user->id,
                    'type' => 'short',
                ], [
                    'fee' => $request->short_fee,
                    'min_duration' => 60,
                    'max_duration' => 90,
                ]);
            }
            if ($request->filled('long_fee')) {
                RaqiSessionType::updateOrCreate([
                    'practitioner_id' => $user->id,
                    'type' => 'long',
                ], [
                    'fee' => $request->long_fee,
                    'min_duration' => 180,
                    'max_duration' => 300,
                ]);
            }
            if ($request->filled('head_cupping_fee')) {
                RaqiSessionType::updateOrCreate([
                    'practitioner_id' => $user->id,
                    'type' => 'head_cupping',
                ], [
                    'fee' => $request->head_cupping_fee,
                    'min_duration' => 15,
                    'max_duration' => 30,
                ]);
            }
            if ($request->filled('body_cupping_fee')) {
                RaqiSessionType::updateOrCreate([
                    'practitioner_id' => $user->id,
                    'type' => 'body_cupping',
                ], [
                    'fee' => $request->body_cupping_fee,
                    'min_duration' => 15,
                    'max_duration' => 30,
                ]);
            }
        }

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('superadmin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Fetch current session fees for this user
        $diagnosisFee = \App\Models\RaqiSessionType::where('practitioner_id', $user->id)->where('type', 'diagnosis')->value('fee');
        $shortFee = \App\Models\RaqiSessionType::where('practitioner_id', $user->id)->where('type', 'short')->value('fee');
        $longFee = \App\Models\RaqiSessionType::where('practitioner_id', $user->id)->where('type', 'long')->value('fee');
        $headCuppingFee = \App\Models\RaqiSessionType::where('practitioner_id', $user->id)->where('type', 'head_cupping')->value('fee');
        $bodyCuppingFee = \App\Models\RaqiSessionType::where('practitioner_id', $user->id)->where('type', 'body_cupping')->value('fee');
        return view('superadmin.users.edit', compact('user', 'diagnosisFee', 'shortFee', 'longFee', 'headCuppingFee', 'bodyCuppingFee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin,patient',
            'specialization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'diagnosis_fee' => 'nullable|integer|min:0',
            'short_fee' => 'nullable|integer|min:0',
            'long_fee' => 'nullable|integer|min:0',
            'head_cupping_fee' => 'nullable|integer|min:0',
            'body_cupping_fee' => 'nullable|integer|min:0',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        // Handle email verification checkbox
        if ($request->has('email_verified') && $request->input('email_verified') == '1') {
            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
                $user->save();
            }
        } else {
            if ($user->email_verified_at) {
                $user->email_verified_at = null;
                $user->save();
            }
        }

        // Handle is_active checkbox
        $user->is_active = $request->has('is_active') ? true : false;
        $user->save();

        // Remove old session types for this user
        RaqiSessionType::where('practitioner_id', $user->id)->delete();

        // Save session fees if Raqi
        if ($user->role === 'admin' && $user->specialization) {
            if ($request->filled('diagnosis_fee')) {
                RaqiSessionType::create([
                    'practitioner_id' => $user->id,
                    'type' => 'diagnosis',
                    'fee' => $request->diagnosis_fee,
                    'min_duration' => 30,
                    'max_duration' => 60,
                ]);
            }
            if ($request->filled('short_fee')) {
                RaqiSessionType::create([
                    'practitioner_id' => $user->id,
                    'type' => 'short',
                    'fee' => $request->short_fee,
                    'min_duration' => 60,
                    'max_duration' => 90,
                ]);
            }
            if ($request->filled('long_fee')) {
                RaqiSessionType::create([
                    'practitioner_id' => $user->id,
                    'type' => 'long',
                    'fee' => $request->long_fee,
                    'min_duration' => 180,
                    'max_duration' => 300,
                ]);
            }
            if ($request->filled('head_cupping_fee')) {
                RaqiSessionType::create([
                    'practitioner_id' => $user->id,
                    'type' => 'head_cupping',
                    'fee' => $request->head_cupping_fee,
                    'min_duration' => 15,
                    'max_duration' => 30,
                ]);
            }
            if ($request->filled('body_cupping_fee')) {
                RaqiSessionType::create([
                    'practitioner_id' => $user->id,
                    'type' => 'body_cupping',
                    'fee' => $request->body_cupping_fee,
                    'min_duration' => 15,
                    'max_duration' => 30,
                ]);
            }
        }

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === \Illuminate\Support\Facades\Auth::id()) {
            return redirect()->route('superadmin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
