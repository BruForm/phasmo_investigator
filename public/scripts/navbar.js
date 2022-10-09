const hamburgerToggler = document.querySelector('.hamburger');
const navlinksContainer = document.querySelector('.navlinks-container');

const navbar = document.querySelector('.navbar');

const rollLink3 = document.querySelector('.rollLink3');
const link3 = document.querySelector('.link3Toggle');

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

// -- Roller sur DIV externe -- DEBUT --
let x = 0;
while (x <= 4) {
  const linkXToggle = '.link' + x + 'Toggle';
  const linkXToggler = document.querySelector(linkXToggle);
  const rollLinkX = '.rollLink' + x;
  const rollerLinkX = document.querySelector(rollLinkX);

  const openRoll = function () {
    if (linkXToggler.getAttribute('aria-expanded') === 'false') {
      linkXToggler.setAttribute('aria-expanded', 'true');
      rollerLinkX.setAttribute('aria-expanded', 'true');
      rollerLinkX.classList.toggle('open');
      rollerLinkX.classList.toggle('close');
    }
  };
  const closeRoll = function () {
    if (linkXToggler.getAttribute('aria-expanded') === 'true') {
      linkXToggler.setAttribute('aria-expanded', 'false');
      rollerLinkX.setAttribute('aria-expanded', 'false');
      rollerLinkX.classList.toggle('close');
      rollerLinkX.classList.toggle('open');
    }
  };
  const test = document.getElementsByClassName(
    linkXToggle.slice(1, linkXToggle.length) // pour supprimer le . devant le nom de mla classe
  );
  // Si on trouve que l'element a une classe linkXtoggle on gere le passage de la souris dessus
  if (test.length === 1) {
    linkXToggler.addEventListener('mouseover', openRoll);
    rollerLinkX.addEventListener('mouseover', openRoll);
    rollerLinkX.addEventListener('mouseleave', closeRoll);
    navbar.addEventListener('mouseleave', closeRoll);
  }
  x++;
}
// -- Roller sur DIV externe -- FIN --

// -- Resize Screen -- DEBUT --
new ResizeObserver((entries) => {
  if (entries[0].contentRect.width <= 800) {
    navlinksContainer.style.transition = 'transform 0.3s ease-out';

    // Hauteur de la nav-links :
    // --calcul de la hauteur moins hauteur de la navbar [ci-dessous]
    //navlinksContainer.style.height = 'calc(100vh - ' + navbar.offsetHeight + 'px)';
    // --hauteur en auto si on ne veux pas prendre toute la hauteur de la page [ci-dessous]
    navlinksContainer.style.height = 'auto';

    // Calcul position du rollLink3 en fonction de "navlinkContainer"
    rollLink3.style.left =
      navlinksContainer.offsetLeft + navlinksContainer.offsetWidth + 'px';
    rollLink3.style.height = navlinksContainer.offsetHeight + 'px';
    // console.log('navlink', navlinksContainer.offsetHeight);
    // console.log('rolllink', rollLink3.offsetHeight);
  } else {
    navlinksContainer.style.transition = 'none';

    // hauteur de la nav-links
    navlinksContainer.style.height = 'auto';
    // Calcul position du rollLink3 en fonction de "Link3"
    rollLink3.style.left =
      link3.offsetLeft +
      link3.offsetWidth / 2 -
      rollLink3.offsetWidth / 2 +
      'px';
    rollLink3.style.height = 'auto';
  }
}).observe(document.body);
// -- Resize Screen -- FIN --
