<x-layout title="Dashboard">
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">

    <style>
        #myTable {
            width: 100%;
            table-layout: fixed; /* Prevents column width from expanding */
        }

        .stats-grid {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            flex: 1;
            border-radius: 12px;
            padding: 24px 0 16px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            text-align: center;
            font-weight: 600;
        }

        .stat-card .stat-number {
            font-size: 2.2rem;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .stat-card .stat-label {
            font-size: 1.1rem;
            color: #555;
        }

        .stat-card.total-siswa {
            background: #e3f0ff;
            color: #1565c0;
        }

        .stat-card.prestasi {
            background: #e6f7ec;
            color: #218838;
        }

        .stat-card.pelanggaran {
            background: #ffeaea;
            color: #c62828;
        }

        .stat-card.rata-poin {
            background: #fff7e6;
            color: #ff9800;
        }
    </style>
    <section id="home" class="content-section active">
        <h1 class="page-title">Dashboard Utama</h1>

        @php $role = auth()->user()->role; @endphp

        <div class="stats-grid">
            @if($role !== 'siswa')
                <div class="stat-card total-siswa">
                    <div class="stat-number" id="total-siswa">{{ $jmlSiswa }}</div>
                    <div class="stat-label">Total Siswa</div>
                </div>
            @endif
            <div class="stat-card prestasi">
                <div class="stat-number" id="prestasi-bulan">{{ $jmlPrestasi }}</div>
                <div class="stat-label">Prestasi Bulan Ini</div>
            </div>
            <div class="stat-card pelanggaran">
                <div class="stat-number" id="pelanggaran-bulan">{{ $jmlMasalah }}</div>
                <div class="stat-label">Pelanggaran Bulan Ini</div>
            </div>
            <div class="stat-card rata-poin">
                <div class="stat-number" id="rata-poin">
                    {{ $rataPoin > 0 ? '+' . $rataPoin : $rataPoin }}
                </div>
                <div class="stat-label">Rata-rata Poin</div>
            </div>
        </div>


        <div class="table-container" style="padding-left: 10px; padding-right: 10px;">
            <h3 style="padding: 20px; margin: 0; background: #f8f9fa; border-bottom: 1px solid #e0e0e0;">Riwayat
                Penilaian</h3>
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
                            <td><span
                                    class="badge {{ $penilaian->jenis == 'prestasi' ? 'badge-success' : 'badge-danger'}}">{{ ucwords($penilaian->jenis) }}</span>
                            </td>
                            <td>{{ ucwords($penilaian->kategori) }}</td>
                            <td>{{ $penilaian->keterangan }}</td>
                            <td><span
                                    class="point-display point-{{ $penilaian->jenis == 'prestasi' ? 'positive' : 'negative'}}">{{ $penilaian->jenis == 'prestasi' ? '+'.$penilaian->poin : '-'.$penilaian->poin}}</span>
                            </td>
                            <td>
                                <button class="btn btn-danger" data-id="{{ $penilaian->id }}"
                                        onclick="hapusPenilaian(this)">Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let table = new DataTable('#myTable', {
            ordering: true,
            order: [[1, 'desc']],
            columnDefs: [
                {orderable: false, targets: [0, 3, 4, 5, 6, 7]}
            ]
        });

        function hapusPenilaian(hapus) {
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
