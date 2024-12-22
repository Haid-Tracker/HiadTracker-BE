@extends('frontend.layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/frontend/style/Notes/style-note.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/frontend/style/Notes/responsive.css') }}" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js'></script>
@endsection

@section('content')
<!-- section 1 -->
<section>
    <div class="container">
        <h2>Pilih Tanggal Terakhir Kamu Haid</h2>

        <form action="{{ route('cycle-record.store') }}" method="POST">
            @csrf
            <input type="hidden" name="start_date" id="start_date" value="{{ old('start_date') }}">
            <input type="hidden" name="end_date" id="end_date" value="{{ old('end_date') }}">

            <div class="tracker" id="service">
                <!-- Kolom Kiri -->
                <div class="col-6">
                    <h3>Kalender Siklus</h3>
                    <div class="calendar">
                        <div id="calendar"></div>
                    </div>
                    <div class="selected-dates-container">
                        <label>Tanggal Siklus Anda</label>
                        <div id="selected-dates-list"></div>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-6">
                    <div class="title-notes">
                        <h3>Catatan Kamu</h3>
                    </div>

                    <div class="notes">
                        <h4>Mood</h4>
                        <p>Bagaimana Perasaanmu?</p>
                        <hr>
                        <div class="mood-buttons">
                            <label for="mood-1" class="mood-option">
                                <input type="radio" name="mood" value="happy" id="mood-1" class="mood-radio" {{ old('mood') == 'happy' ? 'checked' : '' }}>
                                <span class="mood-button" data-value="Happy">😊</span>
                            </label>
                            <label for="mood-2" class="mood-option">
                                <input type="radio" name="mood" value="neutral" id="mood-2" class="mood-radio" {{ old('mood') == 'neutral' ? 'checked' : '' }}>
                                <span class="mood-button" data-value="Neutral">😐</span>
                            </label>
                            <label for="mood-3" class="mood-option">
                                <input type="radio" name="mood" value="sad" id="mood-3" class="mood-radio" {{ old('mood') == 'sad' ? 'checked' : '' }}>
                                <span class="mood-button" data-value="Sad">😞</span>
                            </label>
                            <label for="mood-4" class="mood-option">
                                <input type="radio" name="mood" value="tired" id="mood-4" class="mood-radio" {{ old('mood') == 'tired' ? 'checked' : '' }}>
                                <span class="mood-button" data-value="Tired">😴</span>
                            </label>
                        </div>

                        <h4>Volume Darah</h4>
                        <p>Dalam Durasi Satu Jam, Berapa Kali Anda Mengganti Pembalut?

                        <hr>
                        <div class="pad-change-history">
                            <label for="pad-change-1" class="pad-change-option">
                                <input type="radio" name="blood_volume" value="normal" id="pad-change-1"
                                    class="pad-change-radio" {{ old('blood_volume') == 'normal' ? 'checked' : '' }}>
                                <span class="pad-change-button">Normal (kurang dari atau max 1 kali)</span>
                            </label>
                            <label for="pad-change-2" class="pad-change-option">
                                <input type="radio" name="blood_volume" value="heavy" id="pad-change-2"
                                    class="pad-change-radio" {{ old('blood_volume') == 'heavy' ? 'checked' : '' }}>
                                <span class="pad-change-button">Berat (lebih dari 1 kali)</span>
                            </label>
                        </div>

                        <h4>Gejala</h4>
                        <p>Apa yang kamu rasakan selama haid?</p>
                        <hr>
                        <div class="symptom-buttons">
                            @foreach($symptoms as $symptom)
                            <label for="symptom-{{ $symptom->id }}" class="symptom-option">
                                <input type="checkbox" name="symptoms[]" value="{{ $symptom->id }}"
                                    id="symptom-{{ $symptom->id }}" class="symptom-checkbox"
                                    {{ in_array($symptom->id, old('symptoms', [])) ? 'checked' : '' }}>
                                <span class="symptom-button">
                                    @if ($symptom->name == 'painful')
                                        Nyeri
                                    @elseif ($symptom->name == 'cramps')
                                        Kram
                                    @elseif ($symptom->name == 'nausea')
                                        Mual
                                    @endif
                                </span>
                            </label>
                            @endforeach
                        </div>

                        <h4>Kondisi Siklus</h4>
                        <p>Bagaimana Riwayat Siklus Menstruasi Anda Selama ini?</p>
                        <hr>
                        <div class="cycle-history">
                            <label for="cycle-1" class="cycle-option">
                                <input type="radio" name="cycle_regularity" value="1" id="cycle-1"
                                    class="cycle-radio" {{ old('cycle_regularity') == '1' ? 'checked' : '' }}>
                                <span class="cycle-button">Siklus Saya Teratur</span>
                            </label>
                            <label for="cycle-2" class="cycle-option">
                                <input type="radio" name="cycle_regularity" value="0" id="cycle-2"
                                    class="cycle-radio" {{ old('cycle_regularity') == '0' ? 'checked' : '' }}>
                                <span class="cycle-button">Siklus Saya Tidak Teratur</span>
                            </label>
                        </div>

                        <h4>Penggunaan Obat</h4>
                        <p>Apakah Anda Sedang Mengonsumsi Obat Saat ini?</p>
                        <hr>
                        <div class="medication-history">
                            <label for="medication-1" class="medication-option">
                                <input type="radio" name="medication" value="1" id="medication-1"
                                    class="medication-radio" {{ old('medication') == '1' ? 'checked' : '' }}>
                                <span class="medication-button">Ya</span>
                            </label>
                            <label for="medication-2" class="medication-option">
                                <input type="radio" name="medication" value="0" id="medication-2"
                                    class="medication-radio" {{ old('medication') == '0' ? 'checked' : '' }}>
                                <span class="medication-button">Tidak</span>
                            </label>
                        </div>

                        <h4>Catatan Lainnya:</h4>
                        <textarea name="notes" placeholder="Masukkan catatan..."
                            class="custom-textarea">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="tracker-buttons">
                    <button type="submit">Simpan Catatan</button>
                    <a href="{{ route('cycle-record.index') }}" class="btn">Riwayat Catatan</a>
                </div>
            </div>
        </form>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="banners-container">
            <div class="banners">
                <div class="banner error visible">
                    <div class="banner-icon">
                        <i data-eva="alert-circle-outline" data-eva-fill="#fff" data-eva-height="48" data-eva-width="48"></i>
                    </div>
                    <div class="banner-message">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    <div class="banner-close" onclick="hideBanners()">
                        <i data-eva="close-outline" data-eva-fill="#ffffff"></i>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- section 2 -->
