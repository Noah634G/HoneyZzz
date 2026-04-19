function getCart() {
  return JSON.parse(localStorage.getItem('honeyzzz_cart') || '[]');
}

function updateCartCount() {
  const cart = getCart();
  const total = cart.reduce((s, item) => s + item.qty, 0);
  const badge = document.getElementById('cart-count');
  if (!badge) return;

  if (total > 0) {
    badge.textContent = total;
    badge.style.display = 'inline';
  } else {
    badge.style.display = 'none';
  }
}

let selectedFormat = { poids: 250, prix: 8.90 };

function saveCart(cart) {
  localStorage.setItem('honeyzzz_cart', JSON.stringify(cart));
  updateCartCount();
}

function selectFormat(btn, poids, prix) {
  document.querySelectorAll('.variant-btn').forEach(b => b.classList.remove('selected'));
  btn.classList.add('selected');
  selectedFormat = { poids, prix };
  const prixAffiche = document.getElementById('prix-affiche');
  if (prixAffiche) {
    prixAffiche.textContent = prix.toFixed(2).replace('.', ',') + ' €';
  }
}

function changeQty(delta) {
  const input = document.getElementById('qty');
  if (!input) return;
  let val = parseInt(input.value, 10) + delta;
  if (Number.isNaN(val) || val < 1) val = 1;
  input.value = val;
}

function addToCart() {
  const qtyInput = document.getElementById('qty');
  if (!qtyInput) return;
  const qty = parseInt(qtyInput.value, 10) || 1;
  const addButton = document.getElementById('btn-add-cart');
  const cart = getCart();

  let product = null;
  if (addButton && addButton.dataset.productId) {
    product = {
      id: addButton.dataset.productId,
      nom: addButton.dataset.productName || 'Produit HoneyZzz',
      prix: Number(addButton.dataset.productPrice) || 0,
      img: addButton.dataset.productImg || '',
    };
  } else if (selectedFormat) {
    product = {
      id: 'miel-' + selectedFormat.poids,
      nom: `Miel Toutes Fleurs ${selectedFormat.poids}g`,
      prix: selectedFormat.prix,
      img: 'imagemiel1.jpg',
    };
  }

  if (!product) return;

  const idx = cart.findIndex(item => item.id === product.id);
  if (idx >= 0) {
    cart[idx].qty += qty;
  } else {
    cart.push({ ...product, qty });
  }

  saveCart(cart);
  const feedback = document.getElementById('feedback');
  if (feedback) {
    feedback.textContent = '✓ Ajouté au panier !';
    setTimeout(() => { feedback.textContent = ''; }, 2500);
  }
}

