const sectionView = document.getElementById('sectionView');
const homeSections = [...document.querySelectorAll('.hero, .mainGrid, .journey, .footer')];
const apiUrl = 'api.php';

const guides = [
  { title: 'Choose the right body type', text: 'Compare SUVs, sedans and hatchbacks against the way you drive.', image: 'assets/learn_types.jpg' },
  { title: 'Understand car features', text: 'A plain-language guide to safety, comfort and driver-assistance features.', image: 'assets/learn_features.jpg' },
  { title: 'Engines and fuel choices', text: 'Learn how petrol, diesel and electric powertrains differ.', image: 'assets/learn_engine.jpg' },
  { title: 'Plan your first purchase', text: 'Work through the checks that make buying a car less complicated.', image: 'assets/learn_buy.jpg' },
  { title: 'Compare before you decide', text: 'Use price, year, category and features to narrow down your shortlist.', image: 'assets/knowledge_compare.jpg' },
  { title: 'Keep your car in good shape', text: 'A few practical maintenance habits can make ownership easier.', image: 'assets/knowledge_maintenance.jpg' }
];

function escapeHtml(value) {
  return String(value ?? '').replace(/[&<>"']/g, character => ({
    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
  })[character]);
}

function pageFrame(eyebrow, title, description, content) {
  return `<div class="page-shell"><header class="page-heading"><span class="page-eyebrow">${eyebrow}</span><h1>${title}</h1><p>${description}</p></header>${content}</div>`;
}

async function fetchResource(resource, params = {}) {
  const query = new URLSearchParams({ resource, ...params });
  const response = await fetch(`${apiUrl}?${query}`);
  const payload = await response.json();
  if (!response.ok) throw new Error(payload.error || 'The requested data could not be loaded.');
  return payload;
}

function setError(error) {
  sectionView.insertAdjacentHTML('beforeend', `<p class="error-state">${escapeHtml(error.message)} Check that PHP is enabled and the MySQL connection settings are configured for <strong>api.php</strong>.</p>`);
}

function carImage(brand) {
  const key = String(brand || '').toLowerCase();
  if (key.includes('bmw')) return 'assets/top_bmw.jpg';
  if (key.includes('mercedes')) return 'assets/top_mercedes.jpg';
  if (key.includes('audi')) return 'assets/top_audi.jpg';
  if (key.includes('toyota')) return 'assets/top_toyota.jpg';
  return 'assets/hero.jpg';
}

function renderCarCards(cars) {
  if (!cars.length) return '<p class="empty-state">No cars match these filters. Try a different search.</p>';
  return `<div class="dynamic-grid">${cars.map(car => `<article class="dynamic-card">
    <img src="${carImage(car.brand)}" alt="${escapeHtml(car.name)}" loading="lazy">
    <div class="dynamic-card-body"><h2>${escapeHtml(car.name)}</h2>
      <p>${escapeHtml(car.brand)}${car.model ? ` · ${escapeHtml(car.model)}` : ''}${car.category ? ` · ${escapeHtml(car.category)}` : ''}</p>
      <div class="price">${car.price == null ? 'Price on request' : `₹${Number(car.price).toLocaleString('en-IN')}`}</div>
      <p>${escapeHtml(car.year || 'Year unavailable')} · ${escapeHtml(car.mileage || 'Mileage unavailable')}</p>
      <p>${escapeHtml(car.features || 'Contact us for vehicle details')}</p>
    </div></article>`).join('')}</div>`;
}

async function showBrowse(filters = {}) {
  sectionView.innerHTML = pageFrame('Inventory', 'Browse cars', 'Search the current SS Cars inventory by model, brand, body type or price.', `
    <form class="page-toolbar" id="carFilters">
      <label>Search<input name="query" placeholder="Model or feature"></label>
      <label>Brand<select name="brand"><option value="">All brands</option></select></label>
      <label>Body type<select name="category"><option value="">All body types</option></select></label>
      <label>Maximum price<input name="max_price" type="number" min="0" placeholder="No limit"></label>
      <button type="submit">Find cars</button>
    </form><p class="page-meta" id="carCount">Loading inventory...</p><div id="carResults"></div>`);

  const form = document.getElementById('carFilters');
  const results = document.getElementById('carResults');
  const count = document.getElementById('carCount');
  try {
    const [brands, categories] = await Promise.all([fetchResource('brands'), fetchResource('categories')]);
    form.elements.brand.innerHTML += brands.map(item => `<option value="${escapeHtml(item.name)}">${escapeHtml(item.name)} (${item.car_count})</option>`).join('');
    form.elements.category.innerHTML += categories.map(item => `<option value="${escapeHtml(item.name)}">${escapeHtml(item.name)}</option>`).join('');
    form.elements.query.value = filters.query || '';
    form.elements.brand.value = filters.brand || '';
    form.elements.category.value = filters.category || '';
    form.elements.max_price.value = filters.max_price || '';

    const loadCars = async () => {
      const params = Object.fromEntries(new FormData(form).entries());
      const cars = await fetchResource('cars', Object.fromEntries(Object.entries(params).filter(([, value]) => value)));
      count.textContent = `${cars.length} car${cars.length === 1 ? '' : 's'} found`;
      results.innerHTML = renderCarCards(cars);
    };
    form.addEventListener('submit', async event => {
      event.preventDefault();
      count.textContent = 'Updating inventory...';
      try { await loadCars(); } catch (error) { results.innerHTML = `<p class="error-state">${escapeHtml(error.message)}</p>`; }
    });
    await loadCars();
  } catch (error) { setError(error); }
}

