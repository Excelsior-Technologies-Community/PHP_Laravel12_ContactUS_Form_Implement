<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMessages = ContactMessage::count();
        $newToday = ContactMessage::whereDate('created_at', Carbon::today())->count();
        $newThisWeek = ContactMessage::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->count();
        $unread = ContactMessage::where('status', 'new')->count();

        $chartData = ContactMessage::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [Carbon::now()->subDays(14), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $chartData->pluck('date')->map(fn($d) => Carbon::parse($d)->format('M d'));
        $values = $chartData->pluck('count');

        return view('dashboard', compact('totalMessages', 'newToday', 'newThisWeek', 'unread', 'labels', 'values'));
    }
}
