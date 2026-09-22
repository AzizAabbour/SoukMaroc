import React from 'react';
import { Outlet } from 'react-router-dom';
import Header from '../components/Header';
import Footer from '../components/Footer';

const AuthLayout = () => (
  <div className="layout-main">
    <Header />
    <div className="layout-content" style={{ display: 'flex', justifyContent: 'center', alignItems: 'flex-start', padding: '48px 16px' }}>
      <Outlet />
    </div>
    <Footer />
  </div>
);

export default AuthLayout;
