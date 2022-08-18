import {
  collection,
  getDocs,
  addDoc,
  query,
  where,
  database,
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

              if (currentUserId != "0") {
                const followersQuery = query(
                  collection(database, "notifications"),
                  where("notifType", "==", "follow"),
                  where(
                    "relatedUuid",
                    "==",
                    currentUuid
                  )
                );
                const followersQuerySnapshot = await getDocs(followersQuery);

                // THERE IS NO FOLLOWERS, SO YOU STOP HERE…
                if (followersQuerySnapshot._snapshot.docs.size != 0){
                  // FRIENDS PROCESS FIRST…
                  const followingQuery = query(
                    collection(database, "notifications"),
                    where("notifType", "==", "follow"),
                    where(
                      "uuid",
                      "==",
                      currentUuid
                    )
                  );
                  const followingQuerySnapshot = await getDocs(followingQuery);

                  let friends = [],
                    followers = [];
                  followersQuerySnapshot.forEach((follower) => {
                    followers.push(follower.data());
                    followingQuerySnapshot.forEach((following) => {
                      if (follower.data().uuid == following.data().relatedUuid) {
                        friends.push(follower.data());
                      }
                    });
                  });

                  friends.forEach((friend) => {
                    (async function () {
                      // CHECK IF THE FRIEND ALREADY PASSED THE TOP OR NOT… 🤙
                      const didRankingQuery = query(
                        collection(database, "wpClassement"),
                        where("custom_fields.uuid_user_r", "==", friend["uuid"]),
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
                        notifText = `${vkrz_tracking_vars_user.pseudo_user_layer} a terminé une nouvelle TopList!`;
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
                      }

                      (async function () {
                        try {
                          const newRankingFollow = await addDoc(
                            collection(database, "notifications"),
                            {
                              userId: vkrz_tracking_vars_user.id_user_layer,
                              uuid: vkrz_tracking_vars_user.uuiduser_layer,
                              relatedId: friend["userId"],
                              relatedUuid: friend["uuid"],
                              notifText: notifText,
                              notifLink: link_to_ranking,
                              notifType: "Ranking To Friend Notification",
                              statut: "nouveau",
                              createdAt: new Date(),
                            }
                          );
                          console.log(
                            "Notification sent to friend with ID: ",
                            newRankingFollow.id
                          );
                        } catch (error) {
                          console.error("Error adding document: ", error);
                        }
                      })();
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
                    (async function () {
                      try {
                        const newRankingFollow = await addDoc(
                          collection(database, "notifications"),
                          {
                            userId: vkrz_tracking_vars_user.id_user_layer,
                            uuid: vkrz_tracking_vars_user.uuiduser_layer,
                            relatedId: follower["userId"],
                            relatedUuid: follower["uuid"],
                            notifText: `${vkrz_tracking_vars_user.pseudo_user_layer} vient de terminer une TopList`,
                            notifLink: link_to_ranking,
                            notifType: "Ranking To Follower Notification",
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