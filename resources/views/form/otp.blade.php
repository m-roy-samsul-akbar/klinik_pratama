@extends('layouts.verifikasi')

@section('title', 'Notifikasi WhatsApp')
@section('header', 'DAFTAR NOTIFIKASI WHATSAPP')

@section('content')
    <div class="progress-bar">
        <div class="progress-step">1</div>
        <div class="progress-line"></div>
        <div class="progress-step active">2</div>
        <div class="progress-line"></div>
        <div class="progress-step">3</div>
        <div class="progress-line"></div>
        <div class="progress-step">4</div>
    </div>

    <div class="form-section">
        <h3>MASUKKAN NOMOR WHATSAPP</h3>
        <p class="text-muted" style="margin-bottom:1rem">Nomor ini akan digunakan untuk mengirim <strong>notifikasi kode antrian</strong> Anda.</p>

        <form method="POST" action="" novalidate>
            @csrf

            {{-- Jika Anda membawa konteks pasien / verifikasi, bisa disisipkan di sini --}}
            @isset($verifikasi_id)
                <input type="hidden" name="verifikasi_id" value="{{ $verifikasi_id }}">
            @endisset
            @isset($kode_antrian)
                <input type="hidden" name="kode_antrian" value="{{ $kode_antrian }}">
            @endisset

            <div class="form-group @error('whatsapp') has-error @enderror">
                <label for="whatsapp">Nomor WhatsApp <small>(format Indonesia)</small></label>
                <input
                    id="whatsapp"
                    type="tel"
                    name="whatsapp"
                    inputmode="tel"
                    autocomplete="tel"
                    placeholder="contoh: 0812xxxxxxx atau +62812xxxxxxx"
                    value="{{ old('whatsapp') }}"
                    required
                    class="form-control"
                />
                <small id="whatsappHelp" class="text-muted">Gunakan awalan <strong>+62</strong> atau <strong>0</strong> (misal: +62812… atau 0812…).</small>
                @error('whatsapp')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="checkbox-group @error('consent') has-error @enderror" style="margin-top:1rem">
                <input type="checkbox" id="consent" name="consent" value="1" {{ old('consent') ? 'checked' : '' }} />
                <label for="consent">Saya menyetujui menerima pesan WhatsApp terkait status pendaftaran dan kode antrian.</label>
                @error('consent')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group" style="margin-top:1.25rem">
                <a href="{{ url()->previous() }}" class="btn-back">Batal</a>
                <button type="submit" class="btn-next">Simpan & Lanjutkan</button>
            </div>
        </form>

        <hr style="margin:1.25rem 0" />
        <p class="text-muted" style="font-size:0.9rem">Dengan menekan <em>Simpan & Lanjutkan</em>, sistem akan menyimpan nomor WhatsApp Anda dalam format internasional (+62) untuk keperluan notifikasi.</p>
    </div>
@endsection

@push('scripts')
<script>
(function() {
    const input = document.getElementById('whatsapp');
    const normalize = (raw) => {
        // Hapus semua non-digit kecuali tanda + di depan
        raw = raw.replace(/\s+/g, '');
        if (raw.startsWith('+')) {
            return '+' + raw.slice(1).replace(/\D/g, '');
        }
        return raw.replace(/\D/g, '');
    };

    const toE164ID = (val) => {
        // Aturan sederhana: jika mulai dengan 0, ganti jadi +62
        // jika sudah +62 biarkan, jika mulai 62 tanpa +, tambahkan +
        let v = normalize(val);
        if (!v) return '';
        if (v.startsWith('+62')) return '+62' + v.slice(3);
        if (v.startsWith('62')) return '+62' + v.slice(2);
        if (v.startsWith('0')) return '+62' + v.slice(1);
        // Jika user mengetik + diikuti negara lain, biarkan apa adanya
        if (v.startsWith('+')) return v;
        // Default: anggap Indonesia
        return '+62' + v;
    };

    // Auto-normalize saat blur
    input && input.addEventListener('blur', function() {
        const e164 = toE164ID(this.value);
        this.value = e164;
    });
})();
</script>
@endpush
