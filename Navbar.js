import React from 'react';
import { Link, useLocation } from 'react-router-dom';
import './Navbar.css';

function Navbar() {
  const location = useLocation();
  
  return (
    <nav>
      <ul>
        <li><Link to="/" className={location.pathname === '/' ? 'active' : ''}>🏠 Beranda</Link></li>
        <li><Link to="/about" className={location.pathname === '/about' ? 'active' : ''}>ℹ️ Tentang</Link></li>
        <li><Link to="/jadwal" className={location.pathname === '/jadwal' ? 'active' : ''}>📅 Jadwal</Link></li>
        <li><Link to="/manage-data" className={location.pathname === '/manage-data' ? 'active' : ''}>🗂️ Kelola Data</Link></li>
        <li><Link to="/contact" className={location.pathname === '/contact' ? 'active' : ''}>📞 Kontak</Link></li>
        <li><Link to="/dashboard" className={location.pathname === '/dashboard' ? 'active' : ''}>📊 Dashboard</Link></li>
      </ul>
    </nav>
  );
}

export default Navbar;
