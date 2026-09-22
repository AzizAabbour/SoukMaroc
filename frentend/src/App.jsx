import React from 'react';
import { Routes, Route, Navigate } from 'react-router-dom';
import { useSelector } from 'react-redux';

import MainLayout      from './layouts/MainLayout';
import AuthLayout      from './layouts/AuthLayout';
import DashboardLayout from './layouts/DashboardLayout';

import HomePage         from './pages/HomePage';
import ProductDetailPage from './pages/ProductDetailPage';
import CartPage         from './pages/CartPage';
import CheckoutPage     from './pages/CheckoutPage';
import OrderSuccessPage from './pages/OrderSuccessPage';
import LoginPage        from './pages/auth/LoginPage';
import RegisterPage     from './pages/auth/RegisterPage';

const PrivateRoute = ({ children }) => {
  const { token } = useSelector(s => s.auth);
  return token ? children : <Navigate to="/login" replace />;
};

const App = () => (
  <Routes>
    {/* Public pages */}
    <Route element={<MainLayout />}>
      <Route path="/"               element={<HomePage />} />
      <Route path="/product/:slug"  element={<ProductDetailPage />} />
      <Route path="/cart"           element={<CartPage />} />
      <Route path="/order-success"  element={<OrderSuccessPage />} />
      <Route path="/checkout"       element={<PrivateRoute><CheckoutPage /></PrivateRoute>} />
    </Route>

    {/* Auth pages */}
    <Route element={<AuthLayout />}>
      <Route path="/login"    element={<LoginPage />} />
      <Route path="/register" element={<RegisterPage />} />
    </Route>

    {/* Seller dashboard (placeholder) */}
    <Route element={<PrivateRoute><DashboardLayout /></PrivateRoute>}>
      <Route path="/seller"          element={<div style={{padding:40}}><h2>Tableau de bord vendeur</h2></div>} />
      <Route path="/seller/products" element={<div style={{padding:40}}><h2>Mes produits</h2></div>} />
      <Route path="/seller/orders"   element={<div style={{padding:40}}><h2>Commandes reçues</h2></div>} />
      <Route path="/seller/profile"  element={<div style={{padding:40}}><h2>Mon profil</h2></div>} />
    </Route>

    {/* 404 */}
    <Route path="*" element={<Navigate to="/" replace />} />
  </Routes>
);

export default App;
