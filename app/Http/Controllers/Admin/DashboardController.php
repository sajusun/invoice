<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MealApp\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $verifiedUsers = User::whereNotNull('email_verified_at')->count();
        $unverifiedUsers = User::whereNull('email_verified_at')->count();
//        $newUsersToday = User::whereDate('created_at', Carbon::today())->count();
        $usersThisWeek =User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        $userListThisWeek=$this->userListThisWeek();


        return view('admin.dashboard', compact(
            'totalUsers',
            'verifiedUsers',
            'unverifiedUsers',
            'usersThisWeek',
            'userListThisWeek',
        ));
    }
    public function userListThisWeek(){
        return User::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->latest()->get();
    }
}
