<x-layout title="Penilaian">
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
    
    <style>
        #myTable {
            width: 100%;
            table-layout: fixed; /* Prevents column width from expanding */
        }

    </style>
<section id="penilaian" class="content-section">
    <h1 class="page-title">Input Penilaian</h1>
    
    <div class="form-grid">
        <div>
            <h3 style="margin-bottom: 15px">Input Prestasi/Pelanggaran</h3>

            <form id="form-penilaian" action="{{ route('penilaian.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Pilih Siswa</label>
                    <select class="form-select" name="nama_siswa" id="pilih-siswa">
                        <option value="">Pilih Siswa</option>
                        @foreach ($dataSiswa as $data)
                            <option value="{{ $data->id }}" {{ old('nama_siswa') == $data->id ? 'selected' : '' }}>
                                {{ $data->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('nama_siswa')
                        <small style="color: red;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis</label>
                    <select class="form-select" name="jenis" id="jenis-penilaian">
                        <option value="">Pilih Jenis</option>
                        <option value="prestasi" {{ old('jenis') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                        <option value="pelanggaran" {{ old('jenis') == 'pelanggaran' ? 'selected' : '' }}>Pelanggaran</option>
                    </select>
                    @error('jenis')
                        <small style="color: red;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" name="kategori" id="kategori-penilaian">
                        <option value="">Pilih Kategori</option>
                    </select>
                    @error('kategori')
                        <small style="color: red;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-input" id="keterangan-penilaian" value="{{ old('keterangan') }}">
                    @error('keterangan')
                        <small style="color: red;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Poin</label>
                    <input type="number" name="poin" class="form-input" id="poin-penilaian" value="{{ old('poin') }}">
                    @error('poin')
                        <small style="color: red;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-input" id="tanggal-penilaian" value="{{ old('tanggal') }}">
                    @error('tanggal')
                        <small style="color: red;">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn">Simpan Penilaian</button>
            </form>

        </div>
    </div>

    <div class="table-container" style="padding-left: 10px; padding-right: 10px;">
        <h3 style="padding: 20px; margin: 0; background: #f8f9fa; border-bottom: 1px solid #e0e0e0;">Riwayat Penilaian</h3>
        <div style="overflow-x: auto;">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="white-space: nowrap;">Tanggal</th>
                        <th>Siswa</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th>Poin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-penilaian">
                    @foreach ($penilaianSiswa as $nomor => $penilaian)
                        @php
                            $nomor += 1;
                        @endphp
                    <tr>
                        <td>{{ $nomor }}</td>
                        <td style="white-space: nowrap;">{{ $penilaian->tanggal }}</td>
                        <td>{{ $penilaian->nama_siswa }}</td>
                        <td><span class="badge {{ $penilaian->jenis == 'prestasi' ? 'badge-success' : 'badge-danger'}}">{{ ucwords($penilaian->jenis) }}</span></td>
                        <td>{{ ucwords($penilaian->kategori) }}</td>
                        <td>{{ $penilaian->keterangan }}</td>
                        <td><span class="point-display point-{{ $penilaian->jenis == 'prestasi' ? 'positive' : 'negative'}}">{{ $penilaian->jenis == 'prestasi' ? '+'.$penilaian->poin : '-'.$penilaian->poin}}</span></td>
                        <td>
                            <button class="btn btn-danger" data-id="{{ $penilaian->id }}" onclick="hapusPenilaian(this)">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</section>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
    <script>
        Swal.fire({
            title: "Berhasil!",
            text: `{{ session('success') }}`,
            icon: "success"
        });
    </script>
@endif
<script>
    let table = new DataTable('#myTable', {
        ordering: false  
    });
    


    // Mendapatkan tanggal hari ini
    const today = new Date();

    // Formatkan tanggal ke format YYYY-MM-DD
    const formatDate = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    // Set nilai max pada input tanggal ke hari ini
    document.getElementById('tanggal-penilaian').setAttribute('max', formatDate(today));

    // Fungsi untuk mengubah kategori berdasarkan jenis yang dipilih
    function updateKategori() {
        const jenisSelect = document.getElementById('jenis-penilaian');
        const kategoriSelect = document.getElementById('kategori-penilaian');
        const selectedJenis = jenisSelect.value;
        
        // Reset kategori dropdown
        kategoriSelect.innerHTML = '<option value="">Pilih Kategori</option>';
        
        if (selectedJenis === 'prestasi') {
            // Kategori untuk prestasi
            const prestasiOptions = [
                { value: 'akademik', text: 'Akademik' },
                { value: 'nonakademik', text: 'Nonakademik' }
            ];
            
            prestasiOptions.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option.value;
                optionElement.textContent = option.text;
                if ('{{ old("kategori") }}' === option.value) {
                    optionElement.selected = true;
                }
                kategoriSelect.appendChild(optionElement);
            });
        } else if (selectedJenis === 'pelanggaran') {
            // Kategori untuk pelanggaran
            const pelanggaranOptions = [
                { value: 'ringan', text: 'Ringan' },
                { value: 'sedang', text: 'Sedang' },
                { value: 'berat', text: 'Berat' }
            ];
            
            pelanggaranOptions.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option.value;
                optionElement.textContent = option.text;
                if ('{{ old("kategori") }}' === option.value) {
                    optionElement.selected = true;
                }
                kategoriSelect.appendChild(optionElement);
            });
        }
    }

    // Event listener untuk perubahan jenis
    document.getElementById('jenis-penilaian').addEventListener('change', updateKategori);
    
    // Inisialisasi kategori saat halaman dimuat
    updateKategori();

    function hapusPenilaian(hapus){
        let id = hapus.getAttribute('data-id');
        Swal.fire({
            title: "Apakah Anda Yakin?",
            text: "Penilaian ini akan dihapus dari sistem!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                 window.location.href = '/penilaian_delete/' + id;
            }
        });

    }
</script>
</x-layout>