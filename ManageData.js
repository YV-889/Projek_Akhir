import React, { useState, useEffect } from 'react';
import ApiService from '../services/ApiService';
import './ManageData.css';

function ManageData() {
    // State for categories
    const [kategoriList, setKategoriList] = useState([]);
    const [kategoriName, setKategoriName] = useState('');
    const [editingKategori, setEditingKategori] = useState(null);

    // State for locations
    const [lokasiList, setLokasiList] = useState([]);
    const [lokasiName, setLokasiName] = useState('');
    const [lokasiAlamat, setLokasiAlamat] = useState('');
    const [editingLokasi, setEditingLokasi] = useState(null);

    // General state
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');
    const [success, setSuccess] = useState('');
    const [activeTab, setActiveTab] = useState('kategori');

    useEffect(() => {
        loadKategori();
        loadLokasi();
    }, []);

    // Category functions
    const loadKategori = async () => {
        try {
            const response = await ApiService.getAllKategori();
            if (response.success) {
                setKategoriList(response.data);
            }
        } catch (error) {
            console.error('Error loading kategori:', error);
        }
    };

    const handleKategoriSubmit = async (e) => {
        e.preventDefault();
        if (!kategoriName.trim()) {
            setError('Nama kategori harus diisi');
            return;
        }

        setLoading(true);
        setError('');

        try {
            let response;
            if (editingKategori) {
                response = await ApiService.updateKategori({
                    id: editingKategori.id,
                    nama: kategoriName.trim()
                });
            } else {
                response = await ApiService.createKategori({
                    nama: kategoriName.trim()
                });
            }

            if (response.success) {
                setSuccess(editingKategori ? 'Kategori berhasil diperbarui' : 'Kategori berhasil ditambahkan');
                setKategoriName('');
                setEditingKategori(null);
                loadKategori();
            } else {
                setError(response.message || 'Gagal menyimpan kategori');
            }
        } catch (error) {
            setError('Error koneksi ke server');
        } finally {
            setLoading(false);
        }
    };

    const handleEditKategori = (kategori) => {
        setKategoriName(kategori.nama);
        setEditingKategori(kategori);
        setError('');
        setSuccess('');
    };

    const handleDeleteKategori = async (id) => {
        if (window.confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
            setLoading(true);
            try {
                const response = await ApiService.deleteKategori(id);
                if (response.success) {
                    setSuccess('Kategori berhasil dihapus');
                    loadKategori();
                } else {
                    setError(response.message || 'Gagal menghapus kategori');
                }
            } catch (error) {
                setError('Error koneksi ke server');
            } finally {
                setLoading(false);
            }
        }
    };

    const handleCancelKategori = () => {
        setKategoriName('');
        setEditingKategori(null);
        setError('');
        setSuccess('');
    };

    // Location functions
    const loadLokasi = async () => {
        try {
            const response = await ApiService.getAllLokasi();
            if (response.success) {
                setLokasiList(response.data);
            }
        } catch (error) {
            console.error('Error loading lokasi:', error);
        }
    };

    const handleLokasiSubmit = async (e) => {
        e.preventDefault();
        if (!lokasiName.trim()) {
            setError('Nama lokasi harus diisi');
            return;
        }

        setLoading(true);
        setError('');

        try {
            let response;
            if (editingLokasi) {
                response = await ApiService.updateLokasi({
                    id: editingLokasi.id,
                    nama: lokasiName.trim(),
                    alamat: lokasiAlamat.trim() || null
                });
            } else {
                response = await ApiService.createLokasi({
                    nama: lokasiName.trim(),
                    alamat: lokasiAlamat.trim() || null
                });
            }

            if (response.success) {
                setSuccess(editingLokasi ? 'Lokasi berhasil diperbarui' : 'Lokasi berhasil ditambahkan');
                setLokasiName('');
                setLokasiAlamat('');
                setEditingLokasi(null);
                loadLokasi();
            } else {
                setError(response.message || 'Gagal menyimpan lokasi');
            }
        } catch (error) {
            setError('Error koneksi ke server');
        } finally {
            setLoading(false);
        }
    };

    const handleEditLokasi = (lokasi) => {
        setLokasiName(lokasi.nama);
        setLokasiAlamat(lokasi.alamat || '');
        setEditingLokasi(lokasi);
        setError('');
        setSuccess('');
    };

    const handleDeleteLokasi = async (id) => {
        if (window.confirm('Apakah Anda yakin ingin menghapus lokasi ini?')) {
            setLoading(true);
            try {
                const response = await ApiService.deleteLokasi(id);
                if (response.success) {
                    setSuccess('Lokasi berhasil dihapus');
                    loadLokasi();
                } else {
                    setError(response.message || 'Gagal menghapus lokasi');
                }
            } catch (error) {
                setError('Error koneksi ke server');
            } finally {
                setLoading(false);
            }
        }
    };

    const handleCancelLokasi = () => {
        setLokasiName('');
        setLokasiAlamat('');
        setEditingLokasi(null);
        setError('');
        setSuccess('');
    };

    const clearMessages = () => {
        setError('');
        setSuccess('');
    };

    return (
        <div className="manage-data-container">
            <div className="page-header">
                <h1>🗂️ Kelola Data</h1>
                <p>Kelola kategori dan lokasi untuk jadwal Anda</p>
            </div>

            {/* Messages */}
            {error && (
                <div className="alert alert-error">
                    {error}
                    <button onClick={clearMessages} className="close-btn">×</button>
                </div>
            )}
            {success && (
                <div className="alert alert-success">
                    {success}
                    <button onClick={clearMessages} className="close-btn">×</button>
                </div>
            )}

            {/* Tab Navigation */}
            <div className="tab-navigation">
                <button 
                    className={`tab-btn ${activeTab === 'kategori' ? 'active' : ''}`}
                    onClick={() => setActiveTab('kategori')}
                >
                    🏷️ Kategori
                </button>
                <button 
                    className={`tab-btn ${activeTab === 'lokasi' ? 'active' : ''}`}
                    onClick={() => setActiveTab('lokasi')}
                >
                    📍 Lokasi
                </button>
            </div>

            {/* Category Management */}
            {activeTab === 'kategori' && (
                <div className="tab-content">
                    <div className="form-section">
                        <h2>{editingKategori ? 'Edit Kategori' : 'Tambah Kategori Baru'}</h2>
                        <form onSubmit={handleKategoriSubmit} className="data-form">
                            <div className="form-group">
                                <label>Nama Kategori:</label>
                                <input
                                    type="text"
                                    value={kategoriName}
                                    onChange={(e) => setKategoriName(e.target.value)}
                                    placeholder="Contoh: Meeting, Workshop, Seminar..."
                                    required
                                />
                            </div>
                            <div className="form-actions">
                                <button type="submit" disabled={loading} className="btn-primary">
                                    {loading ? 'Menyimpan...' : editingKategori ? 'Perbarui' : 'Tambah'}
                                </button>
                                {editingKategori && (
                                    <button type="button" onClick={handleCancelKategori} className="btn-secondary">
                                        Batal
                                    </button>
                                )}
                            </div>
                        </form>
                    </div>

                    <div className="list-section">
                        <h2>Daftar Kategori ({kategoriList.length})</h2>
                        {kategoriList.length === 0 ? (
                            <div className="empty-state">
                                <p>Belum ada kategori. Tambahkan kategori pertama Anda!</p>
                            </div>
                        ) : (
                            <div className="data-grid">
                                {kategoriList.map(kategori => (
                                    <div key={kategori.id} className="data-card">
                                        <div className="card-content">
                                            <h3>{kategori.nama}</h3>
                                            <p className="card-meta">
                                                Dibuat: {new Date(kategori.created_at).toLocaleDateString('id-ID')}
                                            </p>
                                        </div>
                                        <div className="card-actions">
                                            <button 
                                                onClick={() => handleEditKategori(kategori)}
                                                className="btn-edit"
                                                disabled={loading}
                                            >
                                                ✏️ Edit
                                            </button>
                                            <button 
                                                onClick={() => handleDeleteKategori(kategori.id)}
                                                className="btn-delete"
                                                disabled={loading}
                                            >
                                                🗑️ Hapus
                                            </button>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                </div>
            )}

            {/* Location Management */}
            {activeTab === 'lokasi' && (
                <div className="tab-content">
                    <div className="form-section">
                        <h2>{editingLokasi ? 'Edit Lokasi' : 'Tambah Lokasi Baru'}</h2>
                        <form onSubmit={handleLokasiSubmit} className="data-form">
                            <div className="form-group">
                                <label>Nama Lokasi:</label>
                                <input
                                    type="text"
                                    value={lokasiName}
                                    onChange={(e) => setLokasiName(e.target.value)}
                                    placeholder="Contoh: Ruang Meeting A, Aula Utama..."
                                    required
                                />
                            </div>
                            <div className="form-group">
                                <label>Alamat (Opsional):</label>
                                <textarea
                                    value={lokasiAlamat}
                                    onChange={(e) => setLokasiAlamat(e.target.value)}
                                    placeholder="Alamat lengkap lokasi..."
                                    rows="3"
                                />
                            </div>
                            <div className="form-actions">
                                <button type="submit" disabled={loading} className="btn-primary">
                                    {loading ? 'Menyimpan...' : editingLokasi ? 'Perbarui' : 'Tambah'}
                                </button>
                                {editingLokasi && (
                                    <button type="button" onClick={handleCancelLokasi} className="btn-secondary">
                                        Batal
                                    </button>
                                )}
                            </div>
                        </form>
                    </div>

                    <div className="list-section">
                        <h2>Daftar Lokasi ({lokasiList.length})</h2>
                        {lokasiList.length === 0 ? (
                            <div className="empty-state">
                                <p>Belum ada lokasi. Tambahkan lokasi pertama Anda!</p>
                            </div>
                        ) : (
                            <div className="data-grid">
                                {lokasiList.map(lokasi => (
                                    <div key={lokasi.id} className="data-card">
                                        <div className="card-content">
                                            <h3>{lokasi.nama}</h3>
                                            {lokasi.alamat && (
                                                <p className="card-address">{lokasi.alamat}</p>
                                            )}
                                            <p className="card-meta">
                                                Dibuat: {new Date(lokasi.created_at).toLocaleDateString('id-ID')}
                                            </p>
                                        </div>
                                        <div className="card-actions">
                                            <button 
                                                onClick={() => handleEditLokasi(lokasi)}
                                                className="btn-edit"
                                                disabled={loading}
                                            >
                                                ✏️ Edit
                                            </button>
                                            <button 
                                                onClick={() => handleDeleteLokasi(lokasi.id)}
                                                className="btn-delete"
                                                disabled={loading}
                                            >
                                                🗑️ Hapus
                                            </button>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                </div>
            )}
        </div>
    );
}

export default ManageData;
