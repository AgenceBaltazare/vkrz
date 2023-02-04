import {
  collection,
  getDocs,
  addDoc,
  query,
  where,
  database,
  sortContendersFuncHelper,
  calcResemblanceFuncHelper,
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
    if (
      document.querySelector(".display_battle") &&
      localStorage.getItem("twitchGameMode") !== null
    ) {
      if (voteParticipatifBoolean) {
        users = {};
        votesNumber.textContent = "0";
        votesNumberForContenderOne = 0;
        votesNumberForContenderTwo = 0;
        contenderOneVotesPercent.textContent = "0%";
        contenderTwoVotesPercent.textContent = "0%";
        X = A = B = 0;
        document.querySelector("#votes-stats-1").classList.remove("active");
        document.querySelector("#votes-stats-2").classList.remove("active");
      } else if (votePredictionBoolean && winnerAlready === false) {
        let side;
        if (e.target.closest("div").getAttribute("id") == "c_1") side = "1";
        else if (e.target.closest("div").getAttribute("id") == "c_2")
          side = "2";

        toFilter = Object.entries(users);
        nonPassed = toFilter.filter(([key, value]) => value.side !== side);
        passed = toFilter.filter(([key, value]) => value.side === side);

        // WINNER CHICKEN DINNER…
        if (passed.length === 1 && winnerAlready === false) {
          winnerAlready = true;
          document.querySelector("#prediction-player").classList.add("d-none");
          document
            .querySelector("#prediction-player .card-header")
            .classList.add("flex-column-reverse");
          document.querySelector("#prediction-player .card-header").style.gap =
            "8px";
          document
            .querySelectorAll(".votes-container > p:first-of-type")
            .forEach((p) => p.remove());
          document.querySelector(".display_battle").classList.add("blur");
          document.querySelector("#winner-sound").play();
          document.querySelector(".twitchGamesWinnerName").textContent =
            passed[0][0];
          $(".twitchGamesWinnerContainer").addClass("show");
          confetti();

          function rnd(m, n) {
            m = parseInt(m);
            n = parseInt(n);

            return Math.floor(Math.random() * (n - m + 1)) + m;
          }

          function confetti() {
            $.each($(".twitchGamesWinnerName.confetti"), function () {
              var confetticount = ($(this).width() / 50) * 10;
              for (var i = 0; i <= confetticount; i++) {
                $(this).append(
                  '<span class="particle c' +
                    rnd(1, 4) +
                    '" style="top:' +
                    rnd(10, 50) +
                    "%; left:" +
                    rnd(0, 100) +
                    "%;width:" +
                    rnd(5, 15) +
                    "px; height:" +
                    rnd(5, 10) +
                    "px;animation-delay: " +
                    rnd(0, 30) / 10 +
                    's;"></span>'
                );
              }
            });
          }

          document
            .querySelector("#winner-continuer")
            .addEventListener("click", () => {
              document
                .querySelector(".display_battle")
                .classList.remove("blur");
              document.querySelector(".twitchGamesWinnerContainer").remove();
              document
                .querySelector("#prediction-player")
                .classList.remove("d-none");
            });

          const twitchGameResumeObj = {
            idRanking: `${$(".contender_zone").data("id-ranking")}`,
            participantsNumber: `${
              Object.keys(users).length + Object.keys(losers).length
            }`,
            mode: "votePrediction",
            winner: `${passed[0][0]}`,
          };
          localStorage.removeItem("resumeTwitchGame");
          localStorage.setItem(
            "resumeTwitchGame",
            JSON.stringify(twitchGameResumeObj)
          );
        }

        for (let user of toFilter) {
          user[1]["voted"] = false;
          user[1]["side"] = "0";
          document
            .querySelector(`#prediction-player #${user[0]}`)
            .classList.remove("text-primary");
        }

        if (passed.length === 0) {
          users = Object.fromEntries(nonPassed);
        } else {
          users = Object.fromEntries(passed);

          losers = { ...losers, ...Object.fromEntries(nonPassed) };

          if (nonPassed.length > 0) {
            const elimines = document.querySelector(
              "#participants .card-title.elimines"
            );
            elimines.classList.remove("d-none");
            elimines.innerHTML = `<span class="va va-unknow va-lg"></span> ${
              Object.keys(losers).length
            } ${Object.keys(losers).length > 1 ? "Eliminés" : "Eliminé"}`;

            for (const [key, loser] of Object.entries(nonPassed)) {
              let target = document.querySelector(
                `#prediction-player #${loser[0]}`
              );
              target.classList.remove("text-primary");
              target.classList.add("beforeDelete");
              setTimeout(() => {
                target.remove();
              }, 4000);
            }
          }
        }

        if (Object.keys(users).length === 1 || winnerAlready === true) {
          document.querySelector("#participants .card-title").innerHTML =
            "<i class='fab fa-twitch'></i> Le gagnant!! 🎉";
        } else if (Object.keys(users).length > 1) {
          preditcionParticipantsVotedNumber.textContent = 0;
          preditcionParticipantsNumber.textContent = Object.keys(users).length;
        } else if (Object.keys(users).length === 0) {
          document.querySelector("#participants .card-title").innerHTML =
            "<i class='fab fa-twitch'></i> 0 Participants";
        }
      } else if (votePointsBoolean) {
        let side;
        if (e.target.closest("div").getAttribute("id") == "c_1") side = "1";
        else if (e.target.closest("div").getAttribute("id") == "c_2")
          side = "2";

        toFilter = Object.entries(users);

        let oppositeSide = side === "1" ? "2" : "1";
        notSameVoteGroup = toFilter.filter(
          ([key, value]) => value.side === oppositeSide
        );
        notSameVoteGroupObj = Object.fromEntries(notSameVoteGroup);

        sameVoteGroup = toFilter.filter(([key, value]) => value.side === side);
        sameVoteGroupObj = Object.fromEntries(sameVoteGroup);

        for (const vainkeurPlusOne of Object.keys(sameVoteGroupObj)) {
          const vainkeurPlusOneDOM = document.querySelector(
              `#ranking-player #${vainkeurPlusOne}`
            ),
            vainkeurPlusOneDOMpoints =
              vainkeurPlusOneDOM.querySelector("td:last-of-type");

          vainkeurPlusOneDOMpoints.innerHTML = `${
            +vainkeurPlusOneDOMpoints.dataset.order + 1
          } &uarr;`;
          vainkeurPlusOneDOMpoints.classList.add("text-success");
          vainkeurPlusOneDOMpoints.setAttribute(
            "data-order",
            `${+vainkeurPlusOneDOMpoints.dataset.order + 1}`
          );
        }

        if (notSameVoteGroup.length > 0) {
          for (let vainkeurMinusOne of Object.keys(notSameVoteGroupObj)) {
            const vainkeurMinusOneDOM = document.querySelector(
                `#ranking-player #${vainkeurMinusOne}`
              ),
              vainkeurMinusOneDOMpoints =
                vainkeurMinusOneDOM.querySelector("td:last-of-type");

            vainkeurMinusOneDOMpoints.innerHTML =
              vainkeurMinusOneDOMpoints.dataset.order;
            vainkeurMinusOneDOMpoints.classList.remove("text-success");
            vainkeurMinusOneDOMpoints.setAttribute(
              "data-order",
              vainkeurMinusOneDOMpoints.dataset.order
            );
          }
        }

        if (Object.keys(users).length) {
          const initTable = (function () {
            let table = $(".table-points").dataTable();
            table.fnDestroy();

            table.dataTable({
              autoWidth: true,
              paging: false,
              searching: false,
              order: [[2, "desc"]],
            });

            positionStr = "";
            document
              .querySelector(".table-points tbody")
              .querySelectorAll("tr")
              .forEach((row, index) => {
                switch (index) {
                  case 0:
                    positionStr =
                      '<span class="ico va va-medal-1 va-lg"></span>';
                    break;
                  case 1:
                    positionStr =
                      '<span class="ico va va-medal-2 va-lg"></span>';
                    break;
                  case 2:
                    positionStr =
                      '<span class="ico va va-medal-3 va-lg"></span>';
                    break;
                  default:
                    positionStr = index + 1;
                }

                row.querySelector("td:first-of-type").innerHTML = positionStr;
                row
                  .querySelector("td:nth-of-type(2)")
                  .classList.remove("voted");
              });
          })();
        }

        pointsParticipantsVotedNumber.textContent = 0;

        for (let user in users) users[user] = { side: "0", voted: false };
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

            function setCookie(cname, cvalue, exdays) {
              const d = new Date();
              d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
              let expires = "Expires=" + d.toUTCString();
              document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }
            setCookie("wordpress_toastr_cookies", JSON.stringify({"toastr_text": null, "toastr_icon":data.level_emoji, "toastr_type":"niveau"}), 365);

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

            // SAVE WINNER OF THE MATCH AUX POINTS TWITCH GAME…
            if (
              document.querySelector(".display_battle") &&
              localStorage.getItem("twitchGameMode") !== null &&
              votePointsBoolean
            ) {
              const twitchGameResumeObj = {
                idRanking: `${id_ranking}`,
                participantsNumber: `${Object.keys(users).length}`,
                mode: "votePoints",
                tbody: `${document.querySelector(".table-points tbody").innerHTML}`,
              };
              localStorage.removeItem("resumeTwitchGame");
              localStorage.setItem(
                "resumeTwitchGame",
                JSON.stringify(twitchGameResumeObj)
              );
            }

            async function notificationsProcess() {
              let myContenders = sortContendersFuncHelper(data.toplist);

              const sendNotification = async function(
                userId,
                uuid,
                relatedId,
                relatedUuid,
                notifText,
                notifLink,
                notifType
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

                if (followersQuerySnapshot._snapshot.docs.size != 0) {
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
                      // CHECK IF THE FRIEND ALREADY PASSED THE TOP OR NOT…
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
                      } else {
                        // GET FRIEND RANKING, SORT IT AND COMPARE IT…
                        let contenders;
                        didRankingQuerySnapshot.forEach((ranking) => {
                          contenders = sortContendersFuncHelper(
                            ranking.data().custom_fields.ranking_r
                          );

                          // DEFINE WHICH CASE, SAME RANKING OR NOT…
                          if (
                            calcResemblanceFuncHelper(
                              myContenders,
                              contenders,
                              false
                            ) === "100%"
                          )
                            notifText = `MATCH TOPLIST! 🤯 toi et ${vkrz_tracking_vars_user.pseudo_user_layer}`;
                          else
                            notifText = `${vkrz_tracking_vars_user.pseudo_user_layer} a terminé un Top que t'as déjà fait!`;
                        });

                        sendNotification(
                          vkrz_tracking_vars_user.id_user_layer,
                          vkrz_tracking_vars_user.uuiduser_layer,
                          friend["userId"],
                          friend["uuid"],
                          notifText,
                          link_to_ranking,
                          "Ranking To Friend Notification"
                        );
                      }
                    })();
                  });
                }
              }

              return "done";
            }
            async function goToTopListPage() {
              localStorage.removeItem("twitchGameMode");
              $(location).attr("href", link_to_ranking);
            }
            notificationsProcess().then(
              async (result) => await goToTopListPage()
            );
          }
        })
        .always(function () {
          ajaxRunning = false;
        });
    }
  });
});
