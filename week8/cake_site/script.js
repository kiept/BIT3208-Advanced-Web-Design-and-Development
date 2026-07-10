const navToggle=document.querySelector('.nav-toggle');
const siteNav=document.querySelector('.site-nav');
if(navToggle){navToggle.addEventListener('click',()=>{siteNav.classList.toggle('open');});}
