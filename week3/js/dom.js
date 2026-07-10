document.addEventListener('DOMContentLoaded', function(){
  // Live preview
  const liveIn = document.getElementById('live-input');
  const liveOut = document.getElementById('live-preview');
  if (liveIn){
    liveIn.addEventListener('input', e=>{ liveOut.textContent = e.target.value || 'Live preview will appear here'; });
  }

  // Menu toggle
  const toggle = document.getElementById('menu-toggle');
  const menu = document.getElementById('menu');
  if (toggle && menu){
    toggle.addEventListener('click', ()=> menu.classList.toggle('hidden'));
  }
});
