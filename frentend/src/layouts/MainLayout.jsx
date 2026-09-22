import React from 'react';
import { Outlet } from 'react-router-dom';
import Header from '../components/Header';
import Footer from '../components/Footer';

const MainLayout = () => (
  <div className="layout-main">
    <Header />
    <div className="layout-content">
      <div className="container" style={{ padding: '24px 16px' }}>
        <Outlet />
      </div>
    </div>
    <Footer />
  </div>
);

export default MainLayout;
