// Form validation: email check and password strength
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('loginForm');
  const email = document.getElementById('email');
  const pw = document.getElementById('password');
  const strength = document.getElementById('strength');

  function checkEmail(v){
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
  }

  function pwStrength(v){
    let score=0;
    if (v.length>=8) score++;
    if (/[A-Z]/.test(v)) score++;
    if (/[0-9]/.test(v)) score++;
    if (/[^A-Za-z0-9]/.test(v)) score++;
    return ['Very weak','Weak','Okay','Good','Strong'][score];
  }

  pw.addEventListener('input', e=>{ strength.textContent = pwStrength(e.target.value); });

  form.addEventListener('submit', function(e){
    const vals = [];
    if (!checkEmail(email.value)) vals.push('Please enter a valid email.');
    if (pw.value.length < 6) vals.push('Password must be at least 6 characters.');
    if (vals.length){
      e.preventDefault();
      alert(vals.join('\n'));
    }
  });
});
