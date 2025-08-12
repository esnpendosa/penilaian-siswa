<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penilaian Siswa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
            padding: 0 20px;
        }

        .logo h2 {
            color: white;
            font-size: 1.5em;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin: 5px 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            border-left-color: #00d4ff;
            transform: translateX(5px);
        }

        .nav-icon {
            margin-right: 10px;
            font-size: 1.2em;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .content-section {
            display: none;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            animation: fadeIn 0.5s ease-in-out;
        }

        .content-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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

        /* Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.1em;
            opacity: 0.9;
        }

        /* Forms */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
<body>
    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="logo">
                <h2><img src="img/LOGO-QUANTUM.png" alt="Logo Quantum" width="70"></h2>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#" class="nav-link active" data-section="home">
                        <span class="nav-icon">🏠</span>
                        Home
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Home Section -->
            <section id="home" class="content-section active">
                <h1 class="page-title">Dashboard Utama</h1>

                <div class="table-container">
                    <h3 style="padding: 20px; margin: 0; background: #f8f9fa; border-bottom: 1px solid #e0e0e0;">Aktivitas Terbaru</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Jenis</th>
                                <th>Keterangan</th>
                                <th>Poin</th>
                            </tr>
                        </thead>
                        <tbody id="recent-activities">
                            <tr>
                                <td>21/06/2025</td>
                                <td>Ahmad Rizki</td>
                                <td><span class="badge badge-success">Prestasi</span></td>
                                <td>Juara 1 Olimpiade Matematika</td>
                                <td><span class="point-display point-positive">+15</span></td>
                            </tr>
                            <tr>
                                <td>20/06/2025</td>
                                <td>Siti Aminah</td>
                                <td><span class="badge badge-danger">Pelanggaran</span></td>
                                <td>Terlambat masuk kelas</td>
                                <td><span class="point-display point-negative">-5</span></td>
                            </tr>
                            <tr>
                                <td>19/06/2025</td>
                                <td>Budi Santoso</td>
                                <td><span class="badge badge-success">Prestasi</span></td>
                                <td>Membantu teman yang kesulitan</td>
                                <td><span class="point-display point-positive">+8</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="form-grid">
                    <div>
                        <h3>Filter Laporan</h3>
                        <div class="form-group">
                            <label class="form-label">Periode</label>
                            <select class="form-select" id="periode-laporan">
                                <option value="bulan-ini">Bulan Ini</option>
                                <option value="semester">Semester</option>
                                <option value="tahun">Tahun Ajaran</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kelas</label>
                            <select class="form-select" id="kelas-laporan">
                                <option value="semua">Semua Kelas</option>
                                <option value="X-A">X-A</option>
                                <option value="X-B">X-B</option>
                                <option value="XI-A">XI-A</option>
                                <option value="XI-B">XI-B</option>
                            </select>
                        </div>
                        <button class="btn" onclick="generateLaporan()">Generate Laporan</button>
                        <button class="btn btn-success" onclick="exportLaporan()">Export Excel</button>
                    </div>
                </div>
                <div class="table-container">
                    <h3 style="padding: 20px; margin: 0; background: #f8f9fa; border-bottom: 1px solid #e0e0e0;">Ranking Siswa</h3>
                    <table class="table">
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
                            <tr>
                                <td>🥇 1</td>
                                <td>Ahmad Rizki</td>
                                <td>X-A</td>
                                <td><span class="point-display point-positive">+25</span></td>
                                <td>3</td>
                                <td>0</td>
                                <td><span class="badge badge-success">Terbaik</span></td>
                            </tr>
                            <tr>
                                <td>🥈 2</td>
                                <td>Budi Santoso</td>
                                <td>XI-A</td>
                                <td><span class="point-display point-positive">+18</span></td>
                                <td>2</td>
                                <td>0</td>
                                <td><span class="badge badge-success">Baik</span></td>
                            </tr>
                            <tr>
                                <td>🥉 3</td>
                                <td>Dewi Lestari</td>
                                <td>X-B</td>
                                <td><span class="point-display point-positive">+12</span></td>
                                <td>2</td>
                                <td>1</td>
                                <td><span class="badge badge-success">Baik</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

           
            <!-- Laporan Section -->
            <section id="laporan" class="content-section">
                
                <h1 class="page-title">Laporan</h1>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">85%</div>
                        <div class="stat-label">Siswa Berprestasi</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">15%</div>
                        <div class="stat-label">Siswa Bermasalah</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">142</div>
                        <div class="stat-label">Total Prestasi</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">38</div>
                        <div class="stat-label">Total Pelanggaran</div>
                    </div>
                </div>

                <div class="form-grid">
                    <div>
                        <h3>Filter Laporan</h3>
                        <div class="form-group">
                            <label class="form-label">Periode</label>
                            <select class="form-select" id="periode-laporan">
                                <option value="bulan-ini">Bulan Ini</option>
                                <option value="semester">Semester</option>
                                <option value="tahun">Tahun Ajaran</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kelas</label>
                            <select class="form-select" id="kelas-laporan">
                                <option value="semua">Semua Kelas</option>
                                <option value="X-A">X-A</option>
                                <option value="X-B">X-B</option>
                                <option value="XI-A">XI-A</option>
                                <option value="XI-B">XI-B</option>
                            </select>
                        </div>
                        <button class="btn" onclick="generateLaporan()">Generate Laporan</button>
                        <button class="btn btn-success" onclick="exportLaporan()">Export Excel</button>
                    </div>
                </div>

                <div class="table-container">
                    <h3 style="padding: 20px; margin: 0; background: #f8f9fa; border-bottom: 1px solid #e0e0e0;">Ranking Siswa</h3>
                    <table class="table">
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
                            <tr>
                                <td>🥇 1</td>
                                <td>Ahmad Rizki</td>
                                <td>X-A</td>
                                <td><span class="point-display point-positive">+25</span></td>
                                <td>3</td>
                                <td>0</td>
                                <td><span class="badge badge-success">Terbaik</span></td>
                            </tr>
                            <tr>
                                <td>🥈 2</td>
                                <td>Budi Santoso</td>
                                <td>XI-A</td>
                                <td><span class="point-display point-positive">+18</span></td>
                                <td>2</td>
                                <td>0</td>
                                <td><span class="badge badge-success">Baik</span></td>
                            </tr>
                            <tr>
                                <td>🥉 3</td>
                                <td>Dewi Lestari</td>
                                <td>X-B</td>
                                <td><span class="point-display point-positive">+12</span></td>
                                <td>2</td>
                                <td>1</td>
                                <td><span class="badge badge-success">Baik</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Data Storage
        let siswaData = [
            { nis: '2023001', nama: 'Ahmad Rizki', kelas: 'X-A', poin: 25, prestasi: 3, pelanggaran: 0 },
            { nis: '2023002', nama: 'Siti Aminah', kelas: 'X-B', poin: -5, prestasi: 0, pelanggaran: 1 },
            { nis: '2023003', nama: 'Budi Santoso', kelas: 'XI-A', poin: 18, prestasi: 2, pelanggaran: 0 }
        ];

        let penilaianData = [
            { id: 1, nis: '2023001', nama: 'Ahmad Rizki', jenis: 'prestasi', kategori: 'Akademik', keterangan: 'Juara 1 Olimpiade Matematika', poin: 15, tanggal: '2025-06-21' }
        ];

        const kategoriPrestasi = {
            'Akademik': 15,
            'Olahraga': 12,
            'Seni': 10,
            'Kepemimpinan': 8,
            'Sosial': 6
        };

        const kategoriPelanggaran = {
            'Terlambat': -5,
            'Tidak Mengerjakan Tugas': -8,
            'Gaduh di Kelas': -10,
            'Bolos': -15,
            'Merokok': -20
        };

        // Navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all links and sections
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
                
                // Show corresponding section
                const sectionId = this.getAttribute('data-section');
                document.getElementById(sectionId).classList.add('active');
            });
        });

        // Form handlers
        document.getElementById('form-siswa').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nama = document.getElementById('nama-siswa').value;
            const nis = document.getElementById('nis-siswa').value;
            const kelas = document.getElementById('kelas-siswa').value;
            
            // Add to data
            siswaData.push({
                nis: nis,
                nama: nama,
                kelas: kelas,
                poin: 0,
                prestasi: 0,
                pelanggaran: 0
            });
            
            // Update displays
            updateTabelSiswa();
            updateSelectSiswa();
            updateStats();
            
            // Reset form
            this.reset();
            alert('Siswa berhasil ditambahkan!');
        });

        // Kategori change handler
        document.getElementById('jenis-penilaian').addEventListener('change', function() {
            const jenis = this.value;
            const kategoriSelect = document.getElementById('kategori-penilaian');
            const poinInput = document.getElementById('poin-penilaian');
            
            kategoriSelect.innerHTML = '<option value="">Pilih Kategori</option>';
            
            if (jenis === 'prestasi') {
                Object.keys(kategoriPrestasi).forEach(kategori => {
                    kategoriSelect.innerHTML += `<option value="${kategori}">${kategori} (+${kategoriPrestasi[kategori]})</option>`;
                });
            } else if (jenis === 'pelanggaran') {
                Object.keys(kategoriPelanggaran).forEach(kategori => {
                    kategoriSelect.innerHTML += `<option value="${kategori}">${kategori} (${kategoriPelanggaran[kategori]})</option>`;
                });
            }
        });

        document.getElementById('kategori-penilaian').addEventListener('change', function() {
            const jenis = document.getElementById('jenis-penilaian').value;
            const kategori = this.value;
            const poinInput = document.getElementById('poin-penilaian');
            
            if (jenis === 'prestasi' && kategoriPrestasi[kategori]) {
                poinInput.value = kategoriPrestasi[kategori];
            } else if (jenis === 'pelanggaran' && kategoriPelanggaran[kategori]) {
                poinInput.value = kategoriPelanggaran[kategori];
            }
        });

        document.getElementById('form-penilaian').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nis = document.getElementById('pilih-siswa').value;
            const jenis = document.getElementById('jenis-penilaian').value;
            const kategori = document.getElementById('kategori-penilaian').value;
            const keterangan = document.getElementById('keterangan-penilaian').value;
            const poin = parseInt(document.getElementById('poin-penilaian').value);
            const tanggal = document.getElementById('tanggal-penilaian').value;
            
            const siswa = siswaData.find(s => s.nis === nis);
            if (!siswa) {
                alert('Siswa tidak ditemukan!');
                return;
            }
            
            // Add to penilaian data
            const newId = penilaianData.length + 1;
            penilaianData.push({
                id: newId,
                nis: nis,
                nama: siswa.nama,
                jenis: jenis,
                kategori: kategori,
                keterangan: keterangan,
                poin: poin,
                tanggal: tanggal
            });
            
            // Update siswa data
            siswa.poin += poin;
            if (jenis === 'prestasi') {
                siswa.prestasi += 1;
            } else {
                siswa.pelanggaran += 1;
            }
            
            // Update displays
            updateTabelPenilaian();
            updateTabelSiswa();
            updateStats();
            updateRecentActivities();
            
            // Reset form
            this.reset();
            alert('Penilaian berhasil disimpan!');
        });

        // Set default date to today
        document.getElementById('tanggal-penilaian').valueAsDate = new Date();

        // Update functions
        function updateTabelSiswa() {
            const tbody = document.getElementById('tabel-siswa');
            tbody.innerHTML = '';
            
            siswaData.forEach(siswa => {
                const status = siswa.poin >= 10 ? 'Baik' : siswa.poin >= 0 ? 'Cukup' : 'Perhatian';
                const statusClass = siswa.poin >= 10 ? 'badge-success' : siswa.poin >= 0 ? 'badge-warning' : 'badge-danger';
                const poinClass = siswa.poin > 0 ? 'point-positive' : siswa.poin < 0 ? 'point-negative' : 'point-neutral';
                const poinSign = siswa.poin > 0 ? '+' : '';
                
                tbody.innerHTML += `
                    <tr>
                        <td>${siswa.nis}</td>
                        <td>${siswa.nama}</td>
                        <td>${siswa.kelas}</td>
                        <td><span class="point-display ${poinClass}">${poinSign}${siswa.poin}</span></td>
                        <td><span class="badge ${statusClass}">${status}</span></td>
                        <td>
                            <button class="btn btn-success" onclick="editSiswa('${siswa.nis}')">Edit</button>
                            <button class="btn btn-danger" onclick="hapusSiswa('${siswa.nis}')">Hapus</button>
                        </td>
                    </tr>
                `;
            });
        }

        function updateSelectSiswa() {
            const select = document.getElementById('pilih-siswa');
            select.innerHTML = '<option value="">Pilih Siswa</option>';
            
            siswaData.forEach(siswa => {
                select.innerHTML += `<option value="${siswa.nis}">${siswa.nama} (${siswa.kelas})</option>`;
            });
        }

        function updateTabelPenilaian() {
            const tbody = document.getElementById('tabel-penilaian');
            tbody.innerHTML = '';
            
            penilaianData.slice().reverse().forEach(penilaian => {
                const jenisClass = penilaian.jenis === 'prestasi' ? 'badge-success' : 'badge-danger';
                const jenisText = penilaian.jenis === 'prestasi' ? 'Prestasi' : 'Pelanggaran';
                const poinClass = penilaian.poin > 0 ? 'point-positive' : 'point-negative';
                const poinSign = penilaian.poin > 0 ? '+' : '';
                const tanggalFormat = new Date(penilaian.tanggal).toLocaleDateString('id-ID');
                
                tbody.innerHTML += `
                    <tr>
                        <td>${tanggalFormat}</td>
                        <td>${penilaian.nama}</td>
                        <td><span class="badge ${jenisClass}">${jenisText}</span></td>
                        <td>${penilaian.kategori}</td>
                        <td>${penilaian.keterangan}</td>
                        <td><span class="point-display ${poinClass}">${poinSign}${penilaian.poin}</span></td>
                        <td>
                            <button class="btn btn-danger" onclick="hapusPenilaian(${penilaian.id})">Hapus</button>
                        </td>
                    </tr>
                `;
            });
        }

        function updateStats() {
            document.getElementById('total-siswa').textContent = siswaData.length;
            
            const prestasiCount = penilaianData.filter(p => p.jenis === 'prestasi').length;
            const pelanggaranCount = penilaianData.filter(p => p.jenis === 'pelanggaran').length;
            
            document.getElementById('prestasi-bulan').textContent = prestasiCount;
            document.getElementById('pelanggaran-bulan').textContent = pelanggaranCount;
            
            const totalPoin = siswaData.reduce((sum, s) => sum + s.poin, 0);
            const rataPoin = siswaData.length > 0 ? (totalPoin / siswaData.length).toFixed(1) : 0;
            document.getElementById('rata-poin').textContent = rataPoin > 0 ? `+${rataPoin}` : rataPoin;
        }

        function updateRecentActivities() {
            const tbody = document.getElementById('recent-activities');
            const recentData = penilaianData.slice(-5).reverse();
            
            tbody.innerHTML = '';
            recentData.forEach(activity => {
                const jenisClass = activity.jenis === 'prestasi' ? 'badge-success' : 'badge-danger';
                const jenisText = activity.jenis === 'prestasi' ? 'Prestasi' : 'Pelanggaran';
                const poinClass = activity.poin > 0 ? 'point-positive' : 'point-negative';
                const poinSign = activity.poin > 0 ? '+' : '';
                const tanggalFormat = new Date(activity.tanggal).toLocaleDateString('id-ID');
                
                tbody.innerHTML += `
                    <tr>
                        <td>${tanggalFormat}</td>
                        <td>${activity.nama}</td>
                        <td><span class="badge ${jenisClass}">${jenisText}</span></td>
                        <td>${activity.keterangan}</td>
                        <td><span class="point-display ${poinClass}">${poinSign}${activity.poin}</span></td>
                    </tr>
                `;
            });
        }

        function updateRanking() {
            const tbody = document.getElementById('tabel-ranking');
            const sortedSiswa = [...siswaData].sort((a, b) => b.poin - a.poin);
            
            tbody.innerHTML = '';
            sortedSiswa.forEach((siswa, index) => {
                const ranking = index + 1;
                const medal = ranking === 1 ? '🥇' : ranking === 2 ? '🥈' : ranking === 3 ? '🥉' : '';
                const status = siswa.poin >= 15 ? 'Terbaik' : siswa.poin >= 5 ? 'Baik' : siswa.poin >= 0 ? 'Cukup' : 'Perhatian';
                const statusClass = siswa.poin >= 15 ? 'badge-success' : siswa.poin >= 5 ? 'badge-success' : siswa.poin >= 0 ? 'badge-warning' : 'badge-danger';
                const poinClass = siswa.poin > 0 ? 'point-positive' : siswa.poin < 0 ? 'point-negative' : 'point-neutral';
                const poinSign = siswa.poin > 0 ? '+' : '';
                
                tbody.innerHTML += `
                    <tr>
                        <td>${medal} ${ranking}</td>
                        <td>${siswa.nama}</td>
                        <td>${siswa.kelas}</td>
                        <td><span class="point-display ${poinClass}">${poinSign}${siswa.poin}</span></td>
                        <td>${siswa.prestasi}</td>
                        <td>${siswa.pelanggaran}</td>
                        <td><span class="badge ${statusClass}">${status}</span></td>
                    </tr>
                `;
            });
        }

        // Action functions
        function editSiswa(nis) {
            const siswa = siswaData.find(s => s.nis === nis);
            if (siswa) {
                const newNama = prompt('Nama baru:', siswa.nama);
                const newKelas = prompt('Kelas baru:', siswa.kelas);
                
                if (newNama && newKelas) {
                    siswa.nama = newNama;
                    siswa.kelas = newKelas;
                    updateTabelSiswa();
                    updateSelectSiswa();
                    alert('Data siswa berhasil diperbarui!');
                }
            }
        }

        function hapusSiswa(nis) {
            if (confirm('Yakin ingin menghapus siswa ini?')) {
                const index = siswaData.findIndex(s => s.nis === nis);
                if (index !== -1) {
                    siswaData.splice(index, 1);
                    updateTabelSiswa();
                    updateSelectSiswa();
                    updateStats();
                    alert('Siswa berhasil dihapus!');
                }
            }
        }

        function hapusPenilaian(id) {
            if (confirm('Yakin ingin menghapus penilaian ini?')) {
                const penilaian = penilaianData.find(p => p.id === id);
                if (penilaian) {
                    const siswa = siswaData.find(s => s.nis === penilaian.nis);
                    if (siswa) {
                        siswa.poin -= penilaian.poin;
                        if (penilaian.jenis === 'prestasi') {
                            siswa.prestasi -= 1;
                        } else {
                            siswa.pelanggaran -= 1;
                        }
                    }
                    
                    const index = penilaianData.findIndex(p => p.id === id);
                    penilaianData.splice(index, 1);
                    
                    updateTabelPenilaian();
                    updateTabelSiswa();
                    updateStats();
                    updateRecentActivities();
                    alert('Penilaian berhasil dihapus!');
                }
            }
        }

        function generateLaporan() {
            updateRanking();
            alert('Laporan berhasil di-generate!');
        }

        function exportLaporan() {
            alert('Fitur export Excel akan segera tersedia!');
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateTabelSiswa();
            updateSelectSiswa();
            updateTabelPenilaian();
            updateStats();
            updateRecentActivities();
            updateRanking();
        });
    </script>
</body>
</html>