import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../services/api';

const CheckoutPage = () => {
  const navigate = useNavigate();
  const [form, setForm] = useState({
    full_name: '', phone: '', address: '', city: '', notes: '',
  });
  const [loading, setLoading] = useState(false);
  const [error,   setError]   = useState('');

  const handleChange = e => setForm({ ...form, [e.target.name]: e.target.value });

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    try {
      await api.post('/orders', form);
      navigate('/order-success');
    } catch (err) {
      setError(err.response?.data?.message || 'Erreur lors de la commande.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <>
      <h2 className="section-title">Finaliser la commande</h2>
      {error && <div className="alert alert-error">{error}</div>}
      <div className="checkout-layout">
        <form className="checkout-form card" onSubmit={handleSubmit}>
          <h3 style={{ marginBottom: 16, fontWeight: 700 }}>Informations de livraison</h3>
          <div className="form-group">
            <label className="form-label">Nom complet</label>
            <input id="checkout-name" name="full_name" type="text" className="input" value={form.full_name} onChange={handleChange} required />
          </div>
          <div className="form-group">
            <label className="form-label">Téléphone</label>
            <input id="checkout-phone" name="phone" type="tel" className="input" value={form.phone} onChange={handleChange} required />
          </div>
          <div className="form-group">
            <label className="form-label">Adresse</label>
            <input id="checkout-address" name="address" type="text" className="input" value={form.address} onChange={handleChange} required />
          </div>
          <div className="form-group">
            <label className="form-label">Ville</label>
            <input id="checkout-city" name="city" type="text" className="input" value={form.city} onChange={handleChange} required />
          </div>
          <div className="form-group">
            <label className="form-label">Notes (optionnel)</label>
            <textarea id="checkout-notes" name="notes" className="input" rows="3" value={form.notes} onChange={handleChange} />
          </div>
          <div className="form-group">
            <label className="form-label">Paiement</label>
            <div className="payment-option">
              <input type="radio" id="cod" name="payment" value="cod" defaultChecked />
              <label htmlFor="cod">💵 Paiement à la livraison</label>
            </div>
          </div>
          <button id="btn-place-order" type="submit" className="btn btn-primary btn-block mt-2" disabled={loading}>
            {loading ? 'Envoi...' : 'Confirmer la commande'}
          </button>
        </form>
      </div>
    </>
  );
};

export default CheckoutPage;
