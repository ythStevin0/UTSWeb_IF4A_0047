// ===== LOGIN OVERLAY =====
function openLogin() {
  document.getElementById('loginOverlay').classList.add('is-open');
  document.body.style.overflow = 'hidden';
}

function closeLogin() {
  document.getElementById('loginOverlay').classList.remove('is-open');
  document.body.style.overflow = '';
}

function togglePassword() {
  const input = document.getElementById('loginPassword'); 
  const icon = document.getElementById('eyeIcon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.className = 'bi bi-eye-slash-fill';
  } else {
    input.type = 'password';
    icon.className = 'bi bi-eye-fill';
  }
}

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeLogin();
});