async function showBrands() {
  sectionView.innerHTML = pageFrame('Makes', 'Explore brands', 'See the makes represented in the current vehicle inventory.', '<p class="page-meta">Loading brands...</p><div class="dynamic-grid" id="brandResults"></div>');
  try {
    const brands = await fetchResource('brands');
    const target = document.getElementById('brandResults');
    target.innerHTML = brands.length ? brands.map(brand => `<button class="dynamic-card brand-card" data-brand="${escapeHtml(brand.name)}"><strong>${escapeHtml(brand.name)}</strong><span>${brand.car_count} listed car${Number(brand.car_count) === 1 ? '' : 's'} · Browse models →</span></button>`).join('') : '<p class="empty-state">No brands found in the active car inventory.</p>';
    target.addEventListener('click', event => {
      const card = event.target.closest('[data-brand]');
      if (card) navigate('browse', { brand: card.dataset.brand });
    });
  } catch (error) { setError(error); }
}

async function showServices() {
  sectionView.innerHTML = pageFrame('Ownership', 'Service history', 'Recent services recorded for vehicles in the SS Cars database.', '<p class="page-meta">Loading service records...</p><div id="serviceResults"></div>');
  try {
    const services = await fetchResource('services');
    const target = document.getElementById('serviceResults');
    target.innerHTML = services.length ? services.map(service => `<article class="service-row">
      <div><h2>${escapeHtml(service.service_type || 'Vehicle service')}</h2><p>${escapeHtml(service.car_name || 'Vehicle')} · ${escapeHtml(service.customer_name || 'Customer')}</p></div>
      <div><p>${escapeHtml(service.service_date || 'Date unavailable')}</p><p>${escapeHtml(service.feedback || 'Service completed')}</p></div>
      <strong class="service-cost">₹${Number(service.service_cost || 0).toLocaleString('en-IN')}</strong>
    </article>`).join('') : '<p class="empty-state">No service records are available yet.</p>';
  } catch (error) { setError(error); }
}

function showLearn() {
  sectionView.innerHTML = pageFrame('Guides', 'Learn before you drive', 'Straightforward guides to help you compare, choose and care for your car.', `<div class="guide-grid">${guides.map(guide => `<article class="dynamic-card guide-card" style="background-image:linear-gradient(0deg,rgba(3,8,13,.2),rgba(3,8,13,.05)),url('${guide.image}')"><div class="dynamic-card-body"><h2>${guide.title}</h2><p>${guide.text}</p></div></article>`).join('')}</div>`);
}

async function showAbout() {
  let totalCars = '—';
  try { totalCars = (await fetchResource('cars')).length.toLocaleString('en-IN'); } catch { /* About content remains available without the database. */ }
  sectionView.innerHTML = pageFrame('Our story', 'Cars are more than a way to get there.', 'SS Cars brings vehicle discovery, ownership support and practical car knowledge together in one place.', `
    <section class="about-band"><div><h2>Make the next decision a confident one.</h2><p>We help drivers explore available cars, understand the details that matter, and find the support they need throughout ownership. Our goal is a clearer, more human car-buying experience.</p><p>From the first shortlist to the next service visit, we keep useful information close at hand.</p></div><img src="assets/journey_car.jpg" alt="A car ready for the road"></section>
    <div class="about-stats"><div><strong>${totalCars}</strong><span>Active cars in inventory</span></div><div><strong>One</strong><span>Place to explore and learn</span></div><div><strong>Every</strong><span>Step of the ownership journey</span></div></div>`);
}

function navigate(view, filters = {}) {
  const validViews = ['home', 'browse', 'brands', 'services', 'learn', 'about'];
  if (!validViews.includes(view)) view = 'home';
  const url = new URL(window.location.href);
  url.hash = view === 'home' ? '' : view;
  history.pushState({ view, filters }, '', url);
  renderView(view, filters);
}

function renderView(view, filters = {}) {
  const isHome = view === 'home';
  sectionView.hidden = isHome;
  homeSections.forEach(section => { section.hidden = !isHome; });
  document.querySelectorAll('.navlinks [data-view]').forEach(link => {
    if (link.dataset.view === view) link.setAttribute('aria-current', 'page');
    else link.removeAttribute('aria-current');
  });
  if (isHome) return;
  window.scrollTo(0, 0);
  if (view === 'browse') showBrowse(filters);
  if (view === 'brands') showBrands();
  if (view === 'services') showServices();
  if (view === 'learn') showLearn();
  if (view === 'about') showAbout();
}

document.querySelectorAll('[data-view]').forEach(link => link.addEventListener('click', event => {
  event.preventDefault();
  navigate(link.dataset.view, link.dataset.category ? { category: link.dataset.category } : {});
}));

window.addEventListener('popstate', event => renderView(window.location.hash.slice(1) || 'home', event.state?.filters || {}));
window.addEventListener('hashchange', () => renderView(window.location.hash.slice(1) || 'home', history.state?.filters || {}));
window.ssCarsNavigate = navigate;
renderView(window.location.hash.slice(1) || 'home');