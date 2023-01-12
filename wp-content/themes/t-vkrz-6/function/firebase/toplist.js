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
  setDoc,
  orderBy,
} from "./config.js";

if(document.querySelector('#twitch-games-ranking')) {
  const twitchGamesRankingContainer = document.querySelector('#twitch-games-ranking'),
        idRanking                   = twitchGamesRankingContainer.dataset.idranking;

  const predictionWinnerTemplate = function(winner, participantsNumber) {
    let wording = "";
    if(+participantsNumber === 2) {
      wording = `le gagant est `;
    } else {
      wording = `a gagné contre ${+participantsNumber - 1} autres participants`;
    }

    return `
      <div class="card-body">
        <h4 class="card-title">
          <i class="fab fa-twitch"></i> ${wording}
        </h4>
              
        <div class="twitchGamesWinnerContainer">
          <span class="twitchGamesWinnerName confetti">${winner}</span>
        </div>
      </div>
    `
  }

  const tablePointsTemplate = function(tbody, participantsNumber) {
    tbody = tbody.replaceAll('text-success', '')
    tbody = tbody.replaceAll('↑', '')

    let tbodyDOM = document.createElement('tbody');
    tbodyDOM.innerHTML = tbody;

    // REFACTOR POSITIONS WITH NUMBERS…
    let rank = 1;
    const rows = tbodyDOM.querySelectorAll('tr');
    rows.forEach((row, index) => {
      let position = Number(row.querySelector('td:last-of-type').dataset.order);

      if(index > 0 && position < Number(rows[index - 1].querySelector('td:last-of-type').dataset.order)) {
        rank = index + 1;
      }

      row.querySelector('td:first-of-type').innerHTML = rank;
    })

    // REFACTOR POSITIONS WITH EMOJIS…
    let positionStr = "";
    tbodyDOM.querySelectorAll('tr').forEach((row, index) => {
      row.querySelector('td:first-of-type').classList.add('text-center');
      row.querySelector('td:last-of-type').classList.add('text-center');
 
      let position = row.querySelector('td:first-of-type').innerHTML;
      switch (position) {
        case "1":
          positionStr = '<span class="ico va va-medal-1 va-lg"></span>';
          break;
        case "2":
          positionStr = '<span class="ico va va-medal-2 va-lg"></span>';
          break;
        case "3":
          positionStr = '<span class="ico va va-medal-3 va-lg"></span>';
          break;
        default:
          positionStr = index + 1;
      }
      row.querySelector('td:first-of-type').innerHTML = positionStr;
    })

    return `
      <div class="card-body">
        <h4 class="card-title">
          <i class="fab fa-twitch"></i> Classements des ${participantsNumber} participants
        </h4>

        <table class="table table-points" style="margin-top: auto;">
          <thead>
            <tr>
              <th>
                <span class="text-muted">
                  Position
                </span>
              </th>

              <th>
                <span class="text-muted">
                  Vainkeur
                </span>
              </th>

              <th class="text-left">
                <span class="text-muted">
                  Points
                </span>
              </th>
            </tr>
          </thead>
          <tbody>
            ${tbodyDOM.innerHTML}
          </tbody>
        </table>
      </div> 
    `
  }

  if(localStorage.getItem('resumeTwitchGame')) {    
    let resumeTwitchGame = localStorage.getItem('resumeTwitchGame');
    resumeTwitchGame = JSON.parse(resumeTwitchGame);

    if(resumeTwitchGame.idRanking === idRanking) {
      if(resumeTwitchGame.mode === "votePoints") {
        twitchGamesRankingContainer.innerHTML = tablePointsTemplate(resumeTwitchGame.tbody, resumeTwitchGame.participantsNumber);
        twitchGamesRankingContainer.classList.remove('d-none');

        if(resumeTwitchGame.participantsNumber >= 25) {
          let table = $('.table-points').dataTable();
          table.fnDestroy();
  
          table.dataTable({
            lengthMenu: [25],
            paging: true,
            searching: true,
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
          });
        }
      } else if (resumeTwitchGame.mode === "votePrediction") {
        twitchGamesRankingContainer.innerHTML = predictionWinnerTemplate(resumeTwitchGame.winner, resumeTwitchGame.participantsNumber)

        twitchGamesRankingContainer.classList.remove('d-none');

        $(".twitchGamesWinnerContainer").addClass('show');
        confetti();
      
        function rnd(m,n) {
          m = parseInt(m);
          n = parseInt(n);
      
          return Math.floor( Math.random() * (n - m + 1) ) + m;
        }
      
        function confetti() {
          $.each($(".twitchGamesWinnerName.confetti"), function(){
            var confetticount = ($(this).width()/50) * 10;
            for(var i = 0; i <= confetticount; i++) {
                $(this).append('<span class="particle c' + rnd(1,4) + '" style="top:' + rnd(10,50) + '%; left:' + rnd(0,100) + '%;width:' + rnd(2,12) + 'px; height:' + rnd(2,14) + 'px;animation-delay: ' + (rnd(0,30)/10) + 's;"></span>');
            }
          });
        }
      }

      // REMOVE LOCAL STORAGE…
      localStorage.removeItem('resumeTwitchGame');
    }
  }
}

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

