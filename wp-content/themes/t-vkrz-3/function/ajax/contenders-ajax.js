import {
  collection,
  getDocs,
  addDoc,
  query,
  where,
  database,
} from "http://localhost:8888/vkrz/wp-content/themes/t-vkrz-3/function/firebase/config.js";

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
      $.ajax({
        method: "POST",
        url: vkrz_ajaxurl,
        data: {
          action: "vkzr_process_vote",
          id_top: $(this).find(".contender_zone").data("id-top"),
          id_ranking: $(this).find(".contender_zone").data("id-ranking"),
          id_winner: $(this).find(".contender_zone").data("id-winner"),
          id_looser: $(this).find(".contender_zone").data("id-looser"),
          current_id_vainkeur: id_vainkeur,
        },
      })
        .done(function (response) {
          let data = JSON.parse(response);

          if (data.level_up !== undefined && data.level_up) {
            $(".dropdown-user-link .user-niveau").html(data.user_level_icon);
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

            // +1 au compteur de votes global
            var current_user_total_votes = parseInt(
              $(".user-total-vote-value").html()
            );
            $(".user-total-vote-value").html(current_user_total_votes + 1);

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

          if (!data.is_next_duel) {
            $(".waiter").show();

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

            $(location).attr("href", link_to_ranking);

            // Optimize contenders object… 🍏
            for (let contender of data.toplist) {
              delete contender.c_name;
              delete contender.elo;
              delete contender.id;
              delete contender.less_to;
              delete contender.more_to;
              delete contender.ratio;
              delete contender.image;
            }

            // INSERT RANKING TO Firebase… ✨
            async function saveRankingToFirebase() {
              try {
                const nouveauClassement = await addDoc(
                  collection(database, "classements"),
                  {
                    categorie: vkrz_tracking_vars_top.top_categorie_layer,
                    top_title: vkrz_tracking_vars_top.top_title_layer,
                    top_id: vkrz_tracking_vars_top.top_id_top_layer,
                    top_type: vkrz_tracking_vars_top.top_type_layer,
                    user_id: vkrz_tracking_vars_user.id_user_layer,
                    user_uuid: vkrz_tracking_vars_user.uuiduser_layer,
                    user_level: vkrz_tracking_vars_top.top_user_level_layer,
                    utm: vkrz_tracking_vars_top.utm_layer,
                    done_date_r: data.date_done,
                    is_suspected_cheating: data.triche,
                    array_ranking: data.toplist,
                    classement_url: data.classement_url,
                  }
                );
                console.log("Document written with ID: ", nouveauClassement.id);
              } catch (error) {
                console.error("Error adding document: ", error);
              }
            }
            saveRankingToFirebase();

            // SORT MY CONTENDERS…
            let myContenders = [],
            myContendersPlaces = [],
            myContendersIDs = [];

            for (let contender of data.toplist) {
              myContenders.push(contender);
              myContendersPlaces.push(contender.place);

              myContendersIDs.push(contender.id_wp);
            }
            myContenders.sort(function(a, b) {
                return b.place - a.place;
            });
            myContendersPlaces.sort(function(a, b) {
                return b - a;
            }).reverse();
            for (let j = 0; j < myContenders.length; j++) {
                myContenders[j].place = myContendersPlaces[j];
            }

            // CHECK IF THERE IS SOME FOLLOWERS (CAN BE ALSO A FRIENDS), AND SEND TO THEM… 💥
            async function checkFollowerBeforeSend() {
              const q1 = query(
                collection(database, "notifications"),
                where("notifType", "==", "follow"),
                where(
                  "relatedId",
                  "==",
                  vkrz_tracking_vars_user.id_user_layer.toString()
                )
              );
              const querySnapshot1 = await getDocs(q1);

              // THERE IS NO FOLLOWERS, SO YOU STOP HERE… 😿
              if (querySnapshot1._snapshot.docs.size === 0) return;

              const q2 = query(
                collection(database, "notifications"),
                where("notifType", "==", "follow"),
                where(
                  "userId",
                  "==",
                  vkrz_tracking_vars_user.id_user_layer.toString()
                )
              );
              const querySnapshot2 = await getDocs(q2);

              /* GET FRIENDS & FOLLOWERS… 👀 */

              // FRIENDS PROCESS…
              let friends = [],
                followers = [];
              querySnapshot1.forEach((data1) => {
                followers.push(data1.data());
                querySnapshot2.forEach((data2) => {
                  if (data1.data().userId == data2.data().relatedId) {
                    friends.push(data1.data());
                  }
                });
              });
              friends.forEach((friend) => {
                async function checkFriendTop() {
                  // CHECK IF THE FRIEND ALREADY PASSED THE TOP OR NOT… 🤙
                  const q3 = query(
                    collection(database, "classements"),
                    where("user_id", "==", Number(friend["userId"])),
                    where(
                      "top_id",
                      "==",
                      Number(vkrz_tracking_vars_top.top_id_top_layer)
                    )
                  );
                  const querySnapshot3 = await getDocs(q3);
                  let notifText = "";

                  if (querySnapshot3._snapshot.docs.size === 0) {
                    notifText = `Ton ami ${vkrz_tracking_vars_user.pseudo_user_layer} a fait un nouveau classement!`
                  } else {
                    /* DID THE TOP… 😻 */

                    // GET FRIEND RANKING, AND SORT IT…
                    querySnapshot3.forEach((data) => {
                      let contenders = [],
                          contendersPlaces = [],
                          contendersIDs = [];

                      for (let contender of data.data().array_ranking) {
                        contenders.push(contender);
                        contendersPlaces.push(contender.place);

                        contendersIDs.push(contender.id_wp);
                      }
                      contenders.sort(function(a, b) {
                          return b.place - a.place;
                      });
                      contendersPlaces.sort(function(a, b) {
                          return b - a;
                      }).reverse();
                      for (let j = 0; j < contenders.length; j++) {
                          contenders[j].place = contendersPlaces[j];
                      }

                      // COMPARE IT WITH MY RANKING…
                      const sameRankingFunc = function (obj1, obj2) {
                        const obj1Keys = Object.keys(obj1);
                        const obj2Keys = Object.keys(obj2);
                      
                        if (obj1Keys.length !== obj2Keys.length) {
                          return false;
                        }
                      
                        for (let objKey of obj1Keys) {
                          if (obj1[objKey] !== obj2[objKey]) {
                            if (typeof obj1[objKey] == "object" && typeof obj2[objKey] == "object") {
                              if (!sameRankingFunc(obj1[objKey], obj2[objKey])) {
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
                      if(sameRankingFunc(contenders, myContenders)) notifText = `MATCH CLASSEMENT! 🤯 toi et ${vkrz_tracking_vars_user.pseudo_user_layer}`; else notifText = `Ton ami ${vkrz_tracking_vars_user.pseudo_user_layer} a fait un classement d'un Top que t'as déjà fait!`
                    })
                  }

                  async function sendToFriend() {
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
                          notifType: "Ranking Notification",
                          statut: "nouveau",
                          createdAt: new Date(),
                        }
                      );
                      console.log(
                        "Notification sent with ID: ",
                        newRankingFollow.id
                      );
                    } catch (error) {
                      console.error("Error adding document: ", error);
                    }
                  }
                  sendToFriend();
                }
                checkFriendTop();
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
                async function sendToFollower() {
                  try {
                    const newRankingFollow = await addDoc(
                      collection(database, "notifications"),
                      {
                        userId: vkrz_tracking_vars_user.id_user_layer,
                        uuid: vkrz_tracking_vars_user.uuiduser_layer,
                        relatedId: follower["userId"],
                        relatedUuid: follower["uuid"],
                        notifText: `${vkrz_tracking_vars_user.pseudo_user_layer} vient de terminer un classement`,
                        notifLink: link_to_ranking,
                        notifType: "Ranking Notification",
                        statut: "nouveau",
                        createdAt: new Date(),
                      }
                    );
                    console.log(
                      "Notification sent with ID: ",
                      newRankingFollow.id
                    );
                  } catch (error) {
                    console.error("Error adding document: ", error);
                  }
                }
                sendToFollower();
              });
            }
            checkFollowerBeforeSend();
          }
        })
        .always(function () {
          ajaxRunning = false;
        });
    }
  });
});