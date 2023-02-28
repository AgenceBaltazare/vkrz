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

  window.onload = function () {
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
            if (e.target !== copyLinkTopList && e.target !== copyLinkTop && e.target === popUp.querySelector("#close-popup")) {
              e.target.closest(".popup-overlay").classList.add("d-none");
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
        }
      });

      // TOP SPONSO POPUP SLIDE DOTS
      if (document.querySelector('.popup-dots')) {
        const dots      = document.querySelectorAll('.dot');
        const slideOne  = document.querySelector('.popup-slide-1');
        const slideTwo  = document.querySelector('.popup-slide-2');
        const retourBtn = document.querySelector('.popup-retour');

        dots.forEach(dot => {
          dot.addEventListener("click", function() {
            if(!dot.classList.contains('active')) {
              dots.forEach(dot => dot.classList.remove('active'));
              dot.classList.add('active');

              if(dot.dataset.slide === "2") {
                slideOne.classList.add('slide-left');
                slideTwo.classList.remove('slide-right');

                retourBtn.classList.remove('invisible');
                retourBtn.addEventListener('click', () => {
                  dots.forEach(dot => dot.classList.remove('active'));
                  dots[0].classList.add('active');

                  retourBtn.classList.add('invisible');
                  slideOne.classList.remove('slide-left');
                  setTimeout(() => slideTwo.classList.add('slide-right'), 100);
                })
              } else {
                retourBtn.classList.add('invisible');
                slideOne.classList.remove('slide-left');
                setTimeout(() => slideTwo.classList.add('slide-right'), 100);
              }
            }
          })
        })
      }
    }

    const popUp = document.querySelector('.popup-overlay');
    const closePopUp = document.querySelector('.close-popup') || document.querySelector('#close-popup');
    if (closePopUp){
      closePopUp.addEventListener('click', () => popUp.classList.add('d-none'));
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

    // JUGEMENT TAB
    if(window.location.href.includes("#juger")) {
      const jugementsContainer = document.querySelector('.toplist_comments');
      const jugementInput      = jugementsContainer.querySelector('#comment');
      const closeBtn           = jugementsContainer.querySelector('.btn-close');

      jugementsContainer.classList.add('show');
      jugementsContainer.ariaModal = "true";
      jugementsContainer.role = "dialog";
      jugementInput.focus();
      closeBtn.addEventListener('click', () => {
        jugementsContainer.classList.remove('show');
        jugementsContainer.ariaModal = "";
        jugementsContainer.role = "";
      })
    }
  };
});

var prefetUsers = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.whitespace,
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: "http://localhost:8888/vkrz/wp-json/vkrz/v1/get_all_users/"
});
var prefetContent = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.whitespace,
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: "http://localhost:8888/vkrz/wp-json/vkrz/v1/getcontent/"
});


$("#searchmembres").typeahead(
  {
    highlight: true,
    minLength: 1
  },
  {
    name: "result",
    source: prefetUsers
  }
);

$("#searchtops").typeahead(
  {
    highlight: true,
    minLength: 1
  },
  {
    name: "result",
    source: prefetContent
  }
);

$(".typesearch").change(function(){
  var typesearch = $(this).val();
  console.log(typesearch);
  if(typesearch == "Membres"){
    $('.searchtops').hide();
    $('.searchmembres').show();
  }
  else{
    $('.searchtops').show();
    $('.searchmembres').hide();
  }
});

$(".opensearch").on("click", function(){
  $('#waiter-recherche').fadeIn();
});

$(".fermerrecherche").on("click", function(){
  $('#waiter-recherche').fadeOut();
});

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(";");
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
if (getCookie("wordpress_toastr_cookies")) {
  // GET COOKIES DATA
  const cookies        = JSON.parse(getCookie("wordpress_toastr_cookies")),
        toastr_text    = cookies.toastr_text,
        toastr_icon    = cookies.toastr_icon,
        toastr_type    = cookies.toastr_type;

  // DEFINE TYPE
  const options = {
    "closeButton": false,
    "newestOnTop": false,
    "progressBar": true,
    "preventDuplicates": true,
    "timeOut": "3000",
    "showEasing": "swing",
    "hideEasing": "linear",
  }
  if(toastr_type === "badge") {
    toastr.success(`Tu obtiens le trophée ${toastr_text} ${toastr_icon}`, 'Nouveau trophée', options);
  } else if (toastr_type === "niveau") {
    toastr.success(`Tu passes au niveau ${toastr_icon}`, `Félicitations ${vainkeurPseudo !== "Lama2Lombre" ? vainkeurPseudo : ""}`, options);
  }

  // REMOVE COOKIE
  document.cookie = "wordpress_toastr_cookies=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 UTC";
}

if (document.querySelector('.save-top')) {
  const saveTopsBtns = document.querySelectorAll('.save-top'); 

  saveTopsBtns.forEach(btn => {
    btn.addEventListener('click', function(e) {
      const idTop      = btn.dataset.idtop;
      const idVainkeur = btn.dataset.idvainkeur;

      if(btn instanceof HTMLAnchorElement) {
        e.preventDefault();

        const btnText    = btn.textContent;
        const topCard    = btn.closest(".min-tournoi.card");

        if(btnText.includes("Un")) {
          btn.textContent = "Save Top";
          topCard?.classList.remove('saved-top');
        } else {
          btn.textContent = "Unsave Top";
          topCard?.classList.add('saved-top');
        }
      } 
      // else if (btn instanceof HTMLInputElement) {}

      $.ajax({
        method: "POST",
        url: vkrz_ajaxurl,
        data: {
          action: "deal_vkrz_save_top",
          id_top: idTop,
          id_vainkeur: idVainkeur,
        },
      });
    })
  })
}

if (document.querySelector('.modal')) {
  document.querySelectorAll('.modal.transparent').forEach(function(modal) {
    modal.addEventListener('hidden.bs.modal', function(e) {
      let modal  = e.currentTarget
      let iframe = modal.querySelector('iframe');
      iframe.src = modal.querySelector('iframe').src;
    });
  });
}
