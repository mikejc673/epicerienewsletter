// script.js
document.addEventListener('DOMContentLoaded', function(){
  // mobile nav
  const navToggle = document.getElementById('nav-toggle');
  const navList = document.getElementById('nav-list');
  navToggle && navToggle.addEventListener('click', () => {
    const open = navList.style.display === 'block';
    navList.style.display = open ? '' : 'block';
    navToggle.setAttribute('aria-expanded', String(!open));
  });

  // Product modal
  const modal = document.getElementById('product-modal');
  const modalContent = document.getElementById('modal-content');
  const modalClose = document.getElementById('modal-close');

  function openProductModal(id){
    const prod = (window.__products || []).find(p => p.id == id);
    if(!prod) return;
    modalContent.innerHTML = `
      <div style="display:flex;gap:1rem;flex-wrap:wrap">
        <div style="flex:1 1 240px"><img src="${prod.image}" alt="${prod.name}" style="width:100%;height:auto;border-radius:8px"></div>
        <div style="flex:1 1 240px">
          <h2 id="modal-title">${prod.name}</h2>
          <p>${prod.description}</p>
          <p><strong>${prod.price.toFixed(2).replace('.',',')}€</strong> ${prod.old_price>0?'<span style="text-decoration:line-through;margin-left:.5rem">'+prod.old_price.toFixed(2).replace('.',',')+'€</span>':''}</p>
          <a href="#newsletter" class="btn btn-primary">Réserver / S'inscrire</a>
        </div>
      </div>
    `;
    modal.setAttribute('aria-hidden','false');
    document.body.style.overflow = 'hidden';
  }

  document.querySelectorAll('.view-more').forEach(btn => {
    btn.addEventListener('click', e => openProductModal(e.currentTarget.dataset.id));
  });

  modalClose && modalClose.addEventListener('click', () => {
    modal.setAttribute('aria-hidden','true');
    document.body.style.overflow = '';
  });
  modal.addEventListener('click', (e) => {
    if(e.target === modal){
      modal.setAttribute('aria-hidden','true');
      document.body.style.overflow = '';
    }
  });

  // Newsletter AJAX
  const form = document.getElementById('newsletter-form');
  const msg = document.getElementById('news-msg');
  if(form){
    form.addEventListener('submit', function(e){
      e.preventDefault();
      msg.textContent = 'Envoi...';
      const data = new FormData(form);
      fetch(form.action, { method:'POST', body: data })
        .then(r => r.json())
        .then(json => {
          if(json.success){
            msg.textContent = 'Merci ! Vous êtes inscrit.';
            form.reset();
          } else {
            msg.textContent = json.error || 'Une erreur est survenue.';
          }
        })
        .catch(() => { msg.textContent = 'Erreur réseau.' });
    });
  }
});