// login.js
const loginForm = document.getElementById('loginForm');
const emailInput = document.getElementById('user-email');
const passwordInput = document.getElementById('user-password');
const errorMessage = document.getElementById('errorMessage');

// Password toggle
const togglePassword = document.createElement('span');
togglePassword.textContent = 'Show';
togglePassword.className = 'ml-2 text-blue-600 cursor-pointer text-sm';
passwordInput.parentNode.appendChild(togglePassword);

togglePassword.addEventListener('click', () => {
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    togglePassword.textContent = 'Hide';
  } else {
    passwordInput.type = 'password';
    togglePassword.textContent = 'Show';
  }
});

// Helper: validate email
function isValidEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

// Form submission
loginForm.addEventListener('submit', (e) => {
  e.preventDefault();
  errorMessage.textContent = '';
  errorMessage.classList.add('hidden');

  const email = emailInput.value.trim();
  const password = passwordInput.value.trim();
  let errors = [];

  if (!email) errors.push('Email is required.');
  else if (!isValidEmail(email)) errors.push('Please enter a valid email.');

  if (!password) errors.push('Password is required.');
  else if (password.length < 8) errors.push('Password must be at least 8 characters.');

  if (errors.length > 0) {
    errorMessage.textContent = errors.join(' ');
    errorMessage.classList.remove('hidden');
    return;
  }

  // Disable button while processing
  const submitBtn = loginForm.querySelector('input[type="submit"]');
  submitBtn.disabled = true;
  submitBtn.value = 'Processing...';

  fetch('../app/controllers/AuthController.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ email, password })
  })
  .then(response => {
    if (!response.ok) throw new Error('Network error');
    return response.json();
  })
  .then(data => {
    if (data.success) {
      window.location.href = data.redirect;
    } else {
      errorMessage.textContent = data.message;
      errorMessage.classList.remove('hidden');
    }
  })
  .catch(err => {
    console.error(err);
    errorMessage.textContent = 'Server error. Please try again later.';
    errorMessage.classList.remove('hidden');
  })
  .finally(() => {
    submitBtn.disabled = false;
    submitBtn.value = 'Sign In';
  });
});