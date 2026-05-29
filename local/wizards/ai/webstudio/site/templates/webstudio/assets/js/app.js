(function(){
  const root=document.documentElement;
  const saved=localStorage.getItem('webstudio-theme');
  if(saved){root.dataset.theme=saved;}
  document.addEventListener('click',function(event){
    const toggle=event.target.closest('[data-theme-toggle]');
    if(toggle){const next=root.dataset.theme==='dark'?'light':'dark';root.dataset.theme=next;localStorage.setItem('webstudio-theme',next);}
    const cert=event.target.closest('[data-certificate]');
    if(cert){const modal=document.querySelector('.modal');if(modal){modal.querySelector('.modal__box').innerHTML=cert.dataset.certificate;modal.classList.add('is-open');}}
    const modalClose=event.target.closest('.modal');
    if(modalClose&&event.target===modalClose){modalClose.classList.remove('is-open');}
  });
})();
