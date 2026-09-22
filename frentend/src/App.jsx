import React from 'react';
import { Routes, Route, Navigate } from 'react-router-dom';
import MainLayout from './layouts/MainLayout';
import AuthLayout from './layouts/AuthLayout';
import DashboardLayout from './layouts/DashboardLayout';
import HomePage from './pages/HomePage';
import LoginPage from './pages/auth/LoginPage';
import RegisterPage from './pages/auth/RegisterPage';
import ProductDetailPage from './pages/ProductDetailPage';
import CartPage from './pages/CartPage';
import CheckoutPage from './pages/CheckoutPage';
import { useSelector } from 'react-redux';

const App = () => {
  const { token } = useSelector(state => state.auth);
  const ProtectedRoute = ({ children }) => (token ? children : <Navigate to="/login" replace />);

  return (
    <Routes>
      <Route element={<MainLayout />}>
        <Route path="/" element={<HomePage />} />
        <Route path="/product/:slug" element={<ProductDetailPage />} />
        <Route path="/cart" element={<CartPage />} />
        <Route path="/checkout" element={<ProtectedRoute><CheckoutPage /></ProtectedRoute>} />
      </Route>

      <Route element={<AuthLayout />}>
        <Route path="/login" element={<LoginPage />} />
        <Route path="/register" element={<RegisterPage />} />
      </Route>

      {/* Admin & Seller dashboards would be added under /admin and /seller with DashboardLayout */}
    </Routes>
  );
};

export default App;
