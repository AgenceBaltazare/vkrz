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
                copyBtn.innerHTML = "✓ Lien du Classement copié !";
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
                copyBtn2.innerHTML = "✓ Lien du Top copié !";
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

$(document).ready(function () {
    $(".close-share").click(function () {
        $(".share-content").removeClass('active-box');
        $(".share-top-content").removeClass('active-box');
        $(".box-info-content").removeClass('active-box');
        $(".share-classement-content").removeClass('active-box');
    });

    $(".share").click(function () {
        $(".share-content").addClass('active-box');
    });
    
    $(".share-natif-top").click(function () {
        $(".share-top-content").addClass('active-box');
    });

    $(".box-info-show").click(function () {
        $(".box-info-content").addClass('active-box');
    });

    $(".share-content-show").click(function () {
        $(".share-content").addClass('active-box');
    });

    $(".share-natif-classement").click(function () {
        $(".share-classement-content").addClass('active-box');
    });

});


// Partage en mode natif DEBUT
/*
const shareClassementNatif = document.querySelector(".share-natif-classement");
const shareTopNatif = document.querySelector(".share-natif-top");
const shareClassement = document.querySelector("#share-classement");
const shareTop = document.querySelector("#share-classement");

shareClassementNatif.addEventListener("click", (event) => {
    if (navigator.share) {
        navigator
            .share({
                title: "WebShare API Demo",
                url: "",
            })
            .then(() => {
                console.log("Merci pour le partage !");
            })
            .catch(console.error);
    } else {
        $("#share-classement").click(function () {
            $(".share-classement-content").show("fast");
        });
        $(".close-share").click(function () {
            $(".share-classement-content").hide("fast");
        });
    }
});

shareTopNatif.addEventListener("click", (event) => {
    console.log('fdfd');
    if (navigator.share) {
        navigator
            .share({
                title: "WebShare API Demo",
                url: "",
            })
            .then(() => {
                console.log("Merci pour le partage !");
            })
            .catch(console.error);
    }
    else {
        console.log('aaa');
        $("#share-top").click(function () {
            $(".share-top-content").show("fast");
        });
        $(".close-share").click(function () {
            $(".share-top-content").hide("fast");
        });
    }
});
*/
// Partage en mode natif FIN

