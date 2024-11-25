<?php

namespace App\Http\Controllers;

use App\Models\EntityRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        /**
         *Dashboard shows all counts
         */
        $successCount = EntityRequest::where('status', 'success')
            ->selectRaw('COUNT(*) as total_success_accounts')
            ->get()[0];

        $rejectCount = EntityRequest::where('status', 'Failed')
            ->selectRaw('COUNT(*) as total_failed_accounts')
            ->get()[0];

        $totalCount = EntityRequest::selectRaw('COUNT(*) as total_accounts')
            ->get()[0];

        $latestCreatedAt = EntityRequest::orderBy('created_at', 'desc')->value('created_at');

        $latestDate = $latestCreatedAt ? \Carbon\Carbon::parse($latestCreatedAt)->format('Y-m-d') : 'N/A';

        //dd($dateOnly);


        $count = array(

            'successCount' => $successCount->total_success_accounts,    
            'failCount' => $rejectCount->total_failed_accounts,
            'totalCount' => $totalCount->total_accounts,
            'latestDate' => $latestDate,

        );
        //dd($count);


        return view('batch.dashboard', ['count' => $count]);
    }

}
