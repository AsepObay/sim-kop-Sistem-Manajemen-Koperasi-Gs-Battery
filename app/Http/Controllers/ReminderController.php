<?php

namespace App\Http\Controllers;

use App\Models\InvoiceReminder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReminderController extends Controller
{
    public function index(): View
    {
        $reminders = InvoiceReminder::pendingForDisplay();

        return view('admin.reminders.index', compact('reminders'));
    }
}
