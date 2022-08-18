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

$(window).on("load", function () {
  if (feather) {
    feather.replace({
      width: 14,
      height: 14,
    });
  }
});

window.onload = function () {
  var copyBtn = document.querySelector(".sharelinkbtn");
  if (copyBtn) {
    copyBtn.addEventListener("click", function (event) {
      var copyInput = copyBtn.querySelector(".input_to_share");
      copyInput.focus();
      copyInput.select();
      try {
        var successful = document.execCommand("copy");
        var msg = successful ? "successful" : "unsuccessful";
        copyBtn.innerHTML = "Copié ✓";
      } catch (err) {
        console.log("Oops, impossible de copier - Demandes pas pourquoi :/");
      }
    });
  }

  var copyBtn2 = document.querySelector(".sharelinkbtn2");
  if (copyBtn2) {
    copyBtn2.addEventListener("click", function (event) {
      var copyInput = copyBtn2.querySelector(".input_to_share2");
      copyInput.focus();
      copyInput.select();
      try {
        var successful = document.execCommand("copy");
        var msg = successful ? "successful" : "unsuccessful";
        copyBtn2.innerHTML = "Copié ✓";
      } catch (err) {
        console.log("Oops, impossible de copier - Demandes pas pourquoi :/");
      }
    });
  }
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
      event_score: 1,
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
    $(".share-content").removeClass("active-box");
    $(".share-top-content").removeClass("active-box");
    $(".box-info-content").removeClass("active-box");
    $(".share-classement-content").removeClass("active-box");
  });

  $(".share").click(function () {
    $(".share-content").addClass("active-box");
  });

  $(".share-natif-top").click(function () {
    $(".share-top-content").addClass("active-box");
  });

  $(".box-info-show").click(function () {
    $(".box-info-content").addClass("active-box");
  });

  $(".share-content-show").click(function () {
    $(".share-content").addClass("active-box");
  });

  $(".share-natif-classement").click(function () {
    $(".share-classement-content").addClass("active-box");
  });
});

if(!localStorage.getItem('come-back')) {
    const comesBackDiv = document.querySelector('.come-back'),
    comesBackCloseBtn = comesBackDiv.querySelector('.come-back-closeBtn');

    comesBackDiv.classList.remove('d-none');

    comesBackCloseBtn.addEventListener('click', function() {
        $('.come-back').fadeOut();
        localStorage.setItem('come-back', 'hide');
    })
}


