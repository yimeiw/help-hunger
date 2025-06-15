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

        <div class="m-6 mt-12">
            @php
                $partner = $reportData['partnerReports'];
            @endphp
             <p class="font-bold text-redb text-lg ">Event Summary & Participation of {{ $partner['partner_name'] }}</p>

            @if (empty($partner))
                <p class="alert alert-info">Tidak ada data mitra ditemukan untuk laporan.</p>
            @else
            <form action="{{ route('partner.program.show') }}" method="get">
                <div class="w-full shadow-md sm:rounded-xl border border-2 border-blackAuth/50">
                    <div class="border border-2 border-greenAuth/50 rounded-lg p-0">
                        <div class="border border-2 h-auto border-redb/50 bg-creamcard rounded-lg">
                            <div class="mb-4 p-8 px-16 flex flex-row justify-between text-redb text-md">
                                <input type="hidden" name="type" id="event-type-input" value="{{ $eventType }}">
                                <div class="flex flex-col gap-y-6 w-full">
                                    <button data-type="volunteer" class="me-2 shadow-md rounded-lg p-4 bg-redb text-creamcard hover:bg-greenbg transition duration-300 ease-in-out event-type-btn">Events Volunteer: {{ $partner['total_volunteer_events'] }} events</button>
                                    
                                    <div >
                                        <p class="font-bold mb-4">Details:</p>
                                        @if ($partner['volunteer_event_details']->isEmpty())
                                            <p class="text-sm">No volunteer events were found for you in the selected period.</p>
                                        @else
                                            <div class="h-32 overflow-y-auto scrollbar-hide">
                                                <ol class="flex flex-col gap-y-8 list-none">
                                                    @foreach ($partner['volunteer_event_details'] as $event)
                                                        <li class="font-bold flex flex-col text-sm">
                                                            {{ $event['event_name'] }}
                                                            <p class="text-sm font-normal">
                                                                Status: 
                                                                <span class="font-semibold {{ $event['status'] == 'accepted' ? 'text-green-500' : ($event['status'] == 'pending' ? 'text-yellow-500' : 'text-red-500') }}">
                                                                    {{ ucfirst($event['status']) }}
                                                                </span>
                                                            </p>
                                                            <span class="text-sm font-normal">Total Volunteer: {{ $event['total_volunteers'] }}</span>
                                                            <hr class="border w-full h-0 border-redb flex justify-center items-center">

                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </div> 
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center justify-center w-full">
                                    <hr class="border w-0 h-full border-redb flex justify-center items-center">
                                </div>
                                                    
                                <div class="flex flex-col gap-y-6 w-full">
                                    <button data-type="donation" class="me-2 shadow-md rounded-lg p-4 bg-redb text-creamcard hover:bg-greenbg transition duration-300 ease-in-out event-type-btn">Event Donasi: {{ $partner['total_donatur_events'] }} events</button>
                                 
                                    <div>
                                        <p class="font-bold mb-4">Details:</p>
                                        @if ($partner['donatur_event_details']->isEmpty())
                                            <p class="text-sm">No donation events were found for you in the selected period.</p>
                                        @else
                                            <div class="h-32 overflow-y-auto scrollbar-hide justify-end" >
                                                <ol class="flex flex-col gap-y-8 list-none ">
                                                    @foreach ($partner['donatur_event_details'] as $event)
                                                        <li class="font-bold flex flex-col text-sm">
                                                            {{ $event['event_name'] }}
                                                            
                                                            <p class="text-sm font-normal">
                                                                Status: 
                                                                <span class="font-semibold {{ $event['status'] == 'accepted' ? 'text-green-500' : ($event['status'] == 'pending' ? 'text-yellow-500' : 'text-red-500') }}">
                                                                    {{ ucfirst($event['status']) }}
                                                                </span>
                                                            </p>

                                                            <span class="text-sm font-normal">Total Donation: Rp{{ number_format($event['total_donations_collected'], 0, ',', '.') }}</span>
                                                            <hr class="border w-full h-0 border-redb flex justify-center items-center">
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endif

        </div>

        <div class="m-6 mt-12">
            <p class="font-bold text-redb text-xl mb-6">Analyst Data</p>

            <div class="grid grid-cols-2 gap-6">
                {{-- Monthly Donations Chart --}}
                <div class="shadow-lg rounded-lg mb-4 p-4 bg-creamhh/50">
                    <div class="card h-100">
                        <div class="font-medium text-redb text-sm mb-4">Monthly Donations</div>
                        <div class="card-body">
                            <canvas id="monthlyDonationsChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Monthly Events Conducted by Partner Chart --}}
                <div class="shadow-lg rounded-lg mb-4 p-4 bg-creamhh/50">
                    <div class="card h-100">
                        <div class="font-medium text-redb text-sm mb-4">Jumlah Event Diselenggarakan per Bulan</div>
                        <div class="card-body">
                            <canvas id="monthlyEventsChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Volunteer Event Status Distribution --}}
                <div class="shadow-lg rounded-lg mb-4 p-4 bg-creamhh/50">
                    <div class="card h-auto">
                        <div class="font-medium text-redb text-sm mb-4">Distribusi Status Event Relawan</div>
                        @if($reportData['volunteerEventStatus']['hasData'])
                            <div class="flex items-center justify-center">
                                <div class=" w-96 h-96">
                                    <canvas id="volunteerStatusChart"></canvas>
                                </div>
                            </div>
                        @else
                            <div class="p-4 text-center bg-gray-100 rounded-lg">
                                <p class="text-gray-600">Belum ada event volunteer dalam periode ini.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Donatur Event Status Distribution --}}
                <div class="shadow-lg rounded-lg mb-4 p-4 bg-creamhh/50">
                    <div class="card h-auto">
                        <div class="font-medium text-redb text-sm mb-4">Distribusi Status Event Donasi</div>
                        {{-- Added chart-container class --}}
                        @if($reportData['donaturEventStatus']['hasData'])
                            <div class="flex items-center justify-center">
                                <div class=" w-96 h-96">
                                    <canvas id="donaturEventStatusChart"></canvas>
                                </div>
                            </div>
                        @else
                            <div class="p-4 text-center bg-gray-100 rounded-lg">
                                <p class="text-gray-600">Belum ada event volunteer dalam periode ini.</p>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
            {{-- Top 5 Events by Volunteer Participation --}}
            <div class="shadow-lg rounded-lg mb-4 p-4 bg-creamhh/50">
                <div class="card h-100">
                    <div class="font-medium text-redb text-sm mb-4">5 Event Teratas Berdasarkan Partisipasi Relawan</div>
                    <div class="card-body h-72">
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

        document.addEventListener('DOMContentLoaded', function() {
            // Volunteer Chart
            if (document.getElementById('volunteerStatusChart') && @json($reportData['volunteerEventStatus']['hasData'])) {
                new Chart(
                    document.getElementById('volunteerStatusChart').getContext('2d'),
                    {
                        type: 'pie',
                        data: {
                            labels: @json($reportData['volunteerEventStatus']['labels']),
                            datasets: [{
                                data: @json($reportData['volunteerEventStatus']['data']),
                                backgroundColor: function(context) {
                                    const status = @json($reportData['volunteerEventStatus']['labels'])[context.dataIndex];
                                    return {
                                        'accepted': '#6FB275',
                                        'pending': '#FFDC58',
                                        'rejected': '#E66967'
                                    }[status];
                                },
                                borderWidth: 0

                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            aspectRatio: 1,
                            radius: '90%',
                            layout: {
                                padding: {
                                    left: 20,
                                    right: 20,
                                    top: 20,
                                    bottom: 20
                                }
                            },
                            elements: {
                                arc: {
                                    borderWidth: 0 // Hilangkan border pie segments
                                }
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        borderWidth: 0, // Hilangkan border legend
                                        useBorderRadius: false
                                    }
                                }
                            }

                        }
                    }
                );
            }
            
            // Donatur Chart
            if (document.getElementById('donaturEventStatusChart') && @json($reportData['donaturEventStatus']['hasData'])) {
                new Chart(
                    document.getElementById('donaturEventStatusChart').getContext('2d'),
                    {
                        type: 'pie',
                        data: {
                            labels: @json($reportData['donaturEventStatus']['labels']),
                            datasets: [{
                                data: @json($reportData['donaturEventStatus']['data']),
                                backgroundColor: function(context) {
                                    const status = @json($reportData['donaturEventStatus']['labels'])[context.dataIndex];
                                    return {
                                        'accepted': '#6FB275',
                                        'pending': '#FFDC58',
                                        'rejected': '#E66967'
                                    }[status];
                                },
                                borderWidth: 0

                            }]
                        },
                        options: {
                            elements: {
                                arc: {
                                    borderWidth: 0 // Hilangkan border pie segments
                                }
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        borderWidth: 0, // Hilangkan border legend
                                        useBorderRadius: false
                                    }
                                }
                            }

                        }
                    }
                );
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
                indexAxis: 'y',
                layout: {
                    padding: {
                        left: 100,  // Ruang ekstra untuk label
                        right: 20,
                        top: 20,
                        bottom: 20
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Relawan'
                        }
                    },
                    y: {
                        ticks: {
                            autoSkip: false,
                            font: {
                                size: 11
                            },
                            mirror: true,  // Alternatif tampilan
                            padding: 15
                        },
                        title: {
                            display: true,
                            text: 'Nama Event'
                        },
                        afterFit: function(axis) {
                            axis.width = 120;  // Memaksa lebar minimum
                        }
                    }
                }
            }
        });

        document.querySelectorAll('.event-type-btn').forEach(button => {
            button.addEventListener('click', function () {
                const type = this.dataset.type;
                document.getElementById('event-type-input').value = type;
                document.getElementById('event-type-text').innerText = type.charAt(0).toUpperCase() + type.slice(1);
                this.closest('form').submit();
            });
        });
    </script>
</x-app-layout>