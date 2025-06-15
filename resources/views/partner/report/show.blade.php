<x-app-layout>
    <div class="container-fluid">

        {{-- Filter Laporan --}}
        <div class="m-6">
            <div class="w-1/2">
                <div class="bg-redb/50  shadow-lg rounded-xl overflow-hidden"> 
                    <div class="bg-redb text-creamcard font-semibold py-4 px-6 border-b border-creamcard text-lg"> Filter Report
                    </div>
                    <div class="p-6"> 
                        <form action="{{ route('partner.report.show') }}" method="GET" class="flex flex-col items-end -mx-2">
                            <div class="flex flex-wrap -mx-2 w-full mb-4">
                                <div class="w-full md:w-1/3 sm:w-1/2 px-2 mb-4 md:mb-0"> 
                                    <label for="start_date" class="block text-creamcard font-medium text-sm mb-2">Tanggal Mulai:</label> 
                                    <input type="text" class="block w-full px-4 py-2 bg-creamcard text-redb font-medium border-redb rounded-lg focus:outline-none focus:ring-2 focus:ring-redb focus:border-redb transition duration-300 ease-in-out" id="start_date" name="start_date" value="{{ request('start_date', \Carbon\Carbon::now()->subMonths(11)->startOfMonth()->format('Y-m-d')) }}"> 
                                </div>
                                <div class="w-full md:w-1/3 sm:w-1/2 px-2 mb-4 md:mb-0"> 
                                    <label for="end_date" class="block text-creamcard font-medium text-sm mb-2">Tanggal Akhir:</label> 
                                    <input type="text" class="block w-full px-4 py-2 bg-creamcard text-redb font-medium border-redb rounded-lg focus:outline-none focus:ring-2 focus:ring-redb focus:border-redb transition duration-300 ease-in-out" id="end_date" name="end_date" value="{{ request('end_date', \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')) }}"> 
                                </div>
                            </div>
                            <div class=""> 
                                <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto"> 
                                    <button type="submit" class="w-full md:w-auto px-5 py-2 bg-creamcard text-redb shadow-quadrupleNonHover font-medium rounded-lg hover:shadow-quadrupleHover hover:text-greenbg transition duration-200 ease-in-out transform hover:-translate-y-px">Terapkan Filter</button> 
                                    <a href="{{ route('partner.report.show') }}" class="w-full md:w-auto px-5 py-2 bg-creamcard text-redb shadow-quadrupleNonHover font-medium rounded-lg hover:shadow-quadrupleHover hover:text-greenbg transition duration-200 ease-in-out transform hover:-translate-y-px">Reset Filter</a> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <p class="font-bold text-redb text-lg">Ringkasan Event & Partisipasi Mitra</p>
        @php
            $partner = $reportData['partnerReports'];
        @endphp

        @if (empty($partner))
            <p class="alert alert-info">Tidak ada data mitra ditemukan untuk laporan.</p>
        @else
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Detail Mitra: {{ $partner['partner_name'] }}</strong>
                    <div>
                        <span class="badge bg-primary me-2">Event Relawan: {{ $partner['total_volunteer_events'] }}</span>
                        <span class="badge bg-success">Event Donasi: {{ $partner['total_donatur_events'] }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Event Relawan:</h5>
                            @if ($partner['volunteer_event_details']->isEmpty())
                                <p>Tidak ada event relawan ditemukan untuk mitra ini dalam periode yang dipilih.</p>
                            @else
                                <ul class="list-group list-group-flush">
                                    @foreach ($partner['volunteer_event_details'] as $event)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $event['event_name'] }}
                                            <span class="badge bg-info rounded-pill">Total Relawan: {{ $event['total_volunteers'] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5>Event Donasi:</h5>
                            @if ($partner['donatur_event_details']->isEmpty())
                                <p>Tidak ada event donasi ditemukan untuk mitra ini dalam periode yang dipilih.</p>
                            @else
                                <ul class="list-group list-group-flush">
                                    @foreach ($partner['donatur_event_details'] as $event)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $event['event_name'] }}
                                            <span class="badge bg-warning rounded-pill">Donasi Terkumpul: Rp{{ number_format($event['total_donations_collected'], 0, ',', '.') }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        ---

        <h2>Analisis Data</h2>
        <div class="row">
            {{-- Monthly Donations Chart --}}
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">Donasi Bulanan</div>
                    <div class="card-body">
                        <canvas id="monthlyDonationsChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Monthly Events Conducted by Partner Chart --}}
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">Jumlah Event Diselenggarakan per Bulan</div>
                    <div class="card-body">
                        <canvas id="monthlyEventsChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- NEW CHART: Volunteer Event Status Distribution --}}
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">Distribusi Status Event Relawan</div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        {{-- Added chart-container class --}}
                        <div class="chart-container" style="position: relative; height:300px; width:100%;">
                            <canvas id="volunteerEventStatusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- NEW CHART: Donatur Event Status Distribution --}}
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">Distribusi Status Event Donasi</div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        {{-- Added chart-container class --}}
                        <div class="chart-container" style="position: relative; height:300px; width:100%;">
                            <canvas id="donaturEventStatusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Top 5 Events by Volunteer Participation --}}
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">5 Event Teratas Berdasarkan Partisipasi Relawan</div>
                    <div class="card-body">
                        <canvas id="topVolunteersChart"></canvas>
                    </div>
                </div>
            </div>
        </div> {{-- End row for charts --}}

    </div> {{-- End container-fluid --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#start_date", {
                dateFormat: "Y-m-d",
                locale: {
                    weekdays: { shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'], longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'], },
                    months: { shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'], longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'], },
                    firstDayOfWeek: 1,
                    rangeSeparator: ' hingga ',
                    time_24hr: true,
                    ordinal: (nth) => { if (nth > 9) { return ''; } return ["", "", "", ""][nth - 1]; },
                },
            });

            flatpickr("#end_date", {
                dateFormat: "Y-m-d",
                locale: {
                    weekdays: { shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'], longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'], },
                    months: { shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'], longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'], },
                    firstDayOfWeek: 1,
                    rangeSeparator: ' hingga ',
                    time_24hr: true,
                    ordinal: (nth) => { if (nth > 9) { return ''; } return ["", "", "", ""][nth - 1]; },
                },
            });
        });



        // Data dari PHP
        const reportData = @json($reportData);

        // --- Chart: Donasi Bulanan ---
        const ctxMonthly = document.getElementById('monthlyDonationsChart').getContext('2d');
        new Chart(ctxMonthly, {
            type: 'bar',
            data: {
                labels: reportData.monthlyDonations.labels,
                datasets: [{
                    label: 'Total Jumlah Donasi',
                    data: reportData.monthlyDonations.data,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Donasi (Rp)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += 'Rp' + context.parsed.y.toLocaleString('id-ID');
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // --- Chart: Jumlah Event Diselenggarakan per Bulan ---
        const ctxMonthlyEvents = document.getElementById('monthlyEventsChart').getContext('2d');
        new Chart(ctxMonthlyEvents, {
            type: 'bar',
            data: {
                labels: reportData.monthlyEvents.labels,
                datasets: [
                    {
                        label: 'Event Relawan',
                        data: reportData.monthlyEvents.volunteer_data,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)', // Biru
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Event Donasi',
                        data: reportData.monthlyEvents.donatur_data,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)', // Merah
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Event'
                        },
                        ticks: {
                            callback: function(value) {
                                if (value % 1 === 0) {
                                    return value;
                                }
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y + ' Event';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // --- NEW CHART: Distribusi Status Event Relawan ---
        console.log('Volunteer Event Status Data:', reportData.volunteerEventStatus.data); // Add this
        const ctxVolunteerStatus = document.getElementById('volunteerEventStatusChart').getContext('2d');
        new Chart(ctxVolunteerStatus, {
            type: 'pie',
            data: {
                labels: reportData.volunteerEventStatus.labels,
                datasets: [{
                    label: 'Jumlah Event',
                    data: reportData.volunteerEventStatus.data,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)', // Selesai
                        'rgba(255, 206, 86, 0.6)', // Sedang Berlangsung
                        'rgba(54, 162, 235, 0.6)'  // Akan Datang
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed + ' Event';
                                }
                                return label;
                            }
                        }
                    },
                    legend: {
                        position: 'right', // Place legend on the right for pie charts
                    }
                }
            }
        });

        // --- NEW CHART: Distribusi Status Event Donasi ---
        const ctxDonaturStatus = document.getElementById('donaturEventStatusChart').getContext('2d');
        new Chart(ctxDonaturStatus, {
            type: 'pie',
            data: {
                labels: reportData.donaturEventStatus.labels,
                datasets: [{
                    label: 'Jumlah Event',
                    data: reportData.donaturEventStatus.data,
                    backgroundColor: [
                        'rgba(153, 102, 255, 0.6)', // Selesai
                        'rgba(255, 99, 132, 0.6)'  // Aktif/Berlangsung
                    ],
                    borderColor: [
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed + ' Event';
                                }
                                return label;
                            }
                        }
                    },
                    legend: {
                        position: 'right', // Place legend on the right for pie charts
                    }
                }
            }
        });

        // --- Chart: 5 Event Teratas Berdasarkan Partisipasi Relawan ---
        const ctxTopVolunteers = document.getElementById('topVolunteersChart').getContext('2d');
        new Chart(ctxTopVolunteers, {
            type: 'bar',
            data: {
                labels: reportData.topEventsByVolunteers.labels,
                datasets: [{
                    label: 'Jumlah Relawan',
                    data: reportData.topEventsByVolunteers.data,
                    backgroundColor: 'rgba(255, 159, 64, 0.6)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y', // Membuat bar horizontal
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Relawan'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Nama Event'
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>