<?php
// File: app/Http/Controllers/ParkingController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ParkingController extends Controller
{
    // Initialize default data structure in session
    private function initializeData()
    {
        if (!Session::has('users')) {
            Session::put('users', [
                [
                    'id' => 1,
                    'name' => 'Maria Santos',
                    'email' => 'maria@student.edu',
                    'password' => 'pass123',
                    'role' => 'student',
                    'student_id' => '2024-1001',
                    'course' => 'Computer Science',
                    'contact' => '09123456789'
                ],
                [
                    'id' => 2,
                    'name' => 'John Cruz',
                    'email' => 'john@student.edu',
                    'password' => 'pass123',
                    'role' => 'student',
                    'student_id' => '2024-1002',
                    'course' => 'Engineering',
                    'contact' => '09123456788'
                ],
                [
                    'id' => 3,
                    'name' => 'Sophia Reyes',
                    'email' => 'sophia@student.edu',
                    'password' => 'pass123',
                    'role' => 'student',
                    'student_id' => '2024-1003',
                    'course' => 'Architecture',
                    'contact' => '09123456787'
                ],
                [
                    'id' => 999,
                    'name' => 'Administrator',
                    'email' => 'admin@parking.edu',
                    'password' => 'admin123',
                    'role' => 'admin'
                ]
            ]);
        }
        
        if (!Session::has('applications')) {
            Session::put('applications', [
                [
                    'id' => 101,
                    'user_id' => 1,
                    'student_name' => 'Maria Santos',
                    'plate_number' => 'NMA-7890',
                    'vehicle_type' => 'Car',
                    'vehicle_model' => 'Toyota Vios',
                    'color' => 'White Pearl',
                    'status' => 'Approved',
                    'date' => '2025-03-25',
                    'approved_by' => 'Administrator',
                    'approval_date' => '2025-03-26',
                    'payment_status' => 'Paid',
                    'parking_slot' => 'A-12'
                ],
                [
                    'id' => 102,
                    'user_id' => 2,
                    'student_name' => 'John Cruz',
                    'plate_number' => 'XYZ-1234',
                    'vehicle_type' => 'Motorcycle',
                    'vehicle_model' => 'Honda Click',
                    'color' => 'Matte Black',
                    'status' => 'Pending',
                    'date' => '2025-03-28',
                    'approved_by' => null,
                    'approval_date' => null,
                    'payment_status' => 'Unpaid',
                    'parking_slot' => null
                ],
                [
                    'id' => 103,
                    'user_id' => 3,
                    'student_name' => 'Sophia Reyes',
                    'plate_number' => 'ABC-5678',
                    'vehicle_type' => 'Car',
                    'vehicle_model' => 'Mitsubishi Mirage',
                    'color' => 'Red',
                    'status' => 'Pending',
                    'date' => '2025-03-29',
                    'approved_by' => null,
                    'approval_date' => null,
                    'payment_status' => 'Unpaid',
                    'parking_slot' => null
                ]
            ]);
        }
        
        if (!Session::has('transactions')) {
            Session::put('transactions', [
                [
                    'id' => 1,
                    'application_id' => 101,
                    'amount' => 500,
                    'payment_method' => 'GCash',
                    'reference_number' => 'GCH-20250326-001',
                    'date' => '2025-03-26',
                    'status' => 'Completed',
                    'approved_by' => 'Administrator',
                    'semester' => '2nd Sem 2024-2025',
                    'valid_until' => '2025-08-31'
                ]
            ]);
        }
        
        if (!Session::has('parking_spots')) {
            $spots = [];
            // Car spots A-01 to A-15
            for ($i = 1; $i <= 15; $i++) {
                $spots[] = [
                    'id' => "A-" . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'type' => 'Car',
                    'status' => ($i == 12) ? 'Occupied' : 'Available',
                    'assigned_to' => ($i == 12) ? 101 : null
                ];
            }
            // Motorcycle spots B-01 to B-10
            for ($i = 1; $i <= 10; $i++) {
                $spots[] = [
                    'id' => "B-" . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'type' => 'Motorcycle',
                    'status' => 'Available',
                    'assigned_to' => null
                ];
            }
            Session::put('parking_spots', $spots);
        }
    }
    
    private function getNextId($key)
    {
        $items = Session::get($key, []);
        return count($items) > 0 ? max(array_column($items, 'id')) + 1 : 1;
    }
    
    public function showLogin()
    {
        if (Session::has('user')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $this->initializeData();
        $users = Session::get('users', []);
        
        $user = collect($users)->first(function ($u) use ($request) {
            return $u['email'] === $request->email && $u['password'] === $request->password;
        });
        
        if ($user) {
            Session::put('user', $user);
            return redirect()->route('dashboard')->with('success', 'Welcome back, ' . $user['name'] . '!');
        }
        
        return back()->with('error', 'Invalid credentials.')->withInput();
    }
    
    public function register(Request $request)
    {
        // Custom validation to check unique email in session
        $this->initializeData();
        $users = Session::get('users', []);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);
        
        // Check if email already exists in session
        $emailExists = collect($users)->contains('email', $request->email);
        
        if ($emailExists) {
            return back()->withErrors(['email' => 'This email is already registered.'])->withInput();
        }
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $newUser = [
            'id' => $this->getNextId('users'),
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'student',
            'student_id' => '2025-' . ($this->getNextId('users') + 1000),
            'course' => $request->course ?? 'Not Specified',
            'contact' => $request->contact ?? 'N/A'
        ];
        
        $users[] = $newUser;
        Session::put('users', $users);
        Session::put('user', $newUser);
        
        return redirect()->route('dashboard')->with('success', 'Registration successful! Welcome to ParkSmart.');
    }
    
    public function logout()
    {
        Session::forget('user');
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
    
    public function dashboard()
    {
        $this->initializeData();
        $user = Session::get('user');
        $applications = Session::get('applications', []);
        $transactions = Session::get('transactions', []);
        
        $stats = [
            'total_applications' => count($applications),
            'pending' => count(array_filter($applications, fn($a) => $a['status'] === 'Pending')),
            'approved' => count(array_filter($applications, fn($a) => $a['status'] === 'Approved')),
            'total_revenue' => array_sum(array_column(array_filter($transactions, fn($t) => $t['status'] === 'Completed'), 'amount')),
            'available_spots' => count(array_filter(Session::get('parking_spots', []), fn($s) => $s['status'] === 'Available')),
            'paid_permits' => count(array_filter($transactions, fn($t) => $t['status'] === 'Completed'))
        ];
        
        $recentApplications = array_slice($applications, -5, 5, true);
        $recentApplications = array_reverse($recentApplications);
        
        $chartData = [
            'pending' => $stats['pending'],
            'approved' => $stats['approved']
        ];
        
        return view('pages.dashboard', compact('stats', 'recentApplications', 'chartData', 'user'));
    }
    
    public function showApplyForm()
    {
        return view('pages.apply');
    }
    
    public function submitApplication(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20',
            'vehicle_type' => 'required|in:Car,Motorcycle',
            'vehicle_model' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50'
        ]);
        
        $this->initializeData();
        $user = Session::get('user');
        $applications = Session::get('applications', []);
        
        // Check duplicate plate
        if (collect($applications)->contains('plate_number', strtoupper($request->plate_number))) {
            return back()->with('error', 'This plate number already has an application.')->withInput();
        }
        
        $newApplication = [
            'id' => $this->getNextId('applications'),
            'user_id' => $user['id'],
            'student_name' => $user['name'],
            'plate_number' => strtoupper($request->plate_number),
            'vehicle_type' => $request->vehicle_type,
            'vehicle_model' => $request->vehicle_model,
            'color' => $request->color,
            'status' => 'Pending',
            'date' => date('Y-m-d'),
            'approved_by' => null,
            'approval_date' => null,
            'payment_status' => 'Unpaid',
            'parking_slot' => null
        ];
        
        $applications[] = $newApplication;
        Session::put('applications', $applications);
        
        return redirect()->route('my.applications')->with('success', 'Application submitted successfully!');
    }
    
    public function myApplications()
    {
        $this->initializeData();
        $user = Session::get('user');
        $applications = Session::get('applications', []);
        
        $myApplications = array_filter($applications, fn($a) => $a['user_id'] === $user['id']);
        
        return view('pages.my-applications', compact('myApplications'));
    }
    
    public function adminApplications()
    {
        $this->initializeData();
        $user = Session::get('user');
        
        if ($user['role'] !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }
        
        $applications = Session::get('applications', []);
        
        return view('pages.admin.applications', compact('applications'));
    }
    
    public function approveApplication($id)
    {
        $this->initializeData();
        $user = Session::get('user');
        
        if ($user['role'] !== 'admin') {
            return back()->with('error', 'Unauthorized.');
        }
        
        $applications = Session::get('applications', []);
        $parkingSpots = Session::get('parking_spots', []);
        $transactions = Session::get('transactions', []);
        
        $index = array_search($id, array_column($applications, 'id'));
        
        if ($index === false || $applications[$index]['status'] !== 'Pending') {
            return back()->with('error', 'Application cannot be approved.');
        }
        
        // Find available parking spot
        $availableSpotKey = null;
        foreach ($parkingSpots as $key => $spot) {
            if ($spot['type'] === $applications[$index]['vehicle_type'] && $spot['status'] === 'Available') {
                $availableSpotKey = $key;
                break;
            }
        }
        
        $feeStructure = ['Car' => 500, 'Motorcycle' => 300];
        
        // Update application
        $applications[$index]['status'] = 'Approved';
        $applications[$index]['approved_by'] = $user['name'];
        $applications[$index]['approval_date'] = date('Y-m-d');
        $applications[$index]['parking_slot'] = $availableSpotKey !== null ? $parkingSpots[$availableSpotKey]['id'] : 'Waitlist';
        $applications[$index]['payment_status'] = 'Awaiting Payment';
        
        // Update parking spot
        if ($availableSpotKey !== null) {
            $parkingSpots[$availableSpotKey]['status'] = 'Occupied';
            $parkingSpots[$availableSpotKey]['assigned_to'] = $applications[$index]['id'];
            Session::put('parking_spots', $parkingSpots);
        }
        
        // Create transaction
        $newTransaction = [
            'id' => $this->getNextId('transactions'),
            'application_id' => $applications[$index]['id'],
            'amount' => $feeStructure[$applications[$index]['vehicle_type']],
            'payment_method' => 'Pending',
            'reference_number' => null,
            'date' => date('Y-m-d'),
            'status' => 'Awaiting Payment',
            'approved_by' => $user['name'],
            'semester' => '2nd Sem 2024-2025',
            'valid_until' => date('Y-m-d', strtotime('+5 months'))
        ];
        
        $transactions[] = $newTransaction;
        
        Session::put('applications', $applications);
        Session::put('transactions', $transactions);
        
        return back()->with('success', 'Application approved successfully! Parking slot: ' . $applications[$index]['parking_slot']);
    }
    
    public function deleteApplication($id)
    {
        $this->initializeData();
        $user = Session::get('user');
        
        if ($user['role'] !== 'admin') {
            return back()->with('error', 'Unauthorized.');
        }
        
        $applications = Session::get('applications', []);
        $parkingSpots = Session::get('parking_spots', []);
        
        $index = array_search($id, array_column($applications, 'id'));
        
        if ($index !== false) {
            // Free up parking spot if assigned
            if ($applications[$index]['parking_slot']) {
                foreach ($parkingSpots as $key => $spot) {
                    if ($spot['assigned_to'] == $applications[$index]['id']) {
                        $parkingSpots[$key]['status'] = 'Available';
                        $parkingSpots[$key]['assigned_to'] = null;
                        break;
                    }
                }
                Session::put('parking_spots', $parkingSpots);
            }
            
            unset($applications[$index]);
            Session::put('applications', array_values($applications));
            
            return back()->with('success', 'Application deleted successfully.');
        }
        
        return back()->with('error', 'Application not found.');
    }
    
    public function transactions()
    {
        $this->initializeData();
        $user = Session::get('user');
        
        if ($user['role'] !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }
        
        $transactions = Session::get('transactions', []);
        $applications = Session::get('applications', []);
        
        // Attach application data to transactions
        foreach ($transactions as &$transaction) {
            $app = collect($applications)->firstWhere('id', $transaction['application_id']);
            $transaction['plate_number'] = $app['plate_number'] ?? 'N/A';
            $transaction['student_name'] = $app['student_name'] ?? 'N/A';
        }
        
        return view('pages.admin.transactions', compact('transactions'));
    }
    
    public function parkingSpots()
    {
        $this->initializeData();
        $user = Session::get('user');
        
        if ($user['role'] !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }
        
        $parkingSpots = Session::get('parking_spots', []);
        $stats = [
            'total' => count($parkingSpots),
            'occupied' => count(array_filter($parkingSpots, fn($s) => $s['status'] === 'Occupied')),
            'available' => count(array_filter($parkingSpots, fn($s) => $s['status'] === 'Available'))
        ];
        
        return view('pages.admin.parking-spots', compact('parkingSpots', 'stats'));
    }
    
    public function reports()
    {
        $this->initializeData();
        $user = Session::get('user');
        
        if ($user['role'] !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }
        
        $transactions = Session::get('transactions', []);
        $applications = Session::get('applications', []);
        
        $completedTransactions = array_filter($transactions, fn($t) => $t['status'] === 'Completed');
        $totalRevenue = array_sum(array_column($completedTransactions, 'amount'));
        
        $carRevenue = 0;
        $motorcycleRevenue = 0;
        
        foreach ($completedTransactions as $transaction) {
            $app = collect($applications)->firstWhere('id', $transaction['application_id']);
            if ($app && $app['vehicle_type'] === 'Car') {
                $carRevenue += $transaction['amount'];
            } elseif ($app && $app['vehicle_type'] === 'Motorcycle') {
                $motorcycleRevenue += $transaction['amount'];
            }
        }
        
        // Monthly data aggregation
        $monthlyData = [];
        foreach ($completedTransactions as $transaction) {
            $month = date('Y-m', strtotime($transaction['date']));
            if (!isset($monthlyData[$month])) {
                $monthlyData[$month] = 0;
            }
            $monthlyData[$month] += $transaction['amount'];
        }
        
        ksort($monthlyData);
        
        return view('pages.admin.reports', compact('totalRevenue', 'carRevenue', 'motorcycleRevenue', 'monthlyData'));
    }
    
    public function systemInfo()
    {
        $this->initializeData();
        $parkingSpots = Session::get('parking_spots', []);
        $users = Session::get('users', []);
        $applications = Session::get('applications', []);
        
        $stats = [
            'total_spots' => count($parkingSpots),
            'car_spots' => count(array_filter($parkingSpots, fn($s) => $s['type'] === 'Car')),
            'motorcycle_spots' => count(array_filter($parkingSpots, fn($s) => $s['type'] === 'Motorcycle')),
            'utilization_rate' => count($parkingSpots) > 0 ? round((count(array_filter($parkingSpots, fn($s) => $s['status'] === 'Occupied')) / count($parkingSpots)) * 100, 2) : 0,
            'total_users' => count(array_filter($users, fn($u) => $u['role'] === 'student')),
            'active_permits' => count(array_filter($applications, fn($a) => $a['status'] === 'Approved'))
        ];
        
        return view('pages.system-info', compact('stats'));
    }
}