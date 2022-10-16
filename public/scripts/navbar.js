const hamburgerToggler = document.querySelector('.hamburger');
const navlinksContainer = document.querySelector('.navlinks-container');

const navbar = document.querySelector('.navbar');

// -- Hamburger -- DEBUT ---
const toggleNav = function(){
  hamburgerToggler.classList.toggle('open');

  const ariaToggle =
    hamburgerToggler.getAttribute('aria-expanded') === 'true'
      ? 'false'
      : 'true';
  hamburgerToggler.setAttribute('aria-expanded', ariaToggle);

  navlinksContainer.classList.toggle('open');
};
hamburgerToggler.addEventListener('click', toggleNav);
// -- Hamburger -- FIN ---

// -- Resize Screen -- DEBUT --
new ResizeObserver((entries) => {
  if (entries[0].contentRect.width <= 1000) {
    navlinksContainer.style.transition = 'transform 0.3s ease-out';

    // Hauteur de la nav-links :
    // --calcul de la hauteur moins hauteur de la navbar [ci-dessous]
    //navlinksContainer.style.height = 'calc(100vh - ' + navbar.offsetHeight + 'px)';
    // --hauteur en auto si on ne veux pas prendre toute la hauteur de la page [ci-dessous]
    navlinksContainer.style.height = 'auto';

  } else {
    navlinksContainer.style.transition = 'none';

    // hauteur de la nav-links
    navlinksContainer.style.height = 'auto';
  }
}).observe(document.body);
// -- Resize Screen -- FIN --
