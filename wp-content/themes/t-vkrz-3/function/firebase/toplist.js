import {
  collection,
  database,
  query,
  where,
  doc,
  getDoc,
  deleteDoc,
  getDocs,
  addDoc,
  orderBy,
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

      // TO DEFINE…
      let myTypeTopRanking, otherTypeTopRanking;

      let myRankingArr = [];
      myRankingQuerySnapshot.forEach((ranking) => {
        myRankingArr = sortContenders(ranking.data().custom_fields.ranking_r);

        myTypeTopRanking = ranking.data().custom_fields.type_top_r;
      });

      // GET THE RANKING OF THE OTHER VAINKEUR FROM FIRESTORE…
      const rankingQuery = doc(database, "wpClassement", idRanking);
      const rankingQuerySnapshot = await getDoc(rankingQuery);

      if (rankingQuerySnapshot.exists()) {
        // FOUND IN FIRESTORE…
        let othersRankingArr = [];
        othersRankingArr = sortContenders(
          rankingQuerySnapshot.data().custom_fields.ranking_r
        );
        otherTypeTopRanking =
          rankingQuerySnapshot.data().custom_fields.type_top_r;

        // CHECK IF WE HAVE THE SAME TYPE TOP RANKING BEFORE COMPARE…
        let top3 = false;
        if (myTypeTopRanking == "top3" || otherTypeTopRanking == "top3") {
          top3 = true;
        }
        // COMPARE IT WITH MY RANKING…
        let calcResemblance = calcResemblanceFunc(
          myRankingArr,
          othersRankingArr,
          top3
        );

        document.querySelector(".vs-resemblance").innerHTML = `
            <h2 class="mt-2 text-center mb-0">
              <b style="color: #7266EF;">${calcResemblance}</b> de ressemblance avec ta TopList !
            </h2>
          `;
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

// TOPLIST COMMENTS…
const toplistCommentsCard = document.querySelector(".toplist_comments"),
  sendCommentBtn = toplistCommentsCard.querySelector("#send_comment_btn"),
  idRanking = toplistCommentsCard.dataset.idranking,
  urlRanking = toplistCommentsCard.dataset.urlranking;
const commentsContainer = toplistCommentsCard.querySelector(
  ".comments-container"
);

const commentTemplate = async function (commentId, uuid, content, secondes) {
  // FUNCTION TO CALCULATE TIME…
  const secondsToStr = function (secondes) {
    function numberEnding(number) {
      return number > 1 ? "s" : "";
    }

    let temp = Math.floor(secondes / 1000);
    let years = Math.floor(temp / 31536000);
    if (years) {
      return years + " ans" + numberEnding(years);
    }
    let days = Math.floor((temp %= 31536000) / 86400);
    if (days) {
      return days + " jour" + numberEnding(days);
    }
    let hours = Math.floor((temp %= 86400) / 3600);
    if (hours) {
      return hours + " heure" + numberEnding(hours);
    }
    let minutes = Math.floor((temp %= 3600) / 60);
    if (minutes) {
      return minutes + " minute" + numberEnding(minutes);
    }
    let seconds = temp % 60;
    if (seconds) {
      return seconds + " seconde" + numberEnding(seconds);
    }
    return "moins d'une seconde"; //'just now' //or other string you like;
  };

  // FUNCTION TO GET USER DATA BY UUID…
  async function getUserData() {
    try {
      let response = await fetch(
        `https://vainkeurz.com/wp-json/vkrz/v1/getuserinfo/${uuid}`
      );
      return await response.json();
    } catch (error) {
      console.log(error);
    }
  }
  const data = await getUserData();

  // RETURN THE COMMENT TEMPLATE DIV…
  let deleteOrNot = "";
  if (uuid == currentUuid) {
    deleteOrNot = `
    <a 
      href="" 
      style=""
      class="deleteCommentBtn ml-3"
      data-commentId="${commentId}"
    >
    X
    </a>
    `;
  }

  return `
    <div class="comment-template media d-flex align-items-start mb-2 p-0">
          <div class="media-left mr-50">
            <div class="avatar">
              <span class="avatar-picture" style="background-image: url(${
                data.avatar
              }); width: 20px; height: 20px;"></span>
            </div>
          </div>

          <div class="media-body">
            <div class="d-flex align-items-center">
              <small style="font-size: .95em; font-weight: 600;">${
                data.pseudo
              }</small>
              <small style="font-size: .75em; margin-left: .5rem; line-height:0;">Il y a ${secondsToStr(
                secondes
              )}</small>

              ${deleteOrNot}
            </div>
          
            <p class="media-heading m-0" style="font-size: 1.2em;">
                ${content}
            </p>

            <a href="" class="replyBtn">
            Répondre
          </a>
          </div>
    </div>

    <hr>
  `;
};

// CHECK IF THERE IS ALREADY A COMMENTS FOR THE TopList…
const topListCommentsQuery = query(
  collection(database, "topListComments"),
  where("idRanking", "==", idRanking),
  orderBy("createdAt", "asc")
);
const topListCommentsQuerySnapshot = await getDocs(topListCommentsQuery);

if (topListCommentsQuerySnapshot._snapshot.docs.size !== 0) {
  // THERE IS SOME COMMENTS…
  let commentsArr = [];
  topListCommentsQuerySnapshot.forEach((comment) =>
    commentsArr.push({ id: comment.id, ...comment.data() })
  );

  for (let comment of commentsArr) {
    let secondes = new Date().getTime() - comment.createdAt.seconds * 1000;

    commentsContainer.insertAdjacentHTML(
      "beforeend",
      await commentTemplate(comment.id, comment.uuid, comment.comment, secondes)
    );
  }

  const deleteCommentsBtns =
    toplistCommentsCard.querySelectorAll(".deleteCommentBtn");
  deleteCommentsBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      e.target.closest(".comment-template").remove();

      deleteDoc(doc(database, "topListComments", btn.dataset.commentid));
    });
  });
} else {
  // NO COMMENTS…
  commentsContainer.innerHTML = `<span>No comments…</span>`;
}

sendCommentBtn.addEventListener("click", function () {
  let comment = toplistCommentsCard.querySelector("#comment").value;

  // INIT COMMENTAREA PLACE…
  if (topListCommentsQuerySnapshot._snapshot.docs.size === 0) {
    commentsContainer.innerHTML = "";
  }
  toplistCommentsCard.querySelector("#comment").value = "";

  // SEND COMMENT TO FIRESTORE…
  async function sentComment() {
    try {
      const newComment = await addDoc(collection(database, "topListComments"), {
        comment: comment,
        idRanking: idRanking,
        urlRanking: urlRanking,
        uuid: currentUuid,
        createdAt: new Date(),
      });
      console.log("Comment sent with ID: ", newComment.id);

      // ADD TO DOM…
      let commentTemplateDiv = await commentTemplate(
        newComment.id,
        currentUuid,
        comment,
        "0"
      );
      commentsContainer.insertAdjacentHTML("beforeend", commentTemplateDiv);

      const deleteCommentsBtns =
        toplistCommentsCard.querySelectorAll(".deleteCommentBtn");
      deleteCommentsBtns.forEach((btn) => {
        btn.addEventListener("click", (e) => {
          e.preventDefault();
          e.target.closest(".comment-template").remove();

          deleteDoc(doc(database, "topListComments", btn.dataset.commentid));
        });
      });
    } catch (error) {
      console.error("Error adding document: ", error);
    }
  }
  sentComment();
});
