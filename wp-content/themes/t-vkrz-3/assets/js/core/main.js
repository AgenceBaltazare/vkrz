$.fn.equalHeights = function () {
  var max_height = 0;
  $(this).each(function () {
    max_height = Math.max($(this).height(), max_height);
  });
  $(this).each(function () {
    $(this).height(max_height);
  });
};

$(document).ready(function () {
  $(".eh").equalHeights();
  $(".eh2").equalHeights();
  $(".ico-master").equalHeights();
  $(".same-h").equalHeights();

  $(".kick").on("click", function () {
    var newTXT = $(this).data("kick");
    $(this).html(newTXT);
  });
});

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
        copyBtn.innerHTML = "✓";
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
        copyBtn2.innerHTML = "✓";
      } catch (err) {
        console.log("Oops, impossible de copier - Demandes pas pourquoi :/");
      }
    });
  }
};

$(window).scroll(function () {
  var scroll = $(window).scrollTop();
  if (scroll > 10) {
    $(".menu-user").addClass("opfull");
  } else {
    $(".menu-user").removeClass("opfull");
  }

  if ($(window).scrollTop() + $(window).height() == $(document).height()) {
    $(".nav-tournament, .stepbar").addClass("disapear");
  } else {
    $(".nav-tournament, .stepbar").removeClass("disapear");
  }
});

/**
 * TRACKING
 */

jQuery(document).ready(function ($) {
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
});

$(function () {
  if ($(".top-sponso"))
    $(".content-intro").css({
      display: "block",
      width: "100%",
    });
});

// countdown timer DEBUT
var countDownDate = new Date("Sep 01, 2021 10:30:30").getTime();

// Update the count down every 1 second
var x = setInterval(function () {
  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

  // Display the result in the element with id="demo"
  $("#timer-sponso").html(days + "J " + hours + "H " + minutes + "M ");

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    $("#timer-sponso").html(
      "Le concours est terminé ! Mais ne t'inquiète pas, on compte bien vous en proposer d'autres ! 😉 Pense à t'inscrire pour être sûr de ne pas les rater. 🙃"
    );
  }
}, 1000);
// countdown timer FIN
