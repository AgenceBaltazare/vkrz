function maj_firebase_finish_top(id_top, id_vainkeur, id_ranking) {
  $.ajax({
    method: "POST",
    url: vkrz_ajaxurl,
    data: {
      action: "vkzr_save_to_firestore_finish_top",
      id_top: id_top,
      id_vainkeur: id_vainkeur,
      id_ranking: id_ranking,
    },
  });
}

function maj_elo_firebase(id_winner, id_looser) {
  $.ajax({
    method: "POST",
    url: vkrz_ajaxurl,
    data: {
      action: "vkzr_save_elo_to_firestore",
      contender_1: id_winner,
      contender_2: id_looser,
    },
  });
}

function maj_firebase_delete_toplist(id_ranking, id_vainkeur) {
  $.ajax({
    method: "POST",
    url: vkrz_ajaxurl,
    data: {
      action: "vkzr_maj_firebase_delete_toplist",
      id_ranking: id_ranking,
      id_vainkeur: id_vainkeur,
    },
  });
}

function post_new_jugement(id_ranking, id_vainkeur, todo) {
  $.ajax({
    method: "POST",
    url: vkrz_ajaxurl,
    data: {
      action: "vkzr_new_jugement",
      id_ranking: id_ranking,
      id_vainkeur: id_vainkeur,
      todo: todo,
    },
  });
}

$.fn.equalHeights = function () {
  var max_height = 0;
  $(this).each(function () {
    max_height = Math.max($(this).height(), max_height);
  });
  $(this).each(function () {
    $(this).height(max_height);
  });
};

$(window).scroll(function () {
  var scroll = $(window).scrollTop();
  if (scroll > 10) {
    $(".intro-mobile").addClass("opfull");
    $(".menu-user").addClass("opfull");
  } else {
    $(".intro-mobile").addClass("opfull");
    $(".menu-user").removeClass("opfull");
  }

  if (scroll > 60) {
    $(".menu-user").addClass("menuvkrzmobilehide");
  } else {
    $(".menu-user").removeClass("menuvkrzmobilehide");
  }

  if ($(window).scrollTop() + $(window).height() == $(document).height()) {
    $(".nav-tournament, .stepbar").addClass("disapear");
  } else {
    $(".nav-tournament, .stepbar").removeClass("disapear");
  }
});

