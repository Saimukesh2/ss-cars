const landingApi = 'api.php';

function landingEscape(value) {
  return String(value ?? '').replace(/[&<>"']/g, character => ({
    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
  })[character]);
}

function landingImageForCategory(name) {
  const category = String(name || '').toLowerCase();
  if (category.includes('suv')) return 'assets/body_suv.jpg';
  if (category.includes('hatch')) return 'assets/body_hatch.jpg';
  if (category.includes('sedan')) return 'assets/body_sedan.jpg';
  if (category.includes('coupe')) return 'assets/body_coupe.jpg';
  if (category.includes('convert')) return 'assets/body_convertible.jpg';
  if (category.includes('muv') || category.includes('mpv')) return 'assets/body_mpv.jpg';
  return 'assets/hero.jpg';
}

function landingImageForCar(brand) {
  const name = String(brand || '').toLowerCase();
  if (name.includes('bmw')) return 'assets/top_bmw.jpg';
  if (name.includes('mercedes')) return 'assets/top_mercedes.jpg';
  if (name.includes('audi')) return 'assets/top_audi.jpg';
  if (name.includes('toyota')) return 'assets/top_toyota.jpg';
  return 'assets/hero.jpg';
}

async function loadLandingResource(resource) {
  const response = await fetch(`${landingApi}?resource=${encodeURIComponent(resource)}`);
  const data = await response.json();
  if (!response.ok) throw new Error(data.error || 'Unable to load landing page data.');
  return data;
}

function renderLandingCategories(categories) {
  const target = document.getElementById('bodyTypes');
  target.innerHTML = categories.length ? categories.map(category => `<a class="bodyCard" href="#browse" data-view="browse" data-category="${landingEscape(category.name)}">
    <img src="${landingImageForCategory(category.name)}" alt="" loading="lazy">
    <div><b>${landingEscape(category.name)}</b><span>${landingEscape(category.description || 'Explore available cars')}</span></div>
  </a>`).join('') : '<p class="empty-state">No active categories are available.</p>';
}

function renderLandingCars(cars) {
  const target = document.getElementById('featuredCars');
  const featured = cars.slice(0, 4);
  target.innerHTML = featured.length ? featured.map(car => `<article class="car">
    <img src="${landingImageForCar(car.brand)}" alt="${landingEscape(car.name)}" loading="lazy">
    <div class="carInfo"><span class="badge">${landingEscape(car.category || 'Available')}</span>
      <h3>${landingEscape(car.name)}</h3>
      <div class="price">${car.price == null ? 'Price on request' : `₹${Number(car.price).toLocaleString('en-IN')}`}</div>
      <div class="spec">${landingEscape(car.year || 'Year unavailable')} &nbsp; ${landingEscape(car.mileage || 'Mileage unavailable')}</div>
    </div>
  </article>`).join('') : '<p class="empty-state">No active cars are available.</p>';
}

async function initializeLanding() {
  const categorySelect = document.getElementById('homeCategory');
  const brandSelect = document.getElementById('homeBrand');
  const form = document.getElementById('homeSearch');

  form.addEventListener('submit', event => {
    event.preventDefault();
    const filters = Object.fromEntries(new FormData(form).entries());
    window.ssCarsNavigate('browse', Object.fromEntries(Object.entries(filters).filter(([, value]) => value)));
  });

  try {
    const [categories, brands, cars] = await Promise.all([
      loadLandingResource('categories'),
      loadLandingResource('brands'),
      loadLandingResource('cars')
    ]);
    categorySelect.innerHTML += categories.map(category => `<option value="${landingEscape(category.name)}">${landingEscape(category.name)}</option>`).join('');
    brandSelect.innerHTML += brands.map(brand => `<option value="${landingEscape(brand.name)}">${landingEscape(brand.name)}</option>`).join('');
    document.getElementById('carTotal').textContent = cars.length.toLocaleString('en-IN');
    document.getElementById('brandTotal').textContent = brands.length.toLocaleString('en-IN');
    renderLandingCategories(categories);
    renderLandingCars(cars);
  } catch (error) {
    document.getElementById('bodyTypes').innerHTML = `<p class="error-state">${landingEscape(error.message)}</p>`;
    document.getElementById('featuredCars').innerHTML = `<p class="error-state">${landingEscape(error.message)}</p>`;
  }
}

initializeLanding();