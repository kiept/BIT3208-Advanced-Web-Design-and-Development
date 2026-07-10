function validateRegister(){
  var pw=document.getElementById('password');
  if (pw && pw.value.length<6){ alert('Password must be at least 6 characters'); return false; }
  return true;
}
