<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Treatment;

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
        $user = Auth::user();
        
        if ($user->isSuperAdmin()) {
            return $this->superAdminDashboard();
        } elseif ($user->isAdmin()) {
            return $this->adminDashboard();
        } else {
            return $this->patientDashboard();
        }
    }

    /**
     * Super Admin Dashboard
     */
    private function superAdminDashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_patients' => User::where('role', 'patient')->count(),
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'completed_appointments' => Appointment::where('status', 'completed')->count(),
        ];

        $recent_appointments = Appointment::with(['patient', 'practitioner'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.superadmin', compact('stats', 'recent_appointments'));
    }

    /**
     * Admin (Raqi/Hijama Practitioner) Dashboard
     */
    private function adminDashboard()
    {
        $stats = [
            'total_appointments' => Appointment::where('practitioner_id', Auth::id())->count(),
            'pending_appointments' => Appointment::where('practitioner_id', Auth::id())->where('status', 'pending')->count(),
            'approved_appointments' => Appointment::where('practitioner_id', Auth::id())->where('status', 'approved')->count(),
            'completed_appointments' => Appointment::where('practitioner_id', Auth::id())->where('status', 'completed')->count(),
            'total_treatments' => Treatment::where('practitioner_id', Auth::id())->count(),
        ];

        $today_appointments = Appointment::with('patient')
            ->where('practitioner_id', Auth::id())
            ->where('appointment_date', today())
            ->orderBy('appointment_time')
            ->get();

        $upcoming_appointments = Appointment::with('patient')
            ->where('practitioner_id', Auth::id())
            ->where('appointment_date', '>', today())
            ->where('status', 'approved')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        return view('dashboard.admin', compact('stats', 'today_appointments', 'upcoming_appointments'));
    }

    /**
     * Patient Dashboard
     */
    private function patientDashboard()
    {
        $stats = [
            'total_appointments' => Appointment::where('user_id', Auth::id())->count(),
            'pending_appointments' => Appointment::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'approved_appointments' => Appointment::where('user_id', Auth::id())->where('status', 'approved')->count(),
            'completed_appointments' => Appointment::where('user_id', Auth::id())->where('status', 'completed')->count(),
        ];

        $upcoming_appointments = Appointment::with('practitioner')
            ->where('user_id', Auth::id())
            ->where('appointment_date', '>=', today())
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        $recent_appointments = Appointment::with('practitioner')
            ->where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.patient', compact('stats', 'upcoming_appointments', 'recent_appointments'));
    }
}
