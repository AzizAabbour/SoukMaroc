import React from 'react';
import { Link } from 'react-router-dom';

const OrderSuccessPage = () => (
  <div style={{ textAlign: 'center', padding: '80px 16px' }}>
    <div style={{ fontSize: 64 }}>✅</div>
    <h2 style={{ fontSize: 28, fontWeight: 700, marginTop: 16 }}>Commande confirmée !</h2>
    <p className="text-muted mt-1">Merci pour votre achat. Vous recevrez une confirmation bientôt.</p>
    <Link to="/" className="btn btn-primary mt-3" style={{ display: 'inline-block' }}>Retour à l'accueil</Link>
  </div>
);

export default OrderSuccessPage;
