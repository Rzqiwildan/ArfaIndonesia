<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    // API untuk mendapatkan ALL dashboard data sekaligus (untuk real-time)
    public function getDashboardData()
    {
        try {
            $data = [
                'bookingStats' => $this->getBookingStatsData(),
                'carStats' => $this->getCarStatsData(),
                'recentBookings' => $this->getRecentBookingsData(),
                'alerts' => $this->getAlertsData(),
                'timestamp' => now()->format('Y-m-d H:i:s')
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Dashboard data loaded successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading dashboard data: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get booking statistics with real data
    private function getBookingStatsData()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        
        // Current period counts
        $todayBookings = Booking::whereDate('created_at', $today)->count();
        $weekBookings = Booking::where('created_at', '>=', $startOfWeek)->count();
        $monthBookings = Booking::where('created_at', '>=', $startOfMonth)->count();
        
        // Previous period counts for trend calculation
        $yesterdayBookings = Booking::whereDate('created_at', $today->copy()->subDay())->count();
        $lastWeekBookings = Booking::whereBetween('created_at', [
            $startOfWeek->copy()->subWeek(),
            $startOfWeek->copy()->subDay()
        ])->count();
        $lastMonthBookings = Booking::whereBetween('created_at', [
            $startOfMonth->copy()->subMonth(),
            $startOfMonth->copy()->subDay()
        ])->count();
        
        // Calculate trends
        $todayTrend = $this->calculateTrend($todayBookings, $yesterdayBookings);
        $weekTrend = $this->calculateTrend($weekBookings, $lastWeekBookings);
        $monthTrend = $this->calculateTrend($monthBookings, $lastMonthBookings);
        
        // Chart data - booking per hari dalam 7 hari terakhir
        $chartData = $this->getBookingChartData();
        
        // Status data untuk status chart
        $statusData = $this->getBookingStatusData();
        
        return [
            'today' => $todayBookings,
            'week' => $weekBookings,
            'month' => $monthBookings,
            'todayTrend' => $todayTrend,
            'weekTrend' => $weekTrend,
            'monthTrend' => $monthTrend,
            'chartData' => $chartData,
            'statusData' => $statusData
        ];
    }

    // Get car statistics with real data
    private function getCarStatsData()
    {
        $totalCars = Mobil::count();
        
        // Get cars that are currently booked (active bookings)
        $today = Carbon::today();
        $activeBookings = Booking::where('status', 'active')
            ->where('rental_date', '<=', $today)
            ->where('return_date', '>=', $today)
            ->distinct('mobil_id')
            ->count('mobil_id');
        
        $availableCars = max(0, $totalCars - $activeBookings);
        
        return [
            'available' => $availableCars,
            'total' => $totalCars,
            'activeBookings' => $activeBookings
        ];
    }

    // Get recent bookings with real data
    private function getRecentBookingsData()
    {
        $recentBookings = Booking::with(['mobil'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'customer' => $booking->full_name,
                    'phone' => $booking->phone_number,
                    'car' => $booking->mobil ? $booking->mobil->name : 'N/A',
                    'car_type' => $booking->mobil ? $booking->mobil->type : 'N/A',
                    'service' => $booking->rental_service,
                    'status' => $booking->status,
                    'rental_date' => $booking->rental_date->format('d M Y'),
                    'return_date' => $booking->return_date->format('d M Y'),
                    'duration' => $booking->duration,
                    'created_at' => $booking->created_at->locale('id')->diffForHumans(),
                    'created_date' => $booking->created_at->format('d M Y H:i')
                ];
            });
        
        return $recentBookings;
    }

    // Get alerts with real data
    private function getAlertsData()
    {
        $alerts = [];
        $today = Carbon::today();
        
        // 1. Booking yang akan berakhir hari ini
        $endingToday = Booking::where('status', 'active')
            ->whereDate('return_date', $today)
            ->count();
        
        if ($endingToday > 0) {
            $alerts[] = [
                'type' => 'warning',
                'icon' => '⚠️',
                'message' => "{$endingToday} booking akan berakhir hari ini",
                'action' => 'Lihat Detail',
                'count' => $endingToday
            ];
        }
        
        // 2. Booking yang terlambat (overdue)
        $overdue = Booking::where('status', 'active')
            ->where('return_date', '<', $today)
            ->count();
        
        if ($overdue > 0) {
            $alerts[] = [
                'type' => 'error',
                'icon' => '🚨',
                'message' => "{$overdue} booking terlambat dikembalikan",
                'action' => 'Follow Up',
                'count' => $overdue
            ];
        }
        
        // 3. Booking pending lama (lebih dari 24 jam)
        $oldPending = Booking::where('status', 'pending')
            ->where('created_at', '<', Carbon::now()->subHours(24))
            ->count();
        
        if ($oldPending > 0) {
            $alerts[] = [
                'type' => 'info',
                'icon' => 'ℹ️',
                'message' => "{$oldPending} booking pending lebih dari 24 jam",
                'action' => 'Review',
                'count' => $oldPending
            ];
        }
        
        // 4. Booking yang akan dimulai besok
        $startingTomorrow = Booking::whereIn('status', ['confirmed', 'pending'])
            ->whereDate('rental_date', $today->copy()->addDay())
            ->count();
        
        if ($startingTomorrow > 0) {
            $alerts[] = [
                'type' => 'info',
                'icon' => '📅',
                'message' => "{$startingTomorrow} booking akan dimulai besok",
                'action' => 'Prepare',
                'count' => $startingTomorrow
            ];
        }
        
        // 5. Mobil dengan utilization tinggi (dipinjam lebih dari 80% waktu bulan ini)
        $highUtilizationCars = $this->getHighUtilizationCars();
        if ($highUtilizationCars > 0) {
            $alerts[] = [
                'type' => 'success',
                'icon' => '🚗',
                'message' => "{$highUtilizationCars} mobil dengan utilization tinggi bulan ini",
                'action' => 'Lihat Detail',
                'count' => $highUtilizationCars
            ];
        }
        
        // Alert positif jika tidak ada masalah urgent
        if (empty($alerts) || !collect($alerts)->contains('type', 'error')) {
            $alerts[] = [
                'type' => 'success',
                'icon' => '✅',
                'message' => 'Semua operasional berjalan lancar',
                'action' => null,
                'count' => 0
            ];
        }
        
        return $alerts;
    }

    // Helper: Calculate trend percentage
    private function calculateTrend($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? '+100%' : '0%';
        }
        
        $percentage = round((($current - $previous) / $previous) * 100);
        return ($percentage >= 0 ? '+' : '') . $percentage . '%';
    }

    // Helper: Get booking chart data for last 7 days
    private function getBookingChartData()
    {
        $chartData = [];
        $chartLabels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = Booking::whereDate('created_at', $date)->count();
            $chartData[] = $count;
            $chartLabels[] = $date->locale('id')->isoFormat('dddd');
        }
        
        return [
            'labels' => $chartLabels,
            'data' => $chartData
        ];
    }

    // Helper: Get booking status distribution
    private function getBookingStatusData()
    {
        // Get counts for each status
        $statusCounts = Booking::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        // Ensure all statuses are present with default 0
        $allStatuses = ['pending', 'confirmed', 'active', 'completed', 'cancelled'];
        $statusData = [];
        
        foreach ($allStatuses as $status) {
            $statusData[$status] = $statusCounts[$status] ?? 0;
        }
        
        return $statusData;
    }

    // Helper: Get cars with high utilization
    private function getHighUtilizationCars()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $daysInMonth = Carbon::now()->daysInMonth;
        
        return Mobil::whereHas('bookings', function ($query) use ($startOfMonth) {
            $query->where('status', 'active')
                  ->where('rental_date', '>=', $startOfMonth);
        })
        ->withCount(['bookings as monthly_bookings' => function ($query) use ($startOfMonth) {
            $query->where('status', 'active')
                  ->where('rental_date', '>=', $startOfMonth);
        }])
        ->get()
        ->filter(function ($car) use ($daysInMonth) {
            // Calculate utilization - if booked days > 80% of month
            $bookedDays = $car->bookings()
                ->where('status', 'active')
                ->where('rental_date', '>=', Carbon::now()->startOfMonth())
                ->sum(DB::raw('DATEDIFF(return_date, rental_date) + 1'));
            
            return ($bookedDays / $daysInMonth) > 0.8;
        })
        ->count();
    }

    // Separate endpoints for real-time specific data (optional, for granular updates)
    public function getBookingStats()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->getBookingStatsData()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getCarStats()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->getCarStatsData()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getRecentBookings()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->getRecentBookingsData()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAlerts()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->getAlertsData()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get live statistics (for real-time counter)
    public function getLiveStats()
    {
        try {
            $data = [
                'total_bookings_today' => Booking::whereDate('created_at', Carbon::today())->count(),
                'active_bookings' => Booking::where('status', 'active')->count(),
                'pending_bookings' => Booking::where('status', 'pending')->count(),
                'available_cars' => $this->getCarStatsData()['available'],
                'last_booking' => Booking::latest()->first()?->created_at?->diffForHumans(),
                'timestamp' => now()->format('H:i:s')
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}