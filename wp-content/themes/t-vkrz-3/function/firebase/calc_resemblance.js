import { collection, database, query, where, getDocs } from "./config.js";

// INIT…
const calcResemblanceDiv = document.querySelector(".calc-resemblance");
const idTop = calcResemblanceDiv.dataset.idtop;

calcResemblanceDiv.classList.add("loaded");
calcResemblanceDiv.addEventListener(
  "click",
  async function () {
    // DOM…
    $(".table-listuserranks").DataTable().destroy();

    document.querySelector("tbody").style.opacity = "0.5";
    const h1 = calcResemblanceDiv.querySelector(".calc-resemblance-h1");
    const progressBar = calcResemblanceDiv.querySelector(".bar");
    progressBar.style.width = `0%`;

    let width = 0;
    const progressBarInterval = setInterval(function () {
      if (width < 99) {
        width += 9;
        h1.textContent = `${width} %`;
        progressBar.style.width = `${width}%`;
      }
    }, 400);

    // FUNCTION TO SORT CONTENDERS…
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

    // CALC RESEMBLANCE…
    const calcResemblance = function (myContenders, otherContenders) {
      let numberContenders = myContenders.length,
        positionEcart,
        similaire,
        pourcentSimilaire = [],
        ressemblances = [],
        totalRessemblances = 0;

      for (let i = 0; i < numberContenders; i++) {
        let otherContenderPlace = otherContenders.find(
          (contender) => contender.id_wp === myContenders[i].id_wp
        ).place;

        positionEcart = Math.abs(myContenders[i].place - otherContenderPlace);

        similaire = 1 / numberContenders / (positionEcart + 1);
        if (
          similaire <=
          1 / numberContenders / (Math.floor(numberContenders / 2) + 1)
        ) {
          similaire = 0;
          pourcentSimilaire.push(similaire);
        } else {
          pourcentSimilaire.push(similaire);
        }
      }

      if (
        Math.round(pourcentSimilaire.reduce((a, b) => a + b, 0) * 100) == 100
      ) {
        totalRessemblances++;
      }

      ressemblances.push(
        Math.round(pourcentSimilaire.reduce((a, b) => a + b, 0) * 100)
      );
      let result =
        Math.round(pourcentSimilaire.reduce((a, b) => a + b, 0) * 100) + "%";

      return result;
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

    // SORT MY RANKING…
    let myContenders = [];
    actualUserRankingQuerySnapshot.forEach(
      (ranking) =>
        (myContenders = sortContenders(ranking.data().custom_fields.ranking_r))
    );
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

      let row = document.querySelector(`.uuid${uuid}`);
      if (myContenders.length === contenders.length && row) {
        let calcResemblanceVar = calcResemblance(myContenders, contenders);

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
        } else if (resemblanceOnlyNumber >= 30 && resemblanceOnlyNumber < 100) {
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
        row.querySelector("td:nth-of-type(3)").innerHTML = calcResemblanceVar;
      }

      index++;
      if (index === usersRanksQuerySnapshot._snapshot.docs.size) {
        // DOM…
        document.querySelector("tbody").style.opacity = "1";
        h1.textContent = "Resemblance is Done!";
        clearInterval(progressBarInterval);
        progressBar.style.width = `100%`;

        document.querySelectorAll(".uncalculated").forEach((el) => el.remove());

        // INIT TABLE…
        if (!$.fn.DataTable.isDataTable(".table-listuserranks")) {
          $(".table-listuserranks").DataTable({
            autoWidth: false,
            lengthMenu: [25],
            pagingType: "full_numbers",
            order: [[2, "desc"]],
            columns: [
              {
                orderable: false,
              },
              {
                orderable: false,
              },
              {
                orderable: true,
              },
              {
                orderable: false,
              },
              {
                orderable: false,
              },
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
          });
        }
      }
    });
  },
  { once: true }
);
