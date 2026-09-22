import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useDispatch } from 'react-redux';
import { setCredentials } from '../../store/authSlice';
import api from '../../services/api';

const LoginPage = () => {
  const dispatch  = useDispatch();
  const navigate  = useNavigate();
  const [form, setForm]   = useState({ email: '', password: '' });
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  const handleChange = e => setForm({ ...form, [e.target.name]: e.target.value });

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);
    try {
      const res = await api.post('/login', form);
      dispatch(setCredentials({ user: res.data.user, token: res.data.token }));
      navigate('/');
    } catch (err) {
      setError(err.response?.data?.message || 'Identifiants incorrects.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="auth-card">
      <div className="zellige-border" style={{ borderRadius: '8px 8px 0 0' }} />
      <div className="auth-body">
        <h2 className="auth-title">Connexion</h2>
        {error && <div className="alert alert-error">{error}</div>}
        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label className="form-label">Adresse e-mail</label>
            <input id="email" name="email" type="email" className="input" value={form.email} onChange={handleChange} required autoFocus />
          </div>
          <div className="form-group">
            <label className="form-label">Mot de passe</label>
            <input id="password" name="password" type="password" className="input" value={form.password} onChange={handleChange} required />
          </div>
          <button id="btn-login" type="submit" className="btn btn-primary btn-block mt-2" disabled={loading}>
            {loading ? 'Connexion...' : 'Se connecter'}
          </button>
        </form>
        <p className="mt-2 text-sm" style={{ textAlign: 'center' }}>
          Pas encore de compte ? <Link to="/register" style={{ color: 'var(--color-primary)' }}>S'inscrire</Link>
        </p>
      </div>
    </div>
  );
};

export default LoginPage;
