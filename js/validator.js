function validateForm() {
  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;

  if (!email || !password) {
    alert('Please fill all the required fields');
    return false;
  }

  if (!isValidEmail(email)) {
    alert('Please enter a valid email address');
    return false;
  }

  return true;
}

function validateRegistration() {
  const username = document.getElementById('username').value;
  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirm_password').value;

  if (!username || !email || !password || !confirmPassword) {
    alert('Please fill all the required fields');
    return false;
  }

  if (!isValidEmail(email)) {
    alert('Please enter a valid email address');
    return false;
  }

  if (password !== confirmPassword) {
    alert('Passwords do not match');
    return false;
  }

  if (password.length < 6) {
    alert('Password must be at least 6 characters long');
    return false;
  }

  return true;
}

function isValidEmail(email) {
  // Regular expression to validate email format
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}
