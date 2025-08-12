<x-layout title="Laporan">
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
    <style>
        #myTable {
            width: 100%;
            table-layout: fixed; /* Prevents column width from expanding */
            
        }

        .badge-primary {
            background-color: #0056b3 !important; /* Biru gelap */
            color: #ffffff !important;
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
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
        .stat-card.berprestasi {
            background: #e3f0ff;
            color: #1565c0;
        }
        .stat-card.bermasalah {
            background: #ffeaea;
            color: #c62828;
        }
        .stat-card.total-prestasi {
            background: #e6f7ec;
            color: #218838;
        }
        .stat-card.total-pelanggaran {
            background: #fff7e6;
            color: #ff9800;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            .content-section, .content-section * {
                visibility: visible;
            }
            .content-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100vw;
                background: #fff !important;
                box-shadow: none !important;
            }
            .stats-grid {
                page-break-inside: avoid;
            }
            .table-container, .table {
                page-break-inside: avoid;
            }
            .stat-card {
                box-shadow: none !important;
            }
            nav, header, footer, .no-print {
                display: none !important;
            }
        }
        @media (max-width: 768px) {
            .stats-grid {
                flex-direction: column;
                gap: 12px;
            }
            .stat-card {
                font-size: 0.95rem;
                padding: 16px 0 10px 0;
            }
            .table-container {
                overflow-x: auto;
            }
            .table {
                font-size: 13px;
                min-width: 600px;
            }
            .no-print[style] {
                float: none !important;
                width: 100%;
                margin-bottom: 12px !important;
            }
        }
    </style>
    <section id="laporan" class="content-section">
        <button class="no-print" onclick="printLaporanPDF()" style="margin-bottom: 18px; padding: 8px 20px; background: #1565c0; color: #fff; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; float: right;">
            🖨️ Print
        </button>
        <h1 class="page-title">Laporan</h1>
        
        <div class="stats-grid">
            <div class="stat-card berprestasi">
                <div class="stat-number">
                    {{ fmod($presentasePrestasi, 1) == 0 ? intval($presentasePrestasi) : number_format($presentasePrestasi, 2) }}%
                </div>
                <div class="stat-label">Siswa Berprestasi</div>
            </div>
            <div class="stat-card bermasalah">
                <div class="stat-number">
                    {{ fmod($presentaseMasalah, 1) == 0 ? intval($presentaseMasalah) : number_format($presentaseMasalah, 2) }}%
                </div>
                <div class="stat-label">Siswa Bermasalah</div>
            </div>
            <div class="stat-card total-prestasi">
                <div class="stat-number">{{ $jmlPrestasi }}</div>
                <div class="stat-label">Total Prestasi</div>
            </div>
            <div class="stat-card total-pelanggaran">
                <div class="stat-number">{{ $jmlMasalah }}</div>
                <div class="stat-label">Total Pelanggaran</div>
            </div>
        </div>

        <div class="table-container" style="padding-left: 10px; padding-right: 10px; padding-top: 20px;">
            <div class="no-print" style="margin-bottom: 12px;">
                <label for="filter-kelas" style="font-weight: 500; margin-right: 8px;">Pilih Kelas:</label>
                <select id="filter-kelas" style="padding: 4px 12px; border-radius: 5px; border: 1px solid #bbb;">
                    <option value="" {{ empty($kelasFilter) ? 'selected' : '' }}>Semua</option>
                    <option value="X" {{ (isset($kelasFilter) && $kelasFilter == 'X') ? 'selected' : '' }}>X</option>
                    <option value="XI" {{ (isset($kelasFilter) && $kelasFilter == 'XI') ? 'selected' : '' }}>XI</option>
                    <option value="XII" {{ (isset($kelasFilter) && $kelasFilter == 'XII') ? 'selected' : '' }}>XII</option>
                </select>
            </div>
            <h3 style="padding: 20px; margin: 0; background: #f8f9fa; border-bottom: 1px solid #e0e0e0;">Ranking Siswa</h3>
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th>Ranking</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Total Poin</th>
                        <th>Prestasi</th>
                        <th>Pelanggaran</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="tabel-ranking">
                    @foreach ($dataSiswa as $rank => $data)
                        @php
                            $rank += 1;
                        @endphp
                    <tr>
                        <td>
                            @if ($rank == 1)
                                🥇 {{ $rank }}
                            @elseif ($rank == 2)
                                🥈 {{ $rank }}
                            @elseif ($rank == 3)
                                🥉 {{ $rank }}
                            @else
                                
                            @endif
                        </td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->kelas }}</td>
                        <td><span class="point-display point-{{ $data->total_poin >= 0 ? 'positive' : 'negative' }}">{{ $data->total_poin }}</span></td>
                        <td>{{ $data->total_prestasi }}</td>
                        <td>{{ $data->total_pelanggaran }}</td>
                        <td>
                            @php
                                $poin = $data->total_poin;
                                if ($poin >= 80) {
                                    $status = ['label' => 'Teladan', 'badge' => 'success'];
                                } elseif ($poin >= 50) {
                                    $status = ['label' => 'Baik', 'badge' => 'primary'];
                                } elseif ($poin >= 20) {
                                    $status = ['label' => 'Cukup', 'badge' => 'warning'];
                                } else {
                                    $status = ['label' => 'Perhatian', 'badge' => 'danger'];
                                }
                            @endphp

                            <span class="badge badge-{{ $status['badge'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script>

        function printLaporanPDF() {
            let url = '/laporan_pdf';
            const kelas = document.getElementById('filter-kelas').value;
            if (kelas) {
                url += '?kelas=' + encodeURIComponent(kelas);
            }
            const win = window.open(url, '_blank');
            if (win) {
                win.onload = function() {
                    win.print();
                };
            }
        }
        let table = new DataTable('#myTable', {
            ordering: false  
        });
        // Filter kelas: reload page with query param
        document.getElementById('filter-kelas').addEventListener('change', function() {
            const val = this.value;
            const url = new URL(window.location.href);
            if (val) {
                url.searchParams.set('kelas', val);
            } else {
                url.searchParams.delete('kelas');
            }
            window.location.href = url.toString();
        });
    </script>
</x-layout>