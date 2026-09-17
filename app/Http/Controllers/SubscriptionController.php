<?php
namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = $this->plans();
        $user = auth()->user();
        return view('subscription-plan.plan', compact('plans', 'user'));
    }

    public function plans(): Collection
    {
        $plans = Plan::all();
        if ($plans->isEmpty()) {
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\PlanSeeder']);
            $plans = Plan::all();
        }
        return $plans;
    }

    public function subscribe(Request $request)
    {
        $plan = Plan::findOrFail($request->plan_id);

        $user = auth()->user();
        $user->plan_id = $plan->id;
        $user->save();

        return redirect('/dashboard')->with('success', 'Plan updated successfully.');
    }
}
