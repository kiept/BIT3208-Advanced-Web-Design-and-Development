function validateRegister(){
  var pw=document.getElementById('password').value;
  var cpw=document.getElementById('confirm_password').value;
  if (pw.length<6){ alert('Password must be at least 6 characters'); return false; }
  if (pw!==cpw){ alert('Passwords do not match'); return false; }
  return true;
}
