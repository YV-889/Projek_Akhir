import React, { useEffect, useState } from 'react';
import axios from 'axios';
import ApiService from '../services/ApiService';
import JadwalStats from '../components/JadwalStats';
import './Dashboard.css';

function Dashboard() {
    const [jadwal, setJadwal] = useState([]);
    const [kategori, setKategori] = useState([]);
    const [lokasi, setLokasi] = useState([]);
    const [liburDates, setLiburDates] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');
    const [lastUpdated, setLastUpdated] = useState(null);

    useEffect(() => {
        loadData();
    }, []);

    const loadData = async () => {
        setLoading(true);
        setError('');
        try {
            // Load all data in parallel for better performance
            const [jadwalResponse, kategoriResponse, lokasiResponse, liburResponse] = await Promise.all([
                ApiService.getAllJadwal(),
                ApiService.getAllKategori(),
                ApiService.getAllLokasi(),
                axios.get('https://api-harilibur.vercel.app/api')
            ]);

            // Set jadwal data
            if (jadwalResponse.success) {
                setJadwal(jadwalResponse.data);
            }

            // Set kategori data
            if (kategoriResponse.success) {
                setKategori(kategoriResponse.data);
            }

            // Set lokasi data
            if (lokasiResponse.success) {
                setLokasi(lokasiResponse.data);
            }

            // Set holiday dates
            const dates = liburResponse.data.map(item => item.holiday_date);
            setLiburDates(dates);
            
            // Update last refreshed timestamp
            setLastUpdated(new Date());
        } catch (error) {
            setError('Gagal memuat data. Periksa koneksi internet Anda.');
            console.error('Error loading data:', error);
        } finally {
            setLoading(false);
        }
    };

    // Enhanced statistics calculations
    const today = new Date();
    const todayString = today.toISOString().split('T')[0];
    const nextWeek = new Date();
    nextWeek.setDate(today.getDate() + 7);
    const nextMonth = new Date();
    nextMonth.setMonth(today.getMonth() + 1);

    // Basic statistics
    const totalKegiatan = jadwal.length;
    const totalKategori = kategori.length;
    const totalLokasi = lokasi.length;
    const totalHariLibur = jadwal.filter(j => liburDates.includes(j.tanggal)).length;

    // Time-based statistics
    const jadwalHariIni = jadwal.filter(j => j.tanggal === todayString);
    const jadwalTerlewat = jadwal.filter(j => new Date(j.tanggal) < today);
    const jadwalMendatang = jadwal.filter(j => {
        const jadwalDate = new Date(j.tanggal);
        return jadwalDate >= today && jadwalDate <= nextWeek;
    }).sort((a, b) => new Date(a.tanggal) - new Date(b.tanggal)).slice(0, 5);
    
    const jadwalBulanIni = jadwal.filter(j => {
        const jadwalDate = new Date(j.tanggal);
        return jadwalDate >= today && jadwalDate <= nextMonth;
    });

    // Category and location statistics
    const kategoriTerpopuler = kategori.map(kat => ({
        ...kat,
        count: jadwal.filter(j => j.kategori_id === kat.id).length
    })).sort((a, b) => b.count - a.count).slice(0, 3);

    const lokasiTerpopuler = lokasi.map(lok => ({
        ...lok,
        count: jadwal.filter(j => j.lokasi_id === lok.id).length
    })).sort((a, b) => b.count - a.count).slice(0, 3);

    if (loading) {
        return (
            <div className="dashboard-container">
                <div className="dashboard-header">
                    <h1>📊 Dashboard Penjadwalan</h1>
                    <p>Memuat data dashboard...</p>
                </div>
                <div className="loading-container">
                    <div className="loading-spinner"></div>
                    <p>Sedang memuat data jadwal, kategori, lokasi, dan hari libur...</p>
                </div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="dashboard-container">
                <div className="dashboard-header">
                    <h1>📊 Dashboard Penjadwalan</h1>
                    <p>Terjadi kesalahan saat memuat data</p>
                </div>
                <div className="alert alert-error">
                    {error}
                    <button onClick={loadData} className="retry-btn">🔄 Coba Lagi</button>
                </div>
            </div>
        );
    }

    return (
        <div className="dashboard-container">
            <div className="dashboard-header">
                <h1>📊 Dashboard Penjadwalan</h1>
                <p>Ringkasan lengkap aktivitas dan statistik jadwal Anda</p>
                {lastUpdated && (
                    <small>Terakhir diperbarui: {lastUpdated.toLocaleString('id-ID')}</small>
                )}
            </div>

            {/* Enhanced Statistics Cards */}
            <div className="stats-grid">
                <div className="stat-card">
                    <div className="stat-icon">📅</div>
                    <div className="stat-content">
                        <h3>{totalKegiatan}</h3>
                        <p>Total Kegiatan</p>
                    </div>
                </div>

                <div className="stat-card">
                    <div className="stat-icon">📋</div>
                    <div className="stat-content">
                        <h3>{jadwalHariIni.length}</h3>
                        <p>Kegiatan Hari Ini</p>
                    </div>
                </div>

                <div className="stat-card">
                    <div className="stat-icon">⏰</div>
                    <div className="stat-content">
                        <h3>{jadwalBulanIni.length}</h3>
                        <p>Kegiatan Bulan Ini</p>
                    </div>
                </div>

                <div className="stat-card">
                    <div className="stat-icon">🏖️</div>
                    <div className="stat-content">
                        <h3>{totalHariLibur}</h3>
                        <p>Kegiatan di Hari Libur</p>
                    </div>
                </div>

                <div className="stat-card">
                    <div className="stat-icon">🏷️</div>
                    <div className="stat-content">
                        <h3>{totalKategori}</h3>
                        <p>Total Kategori</p>
                    </div>
                </div>

                <div className="stat-card">
                    <div className="stat-icon">📍</div>
                    <div className="stat-content">
                        <h3>{totalLokasi}</h3>
                        <p>Total Lokasi</p>
                    </div>
                </div>
            </div>

            {/* Detailed Statistics */}
            <JadwalStats jadwal={jadwal} liburDates={liburDates} />

            {/* Jadwal Hari Ini */}
            <div className="dashboard-section">
                <h3>📅 Jadwal Hari Ini</h3>
                {jadwalHariIni.length === 0 ? (
                    <p className="no-data">Tidak ada kegiatan hari ini.</p>
                ) : (
                    <div className="jadwal-today">
                        {jadwalHariIni.map((item, index) => (
                            <div key={item.id} className="jadwal-item today">
                                <div className="jadwal-content">
                                    <h4>{item.kegiatan}</h4>
                                    <p>📅 {ApiService.formatDate(item.tanggal)}</p>
                                    {liburDates.includes(item.tanggal) && (
                                        <span className="holiday-badge">Hari Libur</span>
                                    )}
                                </div>
                            </div>
                        ))}
                    </div>
                )}
            </div>

            {/* Jadwal Mendatang */}
            <div className="dashboard-section">
                <h3>⏰ Jadwal Mendatang (7 Hari Ke Depan)</h3>
                {jadwalMendatang.length === 0 ? (
                    <p className="no-data">Tidak ada kegiatan dalam 7 hari ke depan.</p>
                ) : (
                    <div className="jadwal-upcoming">
                        {jadwalMendatang.map((item, index) => (
                            <div key={item.id} className="jadwal-item upcoming">
                                <div className="jadwal-content">
                                    <h4>{item.kegiatan}</h4>
                                    <p>📅 {ApiService.formatDate(item.tanggal)}</p>
                                    {liburDates.includes(item.tanggal) && (
                                        <span className="holiday-badge">Hari Libur</span>
                                    )}
                                    {ApiService.isPastDate(item.tanggal) && (
                                        <span className="past-badge">Terlewat</span>
                                    )}
                                </div>
                            </div>
                        ))}
                    </div>
                )}
            </div>

            {/* Tabel Ringkasan Jadwal */}
            <div className="dashboard-section">
                <h3>📊 Ringkasan Semua Jadwal</h3>
                {jadwal.length === 0 ? (
                    <p className="no-data">Belum ada jadwal yang ditambahkan.</p>
                ) : (
                    <div className="table-container">
                        <table className="dashboard-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kegiatan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {jadwal.slice(0, 10).map((item, index) => (
                                    <tr key={item.id}>
                                        <td>{index + 1}</td>
                                        <td>{item.kegiatan}</td>
                                        <td>{ApiService.formatDate(item.tanggal)}</td>
                                        <td>
                                            {ApiService.isPastDate(item.tanggal) && (
                                                <span className="status-badge past">Terlewat</span>
                                            )}
                                            {item.tanggal === todayString && (
                                                <span className="status-badge today">Hari Ini</span>
                                            )}
                                            {!ApiService.isPastDate(item.tanggal) && item.tanggal !== todayString && (
                                                <span className="status-badge upcoming">Mendatang</span>
                                            )}
                                            {liburDates.includes(item.tanggal) && (
                                                <span className="status-badge holiday">Hari Libur</span>
                                            )}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                        {jadwal.length > 10 && (
                            <p className="more-data">
                                Dan {jadwal.length - 10} jadwal lainnya...
                            </p>
                        )}
                    </div>
                )}
            </div>

            {/* Popular Categories and Locations */}
            <div className="dashboard-section">
                <h3>📊 Statistik Kategori & Lokasi Terpopuler</h3>
                <div className="stats-grid">
                    <div className="dashboard-section">
                        <h4>🏷️ Kategori Terpopuler</h4>
                        {kategoriTerpopuler.length === 0 ? (
                            <p className="no-data">Belum ada kategori yang digunakan.</p>
                        ) : (
                            <div className="popular-items">
                                {kategoriTerpopuler.map((kat, index) => (
                                    <div key={kat.id} className="popular-item">
                                        <span className="rank">#{index + 1}</span>
                                        <span className="name">{kat.nama}</span>
                                        <span className="count">{kat.count} kegiatan</span>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                    
                    <div className="dashboard-section">
                        <h4>📍 Lokasi Terpopuler</h4>
                        {lokasiTerpopuler.length === 0 ? (
                            <p className="no-data">Belum ada lokasi yang digunakan.</p>
                        ) : (
                            <div className="popular-items">
                                {lokasiTerpopuler.map((lok, index) => (
                                    <div key={lok.id} className="popular-item">
                                        <span className="rank">#{index + 1}</span>
                                        <span className="name">{lok.nama}</span>
                                        <span className="count">{lok.count} kegiatan</span>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                </div>
            </div>

            {/* Enhanced Refresh Button */}
            <div className="dashboard-actions">
                <button onClick={loadData} className="refresh-btn" disabled={loading}>
                    {loading ? '⏳ Memuat...' : '🔄 Refresh Data'}
                </button>
                {lastUpdated && (
                    <p style={{marginTop: '10px', color: '#7f8c8d', fontSize: '0.9em'}}>
                        Data terakhir diperbarui: {lastUpdated.toLocaleString('id-ID')}
                    </p>
                )}
            </div>
        </div>
    );
}
export default Dashboard;