// RESSEMBLANCE MONDIALE…
if (document.querySelector('.classement')) {
  const idRanking = document.querySelector('.classement').dataset.idranking;

  setTimeout(async () => {
    const rankingQuery = query(
      collection(database, "wpClassement"),
      where("ID", "==", +idRanking),
    );
    const rankingQuerySnapshot = await getDocs(rankingQuery);
    
    // RESSEMBLANCE MONDIALE… 
    let rankingArr = [],
        eloArr     = [],
        myTypeTopRanking;
    rankingQuerySnapshot.forEach(ranking => {
      rankingArr = sortContenders(ranking.data().custom_fields.ranking_r);
      myTypeTopRanking = ranking.data().custom_fields.type_top_r;
    });

    let top3 = false;
    if (myTypeTopRanking == "top3") top3 = true;
    
    for(let [index, contender] of rankingArr.entries()){
      (async function() {
        const documentReference = doc(database, "wpContender", (contender.id_wp).toString());
        const documentSnap      = await getDoc(documentReference);
    
        eloArr.push({place: index, elo: +documentSnap.data().custom_fields.ELO_c, id_wp: contender.id_wp})
    
        eloArr = eloArr.sort((a, b) => b.elo - a.elo)
        eloArr.forEach((contender, index) => contender.place = index);
    
        if((index + 1) == rankingArr.length) {
          const ressemblanceMondiale = document.querySelector('#ressemblance-mondiale');
          ressemblanceMondiale.innerHTML = calcResemblanceFunc(rankingArr, eloArr, top3);
        }
      })()
    }
  }, 3000)
}

