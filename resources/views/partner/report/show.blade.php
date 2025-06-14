<x-app-layout>
    <div class="container-fluid">

        {{-- Filter Laporan --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Filter Laporan</div>
                    <div class="card-body">
                        <form action="{{ route('partner.report.show') }}" method="GET" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label">Tanggal Mulai:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date', \Carbon\Carbon::now()->subMonths(11)->startOfMonth()->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label">Tanggal Akhir:</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date', \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                                <a href="{{ route('partner.report.show') }}" class="btn btn-secondary">Reset Filter</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        ---

        {{-- Ringkasan Laporan Event & Partisipasi Mitra --}}
        <h2>Ringkasan Event & Partisipasi Mitra</h2>
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

    {{-- SCRIPTS Chart.js (Ditempatkan di sini untuk memastikan elemen canvas sudah ada) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
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