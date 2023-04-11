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
  secondsToStrFuncHelper,
  fetchDataFuncHelper,
  sortContendersFuncHelper,
  calcResemblanceFuncHelper,
} from "./config.js";

if(document.querySelector('#twitch-games-ranking')) {
  const twitchGamesRankingContainer = document.querySelector('#twitch-games-ranking'),
        idRanking                   = twitchGamesRankingContainer.dataset.idranking;

  const predictionWinnerTemplate = function(winner, participantsNumber) {
    let wording = "";
    if(+participantsNumber === 2) {
      wording = `Le gagnant est `;
    } else {
      wording = `A gagné contre ${+participantsNumber - 1} autres participants`;
    }

    return `
      <div class="popup participate-popup scale-up-center popup-twitch-games-ranking">
        <button class="close-popup only-x" id="close-popup">&times;</button>

        <div class="popup-header">
          <h3>
             ${wording} <i class="fab fa-twitch ms-1"></i>
          </h3>
        </div>

        <div class="popup-body">
          <div class="twitchGamesWinnerContainer">
            <span class="twitchGamesWinnerName confetti">${winner}</span>
          </div>
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
      <div class="popup participate-popup scale-up-center">
        <button class="close-popup only-x" id="close-popup">&times;</button>

        <div class="popup-header">
          <h3>
            Classements des ${participantsNumber} participants <i class="fab fa-twitch ms-1"></i>
          </h3>
        </div>

        <div class="popup-body">
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

// RESSEMBLANCE MONDIALE…
if(document.querySelector('.classementt')) {
  const idRanking = document.querySelector('.classement').dataset.idranking;

  setTimeout(async () => {
    const rankingQuery = query(
      collection(database, "topLists"),
      where("ID", "==", +idRanking),
    );
    const rankingQuerySnapshot = await getDocs(rankingQuery);
    
    // RESSEMBLANCE MONDIALE… 
    let rankingArr = [],
        eloArr     = [],
        myTypeTopRanking;
    rankingQuerySnapshot.forEach(ranking => {
      rankingArr = sortContendersFuncHelper(ranking.data().ranking_r);
      myTypeTopRanking = ranking.data().type_top_r;
    });

    let top3 = false;
    if (myTypeTopRanking == "top3") top3 = true;
    
    for(let [index, contender] of rankingArr.entries()){
      (async function() {
        const documentReference = doc(database, "wpContender", (contender.id_wp).toString());
        const documentSnap      = await getDoc(documentReference);
    
        eloArr.push({place: index, elo: +documentSnap.data().ELO_c, id_wp: contender.id_wp})
    
        eloArr = eloArr.sort((a, b) => b.elo - a.elo)
        eloArr.forEach((contender, index) => contender.place = index);
    
        if((index + 1) == rankingArr.length) {
          const ressemblanceMondiale = document.querySelector('#ressemblance-mondiale');
          ressemblanceMondiale.innerHTML = calcResemblanceFuncHelper(rankingArr, eloArr, top3);
        }
      })()
    }
  }, 1000)
}

if (document.querySelector(".vs-resemblance")) {
  const cardResemblance = document.querySelector(".vs-resemblance");
  const idTop           = cardResemblance.dataset.idtop;
  const idRanking       = cardResemblance.dataset.idranking;
  const topUrl          = cardResemblance.dataset.topurl;

  const rankingQuery = query(
    collection(database, "topLists"),
    where("ID", "==", +idRanking),
  );
  const rankingQuerySnapshot = await getDocs(rankingQuery);

  if (rankingQuerySnapshot._snapshot.docs.size === 1) {
    // CHECK IF I ALREADY DID THE RANKING…
    const myRankingQuery = query(
      collection(database, "topLists"),
      where("id_tournoi_r", "==", idTop),
      where("uuid_user_r", "==", currentUuid),
      where("done_r", "==", "done")
    );
    const myRankingQuerySnapshot = await getDocs(myRankingQuery);

    if (myRankingQuerySnapshot._snapshot.docs.size === 1) {
      // TO DEFINE…
      let myTypeTopRanking, otherTypeTopRanking;

      let myRankingArr = [],
          myRankingUrl;
      myRankingQuerySnapshot.forEach((ranking) => {
        myRankingArr = sortContendersFuncHelper(ranking.data().ranking_r);
        myRankingUrl = ranking.data().permalink;

        myTypeTopRanking = ranking.data().type_top_r;
      });

      // GET THE RANKING OF THE OTHER VAINKEUR FROM FIRESTORE…
      const rankingQuery = doc(database, "topLists", idRanking);
      const rankingQuerySnapshot = await getDoc(rankingQuery);

      if (rankingQuerySnapshot.exists()) {
        // FOUND IN FIRESTORE…
        let othersRankingArr = [];
        othersRankingArr = sortContendersFuncHelper(
          rankingQuerySnapshot.data().ranking_r
        );
        otherTypeTopRanking =
          rankingQuerySnapshot.data().type_top_r;

        // CHECK IF WE HAVE THE SAME TYPE TOP RANKING BEFORE COMPARE…
        let top3 = false;
        if (myTypeTopRanking == "top3" || otherTypeTopRanking == "top3") {
          top3 = true;
        }
        // COMPARE IT WITH MY RANKING…
        let calcResemblance = calcResemblanceFuncHelper(
          myRankingArr,
          othersRankingArr,
          top3
        );

        document.querySelector(".vs-resemblance").innerHTML = `
          <h6 class="mt-1 text-center mb-0">
            <b style="color: #7266EF;">${calcResemblance}</b> de ressemblance avec
            <a href="${myRankingUrl}">ta TopList !</a> 
          </h6>
        `;
      } else {
        // NOT FOUND IN FIRESTORE…
        console.log("No such document in Firestore!");
      }
    } else {
      // I DIDN'T THE RANKING…
      console.log("I did not the ranking…");
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
        jugementsNumber      = document.querySelector('.jugements-nbr'),
        commentArea = toplistCommentsCard.querySelector("#comment");

  // CHECK IF THERE IS ALREADY A COMMENTS FOR THE TopList…
  let commentsUsersData = [];
  const topListCommentsQuery = query(
    collection(database, "topListComments"),
    where("idRanking", "==", idRanking),
    orderBy("createdAt", "asc")
  );
  const topListCommentsQuerySnapshot = await getDocs(topListCommentsQuery);

  jugementsNumber.innerHTML = topListCommentsQuerySnapshot._snapshot.docs.size;

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
    const data = await fetchDataFuncHelper(`http://vainkeurz.local/wp-json/vkrz/v1/getuserinfo/${uuid}`);

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
          <div class="media-left me-2">
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
                <small class="text-muted" style="font-size: .75em; margin-left: .5rem; line-height:0;">Il y a ${secondsToStrFuncHelper(
                  secondes
                )}</small>
              </div>

              ${deleteOrNot}
            </div>
          
            <p class="media-heading">
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
          jugementsNumber.innerHTML = +jugementsNumber.textContent > 0 ? +jugementsNumber.textContent - 1 : 0;
        });
      });

      // RESET REPLY BUTTONS…
      const replyCommentsBtns =
        toplistCommentsCard.querySelectorAll(".replyCommentBtn");
      replyCommentsBtns.forEach((btn) => {
        btn.addEventListener("click", (e) => {
          e.preventDefault();
          commentArea.value = `${btn.dataset.replyto} `;
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

      jugementsNumber.innerHTML = +jugementsNumber.textContent + 1;
    } else {
      commentArea.setAttribute(
        "placeholder",
        "Avec un petit mot ça marchera mieux 🤪"
      );
    }
  };

  if (topListCommentsLength !== 0) {

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
        jugementsNumber.innerHTML = +jugementsNumber.textContent > 0 ? +jugementsNumber.textContent - 1 : 0;
      });
    });

    const replyCommentsBtns =
      toplistCommentsCard.querySelectorAll(".replyCommentBtn");
    replyCommentsBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        commentArea.value = `${btn.dataset.replyto} `;
        commentArea.focus();
      });
    });
  } else {
    // NO COMMENTS…
    commentsContainer.innerHTML = `<span>Pas encore de jugement, à toi de lancer les hostilités 😬</span>`;
  }

  sendCommentBtn.addEventListener("click", validComment);
  commentArea.addEventListener("keypress", (e) => {
    if (13 == e.keyCode) {
      e.preventDefault();
      validComment();
    }
  });
}