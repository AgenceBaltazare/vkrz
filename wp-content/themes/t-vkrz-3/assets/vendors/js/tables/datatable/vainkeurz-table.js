$('.table-creator').DataTable({
    autoWidth: false,
    lengthMenu: [25],
    pagingType: "full_numbers",
    columns: [
        { orderable: false },
        { orderable: true },
        { orderable: true },
        { orderable: true },
        { orderable: false },
    ],
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Rechercher...",
        processing:     "Traitement en cours...",
        info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
        infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        infoPostFix:    "",
        loadingRecords: "Chargement en cours...",
        zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher 😩",
        emptyTable:     "Aucun résultat trouvé 😩",
        paginate: {
            first:      "Premier",
            previous:   "Pr&eacute;c&eacute;dent",
            next:       "Suivant",
            last:       "Dernier"
        },
    },
    order: [],
});
$('.table-tbegin').DataTable({
    autoWidth: false,
    lengthMenu: [25],
    pagingType: "full_numbers",
    columns: [
        { orderable: false },
        { orderable: false },
        { orderable: false },
        { orderable: false },
    ],
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Rechercher...",
        processing:     "Traitement en cours...",
        info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
        infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        infoPostFix:    "",
        loadingRecords: "Chargement en cours...",
        zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher 😩",
        emptyTable:     "Aucun résultat trouvé 😩",
        paginate: {
            first:      "Premier",
            previous:   "Pr&eacute;c&eacute;dent",
            next:       "Suivant",
            last:       "Dernier"
        },
    },
    order: [],
});
$('.table-4').DataTable({
    autoWidth: true,
    lengthMenu: [25],
    pagingType: "full_numbers",
    columns: [
        { orderable: false },
        { orderable: true },
        { orderable: true },
        { orderable: false },
        { orderable: false },
    ],
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Rechercher...",
        processing:     "Traitement en cours...",
        info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
        infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        infoPostFix:    "",
        loadingRecords: "Chargement en cours...",
        zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher 😩",
        emptyTable:     "Aucun résultat trouvé 😩",
        paginate: {
            first:      "Premier",
            previous:   "Pr&eacute;c&eacute;dent",
            next:       "Suivant",
            last:       "Dernier"
        },
    },
    order: [],
});
$('.table-tdone').DataTable({
    autoWidth: true,
    lengthMenu: [25],
    pagingType: "full_numbers",
    columns: [
        { orderable: false },
        { orderable: true },
        { orderable: true },
        { orderable: false },
        { orderable: false },
        { orderable: false }
    ],
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Rechercher...",
        processing:     "Traitement en cours...",
        info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
        infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        infoPostFix:    "",
        loadingRecords: "Chargement en cours...",
        zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher 😩",
        emptyTable:     "Aucun résultat trouvé 😩",
        paginate: {
            first:      "Premier",
            previous:   "Pr&eacute;c&eacute;dent",
            next:       "Suivant",
            last:       "Dernier"
        },
    },
    order: [],
});

$('.table-vainkeurz').DataTable({
    autoWidth: true,
    lengthMenu: [20],
    searching: false,
    paging: false,
    columns: [
        { orderable: false },
        { orderable: false },
        { orderable: true },
        { orderable: true },
        { orderable: true },
        { orderable: false },
    ],
    order: [],
});


$('.table-bestops').DataTable({
    autoWidth: true,
    lengthMenu: [20],
    searching: true,
    paging: false,
    columns: [
        { orderable: false },
        { orderable: false },
        { orderable: true },
        { orderable: true },
        { orderable: false },
        { orderable: false },
    ],
    order: [],
});

$('.table-bestcreator').DataTable({
    autoWidth: true,
    lengthMenu: [20],
    searching: false,
    paging: false,
    columns: [
        { orderable: false },
        { orderable: false },
        { orderable: true },
        { orderable: true },
        { orderable: true },
        { orderable: false },
    ],
    order: [],
});

$('.table-tas').DataTable({
    autoWidth: true,
    lengthMenu: [20],
    searching: false,
    paging: false,
    columns: [
        { orderable: false },
        { orderable: false },
        { orderable: true },
        { orderable: false },
        { orderable: true },
        { orderable: false }
    ],
    order: [],
});

$('.table-notifications').DataTable({
  autoWidth: false,
  lengthMenu: [25],
  pagingType: "full_numbers",
  columns: [
      { orderable: false },
      { orderable: true },
      { orderable: true }
  ],
  language: {
      search: "_INPUT_",
      searchPlaceholder: "Rechercher...",
      processing:     "Traitement en cours...",
      info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
      infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      infoPostFix:    "",
      loadingRecords: "Chargement en cours...",
      zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher 😩",
      emptyTable:     "Aucun résultat trouvé 😩",
      paginate: {
          first:      "Premier",
          previous:   "Pr&eacute;c&eacute;dent",
          next:       "Suivant",
          last:       "Dernier"
      },
  },
  order: [],
});

$('.table-amigos').DataTable({
  autoWidth: false,
  lengthMenu: [25],
  pagingType: "full_numbers",
  columns: [
      { orderable: false },
      { orderable: true },
      { orderable: true },
      { orderable: true },
      { orderable: true },
  ],
  language: {
      search: "_INPUT_",
      searchPlaceholder: "Rechercher...",
      processing:     "Traitement en cours...",
      info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
      infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      infoPostFix:    "",
      loadingRecords: "Chargement en cours...",
      zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher 😩",
      emptyTable:     "Aucun résultat trouvé 😩",
      paginate: {
          first:      "Premier",
          previous:   "Pr&eacute;c&eacute;dent",
          next:       "Suivant",
          last:       "Dernier"
      },
  },
  order: [],
});
