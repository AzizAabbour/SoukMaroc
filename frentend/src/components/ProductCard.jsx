import React from 'react';
import { Link } from 'react-router-dom';

const ProductCard = ({ product }) => {
  const { name, slug, price, images, discount_price } = product;
  const thumb = images?.[0]?.url || 'https://placehold.co/220x220?text=Produit';
  const finalPrice = discount_price || price;
  const hasDiscount = discount_price && discount_price < price;

  return (
    <Link to={`/product/${slug}`} className="product-card">
      <div className="product-card__img-wrap">
        <img src={thumb} alt={name} className="product-card__img" loading="lazy" />
        {hasDiscount && (
          <span className="product-card__badge">
            -{Math.round((1 - discount_price / price) * 100)}%
          </span>
        )}
      </div>
      <div className="product-card__body">
        <p className="product-card__name">{name}</p>
        <div className="product-card__prices">
          <span className="product-card__price">{Number(finalPrice).toFixed(2)} MAD</span>
          {hasDiscount && (
            <span className="product-card__old-price">{Number(price).toFixed(2)} MAD</span>
          )}
        </div>
      </div>
    </Link>
  );
};

export default ProductCard;
