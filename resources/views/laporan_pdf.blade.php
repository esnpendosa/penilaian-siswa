<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ 'img/LOGO-QUANTUM.png' }}" type="image/x-icon">
    <title>Laporan Peringkat Siswa MA Quantum IDEA</title>
    <style>
        

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            /* padding: 20px; */
            overflow-y: auto;
        }

        .content-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            /* padding: 30px; */
            animation: fadeIn 0.5s ease-in-out;
        }

        .content-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media print {
            body, .container, .main-content {
                width: 100%;
                margin: 0;
                padding: 0;
                overflow: visible !important;
            }

            .table-container {
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            table {
                width: 100% !important;
                /* table-layout: fixed; */
                font-size: 12pt;
            }

            th, td {
                white-space: normal !important;
                overflow-wrap: break-word !important;
            }
            
        }

        .page-title {
            color: #333;
            margin-bottom: 30px;
            font-size: 2em;
            font-weight: 600;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        

        .btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-right: 10px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #fd7e14);
        }

        /* Tables */
        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        .table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .table tr:hover {
            background-color: #f8f9fa;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
        }

        .badge-success {
            background: #28a745;
            color: white;
        }

        .badge-danger {
            background: #dc3545;
            color: white;
        }

        .badge-warning {
            background: #ffc107;
            color: #333;
        }

        /* Point display */
        .point-display {
            font-size: 1.2em;
            font-weight: bold;
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-block;
        }

        .point-positive {
            background: #d4edda;
            color: #155724;
        }

        .point-negative {
            background: #f8d7da;
            color: #721c24;
        }

        .point-neutral {
            background: #fff3cd;
            color: #856404;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                order: 2;
            }
            
            .main-content {
                order: 1;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
        
    </style>
</head>
<body id="laporan">
    <div class="container" >
        <!-- Main Content -->
        <main class="main-content">
            <section  class="content-section">
                <h1 class="page-title">Laporan</h1>
                <div class="table-container" style="padding-left: 10px; padding-right: 10px;">
                    <h3 style=" margin: 0; background: #f8f9fa; border-bottom: 1px solid #e0e0e0;">Ranking Siswa</h3>
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
                                            $status = ['label' => 'Teladan', 'badge' => 'primary'];
                                        } elseif ($poin >= 50) {
                                            $status = ['label' => 'Baik', 'badge' => 'primary'];
                                        } elseif ($poin >= 20) {
                                            $status = ['label' => 'Cukup', 'badge' => 'primary'];
                                        } else {
                                            $status = ['label' => 'Perhatian', 'badge' => 'primary'];
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
        </main>
    </div>
   <!-- jsPDF library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

  <!-- html2pdf.js library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
  <script>
    window.onload = function() {
        setTimeout(() => {
            window.print();
        }, 1000); // tunda 0,5 detik
    };
    
  </script>
</body>
</html>