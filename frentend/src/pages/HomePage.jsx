import React, { useEffect, useState } from 'react';
import { useSearchParams } from 'react-router-dom';
import ProductCard from '../components/ProductCard';
import api from '../services/api';

const CATEGORIES = [
  { label: 'Tous', value: '' },
  { label: 'Électronique', value: 'electronics' },
  { label: 'Mode', value: 'fashion' },
  { label: 'Maison', value: 'home' },
  { label: 'Beauté', value: 'beauty' },
  { label: 'Alimentaire', value: 'food' },
  { label: 'Sports', value: 'sports' },
];

const HomePage = () => {
  const [searchParams] = useSearchParams();
  const query = searchParams.get('q') || '';
  const cat   = searchParams.get('cat') || '';

  const [products, setProducts] = useState([]);
  const [loading,  setLoading]  = useState(true);
  const [error,    setError]    = useState(null);

  useEffect(() => {
    setLoading(true);
    const params = {};
    if (query) params.search   = query;
    if (cat)   params.category = cat;

    api.get('/products', { params })
      .then(r => setProducts(r.data.data || r.data))
      .catch(() => setError('Impossible de charger les produits.'))
      .finally(() => setLoading(false));
  }, [query, cat]);

  return (
    <>
      {/* Hero banner */}
      <section className="hero-banner">
        <div className="hero-inner">
          <h2 className="hero-title">Bienvenue sur Souk Maroc 🇲🇦</h2>
          <p className="hero-sub">Des milliers de produits livrés partout au Maroc</p>
        </div>
      </section>

      {/* Category quick-links */}
      <div className="cat-strip">
        {CATEGORIES.map(c => (
          <a key={c.value} href={c.value ? `/?cat=${c.value}` : '/'} className={`cat-chip ${cat === c.value ? 'active' : ''}`}>
            {c.label}
          </a>
        ))}
      </div>

      {/* Results header */}
      {(query || cat) && (
        <p className="text-muted mb-2" style={{ marginTop: 8 }}>
          {query && <>Résultats pour "<strong>{query}</strong>"&nbsp;</>}
          {cat && <>— Catégorie : <strong>{cat}</strong></>}
        </p>
      )}

      {/* Product grid */}
      {loading && <p className="text-muted" style={{ textAlign: 'center', padding: 40 }}>Chargement...</p>}
      {error   && <div className="alert alert-error">{error}</div>}
      {!loading && !error && (
        products.length > 0
          ? <div className="product-grid">{products.map(p => <ProductCard key={p.id} product={p} />)}</div>
          : <p className="text-muted" style={{ textAlign: 'center', padding: 40 }}>Aucun produit trouvé.</p>
      )}
    </>
  );
};

export default HomePage;
