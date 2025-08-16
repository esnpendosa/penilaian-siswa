<x-layout title="Data Siswa">
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">

    <style>
        #myTable {
            width: 100%;
            table-layout: fixed; /* Prevents column width from expanding */
        }

    </style>
    <section id="data-siswa" class="content-section">
        <h1 class="page-title">Data Pengguna</h1>

        <div class="form-grid">
            <div>
                <h3>Tambah Pengguna</h3>
                <form id="form-siswa" action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-input" name="name" value="{{ old('name') }}">
                        @error('name')
                        <small style="color: red;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Pengguna</label>
                        <input type="text" class="form-input" name="username" value="{{ old('username') }}">
                        @error('username')
                        <small style="color: red;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-input" name="email" value="{{ old('email') }}">
                        @error('email')
                        <small style="color: red;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-input" name="password" value="{{ old('password') }}">
                        @error('password')
                        <small style="color: red;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role">
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="guru_bk" {{ old('role') == 'guru_bk' ? 'selected' : '' }}>Guru BK</option>
                            <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="kepsek" {{ old('role') == 'kepsek' ? 'selected' : '' }}>Kepala Sekolah
                            </option>
                            {{--                            <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>--}}
                        </select>
                        @error('role')
                        <small style="color: red;">{{ $message }}</small>
                        @enderror
                    </div>


                    <button type="submit" class="btn">Tambah Pengguna</button>
                </form>

            </div>
        </div>

        <div class="table-container" style="padding-left: 10px; padding-right: 10px;">
            <h3 style="padding: 20px; margin: 0; background: #f8f9fa; border-bottom: 1px solid #e0e0e0;">Daftar
                Pengguna</h3>
            <table class="table" id="myTable">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody id="tabel-siswa">
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            <button class="btn btn-success" data-id="{{ $user->id }}" onclick="editSiswa(this)">Edit
                            </button>
                            @if(auth()->user()->role == "admin")
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                      onsubmit="return hapusSiswa(this)" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
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

        function hapusSiswa(form) {
            event.preventDefault();
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "pengguna akan dihapus dari sistem!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }

        function editSiswa(edit) {
            const id = edit.getAttribute('data-id');
            window.location.href = '/users/' + id + '/edit';
        }
    </script>
</x-layout>
