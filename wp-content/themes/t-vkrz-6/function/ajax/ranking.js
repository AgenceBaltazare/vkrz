import {
    collection,
    getDocs,
    getDoc,
    query,
    where,
    database,
    doc,
} from "../firebase/config.js";

$(document).ready(function ($) {
  setInterval(getContendersRanking, 10000, topId);
  // const t = getContendersRanking(topId);

  function getContendersRanking(topId) {
    let previousRanking = [];
    $("[data-id]").each(function () {
      previousRanking[$(this).attr("data-id")] = $(this)
        .find(".pointselo")
        .attr("data-points");
    });

    $.ajax({
      method: "POST",
      url: vkrz_ajaxurl,
      data: {
        action: "vkzr_get_contenders_ranking",
        topId: topId,
      },
    })
      .done(function (response) {
        const data = JSON.parse(response);

        for (let place = 1; place <= data.length; place++) {
          const placeSelector = $("#ranking-${place}");
          const illustrationSelector = $("#ranking-${place} .illu img");
          const titleSelector = $("#ranking-${place} .ranking-title");
          const pointsSelector = $("#ranking-${place} .pointselo");

          const newId = data[place - 1].id;
          const newIllustration = data[place - 1].illustration;
          const newTitle = data[place - 1].title;
          const newPoints = Number(data[place - 1].points);

          if (newId === Number(placeSelector.attr("data-id"))) {
            const previousPoints = Number(
              previousRanking[placeSelector.attr("data-id")]
            );
            pointsSelector.attr("data-points", newPoints);

            if (previousPoints < newPoints) {
              pointsSelector.html(
                '<i class="fas fa-caret-up"></i> ${newPoints} pts'
              );
            } else if (previousPoints > newPoints) {
              pointsSelector.html(
                '<i class="fas fa-caret-down"></i> ${newPoints} pts'
              );
            } else if (previousPoints === newPoints) {
              pointsSelector.find(".fas").remove();
            }
          } else {
            const previousPoints = Number(previousRanking[newId]);

            placeSelector.attr("data-id", newId);
            illustrationSelector.attr("src", newIllustration);
            titleSelector.html(newTitle);
            pointsSelector.attr("data-points", newPoints);

            if (previousPoints < newPoints) {
              pointsSelector.html(
                '<i class="fas fa-angle-double-up"></i> ${newPoints} pts'
              );
            } else if (previousPoints > newPoints) {
              pointsSelector.html(
                '<i class="fas fa-angle-double-down"></i> ${newPoints} pts'
              );
            }
          }
        }
      })
      .fail(function () {
        console.log("Ranking is not up to date");
      });
  }

  if (document.querySelector(".ressemblance-elo-avec-ma-toplist")) {
    const div           = document.querySelector(".ressemblance-elo-avec-ma-toplist"),
          results       = div.querySelector('.results'),
          myRankingLink = div.querySelector('.my-ranking-url'),
          idTop         = div.dataset.idtop;

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

        myContenders.forEach((contender, index) => (contender.place = index));
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
          positionEcart = Math.abs(myContenders[i].place - otherContenderPlace);
          similaire = 1 / numberContenders / (positionEcart + 1);
        } else {
          otherContenderPlace = 0;
          positionEcart = Math.abs(myContenders[i].place - otherContenderPlace);
          similaire = 0;
        }

        if (top3 == true) {
          ecartRessemblance = 1 / numberContenders / (numberContenders / 2 + 1);
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
        Math.round(pourcentSimilaire.reduce((a, b) => a + b, 0) * 100) + "%";

      return result;
    };

    (async function() {
        const myRankingQuery = query(
            collection(database, "wpClassement"),
            where("custom_fields.id_tournoi_r", "==", idTop),
            where("custom_fields.done_r", "==", "done"),
            where("custom_fields.uuid_user_r", "==", currentUuid)
            );
        const myRankingQuerySnapshot = await getDocs(myRankingQuery);

        let rankingArr   = [],
            eloArr       = [];
        myRankingQuerySnapshot.forEach(ranking => {
            myRankingLink.setAttribute('href', ranking.data().permalink);
            rankingArr = sortContenders(ranking.data().custom_fields.ranking_r);
        });

        for(let [index, contender] of rankingArr.entries()){
        (async function() {
            const documentReference = doc(database, "wpContender", (contender.id_wp).toString());
            const documentSnap      = await getDoc(documentReference);

            eloArr.push({place: index, elo: +documentSnap.data().custom_fields.ELO_c, id_wp: contender.id_wp})

            eloArr = eloArr.sort((a, b) => b.elo - a.elo)
            eloArr.forEach((contender, index) => contender.place = index);

            if((index + 1) == rankingArr.length) {
                results.textContent = calcResemblanceFunc(rankingArr, eloArr);
            }
        })()
        }
    })()
  }
});
