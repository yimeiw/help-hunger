<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan & Analisis') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="sm:px-6 lg:px-8">
            <h3 class="flex items-center justify-center text-[32px] font-bold text-redb mb-6">Summary Report</h3>
            
            <div class="grid grid-cols-2 gap-8">
                <div class="bg-greenbg overflow-hidden shadow-xl sm:rounded-lg p-6">
                    {{-- Laporan Donasi per Bulan (Grafik Batang) --}}
                    <div class="relative w-[400px] h-[250px] mx-auto">
                        <h4 class="text-md font-semibold text-creamcard mb-3">Tren Donasi Bulanan (12 Bulan Terakhir)</h4>
                        <canvas id="monthlyDonationChart" width="500" height="800" class="mx-auto"></canvas>
                    </div>
                </div>
    
                {{-- Laporan Jumlah Pengguna per Role (Grafik Donut) --}}
                <div class="relative bg-greenbg w-full h-[450px] p-4 overflow-hidden shadow-xl sm:rounded-lg">
                    <h4 class="flex items-center justify-center text-md font-bold text-creamcard mb-3">Distribusi Pengguna Berdasarkan Peran</h4>
                    <canvas id="userRoleChart" height="250" class="mx-auto"></canvas>
                </div>
            </div>
            
            <div class="grid grid-rows-2 mt-8 gap-8">
                {{-- Laporan Top Events by Volunteers (Grafik Batang Horizontal) --}}
                <div class="bg-greenbg overflow-hidden shadow-xl sm:rounded-lg p-6">
                    {{-- Laporan Top Events by Volunteers (Grafik Batang Horizontal) --}}
                    <div class="relative w-[400px] h-[250px] mx-auto">
                        <h4 class="text-md font-bold text-creamcard mb-3">Top 5 Event Berdasarkan Partisipasi Volunteer</h4>
                        <canvas id="topEventsChart" width="600" height="300" class="mx-auto"></canvas>
                    </div>
                </div>
    
                <div class="bg-greenbg overflow-hidden shadow-xl sm:rounded-lg">
                    {{-- Tabel Data Mentah (Contoh: Donasi Terbaru) --}}
                    <div class="p-6">
                        <h4 class="flex items-center justify-center text-[24px] font-semibold text-creamcard mb-3">Newest Donation</h4>
                        <div class="overflow-x-auto bg-creamhh rounded-lg shadow-md">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-creamhh">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-redb uppercase tracking-wider">ID Donasi</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-redb uppercase tracking-wider">Jumlah</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-redb uppercase tracking-wider">Tanggal</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-redb uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-creamcard divide-y divide-gray-200 rounded-lg">
                                    @forelse (\App\Models\Donation::latest()->take(5)->get() as $donation) {{-- Ambil 5 donasi terbaru --}}
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $donation->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp{{ number_format($donation->amount, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $donation->created_at->format('d M Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $donation->status ?? 'Completed' }}</td> {{-- Sesuaikan kolom status --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada data donasi terbaru.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
    
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data dari Laravel Controller
        const reportData = @json($reportData);

        // --- Grafik Donasi Bulanan ---
        const monthlyDonationCtx = document.getElementById('monthlyDonationChart').getContext('2d');
        new Chart(monthlyDonationCtx, {
            type: 'bar',
            data: {
                labels: reportData.monthlyDonations.labels,
                datasets: [{
                    label: 'Total Donasi (Rp)',
                    data: reportData.monthlyDonations.data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    color: '#FFF7D9'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#FFF7D9',
                            font: {
                                size: 14
                            }
                        }
                    },
                    title: {
                        text: 'Tren Donasi Bulanan (12 Bulan Terakhir)',
                        color: '#FFF7D9',
                        font: {
                            size: 16
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#FFF7D9',
                            font: {
                                size: 12
                            }
                        },
                        title: {
                            text: 'Bulan',
                            color: '#FFF7D9'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#FFF7D9',
                            font: {
                                size: 12
                            }
                        },
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Donation (IDR)',
                            color: '#FFF7D9'
                        }
                    }
                }
            }
        });

        // --- Grafik Distribusi Pengguna per Peran ---
        const userRoleCtx = document.getElementById('userRoleChart').getContext('2d');
        new Chart(userRoleCtx, {
            type: 'doughnut',
            data: {
                labels: reportData.userRoles.labels,
                datasets: [{
                    label: 'Jumlah Pengguna',
                    data: reportData.userRoles.data,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)', // Volunteer
                        'rgba(255, 99, 132, 0.6)',  // Donatur
                        'rgba(255, 205, 86, 0.6)'   // Admin
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 205, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins:{
                    labels:{
                        color: '#FFF7D9',
                            font: {
                                size: 14
                            }
                    }
                }
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        // --- Grafik Top Events by Volunteers ---
        const topEventsCtx = document.getElementById('topEventsChart').getContext('2d');
        new Chart(topEventsCtx, {
            type: 'line',
            data: {
                labels: reportData.topEventsByVolunteers.labels,
                datasets: [{
                    label: 'Total Volunteer',
                    data: reportData.topEventsByVolunteers.data,
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1,
                    fill:false,
                    tension: 0.1
                }]
            },
            options: {
                indexAxis: 'y', // Membuat grafik batang horizontal
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#FFF7D9',
                            font: {
                                size: 14
                            }
                        }
                    },
                    title: {
                        color: '#FFF7D9',
                        font: {
                            size: 16
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#FFF7D9',
                            font: {
                                size: 12
                            }
                        },
                        beginAtZero: true,
                        title: {
                            display: true,
                            color: '#FFF7D9',
                            text: 'Total Volunteer'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#FFF7D9',
                            font: {
                                size: 12
                            }
                        },
                        title: {
                            display: true,
                            color: '#FFF7D9',
                            text: 'Event'
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>