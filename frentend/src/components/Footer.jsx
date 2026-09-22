import React from 'react';
import { Link } from 'react-router-dom';

const Footer = () => (
  <footer className="site-footer">
    <div className="zellige-border" />
    <div className="footer-body">
      <div className="container" style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: 32, padding: '40px 16px 24px' }}>
        <div>
          <h4 className="footer-heading">SOUK MAROC</h4>
          <p className="text-sm" style={{ marginTop: 8, lineHeight: 1.7, color: '#ccc' }}>Le marché en ligne du Maroc. Achetez et vendez facilement des milliers de produits locaux.</p>
        </div>
        <div>
          <h4 className="footer-heading">Liens rapides</h4>
          <ul className="footer-links">
            <li><Link to="/">Accueil</Link></li>
            <li><Link to="/cart">Panier</Link></li>
            <li><Link to="/login">Connexion</Link></li>
            <li><Link to="/register">Inscription</Link></li>
          </ul>
        </div>
        <div>
          <h4 className="footer-heading">Aide &amp; Support</h4>
          <ul className="footer-links">
            <li><a href="#">Comment commander?</a></li>
            <li><a href="#">Politique de retour</a></li>
            <li><a href="#">Livraison</a></li>
            <li><a href="#">Contactez-nous</a></li>
          </ul>
        </div>
        <div>
          <h4 className="footer-heading">Vendre sur Souk Maroc</h4>
          <ul className="footer-links">
            <li><Link to="/register">Devenir vendeur</Link></li>
            <li><a href="#">Guide du vendeur</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div className="footer-bottom">
      <div className="container flex-between" style={{ padding: '12px 16px', flexWrap: 'wrap', gap: 8 }}>
        <span>© 2024 Souk Maroc. Tous droits réservés.</span>
        <span>🇲🇦 Made in Morocco</span>
      </div>
    </div>
  </footer>
);

export default Footer;
