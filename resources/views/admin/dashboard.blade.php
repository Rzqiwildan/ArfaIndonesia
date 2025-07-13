<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Beranda Admin') }}
            </h2>
            <div class="flex items-center space-x-4">
                <!-- Connection Status -->
                <div id="connectionStatus" class="flex items-center">
                    <div id="statusIndicator" class="w-3 h-3 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                    <span id="statusText" class="text-sm text-gray-600">Live</span>
                </div>
                <!-- Last Update -->
                <div class="text-sm text-gray-500">
                    Last update: <span id="lastUpdate">-</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Section with Live Time -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg mb-6 overflow-hidden">
                <div class="px-6 py-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold mb-2">Selamat Datang, Admin! 👋</h1>
                            <p class="text-blue-100">{{ date('l, d F Y') }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-blue-200">Waktu Real-time</div>
                            <div id="currentTime" class="text-xl font-semibold"></div>
                            <div id="liveCounter" class="text-xs text-blue-200 mt-1">
                                <span id="liveBookingCount">0</span> booking hari ini
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Real-time KPI Cards with Animation -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Total Booking Hari Ini -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 transform transition-transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Booking Hari Ini</p>
                            <p id="todayBooking" class="text-3xl font-bold text-gray-900 transition-all duration-500">0</p>
                            <p class="text-sm text-green-600 flex items-center mt-1">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                                </svg>
                                <span id="todayTrend">0%</span>
                            </p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div id="todayPulse" class="absolute top-2 right-2 w-2 h-2 bg-green-400 rounded-full opacity-0"></div>
                </div>

                <!-- Total Booking Minggu Ini -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 transform transition-transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Booking Minggu Ini</p>
                            <p id="weekBooking" class="text-3xl font-bold text-gray-900 transition-all duration-500">0</p>
                            <p class="text-sm text-blue-600 flex items-center mt-1">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                                </svg>
                                <span id="weekTrend">0%</span>
                            </p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Booking Bulan Ini -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 transform transition-transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Booking Bulan Ini</p>
                            <p id="monthBooking" class="text-3xl font-bold text-gray-900 transition-all duration-500">0</p>
                            <p class="text-sm text-purple-600 flex items-center mt-1">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                                </svg>
                                <span id="monthTrend">0%</span>
                            </p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Mobil Tersedia (Real-time) -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500 transform transition-transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Mobil Tersedia</p>
                            <p id="availableCars" class="text-3xl font-bold text-gray-900 transition-all duration-500">0</p>
                            <p class="text-sm text-orange-600 mt-1">
                                <span id="totalCars">dari 0 total mobil</span>
                            </p>
                        </div>
                        <div class="bg-orange-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Real-time Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                
                <!-- Booking Trend Chart -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Tren Booking (7 Hari Terakhir)</h3>
                        <div class="flex items-center space-x-2">
                            <div id="chartUpdateIndicator" class="w-2 h-2 bg-blue-500 rounded-full opacity-0 transition-opacity"></div>
                            <select id="chartPeriod" class="border border-gray-300 rounded-lg text-sm">
                                <option value="7">7 Hari</option>
                                <option value="30">30 Hari</option>
                                <option value="90">3 Bulan</option>
                            </select>
                        </div>
                    </div>
                    <div class="relative h-64">
                        <canvas id="bookingChart"></canvas>
                    </div>
                </div>

                <!-- Status Chart with Real-time Updates -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Status Booking (Live)</h3>
                        <div class="flex items-center space-x-2">
                            <div id="statusChartUpdateIndicator" class="w-2 h-2 bg-green-500 rounded-full opacity-0 transition-opacity"></div>
                            <select id="statusChartType" class="border border-gray-300 rounded-lg px-3 py-1 text-sm">
                                <option value="bar">📊 Bar Chart</option>
                                <option value="horizontalBar">📊 Horizontal Bar</option>
                                <option value="line">📈 Line Chart</option>
                                <option value="area">📈 Area Chart</option>
                            </select>
                        </div>
                    </div>
                    <div class="relative h-64">
                        <canvas id="statusChart"></canvas>
                    </div>
                    
                    <!-- Live Status Summary -->
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mt-4">
                        <div class="text-center p-2 bg-yellow-50 rounded-lg">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mx-auto mb-1"></div>
                            <p class="text-xs text-gray-600">Pending</p>
                            <p class="text-sm font-semibold text-gray-900" id="pendingCount">0</p>
                        </div>
                        <div class="text-center p-2 bg-blue-50 rounded-lg">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mx-auto mb-1"></div>
                            <p class="text-xs text-gray-600">Confirmed</p>
                            <p class="text-sm font-semibold text-gray-900" id="confirmedCount">0</p>
                        </div>
                        <div class="text-center p-2 bg-green-50 rounded-lg">
                            <div class="w-3 h-3 bg-green-500 rounded-full mx-auto mb-1"></div>
                            <p class="text-xs text-gray-600">Active</p>
                            <p class="text-sm font-semibold text-gray-900" id="activeCount">0</p>
                        </div>
                        <div class="text-center p-2 bg-gray-50 rounded-lg">
                            <div class="w-3 h-3 bg-gray-500 rounded-full mx-auto mb-1"></div>
                            <p class="text-xs text-gray-600">Completed</p>
                            <p class="text-sm font-semibold text-gray-900" id="completedCount">0</p>
                        </div>
                        <div class="text-center p-2 bg-red-50 rounded-lg">
                            <div class="w-3 h-3 bg-red-500 rounded-full mx-auto mb-1"></div>
                            <p class="text-xs text-gray-600">Cancelled</p>
                            <p class="text-sm font-semibold text-gray-900" id="cancelledCount">0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Real-time Activities & Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                
                <!-- Live Recent Bookings -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            Booking Terbaru
                            <div id="bookingUpdateIndicator" class="w-2 h-2 bg-red-500 rounded-full ml-2 opacity-0 transition-opacity"></div>
                        </h3>
                        <a href="{{ route('admin.booking.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat Semua</a>
                    </div>
                    <div class="space-y-3" id="recentBookings">
                        <div class="text-center py-8 text-gray-500">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-2"></div>
                            Loading bookings...
                        </div>
                    </div>
                </div>

                <!-- Enhanced Quick Actions -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.booking.index') }}" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                            <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Kelola Booking</span>
                            <span id="pendingBadge" class="ml-auto bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">0</span>
                        </a>
                        
                        <a href="{{ route('mobil.index') }}" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Kelola Mobil</span>
                            <span id="availableBadge" class="ml-auto bg-green-500 text-white text-xs px-2 py-1 rounded-full">0</span>
                        </a>
                        
                        <button onclick="forceRefreshDashboard()" class="w-full flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition duration-200">
                            <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Refresh Data</span>
                        </button>
                        
                        <a href="https://wa.me/6281316413586" target="_blank" class="flex items-center p-3 bg-red-50 rounded-lg hover:bg-red-100 transition duration-200">
                            <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">WhatsApp</span>
                        </a>
                    </div>

                    <!-- Real-time Stats -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Live Stats</h4>
                        <div class="space-y-2 text-xs text-gray-600">
                            <div>Booking Aktif: <span id="liveActiveBookings" class="font-semibold text-green-600">0</span></div>
                            <div>Booking Pending: <span id="livePendingBookings" class="font-semibold text-yellow-600">0</span></div>
                            <div>Last Booking: <span id="lastBookingTime" class="font-semibold">-</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Live Alerts Section -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    🚨 Live Alerts & Notifications
                    <div id="alertUpdateIndicator" class="w-2 h-2 bg-red-500 rounded-full ml-2 opacity-0 transition-opacity"></div>
                </h3>
                <div id="alertsContainer" class="space-y-3">
                    <div class="text-center py-4 text-gray-500">
                        <div class="animate-pulse">Loading alerts...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Global variables
        let bookingChart = null;
        let statusChart = null;
        let currentStatusChartType = 'bar';
        let realTimeInterval = null;
        let liveStatsInterval = null;
        let isConnected = true;
        let lastDataTimestamp = null;
        const csrfToken = '{{ csrf_token() }}';

        // Real-time configuration
        const REALTIME_CONFIG = {
            dashboardUpdateInterval: 30000, // 30 seconds for full dashboard
            liveStatsInterval: 5000,        // 5 seconds for live stats only
            maxRetries: 3,
            retryDelay: 2000
        };

        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            initializeRealTimeDashboard();
        });

        function initializeRealTimeDashboard() {
            initializeCharts();
            startRealTimeUpdates();
            startLiveStatsUpdates();
            updateCurrentTime();
            setInterval(updateCurrentTime, 1000);
            
            // Initial data load
            loadDashboardData();
        }

        function startRealTimeUpdates() {
            // Full dashboard data update every 30 seconds
            realTimeInterval = setInterval(() => {
                loadDashboardData();
            }, REALTIME_CONFIG.dashboardUpdateInterval);
        }

        function startLiveStatsUpdates() {
            // Quick stats update every 5 seconds
            liveStatsInterval = setInterval(() => {
                loadLiveStats();
            }, REALTIME_CONFIG.liveStatsInterval);
        }

        function updateCurrentTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID');
            document.getElementById('currentTime').textContent = timeString;
        }

        async function loadDashboardData(showLoader = false) {
            try {
                updateConnectionStatus(true);
                
                if (showLoader) {
                    showUpdateIndicator('chartUpdateIndicator');
                    showUpdateIndicator('statusChartUpdateIndicator');
                    showUpdateIndicator('bookingUpdateIndicator');
                    showUpdateIndicator('alertUpdateIndicator');
                }

                const response = await fetch('{{ route("admin.dashboard.data") }}', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                
                if (result.success) {
                    const data = result.data;
                    lastDataTimestamp = data.timestamp;
                    
                    // Update all dashboard components
                    updateKPICards(data.bookingStats);
                    updateCarStats(data.carStats);
                    updateRecentBookings(data.recentBookings);
                    updateCharts(data.bookingStats);
                    updateAlerts(data.alerts);
                    updateLastUpdateTime();
                    
                    // Update badges
                    updateQuickActionBadges(data.bookingStats.statusData, data.carStats);
                    
                } else {
                    throw new Error(result.message || 'Failed to load dashboard data');
                }
                
            } catch (error) {
                console.error('Error loading dashboard data:', error);
                updateConnectionStatus(false);
                showErrorNotification('Gagal memuat data dashboard');
            }
        }

        async function loadLiveStats() {
            try {
                const response = await fetch('{{ route("admin.dashboard.live-stats") }}', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const result = await response.json();
                
                if (result.success) {
                    const data = result.data;
                    
                    // Update live counters
                    document.getElementById('liveBookingCount').textContent = data.total_bookings_today;
                    document.getElementById('liveActiveBookings').textContent = data.active_bookings;
                    document.getElementById('livePendingBookings').textContent = data.pending_bookings;
                    document.getElementById('lastBookingTime').textContent = data.last_booking || 'Tidak ada';
                    
                    // Animate changes
                    animateValueChange('liveBookingCount');
                    
                    updateConnectionStatus(true);
                } else {
                    throw new Error(result.message);
                }
                
            } catch (error) {
                console.error('Error loading live stats:', error);
                updateConnectionStatus(false);
            }
        }

        function updateKPICards(stats) {
            // Animate number changes
            animateNumberChange('todayBooking', stats.today);
            animateNumberChange('weekBooking', stats.week);
            animateNumberChange('monthBooking', stats.month);
            
            // Update trends
            document.getElementById('todayTrend').textContent = stats.todayTrend;
            document.getElementById('weekTrend').textContent = stats.weekTrend;
            document.getElementById('monthTrend').textContent = stats.monthTrend;
            
            // Update trend colors
            updateTrendColor('todayTrend', stats.todayTrend);
            updateTrendColor('weekTrend', stats.weekTrend);
            updateTrendColor('monthTrend', stats.monthTrend);
        }

        function updateCarStats(stats) {
            animateNumberChange('availableCars', stats.available);
            document.getElementById('totalCars').textContent = `dari ${stats.total} total mobil`;
        }

        function updateRecentBookings(bookings) {
            const container = document.getElementById('recentBookings');
            
            if (bookings.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center py-4">Belum ada booking hari ini</p>';
                return;
            }

            container.innerHTML = bookings.map(booking => {
                const statusColors = {
                    pending: 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                    confirmed: 'bg-blue-100 text-blue-800 border border-blue-200',
                    active: 'bg-green-100 text-green-800 border border-green-200',
                    completed: 'bg-gray-100 text-gray-800 border border-gray-200',
                    cancelled: 'bg-red-100 text-red-800 border border-red-200'
                };

                return `
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">${booking.customer}</p>
                            <p class="text-xs text-gray-500">${booking.car} (${booking.car_type}) • ${booking.service}</p>
                            <p class="text-xs text-gray-400">${booking.rental_date} - ${booking.return_date} (${booking.duration} hari)</p>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="px-2 py-1 text-xs font-medium rounded-full ${statusColors[booking.status]}">
                                ${booking.status}
                            </span>
                            <span class="text-xs text-gray-400 mt-1">${booking.created_at}</span>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function initializeCharts() {
            // Booking Chart (Line Chart)
            const bookingCtx = document.getElementById('bookingChart').getContext('2d');
            bookingChart = new Chart(bookingCtx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Booking',
                        data: [],
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Status Chart
            initializeStatusChart('bar');
            
            // Chart type change handler
            document.getElementById('statusChartType').addEventListener('change', function() {
                const newType = this.value;
                currentStatusChartType = newType;
                initializeStatusChart(newType);
                loadDashboardData();
            });
        }

        function initializeStatusChart(chartType) {
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            
            if (statusChart) {
                statusChart.destroy();
            }

            const chartConfig = {
                type: chartType === 'horizontalBar' ? 'bar' : chartType,
                data: {
                    labels: ['Pending', 'Confirmed', 'Active', 'Completed', 'Cancelled'],
                    datasets: [{
                        label: 'Jumlah Booking',
                        data: [0, 0, 0, 0, 0],
                        backgroundColor: [
                            'rgba(234, 179, 8, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(156, 163, 175, 0.8)',
                            'rgba(239, 68, 68, 0.8)'
                        ],
                        borderColor: [
                            'rgb(234, 179, 8)',
                            'rgb(59, 130, 246)',
                            'rgb(34, 197, 94)',
                            'rgb(156, 163, 175)',
                            'rgb(239, 68, 68)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: chartType === 'horizontalBar' ? 'y' : 'x',
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: chartType === 'line' || chartType === 'area'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            };

            // Special config for area chart
            if (chartType === 'area') {
                chartConfig.type = 'line';
                chartConfig.data.datasets[0].fill = true;
                chartConfig.data.datasets[0].backgroundColor = 'rgba(59, 130, 246, 0.1)';
                chartConfig.data.datasets[0].borderColor = 'rgb(59, 130, 246)';
                chartConfig.data.datasets[0].tension = 0.4;
            }

            statusChart = new Chart(statusCtx, chartConfig);
        }

        function updateCharts(stats) {
            // Update booking chart
            if (bookingChart && stats.chartData) {
                bookingChart.data.labels = stats.chartData.labels;
                bookingChart.data.datasets[0].data = stats.chartData.data;
                bookingChart.update('active');
            }

            // Update status chart
            if (statusChart && stats.statusData) {
                const statusData = stats.statusData;
                statusChart.data.datasets[0].data = [
                    statusData.pending,
                    statusData.confirmed,
                    statusData.active,
                    statusData.completed,
                    statusData.cancelled
                ];
                statusChart.update('active');

                // Update status counts with animation
                animateNumberChange('pendingCount', statusData.pending);
                animateNumberChange('confirmedCount', statusData.confirmed);
                animateNumberChange('activeCount', statusData.active);
                animateNumberChange('completedCount', statusData.completed);
                animateNumberChange('cancelledCount', statusData.cancelled);
            }
        }

        function updateAlerts(alerts) {
            const container = document.getElementById('alertsContainer');
            
            if (alerts.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center py-4">Tidak ada alert saat ini</p>';
                return;
            }

            container.innerHTML = alerts.map(alert => {
                const colors = {
                    warning: 'border-yellow-200 bg-yellow-50',
                    info: 'border-blue-200 bg-blue-50',
                    success: 'border-green-200 bg-green-50',
                    error: 'border-red-200 bg-red-50'
                };

                return `
                    <div class="flex items-center justify-between p-3 border rounded-lg ${colors[alert.type]} transition-all hover:shadow-md">
                        <div class="flex items-center">
                            <span class="text-lg mr-3">${alert.icon}</span>
                            <span class="text-sm text-gray-700">${alert.message}</span>
                        </div>
                        ${alert.action ? `<button class="text-xs text-blue-600 hover:text-blue-800 font-medium px-2 py-1 rounded hover:bg-blue-100 transition-colors">${alert.action}</button>` : ''}
                    </div>
                `;
            }).join('');
        }

        function updateQuickActionBadges(statusData, carStats) {
            document.getElementById('pendingBadge').textContent = statusData.pending || 0;
            document.getElementById('availableBadge').textContent = carStats.available || 0;
        }

        // Animation and utility functions
        function animateNumberChange(elementId, newValue) {
            const element = document.getElementById(elementId);
            const currentValue = parseInt(element.textContent) || 0;
            
            if (currentValue !== newValue) {
                element.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    element.textContent = newValue;
                    element.style.transform = 'scale(1)';
                }, 150);
            }
        }

        function animateValueChange(elementId) {
            const element = document.getElementById(elementId);
            element.style.background = 'rgba(59, 130, 246, 0.1)';
            setTimeout(() => {
                element.style.background = '';
            }, 1000);
        }

        function showUpdateIndicator(indicatorId) {
            const indicator = document.getElementById(indicatorId);
            indicator.style.opacity = '1';
            setTimeout(() => {
                indicator.style.opacity = '0';
            }, 1000);
        }

        function updateTrendColor(elementId, trend) {
            const element = document.getElementById(elementId);
            const parent = element.parentElement;
            
            if (trend.startsWith('+')) {
                parent.className = parent.className.replace(/text-\w+-600/g, 'text-green-600');
            } else if (trend.startsWith('-')) {
                parent.className = parent.className.replace(/text-\w+-600/g, 'text-red-600');
            }
        }

        function updateConnectionStatus(connected) {
            isConnected = connected;
            const indicator = document.getElementById('statusIndicator');
            const text = document.getElementById('statusText');
            
            if (connected) {
                indicator.className = 'w-3 h-3 bg-green-500 rounded-full mr-2 animate-pulse';
                text.textContent = 'Live';
                text.className = 'text-sm text-green-600';
            } else {
                indicator.className = 'w-3 h-3 bg-red-500 rounded-full mr-2';
                text.textContent = 'Disconnected';
                text.className = 'text-sm text-red-600';
            }
        }

        function updateLastUpdateTime() {
            const now = new Date();
            document.getElementById('lastUpdate').textContent = now.toLocaleTimeString('id-ID');
        }

        function forceRefreshDashboard() {
            loadDashboardData(true);
            showSuccessNotification('Dashboard refreshed!');
        }

        function showSuccessNotification(message) {
            createNotification(message, 'success');
        }

        function showErrorNotification(message) {
            createNotification(message, 'error');
        }

        function createNotification(message, type) {
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                info: 'bg-blue-500'
            };
            
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 ${colors[type]} text-white px-4 py-2 rounded-lg shadow-lg z-50 transform transition-transform`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Cleanup intervals when page unloads
        window.addEventListener('beforeunload', function() {
            if (realTimeInterval) clearInterval(realTimeInterval);
            if (liveStatsInterval) clearInterval(liveStatsInterval);
        });

        // Handle visibility change (pause updates when tab is not active)
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                if (realTimeInterval) clearInterval(realTimeInterval);
                if (liveStatsInterval) clearInterval(liveStatsInterval);
            } else {
                startRealTimeUpdates();
                startLiveStatsUpdates();
                loadDashboardData();
            }
        });
    </script>
</x-app-layout>