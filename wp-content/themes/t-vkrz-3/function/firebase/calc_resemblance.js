import {
  collection,
  database,
  query,
  where,
  doc,
  addDoc,
  deleteDoc,
  getDocs,
} from "./config.js";

// INIT…
const calcResemblanceDiv = document.querySelector(".calc-resemblance");
const idTop = calcResemblanceDiv.dataset.idtop;

calcResemblanceDiv.addEventListener("click", async function () {
  // DOM…
  const table = document.querySelector("table");
  table.setAttribute("id", "table-ressemblance");
  table.querySelector("thead tr th:nth-of-type(3) span").textContent = `Voir`;
  table.querySelector("thead tr th:last-of-type").remove()
  function insertAfter(referenceNode, newNode) {
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
  }
  const th = document.createElement("th");
  th.innerHTML = `<span class="text-muted">Ressemblance ↕</span>`;
  insertAfter(table.querySelector("thead tr th:nth-of-type(2)"), th);

  const domQuery = query(
    collection(database, "wpClassement"),
    where("custom_fields.id_tournoi_r", "==", idTop),
    where("custom_fields.done_r", "==", "done")
  );
  const domQuerySnapshot = await getDocs(domQuery);

  // FUNCTION TO SORT CONTENDERS…
  const sortContenders = function (contenders) {
    let contendersArr = [],
      contendersArrPlaces = [],
      contendersArrIDs = [];

    for (let contender of contenders) {
      // delete contender.c_name;
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

  // CALC RESSEMBLANCE…
  const calcRessemblance = function (myContenders, otherContenders) {
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

    if (Math.round(pourcentSimilaire.reduce((a, b) => a + b, 0) * 100) == 100) {
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
  const actualUserRankingQuerySnapshot = await getDocs(actualUserRankingQuery);

  // SORT MY RANKING…
  let myContenders = [];
  actualUserRankingQuerySnapshot.forEach(
    (ranking) =>
      (myContenders = sortContenders(ranking.data().custom_fields.ranking_r))
  );
  console.log("My contenders: ", myContenders);

  // USERS RANKS…
  const usersRanksQuery = query(
    collection(database, "wpClassement"),
    where("custom_fields.id_tournoi_r", "==", idTop),
    where("custom_fields.done_r", "==", "done"),
    where("author", "!=", false)
  );
  const usersRanksQuerySnapshot = await getDocs(usersRanksQuery);
  let html = "";

  // GET FOLLOWING…
  let following = [];
  const followingQuery = query(
    collection(database, "notifications"),
    where("notifType", "==", "follow"),
    where("userId", "==", currentUserId)
  );
  const followingQuerySnapshot = await getDocs(followingQuery);
  followingQuerySnapshot.forEach((f) => following.push(f.data().relatedUuid));

  let i = 0;
  usersRanksQuerySnapshot.forEach((ranking) => {
    let contendersDiv = "",
      contendersIDs = [],
      contenders = [];
    contenders = sortContenders(ranking.data().custom_fields.ranking_r);

    let calcRessemblanceVar = calcRessemblance(myContenders, contenders); // CALC RESSEMBLANCE…

    contenders.forEach((contender) => contendersIDs.push(contender.id_wp));

    const fetchDataAndShow = async () => {
      // FETCH ALL CONTENDERS…
      const map = new Map();
      await Promise.all(
        contendersIDs.map(async (id) => {
          await fetch(
            `https://vainkeurz.com/wp-json/vkrz/v1/getcontenderinfo/${id}`
          )
            .then((res) => res.json())
            .then((response) => map.set(id, response));
        })
      );
      contenders.forEach((contender, index) => {
        if (index < 3) {
          contendersDiv += `
                      <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="${
                        map.get(contender.id_wp).Title
                      }" class="avatartop3 avatar pull-up">
                          <img src="${
                            map.get(contender.id_wp).Thumbnail
                          }" alt="${map.get(contender.id_wp).Title}">
                      </div>
                  `;
        }
      });
      $(document).ready(function () {
        $("body").tooltip({
          selector: "[data-toggle=tooltip]",
        });
      });

      // FETCH USER DATA…
      await fetch(
        `https://vainkeurz.com/wp-json/vkrz/v1/getuserinfo/${
          ranking.data().custom_fields.uuid_user_r
        }`
      )
        .then((res) => res.json())
        .then((response) => {
          let followingOrNotDiv = "";
          let followingOrNot = following.includes(
            ranking.data().custom_fields.uuid_user_r
          );
          if (followingOrNot) {
            followingOrNotDiv = `
                          <a 
                              href="" 
                              data-userid=${response.user_id}
                              class="unfollowBtns dropdown-item"
                              >
                              <span class="ico-action va va-new-button va-z-20"></span> 
                              Unfollow
                          </a>
                      `;
          } else if (ranking.data().custom_fields.uuid_user_r == currentUuid) {
            followingOrNotDiv = ``;
          } else {
            followingOrNotDiv = `
                          <a 
                              href="" 
                              class="followBtns dropdown-item"
                              data-userid=${currentUserId}
                              data-uuid=${currentUuid}
                              data-relatedid=${response.user_id}
                              data-relateduuid="${response.uuid_user_vkrz}"
                              data-text="${vainkeurPseudo} te guette !"
                              data-url="${currentUserProfileUrl}"
                              >
                              <span class="ico-action va va-new-button va-z-20"></span> 
                              Follow
                          </a>
                      `;
          }

          // RESSEMBLANCE NUMBER…
          let ressemblanceOnlyNumber = calcRessemblanceVar.substring(
            0,
            calcRessemblanceVar.indexOf("%")
          );
          ressemblanceOnlyNumber = +ressemblanceOnlyNumber;
          if (ressemblanceOnlyNumber == 100) {
            calcRessemblanceVar = `
                          <span class="badge rounded-pill badge-light-success me-1">${calcRessemblanceVar}</span>
                      `;
          } else if (
            ressemblanceOnlyNumber >= 30 &&
            ressemblanceOnlyNumber < 100
          ) {
            calcRessemblanceVar = `
                          <span class="badge rounded-pill badge-light-info me-1">${calcRessemblanceVar}</span>
                      `;
          } else {
            calcRessemblanceVar = `
                          <span class="badge rounded-pill badge-light-warning me-1">${calcRessemblanceVar}</span>
                      `;
          }

          html += `
                      <tr style="background-color: transparent !important;"">
                          <td class="vainkeur-table">
                              <span class="avatar">
                                  <a href="${
                                    !response.pseudo ? "#" : response.profil_url
                                  }">
                                      <span class="avatar-picture" style="background-image: url(${
                                        !response.pseudo ? "" : response.avatar
                                      });"></span>
                                  </a>
                                  <span class="user-niveau">
                                      ${response.level}
                                  </span>
                              </span>
                              <span class="font-weight-bold championname">
                                  <a href="${
                                    !response.pseudo ? "#" : response.profil_url
                                  }">
                                      ${
                                        !response.pseudo
                                          ? "<i>ANONYME</i>"
                                          : response.pseudo
                                      }
                                      <span class="user-niveau-xs">
                                          ${response.level}
                                      </span>
                                      ${
                                        !response.user_role_administrator
                                          ? ""
                                          : response.user_role_administrator
                                      } 
                                      ${
                                        !response.user_role_author
                                          ? ""
                                          : response.user_role_author
                                      }
                                  </a>
                              </span>
                          </td>

                          <td>
                              ${contendersDiv}
                          </td>

                          <td class="text-center">
                              ${calcRessemblanceVar}
                          </td>

                          <td class="text-right">
                              <div class="dropdown">
                                  <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-medium-2">
                                          <circle cx="12" cy="12" r="1"></circle>
                                          <circle cx="12" cy="5" r="1"></circle>
                                          <circle cx="12" cy="19" r="1"></circle>
                                      </svg>
                                  </a>

                                  <div class="dropdown-menu dropdown-menu-right">
                                      <a href="${
                                        ranking.data().permalink
                                      }" class="dropdown-item">
                                          <span class="ico-action va va-eyes va-z-20"></span> Voir sa TopList
                                      </a>

                                      ${followingOrNotDiv}
                                  </div>      
                              </div>
                          </td>
                      </tr>
                  `;

          document.querySelector("tbody").innerHTML = html;

          i++;
          document.querySelector(".step").textContent = i;

          // LAST ROUND…
          if (usersRanksQuerySnapshot._snapshot.docs.size == i) {
            document.querySelector(".step").textContent =
              domQuerySnapshot._snapshot.docs.size;

            const unfollowBtns = document.querySelectorAll(".unfollowBtns");
            unfollowBtns.forEach((btn) => {
              btn.addEventListener("click", (e) => {
                e.preventDefault();
                e.target.closest("a").remove();

                const checkFollower = async () => {
                  const checkFollowerQuery = query(
                    collection(database, "notifications"),
                    where("notifType", "==", "follow"),
                    where("userId", "==", currentUserId),
                    where("relatedId", "==", btn.dataset.userid)
                  );
                  const checkFollowerQuerySnapshot = await getDocs(
                    checkFollowerQuery
                  );

                  if (checkFollowerQuerySnapshot._snapshot.docs.size === 1) {
                    deleteDoc(
                      doc(
                        database,
                        "notifications",
                        checkFollowerQuerySnapshot.docs[0].id
                      )
                    );
                  }
                };
                checkFollower();
              });
            });

            const followBtns = document.querySelectorAll(".followBtns");
            followBtns.forEach((btn) => {
              btn.addEventListener("click", (e) => {
                e.preventDefault();
                e.target.closest("a").remove();

                async function setNotification() {
                  try {
                    let q = query(
                      collection(database, "notifications"),
                      where("notifText", "==", `${vainkeurPseudo} te guette !`),
                      where("relatedId", "==", btn.dataset.relatedid)
                    );
                    let querySnapshot = await getDocs(q);

                    if (querySnapshot._snapshot.docs.size === 0) {
                      const newFollow = await addDoc(
                        collection(database, "notifications"),
                        {
                          userId: btn.dataset.userid,
                          uuid: btn.dataset.uuid,
                          relatedId: btn.dataset.relatedid,
                          relatedUuid: btn.dataset.relateduuid,
                          notifText: btn.dataset.text,
                          notifLink: btn.dataset.url,
                          notifType: "follow",
                          statut: "nouveau",
                          createdAt: new Date(),
                        }
                      );
                      console.log("Notification sent with ID: ", newFollow.id);
                    }
                  } catch (error) {
                    console.error("Error adding document: ", error);
                  }
                }
                setNotification();
              });
            });

            $("#table-ressemblance").DataTable({
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
        });
    };

    fetchDataAndShow();
  });
});
