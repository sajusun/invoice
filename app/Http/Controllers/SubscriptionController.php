<?php
namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = $this->plans();
        return view('subscription-plan.plan', compact('plans'));
    }

    public function plans(): Collection
    {
        return Plan::all();
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
