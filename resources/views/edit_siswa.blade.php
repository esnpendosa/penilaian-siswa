<x-layout>
    <section id="data-siswa" class="content-section">
        <h1 class="page-title">Edit Siswa</h1>
        
        <div class="form-grid">
            <div>
                <h3>Edit Data Siswa</h3>
                <form id="form-siswa" action="{{ route('siswa.update', ['id' => $dataSiswa->id]) }}" method="POST" style="margin-top: 15px">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-input" id="nama-siswa" name="nama" value="{{ $dataSiswa->nama }}">
                        @error('nama')
                            <small style="color: red;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">NIS</label>
                        <input type="text" maxlength="7" class="form-input" id="nis-siswa" name="nis" value="{{ substr($dataSiswa->nis, -7) }}">
                        @error('nis')
                            <small style="color: red;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kelas</label>
                        <select class="form-select" id="kelas-siswa" name="kelas">
                            <option value="">Pilih Kelas</option>
                            <option value="X" {{ $dataSiswa->kelas == 'X' ? 'selected' : '' }}>X</option>
                            <option value="XI" {{ $dataSiswa->kelas == 'XI' ? 'selected' : '' }}>XI</option>
                            <option value="XII" {{ $dataSiswa->kelas == 'XII' ? 'selected' : '' }}>XII</option>
                        </select>
                        @error('kelas')
                            <small style="color: red;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div style="margin-top: 20px;">
                        <a onclick="kembali()" class="btn">Kembali</a>
                        <button type="submit" class="btn">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        function kembali(){
            window.location.href = '/data_siswa';
        }
    </script>
</x-layout>