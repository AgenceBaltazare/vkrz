$(document).ready(function () {
  var qsRegex;
  var slugStr;
  var state;

  var $grid = $(".grid-to-filtre").isotope({
    itemSelector: ".grid-item",
    layoutMode: "fitRows",
    filter: function () {
      var $this = $(this);
      var searchResult = qsRegex ? $this.text().match(qsRegex) : true;
      var filterButton = state ? $this[0].dataset.filterItem.includes(state) : true;
      // var filterButton = state ? $this.text().includes(state) : true;
      var conceptResult = slugStr ? $this[0].dataset.filterItem.includes(slugStr) : true;
      return searchResult && filterButton && conceptResult;
    },
  });

  // use value of search field to filter
  var $quicksearch = $("#search_form input").keyup(
    debounce(function () {
      qsRegex = new RegExp($quicksearch.val(), "gi");
      $grid.isotope();
    })
  );

  // state filter
  $(".switch-input").on("click", function () {
    var $this = $(this);
    if(!state) state = $this.val();
      else state = ""

    $grid.isotope();
  });

  // concept filter
  $("#selectpickerLiveSearch").on("change", function() {
    var $this = $(this);
    slugStr = $this.val();
    $grid.isotope();
  })

  // debounce so filtering doesn't happen every millisecond
  function debounce(fn, threshold) {
    var timeout;
    threshold = threshold || 100;
    return function debounced() {
      clearTimeout(timeout);
      var args = arguments;
      var _this = this;
      function delayed() {
        fn.apply(_this, args);
      }
      timeout = setTimeout(delayed, threshold);
    };
  }
});
