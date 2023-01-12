// FETCH DATA FUNCTION…
async function getDataAPI(url) {
  try {
    let response = await fetch(url);
    return await response.json();
  } catch (error) {
    console.log(error);
  }
}

// GET NUMBER PAGE…
const table              = document.querySelector('.fetch-table'),
      tbody              = table.querySelector('tbody'),
      nombreTopsDOM      = table.querySelector('.nb_top_vkrz'),
      idVainkeur         = table.dataset.idvainkeur,
      loadAllTopListsBtn = document.querySelector('.load_more_toplists'),
      progressBar        = document.querySelector(".bar"),
      barPercent         = document.querySelector(".bar-percent");


const data = await getDataAPI(`https://vainkeurz.com/wp-json/vkrz/v1/get_numberpage_vainkeur/${idVainkeur}`);

let nombrePages            = data.nb_pages,
    nombreTops             = data.total_items,
    row                    = "",
    typeTopWording         = "",
    progressBarWidthNumber = 0,
    iteration = 0;

loadAllTopListsBtn.addEventListener("click", () => {

  // START RENDERING…
  progressBar.style.display = `block`;
  barPercent.textContent = `1 %`;
  progressBar.style.width = `1%`;

  $(loadAllTopListsBtn).hide();
  $('.list-php').hide();
  $('.loader-list').show();
  var aTag = $("#ancore");
  $('html,body').animate({ scrollTop: aTag.offset().top }, 'slow');


  // INIT LOADER…
  tbody.innerHTML = `
    <!-- data load from firebase -->
    <tr>
      <th></th>
      <th style="transform: translateX(45%);">
        <span class="similarpercent">
          <div class="loader loader--style1" title="0">
            <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
              <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
          s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
          c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z" />
              <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
          C22.32,8.481,24.301,9.057,26.013,10.047z">
                <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite" />
              </path>
            </svg>
          </div>
        </span>
      </th>
      <th></th>
      <th></th>
    </tr>
  `;

  // FETCH LOOP…
  (async function render() {
    // FETCH TOPLISTS DATA BY PAGE…
    for (let i = 1; i <= nombrePages; i++) {
      let toplists = await getDataAPI(
        `https://vainkeurz.com/wp-json/vkrz/v1/getalltoplistbyidvainkeur/${idVainkeur}/${i}`
      );

      toplists.forEach((toplist) => {
        let contendersTD           = "";
        toplist.podium.forEach(contender => {
          contendersTD += `
          <div 
          data-toggle="tooltip" 
          data-popup="tooltip-custom" 
          data-placement="bottom" data-original-title="${!contender.nom_contender ? '' : contender.nom_contender}" 
          class="avatartop3 avatar pull-up">
            <img src="${contender.visuel_contender}" alt="${!contender.nom_contender ? '' : contender.nom_contender}">
          </div>
          `
        })

        // CHECK IF TOP COMPLET OR TOP 3…
        if (toplist.typetop == "top3") {
          typeTopWording = "Voir le Top 3";
        } else {
          typeTopWording = "Voir la TopList";
        }

        row += `
          <tr id="top-${toplist.id_top}">
            <td>
              <a href="${toplist.top_link}" class="top-card">
                <div class="d-flex align-items-center">
                    <div class="avatar">
                        <span class="avatar-picture avatar-top" style="background-image: url(${toplist.thumbnail});"></span>
                    </div>
                    <div class="font-weight-bold topnamebestof">
                        <div class="media-body">
                            <div class="media-heading">
                                <h6 class="cart-item-title mb-0">
                                    ${toplist.top_title}
                                </h6>
                                <span class="cart-item-by legende">
                                    ${toplist.top_question}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
              </a>
            </td>

            <td>
              ${contendersTD}
            </td>

            <td class="text-right">
              ${toplist.nb_votes} <span class="ico3 va-high-voltage va va-lg"></span>
            </td>

            <td class="text-right">
              <a class="btn btn-flat-secondary waves-effect" href="${toplist.toplist_link}" data-toggle="tooltip" data-placement="top" title="" data-original-title="${typeTopWording}">
                <span class="va va-trophy va-lg"></span>
              </a>
              <a class="btn btn-flat-secondary waves-effect" href="${toplist.elo_link}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir la TopList mondiale">
                <span class="va va-globe va-lg"></span>
              </a>
              <a href="${toplist.toplist_link}" class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Juger cette TopList">
                <span class="va va-hache va-lg"></span>
              </a>
            </td>
          </tr>
        `;
      });

      // INCREMENTE PROGRESS BAR…
      iteration = 100 / nombrePages;
      progressBarWidthNumber += Math.round(iteration);
      progressBarWidthNumber = Math.min(progressBarWidthNumber, 99)
      barPercent.textContent = `${progressBarWidthNumber} %`;
      barPercent.style.left = `${progressBarWidthNumber - 2}%`;
      progressBar.style.width = `${progressBarWidthNumber}%`;

      if(i === nombrePages) {
        progressBar.style.width = `100%`;
        tbody.innerHTML = row;

        $('.loader-list').hide();
        $(".list-js").show();

        // INIT DATATABLES…
        $(".fetch-table").DataTable({
        autoWidth: true,
        lengthMenu: [25],
        pagingType: "full_numbers",
        columns: [
          { orderable: false },
          { orderable: true },
          { orderable: true },
          { orderable: false },
          ],
          language: {
          search: "_INPUT_",
          searchPlaceholder: "Rechercher...",
          processing: "Traitement en cours...",
          info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
          infoEmpty:
              "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
          infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
          infoPostFix: "",
          loadingRecords: "Chargement en cours...",
          zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher 😩",
          emptyTable: "Aucun résultat trouvé 😩",
          paginate: {
              first: "Premier",
              previous: "Pr&eacute;c&eacute;dent",
              next: "Suivant",
              last: "Dernier",
          },
          },
          order: [],
        });

        // INIT CONTENDERS BUBBLE…
        $(document).ready(function() {
          $("body").tooltip({
              selector: '[data-toggle=tooltip]'
          });
        });
      }
    }
  })();
})
