<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="py-2 bg-gray-100 min-h-screen">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <x-prims-sub-header>
                Summary Report
            </x-prims-sub-header>
        </div>
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-4">

            <form method="GET" action="{{ route('summary-report') }}" class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">Summary Report</h2>
                    <div class="flex space-x-6">
                        <div>
                            <label class="font-semibold text-gray-700">Month:</label>
                            <select name="month" class="rounded-lg border-gray-300 p-2 w-32">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == $selectedMonth ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">Year:</label>
                            <select name="year" class="rounded-lg border-gray-300 p-2 w-32">
                                @for ($i = 2020; $i <= now()->year; $i++)
                                    <option value="{{ $i }}" {{ $i == $selectedYear ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600">
                            Apply Filter
                        </button>
                    </div>
                </div>
            </form>

            <div class="grid grid-cols-3 gap-3 mb-4">
                <div class="p-3 bg-white rounded-lg shadow-md flex flex-col items-center justify-center transition-transform duration-200 hover:scale-105">
                    <x-heroicon-s-users class="h-5 w-5 text-blue-500 mb-1" />
                    <h3 class="text-sm font-semibold text-gray-700">Patients</h3>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ $totalPatients }}</p>
                </div>

                <div class="p-3 bg-white rounded-lg shadow-md flex flex-col items-center justify-center transition-transform duration-200 hover:scale-105">
                    <x-heroicon-s-check-circle class="h-5 w-5 text-green-500 mb-1" />
                    <h3 class="text-sm font-semibold text-gray-700">Attended</h3>
                    <p class="text-xl font-bold text-green-500 mt-0.5">{{ $attendedCount }}</p>
                </div>

                <div class="p-3 bg-white rounded-lg shadow-md flex flex-col items-center justify-center transition-transform duration-200 hover:scale-105">
                    <x-heroicon-s-x-circle class="h-5 w-5 text-red-500 mb-1" />
                    <h3 class="text-sm font-semibold text-gray-700">Cancelled</h3>
                    <p class="text-xl font-bold text-red-500 mt-0.5">{{ $cancelledCount }}</p>
                </div>
            </div>

            <!-- Charts Row (1 + 2) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Chart 1 -->
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-lg font-semibold text-gray-800 text-center mb-3">Appointments Overview</h3>
                    <div class="relative h-[180px] w-full">
                        <canvas id="appointmentMeter"></canvas>
                    </div>
                </div>

                <!-- Chart 2 -->
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-lg font-semibold text-gray-800 text-center mb-3">Patient Demographics (Age)</h3>
                    <div class="relative h-[180px] w-full">
                        <canvas id="ageChart"></canvas>
                    </div>
                </div>
        </div>
            <!-- Incoming Appointments Table -->
            <div class="bg-white rounded-lg shadow-md p-4 col-span-1 md:col-span-2 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3 text-center">Approved Upcoming Appointments</h3>

                <div class="overflow-y-auto max-h-80 border rounded">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100 text-gray-700 font-semibold sticky top-0 z-10">
                            <tr>
                                <th class="px-4 py-2 border">Patient</th>
                                <th class="px-4 py-2 border">Date</th>
                                <th class="px-4 py-2 border">Time</th>
                                <th class="px-4 py-2 border">Doctor</th>
                                <th class="px-4 py-2 border">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                        @forelse($incomingAppointments as $appt)
                            <tr class="hover:bg-gray-50">
                                <!-- Patient Name -->
                                <td class="px-4 py-2 border">
                                    {{ optional($appt->patient->user)->name 
                                        ?? ($appt->patient->first_name . ' ' . $appt->patient->last_name) 
                                        ?? 'Unknown' }}
                                </td>

                                <!-- Appointment Date -->
                                <td class="px-4 py-2 border">
                                    {{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}
                                </td>

                                <!-- Appointment Time -->
                                <td class="px-4 py-2 border">
                                    {{ \Carbon\Carbon::parse($appt->appointment_date)->format('g:i A') }}
                                </td>

                                <!-- Doctor Name -->
                                <td class="px-4 py-2 border">
                                    {{ optional($appt->doctor)->full_name ?? 'N/A' }}
                                </td>

                                <!-- Status -->
                                <td class="px-4 py-2 border">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $appt->status == 'approved' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                        {{ ucfirst($appt->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-4">
                                    No upcoming appointments
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                <!-- Button to Calendar -->
                <div class="mt-4 text-center">
                    <a href="{{ route('calendar') }}" 
                    class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    View All in Calendar
                    </a>
                </div>
            </div>


            <!-- 🔹 Charts Row (3 + 4) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Chart 3 -->
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-lg font-semibold text-gray-800 text-center mb-3">Top Reasons for Visit</h3>
                    <div class="relative h-[180px] w-full">
                        <canvas id="diagnosisChart"></canvas>
                    </div>
                </div>

                <!-- Chart 4 -->
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-lg font-semibold text-gray-800 text-center mb-3">Top Prescribed Medications</h3>
                    <div class="relative h-[180px] w-full">
                        <canvas id="medicationChart"></canvas>
                    </div>
                </div>
            </div>

               <!-- 💛 Patient Satisfaction / Feedback Summary -->

             <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
    <!-- LEFT: Summary (1/3 width) -->
    <div class="bg-white rounded-2xl shadow p-6 col-span-1 flex flex-col justify-between">
        <div>
            <!-- Title -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">
                    Patient Satisfaction / Feedback Summary
                </h2>
            </div>

            <!-- Stars + Percent -->
            <div class="flex items-center justify-between mb-2">
                <div id="average-stars" class="flex text-yellow-400 text-2xl"></div>
                <span class="text-gray-700 text-lg font-semibold">
                    {{ number_format($satisfactionScore, 0) }}%
                </span>
            </div>

            <!-- Average rating and total feedback -->
            <p class="text-sm text-gray-600 mb-3">
                Average Rating: <strong>{{ $averageRating }}/5</strong><br>
                Total Feedback: <strong>{{ $totalFeedback }}</strong>
            </p>

            <!-- Rating Distribution -->
            <div class="space-y-2">
                @foreach($ratingDistribution as $stars => $count)
                    <div class="flex items-center justify-between text-sm text-gray-700">
                        <div class="flex items-center space-x-1">
                            <span class="w-8">{{ $stars }}★</span>
                            <div class="w-24 bg-gray-100 rounded-full h-2">
                                <div class="bg-yellow-400 h-2 rounded-full transition-all duration-500"
                                    style="width: {{ $totalFeedback > 0 ? ($count / $totalFeedback) * 100 : 0 }}%;">
                                </div>
                            </div>
                        </div>
                        <span>{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- RIGHT: Comments (2/3 width) -->
    <div class="bg-white rounded-2xl shadow p-6 col-span-2">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Feedback</h2>

        <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
            @forelse($recentFeedback as $feedback)
                <div class="border-b border-gray-100 pb-3">
                    <div class="flex justify-between text-sm text-gray-500 mb-1">
                        <span>{{ $feedback->created_at->format('M d, Y') }}</span>
                        <span>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                            @endfor
                        </span>
                    </div>
                    <p class="text-gray-700 text-sm italic">"{{ $feedback->comment }}"</p>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No feedback available.</p>
            @endforelse
        </div>
    </div>
</div>

            <div class="flex justify-end mt-4">
                <button id="generateReport" 
                    class="bg-blue-600 text-white py-2 px-4 rounded-md shadow-md hover:bg-blue-700 text-sm">
                    Generate Accomplishment Report
                </button>
            </div>

            <!-- Report Modal -->
            <div id="reportModal" class="fixed inset-0 hidden z-50 items-center justify-center bg-black bg-opacity-50" aria-hidden="true" role="dialog" aria-modal="true">
            <div class="modal-content bg-white rounded-lg p-4 w-72 shadow-2xl transform transition-transform duration-200 scale-95 opacity-0">
                <h2 class="text-md font-semibold text-gray-800 mb-3">Select Report Type</h2>

                <button data-type="monthly" class="w-full bg-blue-600 text-white py-2 mb-2 rounded-md hover:bg-blue-700 text-sm">Monthly</button>
                <button data-type="yearly" class="w-full bg-yellow-500 text-white py-2 rounded-md hover:bg-yellow-600 text-sm">Yearly</button>
                <button id="closeModal" class="mt-3 w-full bg-gray-300 text-gray-800 py-2 rounded-md hover:bg-gray-400 text-sm">Cancel</button>
            </div>
            </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Data for charts
            const attendedCount = {{ $attendedCount }};
            const cancelledCount = {{ $cancelledCount }};
            const medications = @json($medications);
            const diagnoses = @json($diagnoses);
            const ageGroups = @json($ageGroups);

            // 1. Appointments Overview (Doughnut Chart)
            const ctxAppointment = document.getElementById('appointmentMeter').getContext('2d');
            new Chart(ctxAppointment, {
                type: 'doughnut',
                data: {
                    labels: ['Attended Appointments', 'Cancelled Appointments'],
                    datasets: [{
                        data: [attendedCount, cancelledCount],
                        backgroundColor: ['#34D399', '#F87171'],
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { size: 10 } } },
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    const value = context.parsed;
                                    const total = attendedCount + cancelledCount;
                                    const pct = total ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${context.label}: ${value} (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // 2. Top Prescribed Medications (Horizontal Bar Chart)
            const ctxMed = document.getElementById('medicationChart').getContext('2d');
            new Chart(ctxMed, {
                type: 'bar',
                data: {
                    labels: medications.map(m => m.name),
                    datasets: [{
                        label: 'Quantity Dispensed',
                        data: medications.map(m => m.quantity_dispensed),
                        backgroundColor: '#3B82F6',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    scales: {
                        x: {
                            grid: { display: false },
                            title: { display: true, text: 'Quantity Dispensed', font: { size: 10 } }
                        },
                        y: {
                            grid: { display: false },
                            title: { display: false },
                            ticks: { autoSkip: false, maxTicksLimit: 10, font: { size: 9 } }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        title: {
                            display: false,
                        }
                    }
                }
            });

            // 3. Top Reasons for Visit (Pie Chart)
            const ctxDiag = document.getElementById('diagnosisChart').getContext('2d');
            new Chart(ctxDiag, {
                type: 'pie',
                data: {
                    labels: diagnoses.map(d => d.diagnosis),
                    datasets: [{
                        data: diagnoses.map(d => d.count),
                        backgroundColor: ['#F59E0B', '#EF4444', '#3B82F6', '#10B981', '#8B5CF6'],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right', labels: { font: { size: 10 } } },
                        title: {
                            display: false,
                        }
                    }
                }
            });

            // 4. Patient Demographics (Age Group Bar Chart)
            const ctxAge = document.getElementById('ageChart').getContext('2d');
            new Chart(ctxAge, {
                type: 'bar',
                data: {
                    labels: ageGroups.map(ag => ag.label),
                    datasets: [{
                        label: 'Number of Patients',
                        data: ageGroups.map(ag => ag.count),
                        backgroundColor: '#1E40AF',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: { display: false },
                            title: { display: true, text: 'Age Group', font: { size: 10 } }
                        },
                        y: {
                            grid: { display: true },
                            title: { display: true, text: 'Number of Patients', font: { size: 10 } },
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        title: {
                            display: false,
                        }
                    }
                }
            });
        });
    </script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('reportModal');
  const modalContent = modal ? modal.querySelector('.modal-content') : null;
  const generateBtn = document.getElementById('generateReport');
  const closeModal = document.getElementById('closeModal');

  if (!modal || !modalContent || !generateBtn || !closeModal) {
    console.warn('Report modal init skipped — missing element(s):', {
      modal: !!modal, modalContent: !!modalContent, generateBtn: !!generateBtn, closeModal: !!closeModal
    });
    return;
  }

  function openModal() {
    // show backdrop & center container
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    // allow browser to apply layout then animate modal in
    requestAnimationFrame(() => {
      modalContent.classList.remove('scale-95', 'opacity-0');
      modalContent.classList.add('scale-100', 'opacity-100');
    });

    modal.setAttribute('aria-hidden', 'false');
  }

  function hideModal() {
    // animate out
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');

    // after animation, hide backdrop
    setTimeout(() => {
      modal.classList.remove('flex');
      modal.classList.add('hidden');
      modal.setAttribute('aria-hidden', 'true');
    }, 200);
  }

  // open
  generateBtn.addEventListener('click', openModal);

  // close
  closeModal.addEventListener('click', hideModal);

  // click outside modalContent closes modal
  modal.addEventListener('click', (e) => {
    if (e.target === modal) hideModal();
  });

  // handle report type buttons
  modal.querySelectorAll('button[data-type]').forEach(btn => {
    btn.addEventListener('click', () => {
      const type = btn.getAttribute('data-type');
      const month = "{{ $selectedMonth }}";
      const year = "{{ $selectedYear }}";
      let url = '';

      if (type === 'monthly') {
        url = `{{ route('generate.accomplishment.report') }}?type=monthly&month=${month}&year=${year}`;
      } else {
        url = `{{ route('generate.accomplishment.report') }}?type=yearly&year=${year}`;
      }

      // open in new tab and close modal
      window.open(url, '_blank');
      hideModal();
    });
  });

});
</script>

<!-- Satisfaction bar !-->
<!-- Font Awesome (for stars) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<script>
    // Render stars for the top summary
    const avgStars = {{ $averageRating }};
    const starContainer = document.getElementById('average-stars');
    if (starContainer) {
        const fullStars = Math.floor(avgStars);
        const halfStar = avgStars % 1 >= 0.5;
        for (let i = 1; i <= 5; i++) {
            const star = document.createElement('i');
            if (i <= fullStars) {
                star.className = 'fas fa-star';
            } else if (i === fullStars + 1 && halfStar) {
                star.className = 'fas fa-star-half-alt';
            } else {
                star.className = 'far fa-star';
            }
            starContainer.appendChild(star);
        }
    }
</script>
</x-app-layout>