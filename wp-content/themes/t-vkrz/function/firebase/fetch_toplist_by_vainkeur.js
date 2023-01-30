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


const data = await getDataAPI(`http://localhost:8888/vkrz/wp-json/vkrz/v1/get_numberpage_vainkeur/${idVainkeur}`);

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

  // FETCH LOOP…
  (async function render() {
    // FETCH TOPLISTS DATA BY PAGE…
    for (let i = 1; i <= nombrePages; i++) {
      let toplists = await getDataAPI(
        `http://localhost:8888/vkrz/wp-json/vkrz/v1/getalltoplistbyidvainkeur/${idVainkeur}/${i}`
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
              <div class="top3list">
                ${contendersTD}
              </div>
            </td>

            <td>
              <div class="d-flex align-items-center justify-content-end col-actions">
                  <a class="btn btn-icon btn-label-primary waves-effect" href="${toplist.toplist_link}" data-toggle="tooltip" data-placement="top" title="${typeTopWording}" data-original-title="Voir la TopList">
                    <span class="va va-trophy va-lg"></span>
                  </a>

                  <a class="btn btn-icon btn-label-primary waves-effect" href="(TopList Mondiale Link)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir la TopList mondiale">
                    <span class="va va-globe va-lg"></span>
                  </a>
                  
                  <a href="${toplist.toplist_link}#juger" class="btn btn-icon btn-label-primary waves-effect" data-toggle="tooltip" data-placement="top" title="${typeTopWording}" data-original-title="Juger cette TopList">
                    <span class="va va-hache va-lg"></span>
                  </a>
              </div>
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

        $('.loadmore-container').hide();
        $('.loader-list').hide();
        $(".list-js").show();

        // INIT DATATABLES…
        $(".fetch-table").DataTable({
        autoWidth: true,
        lengthMenu: [25],
        pagingType: "full_numbers",
        columns: [
          { orderable: false },
          { orderable: false },
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
