import React from 'react';
import './Footer.css';

function Footer() {
    return (
        <footer className="app-footer">
            <div className="footer-content">
                <div className="footer-section">
                    <h3>📅 Penjadwalan App</h3>
                    <p>Aplikasi manajemen jadwal yang mudah dan efisien untuk membantu Anda mengorganisir kegiatan sehari-hari.</p>
                </div>
                
                <div className="footer-section">
                    <h4>Fitur Utama</h4>
                    <ul>
                        <li>✅ Manajemen Jadwal</li>
                        <li>🏷️ Kategori Kegiatan</li>
                        <li>📍 Lokasi Kegiatan</li>
                        <li>📊 Export Data</li>
                        <li>🔍 Pencarian & Filter</li>
                    </ul>
                </div>
                
                <div className="footer-section">
                    <h4>Teknologi</h4>
                    <ul>
                        <li>⚛️ React.js</li>
                        <li>🐘 PHP</li>
                        <li>🗄️ MySQL</li>
                        <li>🎨 CSS3</li>
                        <li>📱 Responsive Design</li>
                    </ul>
                </div>
            </div>
            
            <div className="footer-bottom">
                <p>&copy; 2025 Penjadwalan App - Project Based Test</p>
                <p>Developed by: <strong>Tio Afriza & Yales Vepa</strong> | Mata Kuliah: <strong>Pemrograman Web</strong></p>
            </div>
        </footer>
    );
}

export default Footer;
