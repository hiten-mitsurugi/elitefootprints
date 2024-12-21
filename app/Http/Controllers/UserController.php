<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::paginate(10);

        return Inertia::render('Frontend/User/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return Inertia::render('Frontend/User/Create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'address' => 'nullable|string',
            'contactNumber' => 'nullable|string',
            'password' => 'required|string|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // avatar validation
        ]);

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        // Create a new user
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->address = $validated['address'];
        $user->contactNumber = $validated['contactNumber'];
        $user->password = $validated['password'];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $filename = $image->getClientOriginalName();  // Get the original filename
            $imagePath = $image->storeAs('avatars', $filename, 'public'); // Save the avatar in the 'avatars' directory
            $user->avatar = $imagePath; // Store the file path in the database
        }

        // Save the user to the database
        $user->save();

        // Redirect or return a response
        return redirect()->route('user.index')->with('message', 'User created successfully');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return Inertia::render('Frontend/User/Show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return Inertia::render('Frontend/User/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
{
    // Validate the incoming request (exclude password validation)
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required|string',
        'address' => 'nullable|string',
        'contactNumber' => 'nullable|string',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // avatar validation
    ]);

    // Update other fields
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->role = $validated['role'];
    $user->address = $validated['address'];
    $user->contactNumber = $validated['contactNumber'];

    // Handle avatar upload if there is a new avatar
    if ($request->hasFile('avatar')) {
        // Delete the old avatar if it exists (optional but recommended)
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store the new avatar
        $image = $request->file('avatar');
        $filename = $image->getClientOriginalName(); // Get the original filename
        $imagePath = $image->storeAs('avatars', $filename, 'public'); // Save the avatar in the 'avatars' directory
        $user->avatar = $imagePath; // Update the user with the new avatar path
    }

    // Save the updated user to the database
    $user->save();

    return redirect()->route('user.index')->with('message', 'User updated successfully');
}


    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Delete the user's avatar if it exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Delete the user from the database
        $user->delete();

        return redirect()->route('user.index')->with('message', 'User deleted successfully');
    }
}
