<x-layout title="Data Siswa">
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
    
    <style>
        #myTable {
            width: 100%;
            table-layout: fixed; /* Prevents column width from expanding */
        }

    </style>
    <section id="data-siswa" class="content-section">
        <h1 class="page-title">Data Siswa</h1>
        
        <div class="form-grid">
            <div>
                <h3>Tambah Siswa Baru</h3>
                <form id="form-siswa" action="{{ route('siswa.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-input" id="nama-siswa" name="nama" value="{{ old('nama') }}">
                        @error('nama')
                            <small style="color: red;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">NIS</label>
                        <input type="text" maxlength="7" class="form-input" id="nis-siswa" name="nis" value="{{ old('nis') }}">
                        @error('nis')
                            <small style="color: red;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kelas</label>
                        <select class="form-select" id="kelas-siswa" name="kelas">
                            <option value="">Pilih Kelas</option>
                            <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>X</option>
                            <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>XI</option>
                            <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>XII</option>
                        </select>
                        @error('kelas')
                            <small style="color: red;">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn">Tambah Siswa</button>
                </form>

            </div>
        </div>

        <div class="table-container" style="padding-left: 10px; padding-right: 10px;">
            <h3 style="padding: 20px; margin: 0; background: #f8f9fa; border-bottom: 1px solid #e0e0e0;">Daftar Siswa</h3>
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="text-align: left;">NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-siswa">
                    @foreach ($dataSiswa as $nomor => $data)
                    @php $nomor += 1; @endphp
                    <tr>
                        <td>{{ $nomor }}</td>
                        <td style="text-align: left;">{{ $data->full_nis }}</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->kelas }}</td>
                        <td>
                            <button class="btn btn-success" data-id="{{ $data->id }}" onclick="editSiswa(this)">Edit</button>
                            <button class="btn btn-danger" data-id="{{ $data->id }}" data-nama="{{ $data->nama }}" onclick="hapusSiswa(this)">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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

    function hapusSiswa(hapus){
        let data = hapus.getAttribute('data-id');
        let nama = hapus.getAttribute('data-nama');
        Swal.fire({
            title: "Apakah Anda Yakin?",
            text: nama + " akan dihapus dari sistem!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                 window.location.href = '/siswa_delete/' + data;
            }
        });
       
    }

    function editSiswa(edit){
        const id = edit.getAttribute('data-id');
        window.location.href = '/siswa_edit-' + id;
    }
</script>
</x-layout>