"use strict";
!(window.onload = function () {
  var t,
    e,
    s,
    a = new Shepherd.Tour({
      defaultStepOptions: { scrollTo: !1, cancelIcon: { enabled: !0 } },
      useModalOverlay: !0,
    });
  (t = "btn btn-sm btn-label-secondary md-btn-flat save-toplist-tour-btn"),
    (e = "btn btn-sm btn-primary btn-next"),
    (s = "btn btn-sm btn-primary btn-next save-toplist-tour-btn"),
    (a = a).addStep({
      title: "TopList Mondiale",
      text: "Découvre la TopList mondiale et ressemblances",
      attachTo: { element: ".decouvre-toplist-mondiale-tour", on: "bottom" },
      buttons: [
        { text: "Skip", classes: t, action: a.cancel },
        { text: "Next", classes: e, action: a.next },
      ],
    }),
    a.addStep({
      title: "Juger la TopList",
      text: "Laisser ton meilleur jugement",
      attachTo: { element: ".juger-tour", on: "right" },
      buttons: [
        { text: "Skip", classes: t, action: a.cancel },
        { text: "Back", classes: t, action: a.back },
        { text: "Next", classes: e, action: a.next },
      ],
    }),
    a.addStep({
      title: "Partage ta TopList",
      text: "Partage ta TopList et foutre le bordel dans ton groupe de potes",
      attachTo: { element: ".partage-toplist-tour", on: "bottom" },
      buttons: [
        { text: "Back", classes: t, action: a.back },
        { text: "Finish", classes: s, action: a.cancel },
      ],
    }),
    a.start();


    document.addEventListener('click', function(e) {

      if(!e.target.classList.contains("save-toplist-tour-btn")) return;

      $.ajax({
        method: "POST",
        url: vkrz_ajaxurl,
        data: {
          action: "vkrz_toplist_tour",
          id_vainkeur: idVainkeurTour,
        },
      }).done(function(data) {
        // console.log(data);
      });

    })
})();
