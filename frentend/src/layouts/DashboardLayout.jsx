import React from 'react';
import { Outlet, NavLink } from 'react-router-dom';
import Header from '../components/Header';
import Footer from '../components/Footer';

const DashboardLayout = () => (
  <div className="layout-main">
    <Header />
    <div className="layout-content" style={{ display: 'flex', minHeight: 'calc(100vh - 200px)' }}>
      <aside className="dashboard-sidebar">
        <ul className="dashboard-nav">
          <li><NavLink to="/seller" end>Tableau de bord</NavLink></li>
          <li><NavLink to="/seller/products">Mes produits</NavLink></li>
          <li><NavLink to="/seller/orders">Commandes</NavLink></li>
          <li><NavLink to="/seller/profile">Profil</NavLink></li>
        </ul>
      </aside>
      <main className="dashboard-main">
        <Outlet />
      </main>
    </div>
    <Footer />
  </div>
);

export default DashboardLayout;
