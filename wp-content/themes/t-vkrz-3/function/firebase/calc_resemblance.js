import { collection, database, query, where, getDocs } from "./config.js";

/* 
$(".lauch-calressemblance").on('click', function (event) {
  $(".calc-resemblance").trigger("click");
});

// INIT…
const calcResemblanceDiv = document.querySelector(".calc-resemblance");
const idTop = calcResemblanceDiv.dataset.idtop;

calcResemblanceDiv.classList.add("loaded");
calcResemblanceDiv.addEventListener(
  "click",
  async function () {
    // DOM…
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
    const calcResemblance = function (myContenders, othersContenders, top3) {
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

    let myTypeTopRanking, otherTypeTopRanking; // TO DEFINE…
    // SORT MY RANKING…
    let myContenders = [];
    actualUserRankingQuerySnapshot.forEach(
      (ranking) => {
        myContenders = sortContenders(ranking.data().custom_fields.ranking_r);
        myTypeTopRanking = ranking.data().custom_fields.type_top_r;
      }
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

      otherTypeTopRanking = ranking.data().custom_fields.type_top_r;

      let row = document.querySelector(`.uuid${uuid}`);

      let top3 = false;
      if(myTypeTopRanking == "top3" || otherTypeTopRanking == "top3") {
        top3 = true;
      }

      if (myContenders.length === contenders.length && row) {
        if(row.getAttribute('class').split(' ')[0] == `uuid${currentUuid}`) {
          row.style.opacity = "0.3"
          row.style.fontStyle = "italic"
        }

        let calcResemblanceVar = calcResemblance(myContenders, contenders, top3);

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
        document.querySelector(".calc-resemblance").hidden = true;
        clearInterval(progressBarInterval);
        progressBar.style.width = `100%`;

        document.querySelectorAll(".uncalculated").forEach((el) => el.remove());
      }
    });
  },
  { once: true }
);
 */

async function getUserData(link) {
  try {
    let response = await fetch(link);
    return await response.json();
  } catch (error) {
    console.log(error);
  }
}
let data = await getUserData(
  "https://vainkeurz.com/wp-json/vkrz/v1/getalltoplistbyidtop/279103/1"
);
data = Object.entries(data);

let nbPage = data[0][1].nb_pages;
console.log(nbPage);

let row = "";
let results;
let arrTopList = [];

let $c = 1;

for (let i = 2; i <= nbPage; i++) {
async function asyncFunc() {
  console.log(nbPage);
    results = await getUserData(
      `https://vainkeurz.com/wp-json/vkrz/v1/getalltoplistbyidtop/279103/${i}`
    );
    arrTopList = Object.entries(results.toplist);

    arrTopList.forEach((toplist) => {
        let vainkeurPseudoTest = toplist[1].vainkeur.pseudo;
        let vainkeurAvatarTest = toplist[1].vainkeur.avatar;
        row += `
          <tr id="rows">
              <td>
                ${$c} | ${vainkeurPseudoTest}
              </td>

              <td>
              <img src="${vainkeurAvatarTest}" style="width: 40px;height:auto;">
            </td>
          </tr>
        `;
        $c++;
        
      // document.querySelector("tbody").innerHTML = row;
    });

    console.log(i === nbPage, i);

    if(i === nbPage) {
      document.querySelector("tbody").innerHTML = row;
    }
}
asyncFunc()
}

// let index = 2;

// async function delay(ms) {
//   // return await for better async stack trace support in case of errors.
//   return await new Promise(resolve => setTimeout(resolve, ms));
// }

// let run = async () => {
//   await delay(2000);
//   asyncFunc(index++);
// }
// setInterval(run, 1000);

// document.querySelector('.load__more').addEventListener("click", () => {
//   asyncFunc(index++);
// })
