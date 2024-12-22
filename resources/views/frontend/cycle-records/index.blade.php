@extends('frontend.layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/frontend/style/NotesList/style-note-list.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/frontend/style/NotesList/responsive.css') }}" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notes = JSON.parse(localStorage.getItem('haidTrackerNotes')) || [];

        document.querySelectorAll('.calendar').forEach((calendarEl, index) => {
            const calendarContainer = calendarEl.closest('.calendar-container');
            const startDate = calendarContainer.getAttribute('data-start-date');
            const endDate = calendarContainer.getAttribute('data-end-date');

            // Tambahkan 1 hari pada endDate
            const adjustedEndDate = new Date(endDate);
            adjustedEndDate.setDate(adjustedEndDate.getDate() + 1);

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                initialDate: startDate,
                schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
                selectable: false,
                events: [
                    ...notes.map(note => ({
                        title: `Mood: ${note.mood}, Gejala: ${note.symptom}`,
                        start: note.date,
                        description: note.note,
                    })),
                    {
                        start: startDate,
                        end: adjustedEndDate.toISOString().split('T')[0],
                        display: 'background',
                        color: '#ff9f89'
                    }
                ],
                eventClick: function (info) {
                    // Only show alert for note events, not background events
                    if (info.event.display !== 'background') {
                        alert(`Detail Catatan:\n\n${info.event.title}\nCatatan: ${info.event.extendedProps.description}`);
                    }
                },
                handleWindowResize: true,
                expandRows: true
            });

            calendar.render();
        });
    });
</script>
@endsection