function filtrerProduits() {
  const query = document.getElementById('search-input').value.toLowerCase().trim();
  document.querySelectorAll('#products-grid .card').forEach(card => {
    const label = card.querySelector('.card-label').textContent.toLowerCase();
    card.style.display = label.includes(query) ? '' : 'none';
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('search-input');
  if (searchInput) {
    searchInput.addEventListener('input', filtrerProduits);
  }

  const cartButton = document.getElementById('btn-panier');
  if (cartButton) {
    cartButton.addEventListener('click', () => {
      window.location.href = 'panier.html';
    });
  }

  document.querySelectorAll('.variant-btn').forEach(btn => {
    const poids = Number(btn.dataset.poids);
    const prix = Number(btn.dataset.prix);
    if (!Number.isNaN(poids) && !Number.isNaN(prix)) {
      btn.addEventListener('click', () => selectFormat(btn, poids, prix));
    }
  });

  document.querySelectorAll('.qty-btn').forEach(btn => {
    const delta = Number(btn.dataset.qty);
    if (!Number.isNaN(delta)) {
      btn.addEventListener('click', () => changeQty(delta));
    }
  });

  const addCartBtn = document.getElementById('btn-add-cart');
  if (addCartBtn) {
    addCartBtn.addEventListener('click', addToCart);
  }

  updateCartCount();
});

// Fonctions pour le panier
function render() {
  const cart = getCart();
  const container = document.getElementById('cart-container');
  if (!container) return;

  const badge = document.getElementById('cart-count');
  const totalQty = cart.reduce((s, i) => s + i.qty, 0);
  if (totalQty > 0) { badge.textContent = totalQty; badge.style.display = 'inline'; }
  else badge.style.display = 'none';

  if (cart.length === 0) {
    container.innerHTML = `<div class="panier-vide">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
        <line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/>
      </svg>
      <p>Votre panier est vide.</p>
      <a href="boutique.html">Découvrir nos produits →</a>
    </div>`;
    const sousTotalEl = document.getElementById('sous-total');
    const livraisonEl = document.getElementById('livraison');
    const totalEl = document.getElementById('total');
    if (sousTotalEl) sousTotalEl.textContent = '0,00 €';
    if (livraisonEl) livraisonEl.textContent = '—';
    if (totalEl) totalEl.textContent = '0,00 €';
    return;
  }

  let html = '<div class="cart-items">';
  let sousTotal = 0;
  cart.forEach((item, idx) => {
    const itemTotal = item.prix * item.qty;
    sousTotal += itemTotal;
    html += `<div class="cart-item">
      <img class="cart-item-img" src="${item.img}" alt="${item.nom}">
      <div class="cart-item-infos">
        <div class="cart-item-nom">${item.nom}</div>
        <div class="cart-item-prix">${item.prix.toFixed(2).replace('.',',')} € / unité</div>
        <div class="cart-item-controls">
          <div class="qty-controls-sm">
            <button class="qty-btn-sm" data-idx="${idx}" data-delta="-1">−</button>
            <span class="qty-val">${item.qty}</span>
            <button class="qty-btn-sm" data-idx="${idx}" data-delta="1">+</button>
          </div>
          <button class="btn-suppr" data-idx="${idx}">✕ Supprimer</button>
        </div>
      </div>
      <div class="cart-item-total">${itemTotal.toFixed(2).replace('.',',')} €</div>
    </div>`;
  });
  html += '</div>';
  container.innerHTML = html;

  const livraison = sousTotal > 0 ? 5.90 : 0;
  const total = sousTotal + livraison;
  const sousTotalEl = document.getElementById('sous-total');
  const livraisonEl = document.getElementById('livraison');
  const totalEl = document.getElementById('total');
  if (sousTotalEl) sousTotalEl.textContent = sousTotal.toFixed(2).replace('.',',') + ' €';
  if (livraisonEl) livraisonEl.textContent = livraison.toFixed(2).replace('.',',') + ' €';
  if (totalEl) totalEl.textContent = total.toFixed(2).replace('.',',') + ' €';
}

function updateQty(idx, delta) {
  const cart = getCart();
  cart[idx].qty += delta;
  if (cart[idx].qty <= 0) cart.splice(idx, 1);
  saveCart(cart);
  render();
}

function removeItem(idx) {
  const cart = getCart();
  cart.splice(idx, 1);
  saveCart(cart);
  render();
}

function viderPanier() {
  if (confirm('Vider le panier ?')) { localStorage.removeItem('honeyzzz_cart'); render(); }
}

function commander() {
  const cart = getCart();
  if (cart.length === 0) return alert('Votre panier est vide.');
  // Vérification de connexion
  // Pour simplifier, on peut utiliser une variable globale ou localStorage pour la session
  // Ici, on suppose qu'il y a une session PHP, mais pour JS, on peut rediriger vers connexion si pas connecté
  // Pour l'instant, on ajoute une vérification simple : si pas de session, rediriger
  // En réalité, il faudrait vérifier avec PHP, mais pour demo, on peut utiliser localStorage
  const isLoggedIn = localStorage.getItem('honeyzzz_logged_in') === 'true';
  if (!isLoggedIn) {
    alert('Veuillez vous connecter pour passer commande.');
    window.location.href = 'connexion.html';
    return;
  }
  alert('Commande passée ! Merci 🐝\n(Fonctionnalité de paiement à intégrer)');
}

document.addEventListener('DOMContentLoaded', () => {
  // ... existing code ...

  // Event listeners pour le panier
  const btnCommander = document.getElementById('btn-commander');
  if (btnCommander) {
    btnCommander.addEventListener('click', commander);
  }

  const btnVider = document.getElementById('btn-vider');
  if (btnVider) {
    btnVider.addEventListener('click', viderPanier);
  }

  // Event listeners pour les boutons dans le panier (délégation)
  document.addEventListener('click', (e) => {
    if (e.target.classList.contains('qty-btn-sm')) {
      const idx = Number(e.target.dataset.idx);
      const delta = Number(e.target.dataset.delta);
      if (!Number.isNaN(idx) && !Number.isNaN(delta)) {
        updateQty(idx, delta);
      }
    } else if (e.target.classList.contains('btn-suppr')) {
      const idx = Number(e.target.dataset.idx);
      if (!Number.isNaN(idx)) {
        removeItem(idx);
      }
    }
  });

  // Render le panier si on est sur la page panier
  if (document.getElementById('cart-container')) {
    render();
  }
});
