import React, { useEffect, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import api from '../services/api';

const CartPage = () => {
  const navigate = useNavigate();
  const [cart,    setCart]    = useState([]);
  const [loading, setLoading] = useState(true);
  const [error,   setError]   = useState('');

  const fetchCart = () => {
    setLoading(true);
    api.get('/cart')
      .then(r => setCart(r.data.items || r.data || []))
      .catch(e => {
        if (e.response?.status === 401) navigate('/login');
        else setError('Impossible de charger le panier.');
      })
      .finally(() => setLoading(false));
  };

  useEffect(() => { fetchCart(); }, []);

  const removeItem = (id) => {
    api.delete(`/cart/remove/${id}`).then(fetchCart).catch(() => {});
  };

  const updateQty = (id, qty) => {
    if (qty < 1) return;
    api.put(`/cart/update/${id}`, { quantity: qty }).then(fetchCart).catch(() => {});
  };

  const total = cart.reduce((sum, item) => sum + (item.price || 0) * (item.quantity || 1), 0);

  if (loading) return <p className="text-muted" style={{ padding: 40, textAlign: 'center' }}>Chargement...</p>;
  if (error)   return <div className="alert alert-error">{error}</div>;

  return (
    <>
      <h2 className="section-title">Mon panier</h2>
      {cart.length === 0 ? (
        <div style={{ textAlign: 'center', padding: 60 }}>
          <p className="text-muted mb-2">Votre panier est vide.</p>
          <Link to="/" className="btn btn-primary">Continuer vos achats</Link>
        </div>
      ) : (
        <div className="cart-layout">
          <div className="cart-items">
            {cart.map(item => (
              <div key={item.id} className="cart-item">
                <img src={item.image || 'https://placehold.co/80x80?text=P'} alt={item.name} className="cart-item__img" />
                <div className="cart-item__info">
                  <Link to={`/product/${item.slug}`} className="cart-item__name">{item.name}</Link>
                  <p className="cart-item__price">{Number(item.price).toFixed(2)} MAD</p>
                </div>
                <div className="qty-row">
                  <button className="qty-btn" onClick={() => updateQty(item.id, item.quantity - 1)}>−</button>
                  <span className="qty-val">{item.quantity}</span>
                  <button className="qty-btn" onClick={() => updateQty(item.id, item.quantity + 1)}>+</button>
                </div>
                <button className="cart-item__remove" onClick={() => removeItem(item.id)}>✕</button>
              </div>
            ))}
          </div>
          <div className="cart-summary card">
            <h3 className="section-title">Récapitulatif</h3>
            <div className="flex-between mb-1">
              <span>Sous-total</span><span><strong>{total.toFixed(2)} MAD</strong></span>
            </div>
            <div className="flex-between mb-2">
              <span>Livraison</span><span className="text-muted">Gratuite</span>
            </div>
            <hr className="zellige-divider" />
            <div className="flex-between mb-2">
              <span><strong>Total</strong></span><span><strong>{total.toFixed(2)} MAD</strong></span>
            </div>
            <Link id="btn-checkout" to="/checkout" className="btn btn-primary btn-block">Commander</Link>
          </div>
        </div>
      )}
    </>
  );
};

export default CartPage;
