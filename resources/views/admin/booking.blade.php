<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form-Booking') }}
        </h2>
    </x-slot>

    <!-- Halaman Utama -->
    <div class="container mx-auto mt-4 bg-white p-6 rounded-lg shadow-lg">

        <!-- Header Actions -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Booking</h3>
                <span id="bookingCount" class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                    Loading...
                </span>
            </div>

            <div class="flex items-center space-x-3">
                <!-- Filter Status -->
                <select id="statusFilter"
                    class="border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>

                <!-- Search Box -->
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari nama atau nomor..."
                        class="border border-gray-300 rounded-lg px-4 py-2 pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Refresh Button -->
                <button id="refreshButton"
                    class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-lg hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-200 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div id="loadingIndicator" class="hidden">
            <div class="text-center py-8">
                <div
                    class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-blue-500 bg-blue-100">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Memuat data...
                </div>
            </div>
        </div>

        <!-- Table Booking -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden" id="bookingTable">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Pelanggan
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Mobil & Service
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Tanggal Rental
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody id="bookingTableBody" class="bg-white divide-y divide-gray-200">
                        <!-- Data will be loaded here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Detail Booking -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50 p-4">
        <div class="bg-white rounded-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-xl font-semibold text-gray-900">Detail Booking</h3>
                <button id="closeDetailModal" class="text-gray-400 hover:text-gray-600 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="detailContent" class="p-6">
                <!-- Detail content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Modal Update Status -->
    <div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50 p-4">
        <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900">Update Status</h3>
                <button id="closeStatusModal" class="text-gray-400 hover:text-gray-600 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="statusForm">
                <input type="hidden" id="statusBookingId">

                <div class="mb-6">
                    <label for="newStatus" class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                    <select id="newStatus" name="status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                        required>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="flex space-x-3">
                    <button type="button" id="cancelStatusButton"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-lg transition duration-150 font-medium">
                        Batal
                    </button>
                    <button type="submit" id="updateStatusButton"
                        class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-3 rounded-lg transition duration-150 font-medium">
                        <span id="updateStatusText">Update Status</span>
                        <span id="updateStatusLoading" class="hidden">
                            <svg class="animate-spin h-5 w-5 inline" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Memproses...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- JavaScript -->
    <script>
        // Global variables
        let bookingsData = [];
        let filteredData = [];
        const csrfToken = '{{ csrf_token() }}';

        // DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            initializeApp();
        });

        // Initialize app
        function initializeApp() {
            loadBookings();
            initializeEventListeners();
        }

        // Load bookings data from API
        function loadBookings() {
            showLoading(true);

            fetch('{{ route('admin.booking.api') }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bookingsData = data.data;
                        filteredData = bookingsData;
                        renderBookingsTable();
                        updateBookingCount();
                    } else {
                        showErrorAlert('Gagal memuat data: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorAlert('Terjadi kesalahan saat memuat data');
                })
                .finally(() => {
                    showLoading(false);
                });
        }

        // Render bookings table
        function renderBookingsTable() {
            const tbody = document.getElementById('bookingTableBody');

            if (filteredData.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data booking</h3>
                                <p class="text-gray-500 mb-4">Booking dari pelanggan akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = filteredData.map((booking, index) => {
                const rentalDate = new Date(booking.rental_date);
                const returnDate = new Date(booking.return_date);
                const statusBadge = getStatusBadge(booking.status);

                return `
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out ${index % 2 === 0 ? 'bg-white' : 'bg-gray-25'}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <div class="text-sm font-medium text-gray-900">${escapeHtml(booking.full_name)}</div>
                                <div class="text-sm text-gray-500">${escapeHtml(booking.phone_number)}</div>
                                <div class="text-xs text-gray-400 mt-1">${formatDate(booking.created_at)}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <div class="text-sm font-medium text-gray-900">${escapeHtml(booking.mobil?.name || 'N/A')}</div>
                                <div class="text-sm text-gray-500">${booking.mobil?.type || 'N/A'}</div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1 ${booking.rental_service === 'Dengan Driver' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800'}">
                                    ${booking.rental_service}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col text-sm">
                                <div class="text-gray-900">
                                    <span class="font-medium">Sewa:</span> ${formatDateShort(booking.rental_date)}
                                </div>
                                <div class="text-gray-900">
                                    <span class="font-medium">Kembali:</span> ${formatDateShort(booking.return_date)}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    ${calculateDays(booking.rental_date, booking.return_date)} hari
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            ${statusBadge}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <button onclick="viewDetail(${booking.id})"
                                    class="inline-flex items-center px-3 py-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    Detail
                                </button>
                                <button onclick="updateStatus(${booking.id}, '${booking.status}')"
                                    class="inline-flex items-center px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Status
                                </button>
                                <button onclick="deleteBooking(${booking.id}, '${escapeHtml(booking.full_name)}')"
                                    class="inline-flex items-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Initialize event listeners
        function initializeEventListeners() {
            // Refresh button
            document.getElementById('refreshButton').addEventListener('click', loadBookings);

            // Status filter
            document.getElementById('statusFilter').addEventListener('change', applyFilters);

            // Search input
            document.getElementById('searchInput').addEventListener('input', debounce(applyFilters, 300));

            // Modal events
            document.getElementById('closeDetailModal').addEventListener('click', closeDetailModal);
            document.getElementById('closeStatusModal').addEventListener('click', closeStatusModal);
            document.getElementById('cancelStatusButton').addEventListener('click', closeStatusModal);

            // Status form
            document.getElementById('statusForm').addEventListener('submit', handleStatusUpdate);

            // Close modal on outside click
            document.getElementById('detailModal').addEventListener('click', function(e) {
                if (e.target === this) closeDetailModal();
            });

            document.getElementById('statusModal').addEventListener('click', function(e) {
                if (e.target === this) closeStatusModal();
            });
        }

        // Apply filters and search
        function applyFilters() {
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();

            filteredData = bookingsData.filter(booking => {
                const matchStatus = !statusFilter || booking.status.toLowerCase() === statusFilter;
                const matchSearch = !searchTerm ||
                    booking.full_name.toLowerCase().includes(searchTerm) ||
                    booking.phone_number.toLowerCase().includes(searchTerm) ||
                    (booking.mobil?.name || '').toLowerCase().includes(searchTerm);

                return matchStatus && matchSearch;
            });

            renderBookingsTable();
            updateBookingCount();
        }

        // View detail function
        function viewDetail(id) {
            const booking = bookingsData.find(b => b.id === id);
            if (!booking) return;

            const detailHtml = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h4 class="font-semibold text-lg text-gray-900 border-b pb-2">Informasi Pelanggan</h4>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <p class="mt-1 text-sm text-gray-900">${escapeHtml(booking.full_name)}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">No. Handphone</label>
                            <p class="mt-1 text-sm text-gray-900">${escapeHtml(booking.phone_number)}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alamat</label>
                            <p class="mt-1 text-sm text-gray-900">${escapeHtml(booking.address)}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <div class="mt-1">${getStatusBadge(booking.status)}</div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <h4 class="font-semibold text-lg text-gray-900 border-b pb-2">Detail Rental</h4>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mobil</label>
                            <p class="mt-1 text-sm text-gray-900">${escapeHtml(booking.mobil?.name || 'N/A')} (${booking.mobil?.type || 'N/A'})</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Layanan Sewa</label>
                            <p class="mt-1 text-sm text-gray-900">${booking.rental_service}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Penyewaan</label>
                            <p class="mt-1 text-sm text-gray-900">${formatDate(booking.rental_date)}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Pengembalian</label>
                            <p class="mt-1 text-sm text-gray-900">${formatDate(booking.return_date)}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Durasi</label>
                            <p class="mt-1 text-sm text-gray-900">${calculateDays(booking.rental_date, booking.return_date)} hari</p>
                        </div>
                    </div>
                </div>
                
                ${booking.delivery_location || booking.return_location || booking.delivery_time || booking.return_time || booking.special_notes ? `
                            <div class="mt-6 pt-6 border-t">
                                <h4 class="font-semibold text-lg text-gray-900 mb-4">Informasi Tambahan</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    ${booking.delivery_location ? `
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lokasi Antar</label>
                            <p class="mt-1 text-sm text-gray-900">${escapeHtml(booking.delivery_location)}</p>
                        </div>
                        ` : ''}
                                    ${booking.return_location ? `
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lokasi Pengembalian</label>
                            <p class="mt-1 text-sm text-gray-900">${escapeHtml(booking.return_location)}</p>
                        </div>
                        ` : ''}
                                    ${booking.delivery_time ? `
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jam Pengantaran</label>
                            <p class="mt-1 text-sm text-gray-900">${booking.delivery_time}</p>
                        </div>
                        ` : ''}
                                    ${booking.return_time ? `
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jam Pengembalian</label>
                            <p class="mt-1 text-sm text-gray-900">${booking.return_time}</p>
                        </div>
                        ` : ''}
                                </div>
                                ${booking.special_notes ? `
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Catatan Khusus</label>
                        <p class="mt-1 text-sm text-gray-900">${escapeHtml(booking.special_notes)}</p>
                    </div>
                    ` : ''}
                            </div>
                            ` : ''}
                
                <div class="mt-6 pt-6 border-t">
                    <div class="text-sm text-gray-500">
                        <p>Booking dibuat: ${formatDate(booking.created_at)}</p>
                        ${booking.updated_at !== booking.created_at ? `<p>Terakhir diupdate: ${formatDate(booking.updated_at)}</p>` : ''}
                    </div>
                </div>
            `;

            document.getElementById('detailContent').innerHTML = detailHtml;
            document.getElementById('detailModal').classList.remove('hidden');
        }

        // Update status function
        function updateStatus(id, currentStatus) {
            document.getElementById('statusBookingId').value = id;
            document.getElementById('newStatus').value = currentStatus;
            document.getElementById('statusModal').classList.remove('hidden');
        }

        // Handle status update
        function handleStatusUpdate(e) {
            e.preventDefault();

            setButtonLoading('updateStatusButton', true);

            const id = document.getElementById('statusBookingId').value;
            const newStatus = document.getElementById('newStatus').value;

            fetch(`{{ url('admin/booking') }}/${id}/status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        status: newStatus,
                        _method: 'PUT'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeStatusModal();
                        loadBookings(); // Reload data
                        showSuccessAlert(data.message);
                    } else {
                        showErrorAlert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorAlert('Terjadi kesalahan saat mengupdate status');
                })
                .finally(() => {
                    setButtonLoading('updateStatusButton', false);
                });
        }

        // Delete booking function
        function deleteBooking(id, customerName) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Booking dari ${customerName} akan dihapus permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'rounded-lg',
                    cancelButton: 'rounded-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    performDelete(id);
                }
            });
        }

        // Perform delete operation
        function performDelete(id) {
            fetch(`{{ url('admin/booking') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadBookings(); // Reload data
                        showSuccessAlert(data.message);
                    } else {
                        showErrorAlert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorAlert('Terjadi kesalahan saat menghapus booking');
                });
        }

        // Modal functions
        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }

        // Utility functions
        function showLoading(show) {
            const loading = document.getElementById('loadingIndicator');
            const table = document.getElementById('bookingTable');

            if (show) {
                loading.classList.remove('hidden');
                table.classList.add('opacity-50');
            } else {
                loading.classList.add('hidden');
                table.classList.remove('opacity-50');
            }
        }

        function setButtonLoading(buttonId, loading) {
            const button = document.getElementById(buttonId);
            const text = button.querySelector('[id$="Text"]');
            const loadingEl = button.querySelector('[id$="Loading"]');

            if (loading) {
                text.classList.add('hidden');
                loadingEl.classList.remove('hidden');
                button.disabled = true;
            } else {
                text.classList.remove('hidden');
                loadingEl.classList.add('hidden');
                button.disabled = false;
            }
        }

        function updateBookingCount() {
            const countEl = document.getElementById('bookingCount');
            countEl.textContent = `${filteredData.length} booking`;
        }

        function getStatusBadge(status) {
            const statusConfig = {
                'pending': {
                    bg: 'bg-yellow-100',
                    text: 'text-yellow-800',
                    label: 'Pending'
                },
                'confirmed': {
                    bg: 'bg-blue-100',
                    text: 'text-blue-800',
                    label: 'Confirmed'
                },
                'completed': {
                    bg: 'bg-gray-100',
                    text: 'text-gray-800',
                    label: 'Completed'
                },
                'cancelled': {
                    bg: 'bg-red-100',
                    text: 'text-red-800',
                    label: 'Cancelled'
                }
            };

            const config = statusConfig[status] || statusConfig['pending'];
            return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${config.bg} ${config.text}">${config.label}</span>`;
        }

        function formatDate(dateString) {
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }

        function formatDateShort(dateString) {
            const options = {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }

        function calculateDays(startDate, endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays;
        }

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.toString().replace(/[&<>"']/g, function(m) {
                return map[m];
            });
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function showSuccessAlert(message) {
            Swal.fire({
                title: 'Berhasil!',
                text: message,
                icon: 'success',
                confirmButtonColor: '#10B981',
                confirmButtonText: 'OK',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'rounded-lg'
                }
            });
        }

        function showErrorAlert(message) {
            Swal.fire({
                title: 'Error!',
                text: message,
                icon: 'error',
                confirmButtonColor: '#EF4444',
                confirmButtonText: 'OK',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'rounded-lg'
                }
            });
        }

        // Handle session messages
        @if (session('success'))
            showSuccessAlert({!! json_encode(session('success')) !!});
        @endif

        @if (session('error'))
            showErrorAlert({!! json_encode(session('error')) !!});
        @endif
    </script>
</x-app-layout>
