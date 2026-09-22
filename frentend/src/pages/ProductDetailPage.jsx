import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import api from '../services/api';

const ProductDetailPage = () => {
  const { slug } = useParams();
  const navigate = useNavigate();
  const [product, setProduct] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error,   setError]   = useState('');
  const [qty,     setQty]     = useState(1);
  const [adding,  setAdding]  = useState(false);
  const [msg,     setMsg]     = useState('');

  useEffect(() => {
    api.get(`/products/${slug}`)
      .then(r => setProduct(r.data))
      .catch(() => setError('Produit introuvable.'))
      .finally(() => setLoading(false));
  }, [slug]);

  const addToCart = async () => {
    setAdding(true);
    try {
      await api.post('/cart/add', { product_id: product.id, quantity: qty });
      setMsg('Produit ajouté au panier !');
    } catch (e) {
      if (e.response?.status === 401) navigate('/login');
      else setMsg('Erreur lors de l\'ajout.');
    } finally {
      setAdding(false);
      setTimeout(() => setMsg(''), 3000);
    }
  };

  if (loading) return <p className="text-muted" style={{ padding: 40, textAlign: 'center' }}>Chargement...</p>;
  if (error)   return <div className="alert alert-error">{error}</div>;
  if (!product) return null;

  const { name, description, price, discount_price, images, stock } = product;
  const finalPrice = discount_price || price;
  const hasDiscount = discount_price && discount_price < price;
  const thumb = images?.[0]?.url || 'https://placehold.co/500x500?text=Produit';

  return (
    <div className="product-detail">
      <div className="product-detail__gallery">
        <img src={thumb} alt={name} className="product-detail__main-img" />
      </div>
      <div className="product-detail__info">
        <h1 className="product-detail__name">{name}</h1>
        <div className="product-detail__price-row">
          <span className="product-detail__price">{Number(finalPrice).toFixed(2)} MAD</span>
          {hasDiscount && (
            <span className="product-detail__old-price">{Number(price).toFixed(2)} MAD</span>
          )}
        </div>
        <p className="product-detail__stock">
          {stock > 0 ? <span className="text-success">✓ En stock ({stock})</span> : <span className="text-danger">Rupture de stock</span>}
        </p>
        <p className="product-detail__desc">{description}</p>

        <div className="product-detail__actions">
          <label className="form-label">Quantité</label>
          <div className="qty-row">
            <button className="qty-btn" onClick={() => setQty(q => Math.max(1, q - 1))}>−</button>
            <span className="qty-val">{qty}</span>
            <button className="qty-btn" onClick={() => setQty(q => Math.min(stock, q + 1))}>+</button>
          </div>
          <button id="btn-add-cart" className="btn btn-primary" onClick={addToCart} disabled={adding || stock < 1} style={{ marginTop: 16 }}>
            {adding ? 'Ajout...' : '🛒 Ajouter au panier'}
          </button>
          {msg && <div className="alert alert-success mt-1">{msg}</div>}
        </div>
      </div>
    </div>
  );
};

export default ProductDetailPage;
