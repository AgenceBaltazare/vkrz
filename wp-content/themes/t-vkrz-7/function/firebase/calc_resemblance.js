import { collection, database, query, where, getDocs, getDoc, doc } from "./config.js";
import { checkGuetterButton } from "./follow_button.js";

const table = document.querySelector("table"),
  tbody = table.querySelector("tbody"),
  calcResemblanceDiv = document.querySelector(".calc-resemblance"),
  idTop = calcResemblanceDiv.dataset.idtop,
  urlTop = calcResemblanceDiv.dataset.topurl,
  barPercent = calcResemblanceDiv.querySelector(".bar-percent"),
  progressBar = calcResemblanceDiv.querySelector(".bar");

async function getDataAPI(url) {
  try {
    let response = await fetch(url);
    return await response.json();
  } catch (error) {
    console.log(error);
  }
}

const getNombrePages = await getDataAPI(
  `https://vainkeurz.com/wp-json/vkrz/v1/getalltoplistnumberpage/${idTop}`
);

let nombrePages = getNombrePages.nb_pages,
  row = "",
  contendersTD = "",
  guetterTD   =  "",
  progressBarWidthNumber = 0,
  iteration = 0;

(async function render() {
  // START RENDERING…
  progressBar.style.display = `block`;
  barPercent.textContent = `1 %`;
  progressBar.style.width = `1%`;

  // FETCH TOPLISTS DATA BY PAGE…
  for (let i = 1; i <= nombrePages; i++) {
    let toplists = await getDataAPI(
      `https://vainkeurz.com/wp-json/vkrz/v1/getalltoplistbyidtop/${idTop}/${i}`
    );

    toplists.forEach((toplist) => {
      // CHECK NUMBER OF CONTENDERS MAYBE THERE IS ONLY TWO…
      if (toplist.podium.length === 3) {
        contendersTD = `
        <td>
          <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="${toplist.podium[0].nom_contender}" class="avatartop3 avatar pull-up">
              <img src="${toplist.podium[0].visuel_contender}" alt="${toplist.podium[0].nom_contender}">
          </div>
          <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="${toplist.podium[1].nom_contender}" class="avatartop3 avatar pull-up">
            <img src="${toplist.podium[1].visuel_contender}" alt="${toplist.podium[1].nom_contender}">
          </div>
          <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="${toplist.podium[2].nom_contender}" class="avatartop3 avatar pull-up">
            <img src="${toplist.podium[2].visuel_contender}" alt="${toplist.podium[2].nom_contender}">
          </div>
        </td>
        `;
      } else {
        contendersTD = `
        <td>
          <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="${toplist.podium[0].nom_contender}" class="avatartop3 avatar pull-up">
              <img src="${toplist.podium[0].visuel_contender}" alt="${toplist.podium[0].nom_contender}">
          </div>
          <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="${toplist.podium[1].nom_contender}" class="avatartop3 avatar pull-up">
            <img src="${toplist.podium[1].visuel_contender}" alt="${toplist.podium[1].nom_contender}">
          </div>
        </td>
        `;
      }

      // CHECK IF CURRENT USER IS CONNECTED…
      if(currentUserId != "0") {
        guetterTD = `
        <td class="text-right checking-follower">
          <button 
            type="button" 
            id="followBtn" 
            class="btn waves-effect btn-follow d-none" 
            data-userid="${currentUserId}" 
            data-uuid="${currentUuid}" 
            data-relatedid="${toplist.vainkeur.id_user}" 
            data-relateduuid="${toplist.vainkeur.uuid_vainkeur}" 
            data-text="${vainkeurPseudo} te guette !" 
            data-url="${currentUserProfileUrl}"
          >
            <span class="wording">Guetter</span>
            <span class="va va-guetteur-close va va-z-20 emoji"></span>
          </button>
        </td>
        `;
      } else {
        guetterTD = `
        <td>
          <a href="https://vainkeurz.com/se-connecter" class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tu dois être connecté pour guetter ${toplist.vainkeur.pseudo}">
          <span class="text-muted">
              Guetter <span class="va va-guetteur-close va va-z-20 emoji"></span>
          </span>
          </a>
        </td>
        `;
      }

      row += `
        <tr id="rows" class="uuid${
          toplist.vainkeur.uuid_vainkeur
        } uncalculated">
            <td>
              <div class="vainkeur-card">
                <a href="${
                  toplist.vainkeur.profil_url
                }" class="btn btn-flat-primary waves-effect">
                    <span class="avatar">
                        <span class="avatar-picture" style="background-image: url(${
                          toplist.vainkeur.avatar
                        });"></span>
                    </span>
                    <span class="championname">
                        <h4>${toplist.vainkeur.pseudo}</h4>
                        <span class="medailles">
                          ${toplist.vainkeur.level}
                          ${
                            toplist.vainkeur.user_role == "administrator"
                              ? '<span class="va va-vkrzteam va-z-15" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ"></span>'
                              : ""
                          }
                          ${
                            toplist.vainkeur.user_role == "administrator" ||
                            toplist.vainkeur.user_role == "author"
                              ? '<span class="va va-man-singer va-z-15" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops"></span>'
                              : ""
                          }
                        </span>
                    </span>

                </a>
              </div>
            </td>

            ${contendersTD}

            <td class="text-center">
              <a href="${urlTop}" 
              class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tu dois faire ta TopList pour calculer la ressemblance #logik">
                <span class="va va-unknow va-lg"></span>
              </a>
            </td>

            <td class="text-right">
              <a href="${
                toplist.toplist_url
              }" class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir la TopList">
                  <span class="ico ico-reverse va va-eyes va-lg"></span>
              </a>
              <a href="${
                toplist.toplist_url
              }" class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Juger sa TopList">
                  <span class="ico va va-hache va-lg"></span>
              </a>
            </td>

            ${guetterTD}
        </tr>
      `;
    });

    // INCREMENTE PROGRESS BAR…
    iteration = 100 / nombrePages;
    progressBarWidthNumber += Math.round(iteration);
    progressBarWidthNumber = Math.min(progressBarWidthNumber, 99)
    barPercent.textContent = `${progressBarWidthNumber} %`;
    barPercent.style.left = `${progressBarWidthNumber - 3}%`;
    progressBar.style.width = `${progressBarWidthNumber}%`;

    // LAST ITERATION OF THE LOOP, ALL THE DATA FETCHED…
    if (i === nombrePages) {
      tbody.innerHTML = row;

      // GUETTER BUTTONS…
      checkGuetterButton();

      // GET DATA FROM FIRESTORE AND CALCULATE RESEMBLANCE…
      (async function () {
        // SORT CONTENDERS FUNCTION…
        const sortContenders = function (contenders) {
          let contendersArr = [],
            contendersArrPlaces = [],
            contendersArrIDs = [];

          for (let contender of contenders) {
            delete contender.c_name;
            delete contender.elo;
            delete contender.id;
            delete contender.less_to;
            delete contender.more_to;
            delete contender.ratio;
            delete contender.image;

            contendersArr.push(contender);
            contendersArrPlaces.push(contender.place);

            contendersArrIDs.push(contender.id_wp);
          }
          contendersArr.sort(function (a, b) {
            return b.place - a.place;
          });
          contendersArrPlaces
            .sort(function (a, b) {
              return b - a;
            })
            .reverse();
          for (let j = 0; j < contendersArr.length; j++) {
            contendersArr[j].place = contendersArrPlaces[j];
          }
          contenders = contendersArr;

          return contenders;
        };

        // CALC RESEMBLANCE FUNCTION…
        const calcResemblanceFunc = function (
          myContenders,
          othersContenders,
          top3
        ) {
          let numberContenders = myContenders.length,
            positionEcart,
            similaire,
            pourcentSimilaire = [],
            ressemblances = [],
            ecartRessemblance;

          if (top3 === true) {
            myContenders = myContenders.slice(0, 3);
            othersContenders = othersContenders.slice(0, 3);

            numberContenders = 3;

            myContenders.forEach(
              (contender, index) => (contender.place = index)
            );
            othersContenders.forEach(
              (contender, index) => (contender.place = index)
            );
          }

          for (let i = 0; i < numberContenders; i++) {
            let otherContenderPlace;
            if (
              othersContenders.find(
                (contender) => contender.id_wp === myContenders[i].id_wp
              )
            ) {
              otherContenderPlace = othersContenders.find(
                (contender) => contender.id_wp === myContenders[i].id_wp
              ).place;
              positionEcart = Math.abs(
                myContenders[i].place - otherContenderPlace
              );
              similaire = 1 / numberContenders / (positionEcart + 1);
            } else {
              otherContenderPlace = 0;
              positionEcart = Math.abs(
                myContenders[i].place - otherContenderPlace
              );
              similaire = 0;
            }

            if (top3 == true) {
              ecartRessemblance =
                1 / numberContenders / (numberContenders / 2 + 1);
              pourcentSimilaire.push(similaire);
            } else {
              ecartRessemblance =
                1 / numberContenders / (Math.floor(numberContenders / 2) + 1);

              if (similaire <= ecartRessemblance) {
                similaire = 0;
                pourcentSimilaire.push(similaire);
              } else {
                pourcentSimilaire.push(similaire);
              }
            }
          }

          ressemblances.push(
            Math.round(pourcentSimilaire.reduce((a, b) => a + b, 0) * 100)
          );
          let result =
            Math.round(pourcentSimilaire.reduce((a, b) => a + b, 0) * 100) +
            "%";

          return result;
        };

        // RESET TABLE FUNCTION…
        const resetTable = function () {
          // INIT DataTables…
          $(".table-listuserranks").DataTable({
            autoWidth: false,
            lengthMenu: [25],
            pagingType: "full_numbers",
            columns: [
              { orderable: false },
              { orderable: false },
              { orderable: true },
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
              infoFiltered:
                "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
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
            order: [[2, "desc"]],
          });

          // INIT CONTENDERS BUBBLE…
          $(document).ready(function () {
            $("body").tooltip({
              selector: "[data-toggle=tooltip]",
            });
          });

          document.querySelector(".calc-resemblance").classList.add("d-none");
          document
            .querySelector(".table-card-container")
            .classList.remove("d-none");
        };

        // GET ACTUAL USER RANKING…
        const actualUserRankingQuery = query(
          collection(database, "wpClassement"),
          where("custom_fields.id_tournoi_r", "==", idTop),
          where("custom_fields.done_r", "==", "done"),
          where("custom_fields.uuid_user_r", "==", currentUuid)
        );
        const actualUserRankingQuerySnapshot = await getDocs(
          actualUserRankingQuery
        );

        // CALC TOPLIST MONDIALE…
        if(document.querySelector('#ressemblance-ma-toplist-mondiale')) {
          const resultsDOM = document.querySelector('#ressemblance-ma-toplist-mondiale');

          let rankingArr   = [],
            eloArr       = [],
            myTypeTopRankingMondiale;
          actualUserRankingQuerySnapshot.forEach(ranking => {
            rankingArr = sortContenders(ranking.data().custom_fields.ranking_r)
            myTypeTopRankingMondiale = ranking.data().custom_fields.type_top_r;
          });

          let top3Mondiale = false;
          if (myTypeTopRankingMondiale == "top3") top3Mondiale = true;

          for(let [index, contender] of rankingArr.entries()){
            (async function() {
                const documentReference = doc(database, "wpContender", (contender.id_wp).toString());
                const documentSnap      = await getDoc(documentReference);

                eloArr.push({place: index, elo: +documentSnap.data().custom_fields.ELO_c, id_wp: contender.id_wp})

                eloArr = eloArr.sort((a, b) => b.elo - a.elo)
                eloArr.forEach((contender, index) => contender.place = index);

                if((index + 1) == rankingArr.length) {
                  resultsDOM.textContent = calcResemblanceFunc(rankingArr, eloArr, top3Mondiale);
                }
            })()
          }
        }

        if (actualUserRankingQuerySnapshot._snapshot.docs.size != 0) {
          let myTypeTopRanking, otherTypeTopRanking; // TO DEFINE…
          // SORT MY RANKING…
          let myContenders = [];
          actualUserRankingQuerySnapshot.forEach((ranking) => {
            myContenders = sortContenders(
              ranking.data().custom_fields.ranking_r
            );
            myTypeTopRanking = ranking.data().custom_fields.type_top_r;
          });
          console.log("My ranking: ", myContenders);

          // USERS RANKS…
          const usersRanksQuery = query(
            collection(database, "wpClassement"),
            where("custom_fields.id_tournoi_r", "==", idTop),
            where("custom_fields.done_r", "==", "done")
          );
          const usersRanksQuerySnapshot = await getDocs(usersRanksQuery);
          console.log(
            "Number of docs From Firestore: ",
            usersRanksQuerySnapshot._snapshot.docs.size
          );

          let index = 0;
          usersRanksQuerySnapshot.forEach((ranking) => {
            let uuid = ranking.data().custom_fields.uuid_user_r,
              contenders = [];
            contenders = sortContenders(ranking.data().custom_fields.ranking_r);

            otherTypeTopRanking = ranking.data().custom_fields.type_top_r;

            let row = document.querySelector(`.uuid${uuid}`);

            let top3 = false;
            if (myTypeTopRanking == "top3" || otherTypeTopRanking == "top3") {
              top3 = true;
            }

            if (myContenders.length === contenders.length && row) {
              if (
                row.getAttribute("class").split(" ")[0] == `uuid${currentUuid}`
              ) {
                row.style.opacity = "0.3";
                row.style.fontStyle = "italic";
                row.querySelector("td:nth-of-type(5)").innerHTML = "";
              }

              let calcResemblanceVar = calcResemblanceFunc(
                myContenders,
                contenders,
                top3
              );

              // RESEMBLANCE NUMBER…
              let resemblanceOnlyNumber = calcResemblanceVar.substring(
                0,
                calcResemblanceVar.indexOf("%")
              );
              resemblanceOnlyNumber = +resemblanceOnlyNumber;
              if (resemblanceOnlyNumber == 100) {
                calcResemblanceVar = `
                  <span class="badge rounded-pill badge-light-success me-1">${calcResemblanceVar}</span>
                `;
              } else if (
                resemblanceOnlyNumber >= 30 &&
                resemblanceOnlyNumber < 100
              ) {
                calcResemblanceVar = `
                  <span class="badge rounded-pill badge-light-info me-1">${calcResemblanceVar}</span>
                `;
              } else {
                calcResemblanceVar = `
                  <span class="badge rounded-pill badge-light-warning me-1">${calcResemblanceVar}</span>
                `;
              }

              row.classList.remove("uncalculated");
              row.classList.add("calculated");
              row.querySelector("td:nth-of-type(3)").innerHTML =
                calcResemblanceVar;
            }
            index++;

            // READY TO SHOW, ALL DATA FROM FIRESTORE FETCHED AND CALCULATED…
            if (index === usersRanksQuerySnapshot._snapshot.docs.size) {
              document
                .querySelectorAll(".uncalculated")
                .forEach((el) => el.remove());

              resetTable();
            }
          });
        } else {
          resetTable()
        }
      })();
    }
  }
})();
