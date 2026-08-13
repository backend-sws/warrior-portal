<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $tuitions = \App\Models\HomeTuitionLead::where('user_id', $user->id)
            ->orWhere(function($query) use ($user) {
                if ($user->phone) {
                    $cleanPhone = preg_replace('/[^0-9]/', '', $user->phone);
                    $query->where('parent_mobile', $user->phone)
                          ->orWhere('parent_mobile', 'like', "%{$cleanPhone}%");
                }
            })
            ->latest()
            ->get();

        $leadIds = $tuitions->pluck('id')->toArray();

        $serviceChargeInvoices = \App\Models\ParentServiceChargeInvoice::with('lead')
            ->where(function($query) use ($user, $leadIds) {
                $query->where('user_id', $user->id);
                if (!empty($leadIds)) {
                    $query->orWhereIn('home_tuition_lead_id', $leadIds);
                }
            })
            ->latest()
            ->get();

        return view('parent.dashboard', compact('tuitions', 'serviceChargeInvoices'));
    }
}
