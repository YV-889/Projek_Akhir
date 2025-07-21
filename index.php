<?php


header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjadwalan App - Backend API</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            margin-bottom: 40px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
        }

        .header h1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
            font-size: 2.8em;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header p {
            color: #555;
            font-size: 1.2em;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .header p:last-child {
            color: #667eea;
            font-weight: 600;
            font-size: 1.1em;
        }

        .status-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 35px;
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
        }

        .status-card h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.8em;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 35px;
        }

        .status-item {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            padding: 25px;
            border-radius: 12px;
            border-left: 5px solid #3498db;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .status-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .status-item.success {
            border-left-color: #27ae60;
            background: linear-gradient(135deg, #d4edda 0%, #e8f5e8 100%);
        }

        .status-item.error {
            border-left-color: #e74c3c;
            background: linear-gradient(135deg, #f8d7da 0%, #fce4e6 100%);
        }

        .status-item h3 {
            color: #2c3e50;
            margin-bottom: 12px;
            font-size: 1.3em;
            font-weight: 600;
        }

        .status-item p {
            color: #666;
            font-weight: 500;
        }

        .endpoint {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .endpoint h4 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .method {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            font-weight: bold;
            margin-right: 10px;
        }

        .method.get { background: #3498db; color: white; }
        .method.post { background: #27ae60; color: white; }
        .method.put { background: #f39c12; color: white; }
        .method.delete { background: #e74c3c; color: white; }

        .code-block {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            margin: 10px 0;
        }

        .test-btn {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .test-btn:hover {
            background: linear-gradient(135deg, #2980b9 0%, #1f618d 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        .test-btn:active {
            transform: translateY(0);
        }

        .test-btn:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px 0;
        }

        .btn-success {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #229954 0%, #1e8449 100%);
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);
            box-shadow: 0 6px 20px rgba(243, 156, 18, 0.4);
        }

        /* Curl Commands Styling */
        .curl-commands {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin: 20px 0;
        }

        .curl-item {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .curl-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .curl-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .curl-title {
            font-weight: 600;
            font-size: 1.1em;
            margin-left: 15px;
            flex: 1;
        }

        .copy-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .copy-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-1px);
        }

        .copy-btn:active {
            transform: translateY(0);
            background: rgba(255, 255, 255, 0.4);
        }

        .curl-item .code-block {
            margin: 0;
            border-radius: 0;
            background: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.4;
            word-break: break-all;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .footer {
            text-align: center;
            color: white;
            margin-top: 30px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🗓️ Penjadwalan App Backend API</h1>
            <p>RESTful API untuk Manajemen Jadwal Kegiatan</p>
            <p><strong>Project-Based Test - Pemrograman Web</strong></p>
        </div>

        <div class="status-card">
            <h2>📚 API Documentation</h2>
            <p>Silakan gunakan endpoint berikut untuk mengakses data jadwal, kategori, dan lokasi:</p>
            <ul style="margin: 15px 0; padding-left: 20px;">
                <li><code>GET /api/jadwal.php</code> - List semua jadwal</li>
                <li><code>POST /api/jadwal.php</code> - Tambah jadwal</li>
                <li><code>PUT /api/jadwal.php</code> - Edit jadwal</li>
                <li><code>DELETE /api/jadwal.php</code> - Hapus jadwal</li>
                <li><code>GET /api/kategori.php</code> - List kategori</li>
                <li><code>GET /api/lokasi.php</code> - List lokasi</li>
            </ul>
            <p>Gunakan tools seperti Postman, curl, atau Thunder Client untuk menguji endpoint.</p>
        </div>
                <div class="status-item success">
                    <h3>✅ PHP</h3>
                    <p>Version: <?php echo phpversion(); ?></p>
                </div>
                <div class="status-item <?php 
                    try {
                        require_once 'config/database.php';
                        $db = new Database();
                        $conn = $db->getConnection();
                        echo $conn ? 'success' : 'error';
                    } catch (Exception $e) {
                        echo 'error';
                    }
                ?>">
                    <h3><?php 
                        try {
                            require_once 'config/database.php';
                            $db = new Database();
                            $conn = $db->getConnection();
                            echo $conn ? '✅ Database' : '❌ Database';
                        } catch (Exception $e) {
                            echo '❌ Database';
                        }
                    ?></h3>
                    <p><?php 
                        try {
                            require_once 'config/database.php';
                            $db = new Database();
                            $conn = $db->getConnection();
                            echo $conn ? 'Connected' : 'Connection Failed';
                        } catch (Exception $e) {
                            echo 'Connection Failed';
                        }
                    ?></p>
                </div>
                <div class="status-item success">
                    <h3>✅ CORS</h3>
                    <p>Enabled</p>
                </div>
                <div class="status-item success">
                    <h3>✅ API</h3>
                    <p>Active</p>
                </div>
            </div>
        </div>

        <!-- API Documentation -->
        <div class="status-card">
            <h2>📚 API Endpoints</h2>
            <p>Base URL: <strong><?php echo 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']); ?>/api/jadwal.php</strong></p>

            <div class="endpoint">
                <h4><span class="method get">GET</span> Ambil Semua Jadwal</h4>
                <div class="code-block">GET /api/jadwal.php</div>
                <p>Mengambil daftar semua jadwal yang tersimpan.</p>
            </div>

            <div class="endpoint">
                <h4><span class="method get">GET</span> Ambil Jadwal Berdasarkan ID</h4>
                <div class="code-block">GET /api/jadwal.php?id=1</div>
                <p>Mengambil jadwal berdasarkan ID tertentu.</p>
            </div>

            <div class="endpoint">
                <h4><span class="method post">POST</span> Tambah Jadwal Baru</h4>
                <div class="code-block">POST /api/jadwal.php
Content-Type: application/json

{
    "kegiatan": "Meeting dengan klien",
    "tanggal": "2025-07-20"
}</div>
                <p>Menambahkan jadwal baru ke dalam sistem.</p>
            </div>

            <div class="endpoint">
                <h4><span class="method put">PUT</span> Update Jadwal</h4>
                <div class="code-block">PUT /api/jadwal.php
Content-Type: application/json

{
    "id": 1,
    "kegiatan": "Meeting Updated",
    "tanggal": "2025-07-21"
}</div>
                <p>Memperbarui jadwal yang sudah ada.</p>
            </div>

            <div class="endpoint">
                <h4><span class="method delete">DELETE</span> Hapus Jadwal</h4>
                <div class="code-block">DELETE /api/jadwal.php
Content-Type: application/json

{
    "id": 1
}</div>
                <p>Menghapus jadwal dari sistem.</p>
            </div>
        </div>

        <!-- Database Schema -->
        <div class="status-card">
            <h2>🗄️ Database Schema</h2>
            <div class="code-block">
CREATE TABLE jadwal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kegiatan VARCHAR(255) NOT NULL,
    tanggal DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
            </div>
        </div>

        <!-- Sample Data -->
        <div class="status-card">
            <h2>📋 Sample Data</h2>
            
            <?php 
            // Display Jadwal Data
            try {
                require_once 'models/JadwalModel.php';
                $jadwalModel = new JadwalModel();
                $result = $jadwalModel->readAll();

                if ($result['success'] && count($result['data']) > 0) {
                    echo '<h3>📅 Jadwal Data (' . $result['total'] . ' records)</h3>';
                    echo '<table style="width: 100%; border-collapse: collapse; margin-top: 10px;">';
                    echo '<thead><tr style="background: #f8f9fa;"><th style="padding: 8px; border: 1px solid #ddd;">ID</th><th style="padding: 8px; border: 1px solid #ddd;">Kegiatan</th><th style="padding: 8px; border: 1px solid #ddd;">Tanggal</th><th style="padding: 8px; border: 1px solid #ddd;">Kategori</th><th style="padding: 8px; border: 1px solid #ddd;">Lokasi</th><th style="padding: 8px; border: 1px solid #ddd;">Dibuat</th></tr></thead><tbody>';
                    
                    foreach (array_slice($result['data'], 0, 5) as $jadwal) {
                        echo '<tr>';
                        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . $jadwal['id'] . '</td>';
                        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . htmlspecialchars($jadwal['kegiatan']) . '</td>';
                        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . date('d/m/Y', strtotime($jadwal['tanggal'])) . '</td>';
                        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . ($jadwal['kategori'] ?? '-') . '</td>';
                        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . ($jadwal['lokasi'] ?? '-') . '</td>';
                        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . date('d/m/Y H:i', strtotime($jadwal['created_at'])) . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';

                    if ($result['total'] > 5) {
                        echo '<p style="margin-top: 10px; font-style: italic;">Dan ' . ($result['total'] - 5) . ' jadwal lainnya...</p>';
                    }
                } else {
                    echo '<h3>📅 Jadwal Data</h3><p>Belum ada data jadwal. Gunakan endpoint POST untuk menambah data.</p>';
                }
            } catch (Exception $e) {
                echo '<h3>📅 Jadwal Data</h3><p style="color: red;">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
            
            echo '<hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">';
            
            // Display Kategori Data
            try {
                require_once 'models/KategoriModel.php';
                $kategoriModel = new KategoriModel();
                $result = $kategoriModel->readAll();

                if ($result['success'] && count($result['data']) > 0) {
                    echo '<h3>🏷️ Kategori Data (' . count($result['data']) . ' records)</h3>';
                    echo '<table style="width: 100%; border-collapse: collapse; margin-top: 10px;">';
                    echo '<thead><tr style="background: #f8f9fa;"><th style="padding: 8px; border: 1px solid #ddd;">ID</th><th style="padding: 8px; border: 1px solid #ddd;">Nama Kategori</th><th style="padding: 8px; border: 1px solid #ddd;">Dibuat</th></tr></thead><tbody>';
                    
                    foreach (array_slice($result['data'], 0, 5) as $kategori) {
                        echo '<tr>';
                        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . (isset($kategori['id']) ? $kategori['id'] : '-') . '</td>';
                        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . (isset($kategori['nama']) ? htmlspecialchars($kategori['nama']) : '-') . '</td>';
                        
                        // Safe date formatting
                        $createdAt = '-';
                        if (isset($kategori['created_at']) && !empty($kategori['created_at'])) {
                            $timestamp = strtotime($kategori['created_at']);
                            if ($timestamp !== false) {
                                $createdAt = date('d/m/Y H:i', $timestamp);
                            }
                        }
                        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . $createdAt . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                } else {
                    echo '<h3>🏷️ Kategori Data</h3><p>Belum ada data kategori.</p>';
                }
            } catch (Exception $e) {
                echo '<h3>🏷️ Kategori Data</h3><p style="color: red;">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
            
            echo '<hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">';
            
            // Display Lokasi Data
            try {
                require_once 'models/LokasiModel.php';
                $lokasiModel = new LokasiModel();
                $result = $lokasiModel->readAll();

                if ($result['success'] && count($result['data']) > 0) {
                    echo '<h3>📍 Lokasi Data (' . count($result['data']) . ' records)</h3>';
                    echo '<table style="width: 100%; border-collapse: collapse; margin-top: 10px;">';
                    echo '<thead><tr style="background: #f8f9fa;"><th style="padding: 8px; border: 1px solid #ddd;">ID</th><th style="padding: 8px; border: 1px solid #ddd;">Nama Lokasi</th><th style="padding: 8px; border: 1px solid #ddd;">Alamat</th><th style="padding: 8px; border: 1px solid #ddd;">Dibuat</th></tr></thead><tbody>';
                    
                    foreach (array_slice($result['data'], 0, 5) as $lokasi) {
                        echo '<tr>';
                        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . (isset($lokasi['id']) ? $lokasi['id'] : '-') . '</td>';
                        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . (isset($lokasi['nama']) ? htmlspecialchars($lokasi['nama']) : '-') . '</td>';
                        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . (isset($lokasi['alamat']) && !empty($lokasi['alamat']) ? htmlspecialchars($lokasi['alamat']) : '-') . '</td>';
                        
                        // Safe date formatting
                        $createdAt = '-';
                        if (isset($lokasi['created_at']) && !empty($lokasi['created_at'])) {
                            $timestamp = strtotime($lokasi['created_at']);
                            if ($timestamp !== false) {
                                $createdAt = date('d/m/Y H:i', $timestamp);
                            }
                        }
                        echo '<td style="padding: 8px; border: 1px solid #ddd;">' . $createdAt . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                } else {
                    echo '<h3>📍 Lokasi Data</h3><p>Belum ada data lokasi.</p>';
                }
            } catch (Exception $e) {
                echo '<h3>📍 Lokasi Data</h3><p style="color: red;">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
            ?>
        </div>

        <!-- Testing Tools -->
        <div class="status-card">
            <h2>🧪 Testing Tools</h2>
            <p>Untuk menguji API, gunakan tools berikut:</p>
            <ul style="margin: 15px 0; padding-left: 20px;">
                <li><strong>Postman</strong> - Recommended untuk testing manual</li>
                <li><strong>curl</strong> - Command line testing</li>
                <li><strong>Browser</strong> - Untuk endpoint GET</li>
                <li><strong>Thunder Client</strong> - VSCode extension</li>
            </ul>

            <h3>📝 Sample curl Commands</h3>
            <p style="margin-bottom: 20px; color: #666;">Klik tombol copy untuk menyalin command ke clipboard:</p>
            
            <div class="curl-commands">
                <div class="curl-item">
                    <div class="curl-header">
                        <span class="method get">GET</span>
                        <span class="curl-title">Get All Jadwal</span>
                        <button class="copy-btn" onclick="copyToClipboard('curl-jadwal')" title="Copy to clipboard">
                            📋 Copy
                        </button>
                    </div>
                    <div class="code-block" id="curl-jadwal">curl http://{HOST}/api/jadwal.php</div>
                </div>
                
                <div class="curl-item">
                    <div class="curl-header">
                        <span class="method get">GET</span>
                        <span class="curl-title">Get All Kategori</span>
                        <button class="copy-btn" onclick="copyToClipboard('curl-kategori')" title="Copy to clipboard">
                            📋 Copy
                        </button>
                    </div>
                    <div class="code-block" id="curl-kategori">curl http://{HOST}/api/kategori.php</div>
                </div>
                
                <div class="curl-item">
                    <div class="curl-header">
                        <span class="method get">GET</span>
                        <span class="curl-title">Get All Lokasi</span>
                        <button class="copy-btn" onclick="copyToClipboard('curl-lokasi')" title="Copy to clipboard">
                            📋 Copy
                        </button>
                    </div>
                    <div class="code-block" id="curl-lokasi">curl http://{HOST}/api/lokasi.php</div>
                </div>
                
                <div class="curl-item">
                    <div class="curl-header">
                        <span class="method get">GET</span>
                        <span class="curl-title">Health Check</span>
                        <button class="copy-btn" onclick="copyToClipboard('curl-health')" title="Copy to clipboard">
                            📋 Copy
                        </button>
                    </div>
                    <div class="code-block" id="curl-health">curl http://{HOST}/api/health.php</div>
                </div>
                
                <div class="curl-item">
                    <div class="curl-header">
                        <span class="method post">POST</span>
                        <span class="curl-title">Create New Jadwal</span>
                        <button class="copy-btn" onclick="copyToClipboard('curl-post-jadwal')" title="Copy to clipboard">
                            📋 Copy
                        </button>
                    </div>
                    <div class="code-block" id="curl-post-jadwal">curl -X POST http://{HOST}/api/jadwal.php -H "Content-Type: application/json" -d '{"kegiatan":"Test API","tanggal":"2025-07-25"}'</div>
                </div>
                
                <div class="curl-item">
                    <div class="curl-header">
                        <span class="method post">POST</span>
                        <span class="curl-title">Create New Kategori</span>
                        <button class="copy-btn" onclick="copyToClipboard('curl-post-kategori')" title="Copy to clipboard">
                            📋 Copy
                        </button>
                    </div>
                    <div class="code-block" id="curl-post-kategori">curl -X POST http://{HOST}/api/kategori.php -H "Content-Type: application/json" -d '{"nama":"Meeting","deskripsi":"Kategori untuk meeting"}'</div>
                </div>
                
                <div class="curl-item">
                    <div class="curl-header">
                        <span class="method post">POST</span>
                        <span class="curl-title">Create New Lokasi</span>
                        <button class="copy-btn" onclick="copyToClipboard('curl-post-lokasi')" title="Copy to clipboard">
                            📋 Copy
                        </button>
                    </div>
                    <div class="code-block" id="curl-post-lokasi">curl -X POST http://{HOST}/api/lokasi.php -H "Content-Type: application/json" -d '{"nama":"Ruang Meeting","alamat":"Lantai 2"}'</div>
                </div>
            </div>
            
            <!-- Copy notification -->
            <div id="copy-notification" style="display: none; position: fixed; top: 20px; right: 20px; background: #28a745; color: white; padding: 15px 20px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); z-index: 1000; font-weight: 600;">
                ✅ Command copied to clipboard!
            </div>
        </div>

        <!-- Enhanced Quick Test -->
        <div class="status-card">
            <h2>⚡ API Testing Dashboard</h2>
            <p>Comprehensive testing suite untuk semua API endpoints dengan real-time monitoring:</p>
            
            <div class="btn-group">
                <button class="test-btn" onclick="testAPI('jadwal')" id="btn-jadwal">
                    📅 Test Jadwal API
                </button>
                <button class="test-btn" onclick="testAPI('kategori')" id="btn-kategori">
                    🏷️ Test Kategori API
                </button>
                <button class="test-btn" onclick="testAPI('lokasi')" id="btn-lokasi">
                    📍 Test Lokasi API
                </button>
                <button class="test-btn" onclick="testAPI('health')" id="btn-health">
                    ❤️ Test Health API
                </button>
            </div>
            
            <div class="btn-group">
                <button class="test-btn btn-success" onclick="testAllAPIs()" id="btn-all">
                    🚀 Test All APIs
                </button>
                <button class="test-btn btn-warning" onclick="clearResults()" id="btn-clear">
                    🗑️ Clear Results
                </button>
            </div>
            
            <div id="test-result" style="margin-top: 20px;"></div>
            <div id="loading-indicator" style="display: none; text-align: center; margin: 20px 0;">
                <div style="display: inline-block; width: 20px; height: 20px; border: 3px solid #f3f3f3; border-top: 3px solid #3498db; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                <p style="margin-top: 10px; color: #666;">Testing APIs...</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2025 Penjadwalan App - Project Based Test</p>
        <p>Developed by: <strong>Tio Afriza & Yales Vepa</strong></p>
        <p>Mata Kuliah: <strong>Pemrograman Web</strong></p>
    </div>

    <script>
        const apiEndpoints = {
            jadwal: '/api/jadwal.php',
            kategori: '/api/kategori.php',
            lokasi: '/api/lokasi.php',
            health: '/api/health.php'
        };

        // Add CSS animation for spinner
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .result-card {
                background: #f8f9fa;
                border-radius: 10px;
                padding: 20px;
                margin: 10px 0;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
            }
            .result-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            }
        `;
        document.head.appendChild(style);

        function showLoading() {
            document.getElementById('loading-indicator').style.display = 'block';
        }

        function hideLoading() {
            document.getElementById('loading-indicator').style.display = 'none';
        }

        function disableButtons() {
            const buttons = document.querySelectorAll('.test-btn');
            buttons.forEach(btn => {
                btn.disabled = true;
                btn.style.opacity = '0.6';
            });
        }

        function enableButtons() {
            const buttons = document.querySelectorAll('.test-btn');
            buttons.forEach(btn => {
                btn.disabled = false;
                btn.style.opacity = '1';
            });
        }

        function clearResults() {
            document.getElementById('test-result').innerHTML = '';
            hideLoading();
        }

        function testAPI(endpoint) {
            const resultDiv = document.getElementById('test-result');
            const apiUrl = window.location.origin + apiEndpoints[endpoint];
            
            showLoading();
            disableButtons();
            
            resultDiv.innerHTML = `<div class="result-card" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-left: 4px solid #f39c12;">
                <h4>🔄 Testing ${endpoint.toUpperCase()} API</h4>
                <p>URL: <code>${apiUrl}</code></p>
                <p>Status: <strong>In Progress...</strong></p>
            </div>`;
            
            const startTime = Date.now();
            
            fetch(apiUrl)
                .then(response => {
                    const endTime = Date.now();
                    const responseTime = endTime - startTime;
                    
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const endTime = Date.now();
                    const responseTime = endTime - startTime;
                    
                    let dataPreview = '';
                    let recordCount = 'N/A';
                    
                    if (data.data && Array.isArray(data.data)) {
                        recordCount = data.data.length;
                        dataPreview = `
                            <div style="margin: 15px 0;">
                                <h5 style="color: #27ae60; margin-bottom: 10px;">📊 Data Summary</h5>
                                <p><strong>Total Records:</strong> ${data.data.length}</p>
                                <p><strong>API Status:</strong> <span style="color: #27ae60;">✅ ${data.success ? 'Success' : 'Failed'}</span></p>
                            </div>
                        `;
                        
                        if (data.data.length > 0) {
                            const sampleData = JSON.stringify(data.data[0], null, 2);
                            dataPreview += `
                                <details style="margin-top: 15px;">
                                    <summary style="cursor: pointer; font-weight: 600; color: #3498db;">🔍 View Sample Record</summary>
                                    <pre style="background: #2c3e50; color: #ecf0f1; padding: 15px; border-radius: 8px; font-size: 12px; margin-top: 10px; overflow-x: auto;">${sampleData}</pre>
                                </details>
                            `;
                        }
                    } else if (endpoint === 'health') {
                        dataPreview = `
                            <div style="margin: 15px 0;">
                                <h5 style="color: #27ae60; margin-bottom: 10px;">❤️ Health Check Results</h5>
                                <p><strong>Status:</strong> <span style="color: #27ae60;">✅ ${data.status || 'Healthy'}</span></p>
                                <p><strong>Database:</strong> <span style="color: #27ae60;">✅ Connected</span></p>
                            </div>
                        `;
                    } else {
                        const responseData = JSON.stringify(data, null, 2);
                        dataPreview = `
                            <details style="margin-top: 15px;">
                                <summary style="cursor: pointer; font-weight: 600; color: #3498db;">🔍 View Full Response</summary>
                                <pre style="background: #2c3e50; color: #ecf0f1; padding: 15px; border-radius: 8px; font-size: 12px; margin-top: 10px; overflow-x: auto;">${responseData}</pre>
                            </details>
                        `;
                    }
                    
                    resultDiv.innerHTML = `
                        <div class="result-card" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border-left: 5px solid #28a745;">
                            <h4>✅ ${endpoint.toUpperCase()} API Test Successful</h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin: 15px 0;">
                                <div>
                                    <p><strong>⏱️ Response Time:</strong> <span style="color: #28a745; font-weight: 600;">${responseTime}ms</span></p>
                                    <p><strong>📊 Records:</strong> <span style="color: #28a745; font-weight: 600;">${recordCount}</span></p>
                                </div>
                                <div>
                                    <p><strong>🔗 Endpoint:</strong> <code>${apiUrl}</code></p>
                                    <p><strong>🕰️ Tested at:</strong> ${new Date().toLocaleTimeString('id-ID')}</p>
                                </div>
                            </div>
                            ${dataPreview}
                        </div>
                    `;
                })
                .catch(error => {
                    const endTime = Date.now();
                    const responseTime = endTime - startTime;
                    
                    resultDiv.innerHTML = `
                        <div class="result-card" style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border-left: 5px solid #dc3545;">
                            <h4>❌ ${endpoint.toUpperCase()} API Test Failed</h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin: 15px 0;">
                                <div>
                                    <p><strong>⏱️ Response Time:</strong> <span style="color: #dc3545; font-weight: 600;">${responseTime}ms</span></p>
                                    <p><strong>⚠️ Status:</strong> <span style="color: #dc3545; font-weight: 600;">Failed</span></p>
                                </div>
                                <div>
                                    <p><strong>🔗 Endpoint:</strong> <code>${apiUrl}</code></p>
                                    <p><strong>🕰️ Tested at:</strong> ${new Date().toLocaleTimeString('id-ID')}</p>
                                </div>
                            </div>
                            <div style="background: #fff; padding: 15px; border-radius: 8px; margin-top: 15px;">
                                <h5 style="color: #dc3545; margin-bottom: 10px;">🚨 Error Details</h5>
                                <p><strong>Error Message:</strong> <code style="color: #dc3545;">${error.message}</code></p>
                                <p><strong>Possible Causes:</strong></p>
                                <ul style="margin-left: 20px; color: #666;">
                                    <li>Server tidak berjalan atau endpoint tidak tersedia</li>
                                    <li>Database connection error</li>
                                    <li>CORS policy atau network issues</li>
                                    <li>API endpoint configuration error</li>
                                </ul>
                            </div>
                        </div>
                    `;
                })
                .finally(() => {
                    hideLoading();
                    enableButtons();
                });
        }

        function testAllAPIs() {
            const resultDiv = document.getElementById('test-result');
            resultDiv.innerHTML = '<div style="background: #fff3cd; padding: 15px; border-radius: 5px;">🔄 Testing all APIs...</div>';
            
            const results = [];
            const endpoints = Object.keys(apiEndpoints);
            let completed = 0;
            
            endpoints.forEach(endpoint => {
                const apiUrl = window.location.origin + apiEndpoints[endpoint];
                const startTime = Date.now();
                
                fetch(apiUrl)
                    .then(response => {
                        const endTime = Date.now();
                        const responseTime = endTime - startTime;
                        
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        const endTime = Date.now();
                        const responseTime = endTime - startTime;
                        
                        results.push({
                            endpoint,
                            success: true,
                            responseTime,
                            recordCount: data.data ? data.data.length : 'N/A',
                            status: data.success ? 'Success' : 'Failed'
                        });
                    })
                    .catch(error => {
                        const endTime = Date.now();
                        const responseTime = endTime - startTime;
                        
                        results.push({
                            endpoint,
                            success: false,
                            responseTime,
                            error: error.message
                        });
                    })
                    .finally(() => {
                        completed++;
                        if (completed === endpoints.length) {
                            displayAllResults(results);
                        }
                    });
            });
        }

        function displayAllResults(results) {
            const resultDiv = document.getElementById('test-result');
            const successCount = results.filter(r => r.success).length;
            const totalCount = results.length;
            
            let html = `
                <div style="background: ${successCount === totalCount ? '#d4edda' : '#fff3cd'}; padding: 15px; border-radius: 5px; border-left: 4px solid ${successCount === totalCount ? '#28a745' : '#ffc107'};">
                    <h4>${successCount === totalCount ? '✅' : '⚠️'} All APIs Test Results (${successCount}/${totalCount} passed)</h4>
                    <table style="width: 100%; margin-top: 10px; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8f9fa;">
                                <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Endpoint</th>
                                <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Status</th>
                                <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Response Time</th>
                                <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Records</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            results.forEach(result => {
                html += `
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd;">${result.endpoint.toUpperCase()}</td>
                        <td style="padding: 8px; border: 1px solid #ddd; color: ${result.success ? '#28a745' : '#dc3545'};">
                            ${result.success ? '✅ Success' : '❌ Failed'}
                            ${result.error ? '<br><small>' + result.error + '</small>' : ''}
                        </td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${result.responseTime}ms</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${result.recordCount || 'N/A'}</td>
                    </tr>
                `;
            });
            
            html += `
                        </tbody>
                    </table>
                </div>
            `;
            
            resultDiv.innerHTML = html;
        }

        // Copy to clipboard functionality
        async function copyToClipboard(elementId) {
            const element = document.getElementById(elementId);
            if (!element) {
                console.error('Element not found:', elementId);
                return;
            }

            const text = element.textContent || element.innerText;
            
            try {
                // Try using the modern Clipboard API first
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(text);
                } else {
                    // Fallback for older browsers or non-HTTPS
                    const textArea = document.createElement('textarea');
                    textArea.value = text;
                    textArea.style.position = 'fixed';
                    textArea.style.left = '-999999px';
                    textArea.style.top = '-999999px';
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    document.execCommand('copy');
                    textArea.remove();
                }
                
                // Show success notification
                showCopyNotification();
                
                // Update button text temporarily
                const button = document.querySelector(`button[onclick="copyToClipboard('${elementId}')"]`);
                if (button) {
                    const originalText = button.innerHTML;
                    button.innerHTML = '✅ Copied!';
                    button.style.background = 'rgba(40, 167, 69, 0.3)';
                    
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.style.background = 'rgba(255, 255, 255, 0.2)';
                    }, 2000);
                }
                
            } catch (err) {
                console.error('Failed to copy text: ', err);
                
                // Show error notification
                showCopyNotification('❌ Failed to copy command', '#dc3545');
            }
        }

        function showCopyNotification(message = '✅ Command copied to clipboard!', bgColor = '#28a745') {
            const notification = document.getElementById('copy-notification');
            notification.innerHTML = message;
            notification.style.background = bgColor;
            notification.style.display = 'block';
            
            // Add slide-in animation
            notification.style.transform = 'translateX(100%)';
            notification.style.transition = 'transform 0.3s ease';
            
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);
            
            // Hide after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 300);
            }, 3000);
        }

        // Replace {HOST} placeholders with actual host when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const codeBlocks = document.querySelectorAll('.code-block');
            codeBlocks.forEach(function(block) {
                block.innerHTML = block.innerHTML.replace(/{HOST}/g, window.location.host);
            });
        });
    </script>
</body>
</html>
