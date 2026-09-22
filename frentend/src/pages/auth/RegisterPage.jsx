import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useDispatch } from 'react-redux';
import { setCredentials } from '../../store/authSlice';
import api from '../../services/api';

const RegisterPage = () => {
  const dispatch  = useDispatch();
  const navigate  = useNavigate();
  const [form, setForm]   = useState({ name: '', email: '', password: '', password_confirmation: '', role: 'customer' });
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  const handleChange = e => setForm({ ...form, [e.target.name]: e.target.value });

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    if (form.password !== form.password_confirmation) { setError('Les mots de passe ne correspondent pas.'); return; }
    setLoading(true);
    try {
      const res = await api.post('/register', form);
      dispatch(setCredentials({ user: res.data.user, token: res.data.token }));
      navigate('/');
    } catch (err) {
      const msgs = err.response?.data?.errors;
      setError(msgs ? Object.values(msgs).flat().join(' ') : 'Erreur lors de l\'inscription.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="auth-card">
      <div className="zellige-border" style={{ borderRadius: '8px 8px 0 0' }} />
      <div className="auth-body">
        <h2 className="auth-title">Créer un compte</h2>
        {error && <div className="alert alert-error">{error}</div>}
        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label className="form-label">Nom complet</label>
            <input id="name" name="name" type="text" className="input" value={form.name} onChange={handleChange} required autoFocus />
          </div>
          <div className="form-group">
            <label className="form-label">Adresse e-mail</label>
            <input id="reg-email" name="email" type="email" className="input" value={form.email} onChange={handleChange} required />
          </div>
          <div className="form-group">
            <label className="form-label">Mot de passe</label>
            <input id="reg-password" name="password" type="password" className="input" value={form.password} onChange={handleChange} required />
          </div>
          <div className="form-group">
            <label className="form-label">Confirmer le mot de passe</label>
            <input id="reg-password-confirm" name="password_confirmation" type="password" className="input" value={form.password_confirmation} onChange={handleChange} required />
          </div>
          <div className="form-group">
            <label className="form-label">Vous êtes</label>
            <select id="reg-role" name="role" className="input" value={form.role} onChange={handleChange}>
              <option value="customer">Acheteur</option>
              <option value="seller">Vendeur</option>
            </select>
          </div>
          <button id="btn-register" type="submit" className="btn btn-primary btn-block mt-2" disabled={loading}>
            {loading ? 'Inscription...' : 'S\'inscrire'}
          </button>
        </form>
        <p className="mt-2 text-sm" style={{ textAlign: 'center' }}>
          Déjà un compte ? <Link to="/login" style={{ color: 'var(--color-primary)' }}>Se connecter</Link>
        </p>
      </div>
    </div>
  );
};

export default RegisterPage;