if (document.querySelector(".vs-resemblance")) {
  const cardResemblance = document.querySelector(".vs-resemblance");
  const idTop           = cardResemblance.dataset.idtop;
  const idRanking       = cardResemblance.dataset.idranking;
  const rankingUrl      = cardResemblance.dataset.rankingUrl;
  const topUrl          = cardResemblance.dataset.topurl;

  const rankingQuery = query(
    collection(database, "wpClassement"),
    where("ID", "==", +idRanking),
  );
  const rankingQuerySnapshot = await getDocs(rankingQuery);

  if (rankingQuerySnapshot._snapshot.docs.size === 1) {
    // CHECK IF I ALREADY DID THE RANKING…
    const myRankingQuery = query(
      collection(database, "wpClassement"),
      where("custom_fields.id_tournoi_r", "==", idTop),
      where("custom_fields.done_r", "==", "done"),
      where("custom_fields.uuid_user_r", "==", currentUuid)
    );
    const myRankingQuerySnapshot = await getDocs(myRankingQuery);

    if (myRankingQuerySnapshot._snapshot.docs.size === 1) {
      // TO DEFINE…
      let myTypeTopRanking, otherTypeTopRanking;

      let myRankingArr = [],
          myRankingUrl;
      myRankingQuerySnapshot.forEach((ranking) => {
        myRankingArr = sortContenders(ranking.data().custom_fields.ranking_r);
        myRankingUrl = ranking.data().permalink;

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
            <b style="color: #7266EF;">${calcResemblance}</b> de ressemblance avec
            <a href="${myRankingUrl}">ta TopList !</a> 
          </h2>
        `;
      } else {
        // NOT FOUND IN FIRESTORE…
        // console.log("No such document in Firestore!");
      }
    } else {
      // I DIDN'T THE RANKING…
      // console.log("I did not the ranking…");
      cardResemblance.innerHTML = `
        <a href="${topUrl}" class="w-100 btn btn-rose waves-effect p-1 mt-2">
          <p class="h4 text-white m-0">
            Faire ma TopList
          </p>
        </a>
      `;
    }
  }
}

if (document.querySelector(".toplist_comments")) {
  // TOPLIST COMMENTS…
  const toplistCommentsCard = document.querySelector(".toplist_comments"),
        sendCommentBtn      = toplistCommentsCard.querySelector("#send_comment_btn"),
        idRanking           = toplistCommentsCard.dataset.idranking,
        urlRanking          = toplistCommentsCard.dataset.urlranking,
        authorid            = toplistCommentsCard.dataset.authorid,
        authorpseudo        = toplistCommentsCard.dataset.authorpseudo,
        authoruuid          = toplistCommentsCard.dataset.authoruuid,
        id_vainkeur         = toplistCommentsCard.dataset.id_vainkeur_actual,
        commentsContainer   = toplistCommentsCard.querySelector(
          ".comments-container"
        ),
        commentArea = toplistCommentsCard.querySelector("#comment");

  // CHECK IF THERE IS ALREADY A COMMENTS FOR THE TopList…
  let commentsUsersData = [];
  const topListCommentsQuery = query(
    collection(database, "topListComments"),
    where("idRanking", "==", idRanking),
    orderBy("createdAt", "asc")
  );
  const topListCommentsQuerySnapshot = await getDocs(topListCommentsQuery);

  topListCommentsQuerySnapshot.forEach((comment) => {
    if (authorid != comment.data().userId) {
      commentsUsersData.push([comment.data().uuid, comment.data().userId]);
    }
  });
  commentsUsersData.push([authoruuid, authorid]);

  let set = new Set(
    commentsUsersData.map((userData) => JSON.stringify(userData))
  );
  commentsUsersData = Array.from(set).map((elem) => JSON.parse(elem));

  let topListCommentsLength = topListCommentsQuerySnapshot._snapshot.docs.size;

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
            <a href="${data.profil_url}" class="text-white">
              <span class="avatar-picture" style="background-image: url(${
                data.avatar
              }); width: 20px; height: 20px;"></span>
            </a>
            </div>
          </div>

          <div class="media-body">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <a href="${data.profil_url}" class="text-white">
                  <small style="font-size: .95em; font-weight: 600;">${
                    data.pseudo
                  }</small>
                </a>
                <small class="text-muted" style="font-size: .75em; margin-left: .5rem; line-height:0;">Il y a ${secondsToStr(
                  secondes
                )}</small>
              </div>

              ${deleteOrNot}
            </div>
          
            <p class="media-heading m-0" style="font-size: 1.2em;">
                ${content}
            </p>

            <a href="" class="replyCommentBtn" data-replyTo="@${data.pseudo}">
              Répondre
            </a>
          </div>

          <hr>
    </div>
  `;
  };

  async function sendComment(comment, idRanking, urlRanking, currentUuid) {
    try {
      const newComment = await addDoc(collection(database, "topListComments"), {
        comment: comment,
        idRanking: idRanking,
        urlRanking: urlRanking,
        uuid: currentUuid,
        userId: currentUserId,
        createdAt: new Date(),
      });
      // console.log("Comment sent with ID: ", newComment.id);

      // ADD TO DOM…
      let commentTemplateDiv = await commentTemplate(
        newComment.id,
        currentUuid,
        comment,
        "0"
      );
      commentsContainer.insertAdjacentHTML("beforeend", commentTemplateDiv);

      if (topListCommentsLength == 0) {
        commentsContainer.style.height = `${
          +commentsContainer.style.height.substring(
            0,
            commentsContainer.style.height.indexOf("px")
          ) + 100
        }px`;
        topListCommentsLength = 1;
      }
      commentsContainer.scrollTop = commentsContainer.scrollHeight;

      // RESET DELETE BUTTONS…
      const deleteCommentsBtns =
        toplistCommentsCard.querySelectorAll(".deleteCommentBtn");
      deleteCommentsBtns.forEach((btn) => {
        btn.addEventListener("click", (e) => {
          e.preventDefault();
          e.target.closest(".comment-template").remove();

          deleteDoc(doc(database, "topListComments", btn.dataset.commentid));

          // Décremente
          post_new_jugement(idRanking, id_vainkeur, "delete");
        });
      });

      // RESET REPLY BUTTONS…
      const replyCommentsBtns =
        toplistCommentsCard.querySelectorAll(".replyCommentBtn");
      replyCommentsBtns.forEach((btn) => {
        btn.addEventListener("click", (e) => {
          e.preventDefault();
          commentArea.value = `${btn.dataset.replyto}`;
          commentArea.focus();
        });
      });

      // SEND NOTIFICATION…
      commentsUsersData.reverse().forEach((userData, index) => {
        if (userData[1] != currentUserId) {
          let notifText;
          if (index === 0) {
            notifText = `${vainkeurPseudo} a jugé une de tes TopList!`;
          } else {
            notifText = `${vainkeurPseudo} a aussi laissé un jugement sur cette TopList !`;
          }

          async function sendNotif() {
            try {
              const notification = await addDoc(
                collection(database, "notifications"),
                {
                  userId: currentUserId,
                  uuid: currentUuid,
                  relatedId: userData[1],
                  relatedUuid: userData[0],
                  notifText: notifText,
                  notifLink: urlRanking,
                  notifType: "TopList Comment Reply Notification",
                  statut: "nouveau",
                  createdAt: new Date(),
                }
              );

              // console.log("Notification sent with ID: ", notification.id);
            } catch (error) {
              console.error("Error adding comment notification: ", error);
            }
          }
          sendNotif();
        }
      });
    } catch (error) {
      console.error("Error adding comment: ", error);
    }
  }

  const validComment = function () {
    let comment = commentArea.value;

    if (comment) {
      // INIT COMMENTAREA…
      if (topListCommentsLength === 0) {
        commentsContainer.innerHTML = "";
      }
      commentArea.value = "";
      commentArea.focus();

      // SEND COMMENT TO FIRESTORE…
      sendComment(comment, idRanking, urlRanking, currentUuid);

      // Incremente + check badge
      post_new_jugement(idRanking, id_vainkeur, "add");
    } else {
      commentArea.setAttribute(
        "placeholder",
        "Avec un petit mot ça marchera mieux 🤪"
      );
    }
  };

  if (topListCommentsLength !== 0) {
    // THERE IS SOME COMMENTS…
    commentsContainer.style.maxHeight = "150px";

    let commentsArr = [];
    topListCommentsQuerySnapshot.forEach((comment) =>
      commentsArr.push({ id: comment.id, ...comment.data() })
    );

    for (let comment of commentsArr) {
      let secondes = new Date().getTime() - comment.createdAt.seconds * 1000;

      commentsContainer.insertAdjacentHTML(
        "beforeend",
        await commentTemplate(
          comment.id,
          comment.uuid,
          comment.comment,
          secondes
        )
      );
    }

    const deleteCommentsBtns =
      toplistCommentsCard.querySelectorAll(".deleteCommentBtn");
    deleteCommentsBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        e.target.closest(".comment-template").remove();

        deleteDoc(doc(database, "topListComments", btn.dataset.commentid));

        // Décremente
        post_new_jugement(idRanking, id_vainkeur, "delete");
      });
    });

    const replyCommentsBtns =
      toplistCommentsCard.querySelectorAll(".replyCommentBtn");
    replyCommentsBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        commentArea.value = `${btn.dataset.replyto}`;
        commentArea.focus();
      });
    });
  } else {
    // NO COMMENTS…
    commentsContainer.innerHTML = `<span style="color: #A9A9AC;">Aucun jugement pour le moment - Soit le 1er</span>`;
  }

  sendCommentBtn.addEventListener("click", validComment);
  commentArea.addEventListener("keypress", (e) => {
    if (13 == e.keyCode) {
      e.preventDefault();
      validComment();
    }
  });
}

if (document.querySelector('#form-coupon')) {
  const playerForm = document.querySelector('#form-coupon');

  playerForm.addEventListener('submit', async function(e) {
    e.preventDefault();

    const customDocId = `U:${playerForm.elements['uuiduser'].value};T:${playerForm.elements['top'].value};R:${playerForm.elements['ranking'].value}`;

    try {
      const newPlayer = await setDoc(doc(database, "players", customDocId), {
        uuidPlayer: playerForm.elements['uuiduser'].value,
        emailPlayer: playerForm.elements['email-player-input'].value,
        ranking: playerForm.elements['ranking'].value,
        top: playerForm.elements['top'].value,
        vainkeurId: playerForm.elements['id_vainkeur'].value,
        createdAt: new Date(),
      });
      console.log("Player well sent !");
    } catch (error) {
      console.error("Error adding comment: ", error);
    }
  })
}