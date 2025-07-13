<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Mobil') }}
        </h2>
    </x-slot>

    <!-- Halaman Utama -->
    <div class="container mx-auto mt-4 bg-white p-6 rounded-lg shadow-lg">

        <!-- Button Tambah Mobil -->
        <div class="mb-6">
            <button id="addCarButton"
                class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Tambah Mobil
            </button>
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

        <!-- Table Mobil -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden" id="mobilTable">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Nama Mobil
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tipe
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Stok
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody id="mobilTableBody" class="bg-white divide-y divide-gray-200">
                    <!-- Data will be loaded here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Popup Tambah Mobil -->
    <div id="addCarModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50 p-4">
        <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900">Tambah Mobil Baru</h3>
                <button id="closeModalButton" class="text-gray-400 hover:text-gray-600 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="addCarForm">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Mobil</label>
                    <input type="text" name="name" id="name"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                        placeholder="Contoh: Toyota Avanza" required>
                    <div id="nameError" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Transmisi</label>
                    <select name="type" id="type"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                        required>
                        <option value="">Pilih Tipe Transmisi</option>
                        <option value="Manual">Manual</option>
                        <option value="Matic">Matic</option>
                    </select>
                    <div id="typeError" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <div class="mb-6">
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Stok</label>
                    <input type="number" name="stok" id="stok"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                        placeholder="0" required min="0">
                    <div id="stokError" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <div class="flex space-x-3">
                    <button type="button" id="cancelButton"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-lg transition duration-150 font-medium">
                        Batal
                    </button>
                    <button type="submit" id="submitButton"
                        class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-3 rounded-lg transition duration-150 font-medium">
                        <span id="submitText">Tambah Mobil</span>
                        <span id="submitLoading" class="hidden">
                            <svg class="animate-spin h-5 w-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
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

    <!-- Modal Edit Mobil -->
    <div id="editCarModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50 p-4">
        <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900">Edit Mobil</h3>
                <button id="closeEditModalButton" class="text-gray-400 hover:text-gray-600 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="editCarForm">
                <input type="hidden" id="editCarId" name="id">

                <div class="mb-4">
                    <label for="editName" class="block text-sm font-medium text-gray-700 mb-2">Nama Mobil</label>
                    <input type="text" name="name" id="editName"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                        required>
                    <div id="editNameError" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <div class="mb-4">
                    <label for="editType" class="block text-sm font-medium text-gray-700 mb-2">Tipe Transmisi</label>
                    <select name="type" id="editType"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                        required>
                        <option value="Manual">Manual</option>
                        <option value="Matic">Matic</option>
                    </select>
                    <div id="editTypeError" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <div class="mb-6">
                    <label for="editStok" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Stok</label>
                    <input type="number" name="stok" id="editStok"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                        required min="0">
                    <div id="editStokError" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <div class="flex space-x-3">
                    <button type="button" id="cancelEditButton"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-lg transition duration-150 font-medium">
                        Batal
                    </button>
                    <button type="submit" id="editSubmitButton"
                        class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 rounded-lg transition duration-150 font-medium">
                        <span id="editSubmitText">Update Mobil</span>
                        <span id="editSubmitLoading" class="hidden">
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
        let mobilsData = [];
        const csrfToken = '{{ csrf_token() }}';

        // DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            initializeApp();
        });

        // Initialize app
        function initializeApp() {
            loadMobils();
            initializeEventListeners();
        }

        // Load mobils data from API
        function loadMobils() {
            showLoading(true);

            fetch('{{ route('mobil.api') }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mobilsData = data.data;
                        renderMobilsTable();
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

        // Render mobils table
        function renderMobilsTable() {
            const tbody = document.getElementById('mobilTableBody');

            if (mobilsData.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data mobil</h3>
                                <p class="text-gray-500 mb-4">Mulai dengan menambahkan mobil pertama Anda</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = mobilsData.map((mobil, index) => `
                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out ${index % 2 === 0 ? 'bg-white' : 'bg-gray-25'}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="text-sm font-semibold text-gray-900">${escapeHtml(mobil.name)}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full ${mobil.type === 'Manual' ? 'bg-orange-100 text-orange-800 border border-orange-200' : 'bg-green-100 text-green-800 border border-green-200'}">
                            ${mobil.type}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="text-sm font-semibold text-gray-900">${mobil.stok}</span>
                            <span class="ml-2 text-sm text-gray-500">unit</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <button onclick="editMobil(${mobil.id}, '${escapeHtml(mobil.name)}', '${mobil.type}', ${mobil.stok})"
                                class="inline-flex items-center px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Edit
                            </button>
                            <button onclick="deleteMobil(${mobil.id}, '${escapeHtml(mobil.name)}')"
                                class="inline-flex items-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Initialize event listeners
        function initializeEventListeners() {
            // Add car modal
            document.getElementById('addCarButton').addEventListener('click', openAddModal);
            document.getElementById('closeModalButton').addEventListener('click', closeAddModal);
            document.getElementById('cancelButton').addEventListener('click', closeAddModal);

            // Edit car modal
            document.getElementById('closeEditModalButton').addEventListener('click', closeEditModal);
            document.getElementById('cancelEditButton').addEventListener('click', closeEditModal);

            // Refresh button
            document.getElementById('refreshButton').addEventListener('click', loadMobils);

            // Form submissions
            document.getElementById('addCarForm').addEventListener('submit', handleAddSubmit);
            document.getElementById('editCarForm').addEventListener('submit', handleEditSubmit);

            // Close modal on outside click
            document.getElementById('addCarModal').addEventListener('click', function(e) {
                if (e.target === this) closeAddModal();
            });

            document.getElementById('editCarModal').addEventListener('click', function(e) {
                if (e.target === this) closeEditModal();
            });
        }

        // Modal functions
        function openAddModal() {
            clearForm('addCarForm');
            clearErrors(['name', 'type', 'stok']);
            document.getElementById('addCarModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addCarModal').classList.add('hidden');
        }

        function openEditModal() {
            document.getElementById('editCarModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editCarModal').classList.add('hidden');
        }

        // Edit mobil function
        function editMobil(id, name, type, stok) {
            document.getElementById('editCarId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editType').value = type;
            document.getElementById('editStok').value = stok;
            clearErrors(['editName', 'editType', 'editStok'], 'edit');
            openEditModal();
        }

        // Handle add form submission
        function handleAddSubmit(e) {
            e.preventDefault();

            setButtonLoading('submitButton', true);
            clearErrors(['name', 'type', 'stok']);

            const formData = new FormData(e.target);

            fetch('{{ route('mobil.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeAddModal();
                        loadMobils(); // Reload data
                        showSuccessAlert(data.message);
                    } else {
                        if (data.errors) {
                            showValidationErrors(data.errors);
                        } else {
                            showErrorAlert(data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorAlert('Terjadi kesalahan saat menambahkan mobil');
                })
                .finally(() => {
                    setButtonLoading('submitButton', false);
                });
        }

        // Handle edit form submission
        function handleEditSubmit(e) {
            e.preventDefault();

            setButtonLoading('editSubmitButton', true);
            clearErrors(['editName', 'editType', 'editStok'], 'edit');

            const formData = new FormData(e.target);
            const id = document.getElementById('editCarId').value;

            fetch(`{{ url('admin/mobil') }}/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: (() => {
                        formData.append('_method', 'PUT');
                        return formData;
                    })()
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeEditModal();
                        loadMobils(); // Reload data
                        showSuccessAlert(data.message);
                    } else {
                        if (data.errors) {
                            showValidationErrors(data.errors, 'edit');
                        } else {
                            showErrorAlert(data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorAlert('Terjadi kesalahan saat mengupdate mobil');
                })
                .finally(() => {
                    setButtonLoading('editSubmitButton', false);
                });
        }

        // Delete mobil function
        function deleteMobil(id, name) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Mobil ${name} akan dihapus permanen!`,
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
            fetch(`{{ url('admin/mobil') }}/${id}`, {
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
                        loadMobils(); // Reload data
                        showSuccessAlert(data.message);
                    } else {
                        showErrorAlert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorAlert('Terjadi kesalahan saat menghapus mobil');
                });
        }

        // Utility functions
        function showLoading(show) {
            const loading = document.getElementById('loadingIndicator');
            const table = document.getElementById('mobilTable');

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

        function clearForm(formId) {
            document.getElementById(formId).reset();
        }

        function clearErrors(fields, prefix = '') {
            fields.forEach(field => {
                const errorId = prefix ? `${prefix}${field.charAt(0).toUpperCase() + field.slice(1)}Error` :
                    `${field}Error`;
                const errorEl = document.getElementById(errorId);
                if (errorEl) {
                    errorEl.classList.add('hidden');
                    errorEl.textContent = '';
                }
            });
        }

        function showValidationErrors(errors, prefix = '') {
            Object.keys(errors).forEach(field => {
                const errorId = prefix ? `${prefix}${field.charAt(0).toUpperCase() + field.slice(1)}Error` :
                    `${field}Error`;
                const errorEl = document.getElementById(errorId);
                if (errorEl && errors[field].length > 0) {
                    errorEl.textContent = errors[field][0];
                    errorEl.classList.remove('hidden');
                }
            });
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

        // Handle session messages (jika ada)
        @if (session('success'))
            showSuccessAlert({!! json_encode(session('success')) !!});
        @endif

        @if (session('error'))
            showErrorAlert({!! json_encode(session('error')) !!});
        @endif
    </script>
</x-app-layout>