@section('content')
<section>
    <div class="container">
            <div class="header-notes">
                <h2>List Catatan Siklus Kamu</h2>
                <button class="back-button" onclick="window.location.href='{{ route('cycle-record.create') }}'"><svg
                        xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24">
                        <path fill="currentColor" fill-rule="evenodd"
                            d="m3.343 12l7.071 7.071L9 20.485l-7.778-7.778a1 1 0 0 1 0-1.414L9 3.515l1.414 1.414z" />
                    </svg></button>
            </div>

            <div class="unduh-buttons">
                <a href="{{ route('cycle-record.index.pdf') }}" style="text-decoration: none;" target="blank" class="unduh">Unduh Semua Catatan</a>
            </div>

            @foreach ($initialDatas as $data)
                <div class="tracker" id="service">
                    <!-- Kolom Kiri -->
                    <div class="col-6">
                        <!-- Konten Baru di Sini -->
                        <h3>Kalender Siklus</h3>
                        <div class="calendar-container" data-start-date="{{ $data->start_date }}" data-end-date="{{ $data->end_date }}">
                            <div id="calendar" class="calendar"></div>
                        </div>
                        <div class="selected-dates-container">
                            <label><strong>Tanggal Siklus Anda</strong></label>
                            <div id="selected-dates-list">
                                <p>
                                    {{ \Carbon\Carbon::parse($data->start_date)->locale('id')->isoFormat('D MMM YYYY') }} &ndash;
                                    {{ \Carbon\Carbon::parse($data->end_date)->locale('id')->isoFormat('D MMM YYYY') }}
                                </p>
                                <span class="badge bg-{{ $data->feedback?->status === 'normal' ? 'success' : 'warning' }}">
                                    {{ $data->feedback?->status === 'normal' ? 'Normal' : 'Abnormal' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Kolom Kanan -->
                    <div class="col-6">
                        <div class="title-notes">
                            <h3>Catatan Kamu</h3>
                        </div>

                        <div class="notes">
                            <h4>Mood</h4>
                            <p>
                                <div class="mood-button">
                                    @if ($data->mood == "happy")
                                        <button value="happy" id="mood-1">😊</button>
                                    @elseif($data->mood == "neutral")
                                        <button value="not-happy" id="mood-2">😐</button>
                                    @elseif($data->mood == "tired")
                                        <button value="tired" id="mood-3">😞</button>
                                    @else
                                        <button value="sad" id="mood-4">😞</button>
                                    @endif
                                    <span>{{ $data->mood }}</span>
                                </div>
                            </p>
                            <hr>

                            <h4>Gejala</h4>
                            <div class="symptom-button">
                                @if($data->symptoms->count() > 0)
                                @foreach($data->symptoms as $symptom)
                                    <button type="button" class="symptom-{{ $symptom->name }}" data-symptom="{{ $symptom->name }}">
                                        @if ($symptom->name == 'painful')
                                            Nyeri
                                        @elseif ($symptom->name == 'cramps')
                                            Kram
                                        @elseif ($symptom->name == 'nausea')
                                            Mual
                                        @endif
                                    </button>
                                @endforeach
                                @else
                                    <button type="button" id="symptom-4">
                                        Tidak Ada Gejala
                                    </button>
                                @endif
                            </div>
                            <hr>

                            <h4>Catatan Lainnya:</h4>
                            <textarea readonly>{{ $data->notes }}</textarea>
                        </div>
                    </div>
                    <div class="tracker-buttons">
                        <button onclick="window.location.href='{{ route('cycle-record.show', $data->id) }}'">Detail Catatan</button>
                        <button class="btn-edit" onclick="window.location.href='{{ route('cycle-record.edit', $data->id) }}'">Edit Catatan</button>
                        <form id="delete-form" action="{{ route('cycle-record.destroy', $data->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn-remove" onclick="confirmDelete()">
                                <img src="{{ asset('assets/frontend/img/trash-solid.svg') }}" alt="Delete">
                            </button>
                        </form>

                    </div>
                </div>
            @endforeach

            <div id="remaining-records" style="display: none;">
                @foreach ($remainingDatas  as $data)
                    <div class="tracker additional-tracker" id="service">
                        <!-- Kolom Kiri -->
                        <div class="col-6">
                            <!-- Konten Baru di Sini -->
                            <h3>Kalender Siklus</h3>
                            <div class="calendar-container" data-start-date="{{ $data->start_date }}" data-end-date="{{ $data->end_date }}">
                                <div id="calendar" class="calendar"></div>
                            </div>
                            <div class="selected-dates-container">
                                <label><strong>Tanggal Siklus Anda</strong></label>
                                <div id="selected-dates-list">
                                    <p>
                                        {{ \Carbon\Carbon::parse($data->start_date)->locale('id')->isoFormat('D MMM YYYY') }} &ndash;
                                        {{ \Carbon\Carbon::parse($data->end_date)->locale('id')->isoFormat('D MMM YYYY') }}
                                    </p>
                                    <span class="badge bg-{{ $data->feedback?->status === 'normal' ? 'success' : 'warning' }}">
                                        {{ $data->feedback?->status === 'normal' ? 'Normal' : 'Abnormal' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Kolom Kanan -->
                        <div class="col-6">
                            <div class="title-notes">
                                <h3>Catatan Kamu</h3>
                            </div>

                            <div class="notes">
                                <h4>Mood</h4>
                                <p>
                                    <div class="mood-button">
                                        @if ($data->mood == "happy")
                                            <button value="happy" id="mood-1">😊</button>
                                        @elseif($data->mood == "neutral")
                                            <button value="not-happy" id="mood-2">😐</button>
                                        @elseif($data->mood == "tired")
                                            <button value="tired" id="mood-3">😞</button>
                                        @else
                                            <button value="sad" id="mood-4">😞</button>
                                        @endif
                                        <span>{{ $data->mood }}</span>
                                    </div>
                                </p>
                                <hr>

                                <h4>Gejala</h4>
                                <div class="symptom-button">
                                    @if($data->symptoms->count() > 0)
                                    @foreach($data->symptoms as $symptom)
                                        <button type="button" class="symptom-{{ $symptom->name }}" data-symptom="{{ $symptom->name }}">
                                            {{ ($symptom->name) }}
                                        </button>
                                    @endforeach
                                    @else
                                        <button type="button" id="symptom-4">
                                            Tidak Ada Gejala
                                        </button>
                                    @endif
                                </div>
                                <hr>

                                <h4>Catatan Lainnya:</h4>
                                <textarea readonly>{{ $data->notes }}</textarea>
                            </div>
                        </div>
                        <div class="tracker-buttons">
                            <button onclick="window.location.href='{{ route('cycle-record.show', $data->id) }}'">Detail Catatan</button>
                            <button class="btn-edit" onclick="window.location.href='{{ route('cycle-record.edit', $data->id) }}'">Edit Catatan</button>
                            <form action="{{ route('cycle-record.destroy', $data->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn-remove" onclick="window.location.href='{{ route('cycle-record.destroy', $data->id) }}'">
                                    <img src="{{ asset('assets/frontend/img/trash-solid.svg') }}" alt="">
                                </button>
                            </form>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
</section>
<div class="show-another">
    <button id="show-more">Tampilkan Catatan Lainnya</button>
    <button id="show-less">Lihat Lebih Sedikit</button>
</div>
@endsection

@section('js-section')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const showMoreButton = document.getElementById('show-more');
    const showLessButton = document.getElementById('show-less');
    const remainingRecords = document.getElementById('remaining-records');

    // Show more button click handler
    showMoreButton.addEventListener('click', function () {
        remainingRecords.style.display = 'block';
        showMoreButton.style.display = 'none';
        showLessButton.style.display = 'block';
    });

    // Show less button click handler
    showLessButton.addEventListener('click', function () {
        remainingRecords.style.display = 'none';
        showMoreButton.style.display = 'block';
        showLessButton.style.display = 'none';
    });
});
</script>

<script>
    function confirmDelete() {
        // SweetAlert Konfirmasi
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ed1c24',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit();
            }
        });
    }
</script>
@endsection
