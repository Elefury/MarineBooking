<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
        {
            return view('admin.users.edit', compact('user'));
        }

        public function update(Request $request, User $user)
        {
            $user->update($request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'is_admin' => 'boolean'
            ]));

            return redirect()->route('admin.users.index');
        }




         public function destroy(User $user)
        {
            if ($user->is_admin) {
                return back()->with('error', 'Администратор не может быть удален.');
            }
            $bookingsCount = $user->bookings()->count();
            $voyageBookingsCount = $user->voyageBookings()->count();
            
            if ($bookingsCount > 0 || $voyageBookingsCount > 0) {
                $message = "Пользователь не может быть удален. ";
                
                if ($bookingsCount > 0) {
                    $message .= "У пользователя имеются бронирования круизов ($bookingsCount)";
                }
                
                if ($voyageBookingsCount > 0) {
                    if ($bookingsCount > 0) {
                    $message .= " и бронирования рейсов ($voyageBookingsCount)";
                    } else {
                    $message .= "У пользователя имеются бронирования рейсов ($voyageBookingsCount)";
                    }
                }
                $message .= ".";
                return back()->with('error', trim($message));
            }

            $user->delete();
            return back()->with('success', 'Пользователь был успешно удален.');
        }

    }
