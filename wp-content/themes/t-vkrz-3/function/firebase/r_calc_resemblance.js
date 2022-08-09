import {
  collection,
  database,
  query,
  where,
  doc,
  getDoc,
  getDocs,
} from "./config.js";

if (document.querySelector(".vs-resemblance")) {
  const cardResemblance = document.querySelector(".vs-resemblance");
  const idRanking = cardResemblance.dataset.idranking;
  const idTop = cardResemblance.dataset.idtop;
  const rankingUrl = cardResemblance.dataset.rankingUrl;

  // CHECK IF IT IS MY RANKING OR NOT…
  const rankingQuery = query(
    collection(database, "wpClassement"),
    where("ID", "==", +idRanking),
    where("author.id", "==", currentUserId)
  );
  const rankingQuerySnapshot = await getDocs(rankingQuery);

  if (rankingQuerySnapshot._snapshot.docs.size !== 1) {
    // OK GOOD, OTHER'S RANKING…

    // CHECK IF I ALREADY DID THE RANKING…
    const myRankingQuery = query(
      collection(database, "wpClassement"),
      where("custom_fields.id_tournoi_r", "==", idTop),
      where("author.id", "==", currentUserId),
      where("custom_fields.done_r", "==", "done")
    );
    const myRankingQuerySnapshot = await getDocs(myRankingQuery);

    if (myRankingQuerySnapshot._snapshot.docs.size === 1) {
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

      // FUCNTION TO CALC RESEMBLANCE…
      const calcResemblanceFunc = function (myContenders, othersContenders) {
        let numberContenders = myContenders.length,
          positionEcart,
          similaire,
          pourcentSimilaire = [],
          ressemblances = [],
          totalRessemblances = 0;

        for (let i = 0; i < numberContenders; i++) {
          let otherContenderPlace = othersContenders.find(
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

      let myRankingArr = [];
      myRankingQuerySnapshot.forEach(
        (ranking) =>
          (myRankingArr = sortContenders(
            ranking.data().custom_fields.ranking_r
          ))
      );

      // GET THE RANKING OF THE OTHER VAINKEUR FROM FIRESTORE…
      const rankingQuery = doc(database, "wpClassement", idRanking);
      const rankingQuerySnapshot = await getDoc(rankingQuery);

      if (rankingQuerySnapshot.exists()) {
        // FOUND IN FIRESTORE…
        let othersRankingArr = [];
        othersRankingArr = sortContenders(
          rankingQuerySnapshot.data().custom_fields.ranking_r
        );

        // COMPARE IT WITH MY RANKING…
        let calcResemblance = calcResemblanceFunc(
          myRankingArr,
          othersRankingArr
        );
        document.querySelector(".vs-resemblance").innerHTML = `
        <h2 class="mt-2 text-center mb-0">
          <b style="color: #7266EF;">${calcResemblance}</b> de ressemblance avec ta TopList !
        </h2>
        `
          ;
      } else {
        // NOT FOUND IN FIRESTORE…
        console.log("No such document in Firestore!");
      }
    } else {
      // I DIDN'T RANKING…
      console.log("I did not the ranking…");
      cardResemblance.innerHTML = `
      <a href="${rankingUrl}" class="w-100 btn btn-rose waves-effect p-1 mt-2">
        <p class="h4 text-white m-0">
          Faire ma TopList
        </p>
      </a>
    `;
    }
  } else {
    // MY RANKING…
    console.log("My Ranking…");
  }
}