jQuery(document).ready(function ($) {
  $(".eh").equalHeights();
  $(".ehcard").equalHeights();
  $(".eh2").equalHeights();
  $(".eh3").equalHeights();
  $(".ico-master").equalHeights();
  $(".same-h").equalHeights();
  $(".same-h2").equalHeights();

  $(".kick").on("click", function () {
    var newTXT = $(this).data("kick");
    $(this).html(newTXT);
  });

  window.dataLayer.push({
    event: "track_event",
    event_name: "page_view",
    event_score: 1,
    page_title: vkrz_tracking_vars_current_page.page_title,
    categorie: vkrz_tracking_vars_current_page.page_category,
  });

  $(".main-menu .nav-item .rs-menu a").click(function (e) {
    const rs_name = $(this).data("rs-name");
    window.dataLayer.push({
      event: "track_event",
      event_name: "click_social",
      event_score: 10,
      rs_name: rs_name,
      user_id: vkrz_tracking_vars_user.id_user_layer,
      user_uuid: vkrz_tracking_vars_user.uuiduser_layer,
      page_title: vkrz_tracking_vars_current_page.page_title,
    });
  });

  $(".card-body .share-t a").click(function (e) {
    const rs_name = $(this).attr("title");
    window.dataLayer.push({
      event: "track_event",
      event_name: "share_top",
      event_score: 20,
      rs_name: rs_name,
      user_id: vkrz_tracking_vars_user.id_user_layer,
      user_uuid: vkrz_tracking_vars_user.uuiduser_layer,
      page_title: vkrz_tracking_vars_current_page.page_title,
    });
  });

  $(".close-share").click(function () {
    $(".share-top-content").removeClass("active-box");
    $(".box-info-content").removeClass("active-box");
    $(".share-classement-content").removeClass("active-box");
  });

  $(".share-natif-top").click(function () {
    $(".share-top-content").addClass("active-box");
    $(".box-info-content").removeClass("active-box");
  });

  $(".box-info-show").click(function () {
    $(".box-info-content").addClass("active-box");
  });

  $(".share-natif-classement").click(function () {
    "";
    $(".share-classement-content").addClass("active-box");
  });

  window.onload = function () {
    if(document.querySelector('.to-sign')) {
      if(document.querySelector('.to-sign.connected')) {
        document.querySelector('.to-sign').classList.add('signs');
      }
    }

    var copyBtns = document.querySelectorAll(".sharelinkbtn");
    copyBtns.forEach((copyBtn) => {
      copyBtn.addEventListener("click", function (event) {
        var copyInputs = copyBtn.querySelectorAll(".input_to_share");

        copyInputs.forEach((copyInput) => {
          copyInput.focus();
          copyInput.select();
          try {
            var successful = document.execCommand("copy");
            var msg = successful ? "successful" : "unsuccessful";
            copyBtn.innerHTML = "Copié ✓";
          } catch (err) {
            console.log(
              "Oops, impossible de copier - Demandes pas pourquoi :/"
            );
          }
        });
      });
    });

    var copyBtns2 = document.querySelectorAll(".sharelinkbtn2");
    copyBtns2.forEach((copyBtn) => {
      copyBtn.addEventListener("click", function (event) {
        var copyInputs = copyBtn.querySelectorAll(".input_to_share2");

        copyInputs.forEach((copyInput) => {
          copyInput.focus();
          copyInput.select();
          try {
            var successful = document.execCommand("copy");
            var msg = successful ? "successful" : "unsuccessful";
            copyBtn.innerHTML = "Copié ✓";
          } catch (err) {
            console.log(
              "Oops, impossible de copier - Demandes pas pourquoi :/"
            );
          }
        });
      });
    });

    if(document.querySelector('#wppb-register-user-sign-on')) {
      const form = document.querySelector('#wppb-register-user-sign-on');
      form.addEventListener('submit', () => {
        const formAction = form.getAttribute('action');
        
        if(!formAction.includes('codeinvit')) {
          const codeInvitValue = form.querySelector('#referral').value;
          form.setAttribute('action', `${formAction}?codeinvit=${codeInvitValue}`)
        }
      });
    }

    if(document.querySelector('#copyReferralLink')) {
      const buttons = document.querySelectorAll("#copyReferralLink");

      buttons.forEach(button => button.addEventListener('click', function(e) {
        e.preventDefault();
        const copy = (text) => navigator.clipboard.writeText(text);
        copy(button.getAttribute('href'));
        button.querySelector('p:first-of-type').innerHTML = 'Bien copié ! <span class="ico va va-floppy-disk va-lg"></span>'
      }))
    }

    if (document.querySelector(".popup-overlay")) {
      const popUps = document.querySelectorAll(".popup-overlay");

      const dealClosePopUp = function(popUp) {
        let copyLinkTopList = popUp.querySelector(".sharelinkbtn .fa-link");
        let copyLinkTop     = popUp.querySelector(".sharelinkbtn2 .fa-link");
        
        document.addEventListener("click", (e) => {
          if (
            e.target.closest(".popup") !== popUp.querySelector(".popup") ||
            e.target === popUp.querySelector("#close-popup")
          ) {

            if (e.target !== copyLinkTopList && e.target !== copyLinkTop) {
              popUp.classList.add("d-none");
            }
          }
        });

        document.addEventListener("keydown", function (e) {
          if (e.key === "Escape") {
            popUp.classList.add("d-none");
          }
        });
      }

      popUps.forEach((popUp) => {
        if (!popUp.classList.contains("d-none") || popUp.querySelector('.finish-participate-popup')) {
          dealClosePopUp(popUp);
        } else {
          const openPopUp                  = document.querySelector('.open-popup');
          const popUp                      = document.querySelector('.popup-overlay');
          const closePopUp                 = document.querySelector('.close-popup');
          const keurzDropDownMenuContainer = document.querySelector('.keurz-dropdown-container');
          const keurzDropDownMenu          = document.querySelector('.keurz-dropdown');

          if(!localStorage.getItem('referral')) {
            keurzDropDownMenuContainer.addEventListener('click', () => {
              document.querySelector('.signs').classList.remove('signs')
              localStorage.setItem("referral", "hide");
            });
          } else {
            document.querySelector('.signs').classList.remove('signs');
          }

          openPopUp.addEventListener('click', () => {
            popUp.classList.remove('d-none');
            dealClosePopUp(popUp);
            keurzDropDownMenu.classList.remove('show');
            keurzDropDownMenu.classList.add('hide');
          });
          closePopUp.addEventListener('click', () => popUp.classList.add('d-none'));
        }
      });
    }

    // UTM
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    if(urlParams.get("utm")) {
      const utm = urlParams.get("utm");

      function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        let expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
      }
      document.cookie =
      "wordpress_vainkeurz_user_utm=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 UTC";
      setCookie("wordpress_vainkeurz_user_utm", utm, 365)
    }
  };
});
