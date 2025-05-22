<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get the current month's expenses
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $all_time_expense = Auth::user()->expenses()->sum('amount');
        
        $all_expense_user = Auth::user()->expenses()
                                ->orderBy('date', 'desc') // Sort by the date column in ascending/des order
                                ->get();

        // Get expenses for the current month
        $expenses = Auth::user()->expenses()->whereMonth('date', $currentMonth)
                                            ->whereYear('date', $currentYear)
                                            ->latest()
                                            ->get();

        // Get the user's monthly earnings from the `users` table
        $earnings = Auth::user()->monthly_earnings;
        $earnings = $earnings ?? 0;

        // Calculate the total expense for the current month
        $totalExpense = $expenses->sum('amount');

        // Calculate the remaining balance
        $remaining = $earnings - $totalExpense;
        
        // Calculate the percentage of earnings spent
        $spendPercentage = $earnings > 0 ? ($totalExpense / $earnings) * 100 : 0;

        // Determine the trend based on the percentage spent
        $trend = 'Normal'; 
        if ($spendPercentage < 30) {
            $trend = 'Good';
        } elseif ($spendPercentage > 90) {
            $trend = 'Very Bad';
        }elseif ($spendPercentage > 70) {
            $trend = 'Bad';
        }

        // Group expenses by category for pie chart
        $categoryWiseExpense = Auth::user()->expenses()
                                        ->whereMonth('date', $currentMonth)
                                        ->whereYear('date', $currentYear)
                                        ->selectRaw('category_id, sum(amount) as total_amount')
                                        ->groupBy('category_id')
                                        ->get();

        // Extract category data for chart
        $categories = $categoryWiseExpense->pluck('category_id')->toArray();
        $amounts = $categoryWiseExpense->pluck('total_amount')->toArray();

        // Get the total expenses for the last 6 months (or any number of months)
        $monthlyExpenses = Auth::user()->expenses()
                                    ->whereYear('date', $currentYear)
                                    ->whereMonth('date', '>=', $currentMonth - 5)
                                    ->selectRaw('month(date) as month, sum(amount) as total_amount')
                                    ->groupBy('month')
                                    ->get()
                                    ->sortBy('month');
        
        // Prepare data for chart
        $months = $monthlyExpenses->pluck('month');
        $expensesData = $monthlyExpenses->pluck('total_amount');

        // Pass all the data to the view
        return view('home', compact('all_time_expense','all_expense_user','totalExpense', 'remaining', 'spendPercentage', 'trend', 'categories', 'amounts', 'months', 'expensesData'));
    }

     public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'category' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $userid = Auth::user()->id;
        // dd($userid);

        Expense::create([
            'user_id' => $userid,
            'date' => $request->date,
            'amount' => $request->amount,
            'category_id' => $request->category,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Expense added successfully!');
    }
}