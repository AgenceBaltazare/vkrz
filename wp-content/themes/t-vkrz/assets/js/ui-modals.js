/**
 * UI Modals
 */

'use strict';

(function () {
  // Animation Dropdown
  const animationDropdown = document.querySelector('#animation-dropdown'),
    animationModal = document.querySelector('#animationModal');
  if (animationDropdown) {
    animationDropdown.onchange = function () {
      animationModal.classList = '';
      animationModal.classList.add('modal', 'animate__animated', this.value);
    };
  }

  // Onboarding modal carousel height animation
  document.querySelectorAll('.carousel').forEach(carousel => {
    carousel.addEventListener('slide.bs.carousel', event => {
      // ! Todo: Convert to JS (animation) (jquery)
      var nextH = $(event.relatedTarget).height();
      $(carousel).find('.active.carousel-item').parent().animate(
        {
          height: nextH
        },
        500
      );
    });
  });
})();
