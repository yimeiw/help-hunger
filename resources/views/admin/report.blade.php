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
                    <h4 class="flex justify-center text-md font-semibold text-creamcard mb-3">Tren Donasi Bulanan (12 Bulan Terakhir)</h4>
                    {{-- Laporan Donasi per Bulan (Grafik Batang) --}}
                    <div class="w-full max-w-5xl h-[350px] mx-auto">
                        <canvas id="monthlyDonationChart" width="500" height="800" class="mx-auto"></canvas>
                    </div>
                </div>
    
                {{-- Laporan Jumlah Pengguna per Role (Grafik Donut) --}}
                <div class="bg-greenbg w-full max-w-5xl mx-auto h-[450px] p-4 overflow-hidden shadow-xl sm:rounded-lg">
                    <h4 class="flex items-center justify-center text-md font-bold text-creamcard mb-3">Distribusi Pengguna Berdasarkan Peran</h4>
                    <div class="relative h-[350px] w-full pr-12">
                        <canvas id="userRoleChart"></canvas>
                    </div>
                </div>
            </div>
            
            {{-- Laporan Top Events by Volunteers (Grafik Batang Horizontal) --}}
            <div class="mt-8 bg-greenbg overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h4 class="flex justify-center text-md font-bold text-creamcard mb-3">Top 5 Event Berdasarkan Partisipasi Volunteer</h4>
                <div class="w-full max-w-5xl h-[500px] mx-auto px-4">
                    <canvas id="topEventsChart" class="w-full h-full"></canvas>
                </div>
            </div>

            {{-- Tabel Data Mentah (Contoh: Donasi Terbaru) --}}
            <div class="mt-8 p-6 bg-greenbg overflow-hidden shadow-xl sm:rounded-lg">
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
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-creamcard text-center">Tidak ada data donasi terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Data dari Laravel Controller
        const reportData = @json($reportData);

        Chart.defaults.color = '#FFF7D9';

        // --- Grafik Donasi Bulanan ---
        const monthlyDonationCtx = document.getElementById('monthlyDonationChart').getContext('2d');
        new Chart(monthlyDonationCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($reportData['monthlyDonations']['labels']) !!},
                datasets: [{
                    label: 'Total Donasi (Rp)',
                    data: {!! json_encode($reportData['monthlyDonations']['data']) !!},
                    backgroundColor: 'rgb(54, 163, 235)',
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
                    },
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)',
                        },
                        ticks: {
                            color: '#FFF7D9',
                            font: {
                                size: 12
                            }
                        },
                        title: {
                            text: 'Bulan',
                            color: '#FFF7D9'
                        },
                    },
                    y: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)',
                        },
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
                        'rgba(255, 44, 90, 0.65)',  // Donatur
                        'rgba(255, 204, 86, 0.7)',   // Admin
                        'rgba(75, 192, 192, 0.71)', // Volunteer
                        'rgba(86, 156, 255, 0.7)', // Other
                        'rgba(153, 102, 255, 0.7)',   // Partner
                        'rgba(255, 64, 182, 0.7)', // Other
                    ],
                    borderColor: [
                        'rgba(255, 44, 90, 0.65)',
                        'rgba(255, 205, 86, 1)',   
                        'rgba(75, 192, 192, 1)',
                        'rgba(86, 156, 255, 0.7)',
                        'rgba(153, 102, 255, 0.7)',  
                        'rgba(255, 64, 182, 0.7)', 
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins:{
                    legend: {
                        position: 'right',
                        labels: {
                            color: '#FFF7D9',
                            font: {
                                size: 14
                            }
                        }
                    },
                    labels:{
                        color: '#FFF7D9',
                            font: {
                                size: 14
                            }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        // --- Grafik Top Events by Volunteers ---
        const topEventsCtx = document.getElementById('topEventsChart').getContext('2d');
        new Chart(topEventsCtx, {
            type: 'bar',
            data: {
                labels: reportData.topEventsByVolunteers.labels,
                datasets: [{
                    label: 'Total Volunteer',
                    data: reportData.topEventsByVolunteers.data,
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                indexAxis: 'y', // Membuat grafik batang horizontal
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#FFF7D9',
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        enabled: true
                    },
                    title: {
                        display: false,
                        text: 'Top 5 Event',
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
                            },
                            beginAtZero: true
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)'
                        },
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
                            },
                            callback: function(value) {
                                const label = this.getLabelForValue(value);
                                // Membatasi panjang label agar tidak terlalu panjang
                                return label.length > 40 ? label.substring(0, 37) + '...' : label;
                            }
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)'
                        },
                        title: {
                            display: true,
                            color: '#FFF7D9',
                            text: 'Event',
                            weight: 'bold'
                        }
                    }
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 10,
                        bottom: 10
                    }
                }
            }
        });

    </script>
    @endpush
</x-app-layout>