document.addEventListener('DOMContentLoaded', function () {
  const loader = document.getElementById('loader');
  loader.style.opacity = '0';
  setTimeout(function () {
    loader.style.display = 'none';
  }, 600);
});

document.querySelector(".users-card-profile").addEventListener('click', () => {
  if(document.querySelector('.fir-image-figure').style.display == 'none'){
    document.querySelector('.fir-image-figure').style.display = 'flex';
  }
  else{
    document.querySelector('.fir-image-figure').style.display = 'none';
  }
})