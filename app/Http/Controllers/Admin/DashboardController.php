<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SubscriptionController;
use App\Models\MealApp\User;
use App\Models\Payment;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalUsers = User::count();
        $verifiedUsers = User::whereNotNull('email_verified_at')->count();
        $unverifiedUsers = User::whereNull('email_verified_at')->count();
        $usersThisWeek = User::whereDate('created_at', Carbon::today())->count();
        $usersList = User::whereDate('created_at', Carbon::today())->get();
        //$usersThisWeek =User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $usersList=$this->userListThisWeek();
        if ($request->has('status')){
            $usersList=$this->filter_user_list($request)->latest()->paginate(10)->withQueryString();
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'verifiedUsers',
            'unverifiedUsers',
            'usersThisWeek',
            'usersList',
        ));
    }

    public function all_user_list(Request $request)
    {
//        $query = User::query();
//
//        if ($request->has('status')) {
//            if ($request->status == 'verified') {
//                $query->whereNotNull('email_verified_at');
//            } elseif ($request->status == 'unverified') {
//                $query->whereNull('email_verified_at');
//            } elseif ($request->status == 'new') {
//                $query->whereDate('created_at', now()->toDateString());
//            }
//        }
//
//        // Search by name, id, or email
//        if ($request->filled('search')) {
//            $searchTerm = $request->search;
//
//            $query->where(function ($q) use ($searchTerm) {
//                $q->where('name', 'like', "%$searchTerm%")
//                    ->orWhere('email', 'like', "%$searchTerm%")
//                    ->orWhere('id', $searchTerm);
//            });
//        }
//
//        // Paginate and preserve query strings
//        $users = $query->latest()->paginate($request->paginate)->withQueryString();
        $users=$this->filter_user_list($request)->latest()->paginate($request->paginate)->withQueryString();
       return view('admin.users-list', compact('users'));

    }
    public function filter_user_list(Request $request)
    {
        $query = User::query();

        if ($request->has('status')) {
            if ($request->status == 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status == 'unverified') {
                $query->whereNull('email_verified_at');
            } elseif ($request->status == 'new') {
                $query->whereDate('created_at', now()->toDateString());
            }
        }

        // Search by name, id, or email
        if ($request->filled('search')) {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%$searchTerm%")
                    ->orWhere('email', 'like', "%$searchTerm%")
                    ->orWhere('id', $searchTerm);
            });
        }

        // Paginate and preserve query strings
        return $query;
//       return view('admin.users-list', compact('users'));

    }
    public function userListThisWeek(){
        return User::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->latest()->paginate(10);
    }
    public function payments(){
        $payments=Payment::with('user')->get();
        return view('admin.payments', compact('payments'));
    }

    public function view_payment_form(Request $request)
    {
        $sub=new SubscriptionController();
        $plans=$sub->plans();
      return  view('admin.make-payment-form', compact('plans'));

    }
    public function make_payments(Request $request){
        $plan = Plan::findOrFail($request->plan_id);
        $user = User::findOrFail($request->user_id);

        // Simulate successful payment (for now)
        $payment = Payment::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'payment_method' => 'Manually Set',
            'amount' => $plan->price,
            'payment_status' => 'success',
        ]);
        // Update user plan
        $user->plan_id = $plan->id;
        if ($plan->price > 0) {
            $user->expires_at = now()->addDays(365);
        } else {
            $user->expires_at = null;
        }
        $user->save();
        return redirect()->route('admin.dashboard.payments')->with('success', 'Payment made successfully');
    }

}
