// ===== LOGIN OVERLAY =====
function openLogin() {
  const overlay = document.getElementById('loginOverlay');
  overlay.classList.add('is-open');
  document.body.style.overflow = 'hidden';

  // Cek jika sudah login
  const saved = localStorage.getItem('warhex_user');
  if (saved) {
    const user = JSON.parse(saved);
    renderSuccess(user.email);
  }
}

function closeLogin() {
  document.getElementById('loginOverlay').classList.remove('is-open');
  document.body.style.overflow = '';
}

function togglePassword() {
  const input = document.getElementById('loginPassword');
  const icon  = document.getElementById('eyeIcon');
  const isHidden = input.type === 'password';
  input.type      = isHidden ? 'text' : 'password';
  icon.className  = isHidden ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
}

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeLogin();
});

// FORM
document.addEventListener('DOMContentLoaded', initApp);

function initApp() {
  const emailInput    = document.getElementById('loginEmail');
  const passwordInput = document.getElementById('loginPassword');
  const submitBtn     = document.getElementById('loginSubmitBtn');
  const loginForm     = document.querySelector('.login-form');

  submitBtn.addEventListener('click', handleLogin);
  loginForm.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') handleLogin(e);
  });

  function handleLogin(e) {
    e.preventDefault();

    const email    = emailInput.value.trim();
    const password = passwordInput.value.trim();
    const emailOK  = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

    removeError();

    if (!email || !password) return showError('Please fill in all fields.');
    if (!emailOK)            return showError('Please enter a valid email.');

    localStorage.setItem('warhex_user', JSON.stringify({
      email,
      savedAt: new Date().toISOString()
    }));
    localStorage.setItem('warhex_session', 'active');

    renderSuccess(email);
  }

  function showError(msg) {
    const el = document.createElement('p');
    el.className = 'login-error-msg';
    el.textContent = msg;
    submitBtn.insertAdjacentElement('beforebegin', el);
    setTimeout(removeError, 3000);
  }

  function removeError() {
    document.querySelector('.login-error-msg')?.remove();
  }

  const seriesFilterButtons = document.querySelectorAll('.js-series-filter');
  const seriesCards = document.querySelectorAll('.series-card');
  const seriesSearchInput = document.querySelector('.series-search-input');

  const getActiveFilter = () => {
    const activeButton = document.querySelector('.js-series-filter.active');
    return activeButton?.dataset.filter?.toUpperCase() || 'ALL';
  };

  const updateSeriesVisibility = () => {
    const activeFilter = getActiveFilter();
    const query = seriesSearchInput?.value.trim().toLowerCase() || '';

    seriesCards.forEach((card) => {
      const categories = (card.dataset.category || '')
        .split(',')
        .map((category) => category.trim().toUpperCase())
        .filter(Boolean);
      const title = card.querySelector('.series-title-text')?.textContent.trim().toLowerCase() || '';
      const genre = card.querySelector('.series-genre')?.textContent.trim().toLowerCase() || '';
      const categoryMatch = activeFilter === 'ALL' || categories.includes(activeFilter);
      const searchMatch = !query || title.includes(query) || genre.includes(query);
      card.closest('.col').style.display = categoryMatch && searchMatch ? '' : 'none';
    });
  };

  seriesFilterButtons.forEach((button) => {
    button.addEventListener('click', (event) => {
      event.preventDefault();
      const filterType = button.dataset.filter?.toUpperCase();
      if (!filterType) return;

      seriesFilterButtons.forEach((btn) => {
        btn.classList.toggle('active', btn === button);
      });

      updateSeriesVisibility();
    });
  });

    seriesSearchInput?.addEventListener('input', updateSeriesVisibility);
}

// SUCCESS STATE
function renderSuccess(email) {
  document.querySelector('.login-panel').innerHTML = `
    <div class="login-success">
      <div class="login-success-icon"><i class="bi bi-check-lg"></i></div>
      <p class="login-success-kicker">ACCESS GRANTED</p>
      <h3 class="login-success-title">WELCOME BACK</h3>
      <p class="login-success-email">Logged in as <span>${email}</span></p>
      <div class="login-success-divider"></div>
      <button class="login-submit" onclick="closeLogin()">
        ENTER BATTLEFIELD <i class="bi bi-arrow-right"></i>
      </button>
    </div>
  `;
}

// esc untuk close login
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeLogin();
});

