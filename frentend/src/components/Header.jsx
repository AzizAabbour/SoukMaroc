import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';
import { logout } from '../store/authSlice';

const Header = () => {
  const { user, token } = useSelector(s => s.auth);
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [search, setSearch] = useState('');

  const handleSearch = (e) => {
    e.preventDefault();
    if (search.trim()) navigate(`/?q=${encodeURIComponent(search.trim())}`);
  };

  const handleLogout = () => {
    dispatch(logout());
    navigate('/');
  };

  return (
    <header className="site-header">
      {/* Top bar */}
      <div className="zellige-border" />
      <div className="header-top">
        <div className="container flex-between" style={{ padding: '6px 16px' }}>
          <span className="text-sm text-muted">Livraison gratuite dès 300 MAD &nbsp;🇲🇦</span>
          <div className="flex gap-1" style={{ fontSize: 13 }}>
            {token ? (
              <>
                <span>Bonjour, <strong>{user?.name}</strong></span>
                <span>|</span>
                <button onClick={handleLogout} style={{ color: '#c0392b', background: 'none', border: 'none', cursor: 'pointer', fontSize: 13 }}>Déconnexion</button>
              </>
            ) : (
              <>
                <Link to="/login">Connexion</Link>
                <span>|</span>
                <Link to="/register">Inscription</Link>
              </>
            )}
          </div>
        </div>
      </div>

      {/* Main header row */}
      <div className="header-main">
        <div className="container flex-between gap-2" style={{ padding: '12px 16px' }}>
          {/* Logo */}
          <Link to="/" className="logo">
            <span className="logo-souk">SOUK</span>
            <span className="logo-maroc">MAROC</span>
          </Link>

          {/* Search */}
          <form className="header-search" onSubmit={handleSearch}>
            <input
              type="text"
              className="header-search__input"
              placeholder="Rechercher des produits..."
              value={search}
              onChange={e => setSearch(e.target.value)}
            />
            <button type="submit" className="header-search__btn">Chercher</button>
          </form>

          {/* Cart */}
          <Link to="/cart" className="cart-link">
            <span className="cart-icon">🛒</span>
            <span className="cart-label">Panier</span>
          </Link>
        </div>
      </div>

      {/* Nav bar */}
      <nav className="header-nav">
        <div className="container">
          <ul className="nav-list">
            <li><Link to="/">Accueil</Link></li>
            <li><Link to="/?cat=electronics">Électronique</Link></li>
            <li><Link to="/?cat=fashion">Mode</Link></li>
            <li><Link to="/?cat=home">Maison</Link></li>
            <li><Link to="/?cat=beauty">Beauté</Link></li>
            <li><Link to="/?cat=food">Alimentaire</Link></li>
            <li><Link to="/?cat=sports">Sports</Link></li>
          </ul>
        </div>
      </nav>
    </header>
  );
};

export default Header;