<section class="article">
    <div class="container-article">
        <div class="section-prediction">
            <!-- Kolom Kiri -->
            <div class="col-6">
                <!-- Konten Baru di Sini -->
                <div class="predction-cycle">
                    <h3>Hasil Prediksi Periode Selanjutnya</h3>
                    <div class="card">
                        {{-- <div class="card-date">
                            <p class="card-date-title">Tanggal</p>
                            <p class="card-date-subtitle">Periode Selanjutnya</p>
                            <p class="card-date-number">12-25</p>
                            <p class="card-date-month">Juli, 2024</p>
                        </div> --}}
                        {{-- @dd($prediction) --}}
                        <div class="card-date">
                            <p class="card-date-title">Tanggal</p>
                            <p class="card-date-subtitle">Periode Selanjutnya</p>
                            @if($prediction['dates'])
                                <p class="card-date-number">{{ $prediction['dates'] }}</p>
                                <p class="card-date-month">{{ $prediction['month_year'] }}</p>
                            @else
                                <p class="card-date-number">-</p>
                                <p class="card-date-month">Belum ada catatan haid</p>
                            @endif
                        </div>
                        <div class="card-content">
                            <h4>Kondisi Kamu</h4>
                            @if($prediction['feedback'])
                                <p>{!! nl2br(e($prediction['feedback'])) !!}</p>
                            @else
                                <p>
                                    Belum ada catatan kondisi untuk ditampilkan. Silakan input data siklus terlebih dahulu.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-6">
                {{-- @if($article)
                <div class="article-item">
                    <h4>{{ $article->title }}</h4>
                    <div class="article-content">
                        {{ Str::limit($article->content, 200) }}
                    </div>
                </div>
                @else
                    <p>Belum ada artikel rekomendasi.</p>
                @endif --}}

                @if($article)
                <div class="title-artikel">
                    <h3>{{ $article->title }}</h3>
                    <div class="artikel-recomendation">
                        {{ Str::limit($article->content, 250) }}
                    </div>
                    <a href="{{ route('article.show', $article->id) }}">
                        <button>Baca Artikel</button>
                    </a>
                </div>
                @else
                    <p>Belum ada artikel rekomendasi.</p>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- end section 2 -->
@endsection

@section('js-section')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectedDates = [];
    const selectedDatesList = document.getElementById('selected-dates-list');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        dateClick: handleDateClick,
        handleWindowResize: true,
        expandRows: true
    });

    calendar.render();

    // Fungsi saat tanggal diklik
    function handleDateClick(info) {
        const clickedDate = info.dateStr;

        if (selectedDates.length >= 2 && !selectedDates.includes(clickedDate)) {
            alert('Anda hanya diperkenankan memilih maksimal dua tanggal siklus.');
            return;
        }

        if (selectedDates.includes(clickedDate)) {
            removeDate(clickedDate);
        } else {
            selectedDates.push(clickedDate);
            // Sort dates to ensure start_date is always the earlier date
            selectedDates.sort();
        }

        updateSelectedDatesDisplay();
        updateCalendarHighlight();
        updateHiddenInputs();
    }

    // Update hidden inputs for form submission
    function updateHiddenInputs() {
        if (selectedDates.length > 0) {
            startDateInput.value = selectedDates[0];
        }
        if (selectedDates.length > 1) {
            endDateInput.value = selectedDates[1];
        }
    }

    // Update tampilan daftar tanggal
    function updateSelectedDatesDisplay() {
        selectedDatesList.innerHTML = "";

        selectedDates.forEach((date, index) => {
            const dateItem = document.createElement('div');
            dateItem.classList.add('selected-date-item');
            dateItem.innerHTML = `
                ${index === 0 ? 'Tanggal Mulai: ' : 'Tanggal Selesai: '} ${formatDate(date)}
                <button type="button" onclick="removeDateHandler('${date}')">✖</button>
            `;
            selectedDatesList.appendChild(dateItem);
        });
    }

    // Format tanggal ke format DD/MM/YYYY
    function formatDate(dateStr) {
        const date = new Date(dateStr);
        return `${String(date.getDate()).padStart(2, '0')}/${String(date.getMonth() + 1).padStart(2, '0')}/${date.getFullYear()}`;
    }

    // Hapus tanggal dari daftar
    window.removeDateHandler = function(date) {
        removeDate(date);
        updateSelectedDatesDisplay();
        updateCalendarHighlight();
        updateHiddenInputs();
    };

    function removeDate(date) {
        const index = selectedDates.indexOf(date);
        if (index > -1) {
            selectedDates.splice(index, 1);
        }
    }

    // Highlight tanggal di kalender
    function updateCalendarHighlight() {
        calendar.getEvents().forEach(event => event.remove());
        selectedDates.forEach(date => {
            calendar.addEvent({
                start: date,
                allDay: true,
                display: 'background',
                color: '#ff9f89'
            });
        });
    }
});
</script>
@endsection
