import {
  collection,
  getDocs,
  addDoc,
  query,
  where,
  database,
  orderBy,
  doc,
  limit,
  deleteDoc,
} from "../firebase/config.js";

$(document).ready(function ($) {
  let ajaxRunning = false;

  $(window).keyup(function (e) {
    if (e.keyCode === 37) {
      $("#c_1").trigger("click");
    } else if (e.keyCode === 39) {
      $("#c_2").trigger("click");
    }
  });

  $(document).on("click", ".display_battle .link-contender", {}, function (e) {
    if (document.querySelector(".twitch-votes-container")) {
      // CLEAR COUNTING FOR EACH VOTE…
      console.log("Clear counting…");
      listeningForCount = false;
      votesNumberForContenderOne = 0;
      votesNumberForContenderTwo = 0;
      contenderOneVotes.textContent = votesNumberForContenderOne;
      contenderTwoVotes.textContent = votesNumberForContenderTwo;
      contenderOneVotesPercent.textContent = "0%";
      contenderTwoVotesPercent.textContent = "0%";
      X = A = B = 0;

      document.querySelector("#votes-stats-1").classList.remove("active");
      document.querySelector("#votes-stats-2").classList.remove("active");

      startCountBtn.classList.add("btn-relief-primary");
      startCountBtn.classList.remove("btn-outline-warning");
      startCountBtn.textContent = "Start";

      if (voteParticipatifBoolean) {
        users = {};
      } else if (votePredictionBoolean) {
        let side;
        if (e.target.closest("div").getAttribute("id") == "c_1") side = "1";
        else if (e.target.closest("div").getAttribute("id") == "c_2")
          side = "2";

        toFilter = Object.entries(users);
        nonPassed = toFilter.filter(([key, value]) => value.side !== side);
        losers = {...losers, ...Object.fromEntries(nonPassed)};

        passed = toFilter.filter(([key, value]) => value.side === side);
        for (let user of toFilter)
          if (user[1]["voted"]) user[1]["voted"] = false;
        users = Object.fromEntries(passed);

        // PROCESS FOR PARTICIPANTS…
        participantsDOM.innerHTML = userListItem = "";
        for(let participant of Object.keys(users)) userListItem += `<li class="list-group-item" id="${participant}">${participant}</li>`;
        participantsDOM.innerHTML = userListItem 

        // PROCESS FOR LOSERS…
        if(nonPassed.length > 0) {
          let losersDOM = document.querySelector('#losers');
          losersDOM.classList.remove('d-none');
          losersDOM = losersDOM.querySelector('.list-group');

          for(const [key, loser] of Object.entries(nonPassed)) {
            losersDOM.insertAdjacentHTML("afterbegin", `<li class="list-group-item text-danger">${loser[0]}</li>`);
          }
        }
      } else if (votePointsBoolean) {
        console.log(users);
        let side;
        if (e.target.closest("div").getAttribute("id") == "c_1") side = "1";
        else if (e.target.closest("div").getAttribute("id") == "c_2")
          side = "2";

        toFilter = Object.entries(users);

        let oppositeSide = side === "1" ? "2" : "1";
        notSameVoteGroup = toFilter.filter(([key, value]) => value.side === oppositeSide);
        notSameVoteGroupObj = Object.fromEntries(notSameVoteGroup);
        
        sameVoteGroup = toFilter.filter(([key, value]) => value.side === side);
        sameVoteGroupObj = Object.fromEntries(sameVoteGroup);

        for (const vainkeurPlusOne of Object.keys(sameVoteGroupObj)) {
          const vainkeurPlusOneDOM                = document.querySelector(`#${vainkeurPlusOne}`),
                vainkeurPlusOneDOMpoints          = vainkeurPlusOneDOM.querySelector('td:last-of-type');
          let vainkeurPlusOneDOMpointsTextContent = vainkeurPlusOneDOMpoints.textContent;

          if(vainkeurPlusOneDOMpointsTextContent.includes("↑")) {
            pointsOne = vainkeurPlusOneDOMpointsTextContent.substring(0, vainkeurPlusOneDOMpointsTextContent.indexOf("↑"));
          } else {
            pointsOne = vainkeurPlusOneDOMpointsTextContent.substring(0, vainkeurPlusOneDOMpointsTextContent.indexOf("↓"));
          }

          vainkeurPlusOneDOMpoints.innerHTML = `${+pointsOne + 1} &uarr;`
          vainkeurPlusOneDOMpoints.setAttribute('data-order', `${+pointsOne + 1}`)
          vainkeurPlusOneDOMpoints.classList.remove('text-danger')
          vainkeurPlusOneDOMpoints.classList.add('text-success')
        } 

        if(notSameVoteGroup.length > 0) {
          for (let vainkeurMinusOne of Object.keys(notSameVoteGroupObj)) {
            const vainkeurMinusOneDOM                 = document.querySelector(`#${vainkeurMinusOne}`),
                  vainkeurMinusOneDOMpoints           = vainkeurMinusOneDOM.querySelector('td:last-of-type');
            let vainkeurMinusOneDOMpointsTextContent  = vainkeurMinusOneDOMpoints.textContent;

            if(vainkeurMinusOneDOMpointsTextContent.includes("↑")) {
              pointsTwo = vainkeurMinusOneDOMpointsTextContent.substring(0, vainkeurMinusOneDOMpointsTextContent.indexOf("↑"));
            } else {
              pointsTwo = vainkeurMinusOneDOMpointsTextContent.substring(0, vainkeurMinusOneDOMpointsTextContent.indexOf("↓"));
            }

            if(+pointsTwo > 0) {
              vainkeurMinusOneDOMpoints.innerHTML = `${+pointsTwo - 1} &darr;`
              vainkeurMinusOneDOMpoints.setAttribute('data-order', `${+pointsTwo - 1}`)
            } else {
              vainkeurMinusOneDOMpoints.innerHTML = "0 &darr;"
              vainkeurMinusOneDOMpoints.setAttribute('data-order', '0')
            }
            vainkeurMinusOneDOMpoints.classList.remove('text-success')
            vainkeurMinusOneDOMpoints.classList.add('text-danger')
          }
        }   

        if(Object.keys(users).length) {
          const initTable = function () {
            let table = $('.table-points').dataTable();
            table.fnDestroy();

            table.dataTable({
              autoWidth: true,
              paging: false,
              searching: false,
              order: [[3, 'desc']],
            });

            positionStr = "";
            document.querySelector('.table-points tbody').querySelectorAll('tr').forEach((row, index) => {
              switch (index) {
                case 0:
                  positionStr = '<span class="ico va va-medal-1 va-lg"></span>';
                  break;
                case 1:
                  positionStr = '<span class="ico va va-medal-2 va-lg"></span>';
                  break;
                case 2:
                  positionStr = '<span class="ico va va-medal-3 va-lg"></span>';
                  break;
                default:
                  positionStr = index + 1;
              }

              row.querySelector('td:first-of-type').innerHTML = positionStr;
              row.querySelector('td:nth-of-type(3)').textContent = '🟠';

            })
          }();
        }

        for(let user in users) users[user] = { side: "0", voted: false };
      }
    }

    $(".contender_zone").removeClass("animate__zoomIn");
    $(".contender_zone").removeClass("animate__slideInDown");
    $(".contender_zone").removeClass("animate__slideInUp");

    e.preventDefault();

    if (!ajaxRunning) {
      ajaxRunning = true;
      if ($(this).find(".contender_zone").attr("id") === "c_1") {
        $("#c_1").addClass("vainkeurz");
        $("#c_1").addClass("animate__headShake");
        $("#c_2").addClass("animate__fadeOutDown");
      } else if ($(this).find(".contender_zone").attr("id") === "c_2") {
        $("#c_2").addClass("vainkeurz");
        $("#c_2").addClass("animate__headShake");
        $("#c_1").addClass("animate__fadeOutDown");
      }

      // Variables
      const id_top = $(this).find(".contender_zone").data("id-top");
      const id_ranking = $(this).find(".contender_zone").data("id-ranking");
      const id_winner = $(this).find(".contender_zone").data("id-winner");
      const id_looser = $(this).find(".contender_zone").data("id-looser");

      $.ajax({
        method: "POST",
        url: vkrz_ajaxurl,
        data: {
          action: "vkzr_process_vote",
          id_top: id_top,
          id_ranking: id_ranking,
          id_winner: id_winner,
          id_looser: id_looser,
          current_id_vainkeur: id_vainkeur,
        },
      })
        .done(function (response) {
          let data = JSON.parse(response);

          if (data.level_up !== undefined && data.level_up) {
            $(".dropdown-user-link .user-niveau").html(data.user_level_icon);

            toastr["success"](
              "Tu passes au niveau " + data.level_emoji,
              "Félicitations",
              {
                closeButton: true,
                tapToDismiss: false,
                progressBar: true,
              }
            );

            window.dataLayer.push({
              event: "track_event",
              event_name: "level_up",
              categorie: vkrz_tracking_vars_top.top_categorie_layer,
              top_title: vkrz_tracking_vars_top.top_title_layer,
              top_id: vkrz_tracking_vars_top.top_id_top_layer,
              top_type: vkrz_tracking_vars_top.top_type_layer,
              user_id: vkrz_tracking_vars_user.id_user_layer,
              user_uuid: vkrz_tracking_vars_user.uuiduser_layer,
              user_level: data.user_level,
              utm: vkrz_tracking_vars_top.utm_layer,
              event_score: 50,
            });
          }

          if (data.is_next_duel) {
            $(".display_battle").html(data.contenders_html);
            // var contenders = $(".display_battle .link-contender");
            $(".contender_1 .contender_zone").addClass("animate__zoomIn");
            $(".contender_2 .contender_zone").addClass("animate__zoomIn");

            $(".stepbar").width(data.current_step + "%");
            $(".stepbar span").html(data.current_step + "%");

            // +1 au compteur de votes du tournoi
            var current_user_t_votes = parseInt(
              $("#rank-" + data.id_ranking + " span.value-span").html()
            );
            $("#rank-" + data.id_ranking + " span.value-span").html(
              current_user_t_votes + 1
            );

            // +1 au compteur de XP
            var current_user_total_votes = parseInt(
              $(".user-total-vote-value").html()
            );
            $(".user-total-vote-value").html(current_user_total_votes + 1);

            // +1 au compteur des KEURZ
            var current_user_total_keurz = parseInt(
              $(".money-disponible").html()
            );
            $(".money-disponible").html(current_user_total_keurz + 1);

            // -1 au décompte du prochain niveau
            var current_decompte_vote = parseInt($(".decompte_vote").html());
            var $new_decompte_vote_val = current_decompte_vote - 1;
            if ($new_decompte_vote_val <= 0) {
              $new_decompte_vote_val = 0;
            }
            $(".decompte_vote").html($new_decompte_vote_val);

            $(".display_users_votes h6").replaceWith(data.uservotes_html);
            $(".current_rank").html(data.user_ranking_html);
          }

          window.dataLayer.push({
            event: "track_event",
            event_name: "vote",
            categorie: vkrz_tracking_vars_top.top_categorie_layer,
            top_title: vkrz_tracking_vars_top.top_title_layer,
            top_id: vkrz_tracking_vars_top.top_id_top_layer,
            top_type: vkrz_tracking_vars_top.top_type_layer,
            user_id: vkrz_tracking_vars_user.id_user_layer,
            user_uuid: vkrz_tracking_vars_user.uuiduser_layer,
            user_level: vkrz_tracking_vars_top.top_user_level_layer,
            utm: vkrz_tracking_vars_top.utm_layer,
            event_score: 1,
          });

          // Save ELO score
          maj_elo_firebase(id_winner, id_looser);

          if (!data.is_next_duel) {
            $(".waiter").show();

            maj_firebase_finish_top(id_top, id_vainkeur, id_ranking);

            window.dataLayer.push({
              event: "track_event",
              event_name: "end_top",
              categorie: vkrz_tracking_vars_top.top_categorie_layer,
              top_title: vkrz_tracking_vars_top.top_title_layer,
              top_id: vkrz_tracking_vars_top.top_id_top_layer,
              top_type: vkrz_tracking_vars_top.top_type_layer,
              user_id: vkrz_tracking_vars_user.id_user_layer,
              user_uuid: vkrz_tracking_vars_user.uuiduser_layer,
              user_level: vkrz_tracking_vars_top.top_user_level_layer,
              utm: vkrz_tracking_vars_top.utm_layer,
              event_score: 20,
            });

            // CHECK IF THERE IS SOME FOLLOWERS (CAN BE ALSO A FRIENDS), SEND NOTIFICATIONS TO THEM AND GO THE RANKING PAGE…
            (async function () {
              // FUNCTION TO SORT CONTENDERS…
              const sortContenders = function (ranking) {
                let contendersArr = [],
                  contendersArrPlaces = [],
                  contendersArrIDs = [];

                for (let contender of ranking) {
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
                ranking = contendersArr;

                return ranking;
              };
              let myContenders = sortContenders(data.toplist);

              // SEND NOTIFICATION FUNCTION…
              async function sendNotification(
                userId,
                uuid,
                relatedId,
                relatedUuid,
                notifText,
                notifLink,
                notifType,
                extendedData
              ) {
                try {
                  const newRankingFollow = await addDoc(
                    collection(database, "notifications"),
                    {
                      userId: userId,
                      uuid: uuid,
                      relatedId: relatedId,
                      relatedUuid: relatedUuid,
                      notifText: notifText,
                      notifLink: notifLink,
                      notifType: notifType,
                      extendedData: extendedData,
                      statut: "nouveau",
                      createdAt: new Date(),
                    }
                  );
                  console.log(
                    "Notification sent to follower with ID: ",
                    newRankingFollow.id
                  );
                } catch (error) {
                  console.error("Error adding document: ", error);
                }
              }

              if (currentUserId != "0") {
                const followersQuery = query(
                  collection(database, "notifications"),
                  where("notifType", "==", "follow"),
                  where("relatedUuid", "==", currentUuid)
                );
                const followersQuerySnapshot = await getDocs(followersQuery);

                // THERE IS NO FOLLOWERS, SO YOU STOP HERE…
                if (followersQuerySnapshot._snapshot.docs.size != 0) {
                  // FRIENDS PROCESS FIRST…
                  const followingQuery = query(
                    collection(database, "notifications"),
                    where("notifType", "==", "follow"),
                    where("uuid", "==", currentUuid)
                  );
                  const followingQuerySnapshot = await getDocs(followingQuery);

                  let friends = [],
                    followers = [];
                  followersQuerySnapshot.forEach((follower) => {
                    followers.push(follower.data());
                    followingQuerySnapshot.forEach((following) => {
                      if (
                        follower.data().uuid == following.data().relatedUuid
                      ) {
                        friends.push(follower.data());
                      }
                    });
                  });

                  friends.forEach((friend) => {
                    (async function () {
                      // CHECK IF THE FRIEND ALREADY PASSED THE TOP OR NOT… 🤙
                      const didRankingQuery = query(
                        collection(database, "wpClassement"),
                        where(
                          "custom_fields.uuid_user_r",
                          "==",
                          friend["uuid"]
                        ),
                        where(
                          "custom_fields.id_tournoi_r",
                          "==",
                          vkrz_tracking_vars_top.top_id_top_layer.toString()
                        ),
                        where("custom_fields.done_r", "==", "done")
                      );
                      const didRankingQuerySnapshot = await getDocs(
                        didRankingQuery
                      );
                      let notifText = "";

                      if (didRankingQuerySnapshot._snapshot.docs.size === 0) {
                        // CHECK IF HE ALREADY READ THE NOTIFICATION…
                        (async function () {
                          const querios = query(
                            collection(database, "notifications"),
                            where("uuid", "==", currentUuid),
                            where(
                              "notifType",
                              "==",
                              "Ranking To Friend Notification"
                            ),
                            where("relatedUuid", "==", friend["uuid"]),
                            where("statut", "==", "nouveau"),
                            orderBy("createdAt", "desc"),
                            limit(1)
                          );
                          const queriosSnapshot = await getDocs(querios);
                          let oldNotif;
                          queriosSnapshot.forEach((data) => {
                            oldNotif = { id: data.id, ...data.data() };
                          });

                          if (queriosSnapshot._snapshot.docs.size === 0) {
                            // ALREADY READ THE NOTIFICATION…
                            // SEND SIMPLE NOTIFICATION…
                            sendNotification(
                              vkrz_tracking_vars_user.id_user_layer,
                              vkrz_tracking_vars_user.uuiduser_layer,
                              friend["userId"],
                              friend["uuid"],
                              `${vkrz_tracking_vars_user.pseudo_user_layer} à fait une TopList de ${vkrz_tracking_vars_top.top_only_title_layer}`,
                              link_to_ranking,
                              "Ranking To Friend Notification",
                              `${
                                vkrz_tracking_vars_top.top_only_title_layer
                              }|${1}`
                            );
                          } // NOT READ THE NOTIFICATION…
                          else {
                            (async function () {
                              let oldNotifMessage = oldNotif.notifText;
                              if (
                                !oldNotifMessage.includes("MATCH TOPLIST!") &&
                                !oldNotifMessage.includes("déjà fait!")
                              ) {
                                deleteDoc(
                                  doc(database, "notifications", oldNotif.id)
                                );
                              }

                              const [oldTopTitle, topListNumber] =
                                oldNotif.extendedData.split("|");

                              // AVOID THE TOPs WHO GOT THE SAME NAME…
                              let notifMessage;
                              if (
                                oldTopTitle ==
                                vkrz_tracking_vars_top.top_only_title_layer
                              ) {
                                notifMessage = `${vkrz_tracking_vars_user.pseudo_user_layer} à fait deux TopList de ${vkrz_tracking_vars_top.top_only_title_layer}`;
                              } else {
                                notifMessage = `${vkrz_tracking_vars_user.pseudo_user_layer} à fait deux TopList: ${vkrz_tracking_vars_top.top_only_title_layer} et ${oldTopTitle}`;
                              }

                              if (oldNotif.notifLink != currentUserProfileUrl) {
                                // ONLY TWO…
                                sendNotification(
                                  vkrz_tracking_vars_user.id_user_layer,
                                  vkrz_tracking_vars_user.uuiduser_layer,
                                  friend["userId"],
                                  friend["uuid"],
                                  notifMessage,
                                  currentUserProfileUrl,
                                  "Ranking To Friend Notification",
                                  `${
                                    vkrz_tracking_vars_top.top_only_title_layer
                                  }|${2}`
                                );
                              } else {
                                // SEND COMPOUND NOTIFICATION…
                                sendNotification(
                                  vkrz_tracking_vars_user.id_user_layer,
                                  vkrz_tracking_vars_user.uuiduser_layer,
                                  friend["userId"],
                                  friend["uuid"],
                                  `${vkrz_tracking_vars_user.pseudo_user_layer} à fait des TopList: ${vkrz_tracking_vars_top.top_only_title_layer} et ${topListNumber} autres`,
                                  currentUserProfileUrl,
                                  "Ranking To Friend Notification",
                                  `${
                                    vkrz_tracking_vars_top.top_only_title_layer
                                  }|${+topListNumber + 1}`
                                );
                              }
                            })();
                          }
                        })();
                      } else {
                        // GET FRIEND RANKING, SORT IT AND COMPARE IT…
                        let contenders;
                        didRankingQuerySnapshot.forEach((ranking) => {
                          contenders = sortContenders(
                            ranking.data().custom_fields.ranking_r
                          );

                          // COMPARE IT WITH MY RANKING…
                          const sameRankingFunc = function (obj1, obj2) {
                            const obj1Keys = Object.keys(obj1);
                            const obj2Keys = Object.keys(obj2);

                            if (obj1Keys.length !== obj2Keys.length) {
                              return false;
                            }

                            for (let objKey of obj1Keys) {
                              if (obj1[objKey] !== obj2[objKey]) {
                                if (
                                  typeof obj1[objKey] == "object" &&
                                  typeof obj2[objKey] == "object"
                                ) {
                                  if (
                                    !sameRankingFunc(obj1[objKey], obj2[objKey])
                                  ) {
                                    return false;
                                  }
                                } else {
                                  return false;
                                }
                              }
                            }

                            return true;
                          };

                          // DEFINE WHICH CASE, SAME RANKING OR NOT…
                          if (sameRankingFunc(contenders, myContenders))
                            notifText = `MATCH TOPLIST! 🤯 toi et ${vkrz_tracking_vars_user.pseudo_user_layer}`;
                          else
                            notifText = `${vkrz_tracking_vars_user.pseudo_user_layer} a terminé un Top que t'as déjà fait!`;
                        });

                        // SEND NOTIFICATION…
                        sendNotification(
                          vkrz_tracking_vars_user.id_user_layer,
                          vkrz_tracking_vars_user.uuiduser_layer,
                          friend["userId"],
                          friend["uuid"],
                          notifText,
                          link_to_ranking,
                          "Ranking To Friend Notification",
                          `${vkrz_tracking_vars_top.top_only_title_layer}|${1}`
                        );
                      }
                    })();
                  });

                  // GET ONLY FOLLOWERS…
                  const isSameFollower = (a, b) => a.userId === b.userId;
                  const onlyInLeft = (left, right, compareFunc) =>
                    left.filter(
                      (leftValue) =>
                        !right.some((rightValue) =>
                          compareFunc(leftValue, rightValue)
                        )
                    );
                  let onlyInA = onlyInLeft(followers, friends, isSameFollower),
                    onlyInB = onlyInLeft(friends, followers, isSameFollower);
                  followers = [...onlyInA, ...onlyInB];

                  // SEND TO FOLLOWERS NOTIFICATION…
                  followers.forEach((follower) => {
                    // CHECK IF HE ALREADY READ THE NOTIFICATION…
                    (async function () {
                      const querios = query(
                        collection(database, "notifications"),
                        where("uuid", "==", currentUuid),
                        where(
                          "notifType",
                          "==",
                          "Ranking To Follower Notification"
                        ),
                        where("relatedUuid", "==", follower["uuid"]),
                        where("statut", "==", "nouveau"),
                        orderBy("createdAt", "desc"),
                        limit(1)
                      );
                      const queriosSnapshot = await getDocs(querios);
                      let oldNotif;
                      queriosSnapshot.forEach((data) => {
                        oldNotif = { id: data.id, ...data.data() };
                      });

                      if (queriosSnapshot._snapshot.docs.size === 0) {
                        // ALREADY READ THE NOTIFICATION…
                        // SEND SIMPLE NOTIFICATION…
                        sendNotification(
                          vkrz_tracking_vars_user.id_user_layer,
                          vkrz_tracking_vars_user.uuiduser_layer,
                          follower["userId"],
                          follower["uuid"],
                          `${vkrz_tracking_vars_user.pseudo_user_layer} à fait une TopList de ${vkrz_tracking_vars_top.top_only_title_layer}`,
                          link_to_ranking,
                          "Ranking To Follower Notification",
                          `${vkrz_tracking_vars_top.top_only_title_layer}|${1}`
                        );
                      } // NOT READ THE NOTIFICATION…
                      else {
                        (async function () {
                          // DELETE THE NOTIFICATION ONE…
                          deleteDoc(
                            doc(database, "notifications", oldNotif.id)
                          );

                          const [oldTopTitle, topListNumber] =
                            oldNotif.extendedData.split("|");

                          // AVOID THE TOPs WHO GOT THE SAME NAME…
                          let notifMessage;
                          if (
                            oldTopTitle ==
                            vkrz_tracking_vars_top.top_only_title_layer
                          ) {
                            notifMessage = `${vkrz_tracking_vars_user.pseudo_user_layer} à fait deux TopList de ${vkrz_tracking_vars_top.top_only_title_layer}`;
                          } else {
                            notifMessage = `${vkrz_tracking_vars_user.pseudo_user_layer} à fait deux TopList: ${vkrz_tracking_vars_top.top_only_title_layer} et ${oldTopTitle}`;
                          }

                          if (oldNotif.notifLink != currentUserProfileUrl) {
                            // ONLY TWO…
                            sendNotification(
                              vkrz_tracking_vars_user.id_user_layer,
                              vkrz_tracking_vars_user.uuiduser_layer,
                              follower["userId"],
                              follower["uuid"],
                              notifMessage,
                              currentUserProfileUrl,
                              "Ranking To Follower Notification",
                              `${
                                vkrz_tracking_vars_top.top_only_title_layer
                              }|${2}`
                            );
                          } else {
                            // SEND COMPOUND NOTIFICATION…
                            sendNotification(
                              vkrz_tracking_vars_user.id_user_layer,
                              vkrz_tracking_vars_user.uuiduser_layer,
                              follower["userId"],
                              follower["uuid"],
                              `${vkrz_tracking_vars_user.pseudo_user_layer} à fait des TopList: ${vkrz_tracking_vars_top.top_only_title_layer} et ${topListNumber} autres`,
                              currentUserProfileUrl,
                              "Ranking To Follower Notification",
                              `${vkrz_tracking_vars_top.top_only_title_layer}|${
                                +topListNumber + 1
                              }`
                            );
                          }
                        })();
                      }
                    })();
                  });
                }

                $(location).attr("href", link_to_ranking);
              } else {
                $(location).attr("href", link_to_ranking);
              }
            })();
          }
        })
        .always(function () {
          ajaxRunning = false;
        });
    }
  });
});
