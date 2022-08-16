import {
  collection,
  getDocs,
  deleteDoc,
  addDoc,
  doc,
  query,
  where,
  database,
} from "./config.js";

function checkGuetterButton() {
  if (
    document.querySelector("#followBtn") ||
    document.querySelector(".checking-follower")
  ) {
    let span;
    const followBtns = document.querySelectorAll("#followBtn");

    followBtns.forEach((followBtn) => {
      async function checkFollower() {
        /* CHECK IF HE'S FOLLOWED BY CURRENT VAINKEUR! */
        let q = query(
          collection(database, "notifications"),
          where("userId", "==", currentUserId),
          where("notifText", "==", `${vainkeurPseudo} te guette !`),
          where("relatedId", "==", followBtn.dataset.relatedid)
        );
        let querySnapshot = await getDocs(q);

        if (followBtn.querySelector(".wording")) {
          span = followBtn.querySelector(".wording");
        }
        followBtn.classList.remove("d-none");
        followBtn.style.float = "right";

        if (querySnapshot._snapshot.docs.size === 0) {
          /* NOT A FOLLOWER… */

          // SET NOTIFICATION… 🧑‍💻
          followBtn.addEventListener("click", function () {
            if (!followBtn.classList.contains("unfollowBtn")) {
              span = followBtn.querySelector(".wording");

              // STYLES… 🍏
              followBtn.classList.add("unfollowBtn");

              if (followBtn.querySelector(".wording")) {
                span.textContent = "Guetté";
              }

              followBtn.querySelector(".emoji").classList.add("va-guetteur");
              followBtn
                .querySelector(".emoji")
                .classList.remove("va-guetteur-close");

              if (document.querySelector(".followers-nbr")) {
                document.querySelector(".followers-nbr").textContent =
                  +document.querySelector(".followers-nbr").textContent + 1;
                if (+document.querySelector(".followers-nbr").textContent > 1) {
                  document.querySelector(".followers-nbr-text").textContent =
                    "Guetteurs";
                }
              }

              // INSERT DATA TO Firebase… 🤹
              async function setNotification() {
                try {
                  q = query(
                    collection(database, "notifications"),
                    where("userId", "==", currentUserId),
                    where("relatedId", "==", followBtn.dataset.relatedid)
                  );
                  querySnapshot = await getDocs(q);

                  if (querySnapshot._snapshot.docs.size === 0) {
                    const newFollow = await addDoc(
                      collection(database, "notifications"),
                      {
                        userId: followBtn.dataset.userid,
                        uuid: followBtn.dataset.uuid,
                        relatedId: followBtn.dataset.relatedid,
                        relatedUuid: followBtn.dataset.relateduuid,
                        notifText: followBtn.dataset.text,
                        notifLink: followBtn.dataset.url,
                        notifType: "follow",
                        statut: "nouveau",
                        createdAt: new Date(),
                      }
                    );
                    console.log("Notification sent with ID: ", newFollow.id);
                    followBtn.setAttribute("data-documentId", newFollow.id);
                  }
                } catch (error) {
                  console.error("Error adding document: ", error);
                }
              }
              setNotification();
            } else {
              deleteDoc(
                doc(database, "notifications", followBtn.dataset.documentid)
              );

              if (document.querySelector(".followers-nbr")) {
                document.querySelector(".followers-nbr").textContent =
                  +document.querySelector(".followers-nbr").textContent - 1;
                if (
                  +document.querySelector(".followers-nbr").textContent <= 1
                ) {
                  document.querySelector(".followers-nbr-text").textContent =
                    "Guetteur";
                }
              }

              followBtn.querySelector(".emoji").classList.remove("va-guetteur");
              followBtn
                .querySelector(".emoji")
                .classList.add("va-guetteur-close");

              followBtn.classList.remove("unfollowBtn");
              if (followBtn.querySelector(".wording")) {
                followBtn.querySelector("span").textContent = "Guetter";
              }
            }
          });
        } else {
          /* FOLLOWED ALREADY… */

          // STYLES… 🍏
          followBtn.classList.add("unfollowBtn");

          followBtn.querySelector(".emoji").classList.add("va-guetteur");
          followBtn
            .querySelector(".emoji")
            .classList.remove("va-guetteur-close");

          if (followBtn.querySelector(".wording")) {
            span.textContent = "Guetté";
          }
          followBtn.setAttribute(
            "data-documentId",
            querySnapshot._snapshot.docChanges[0].doc.key.path.segments[6]
          );

          followBtn.addEventListener("click", function () {
            if (!followBtn.classList.contains("unfollowBtn")) {
              // STYLES… 🍏
              followBtn.classList.add("unfollowBtn");

              if (followBtn.querySelector(".wording")) {
                followBtn.querySelector("span").textContent = "Guetté";
              }

              followBtn.querySelector(".emoji").classList.add("va-guetteur");
              followBtn
                .querySelector(".emoji")
                .classList.remove("va-guetteur-close");

              if (document.querySelector(".followers-nbr")) {
                document.querySelector(".followers-nbr").textContent =
                  +document.querySelector(".followers-nbr").textContent + 1;
                if (+document.querySelector(".followers-nbr").textContent > 1) {
                  document.querySelector(".followers-nbr-text").textContent =
                    "Guetteurs";
                }
              }

              // INSERT DATA TO Firebase… 🤹
              async function setNotification() {
                try {
                  q = query(
                    collection(database, "notifications"),
                    where("userId", "==", currentUserId),
                    where("relatedId", "==", followBtn.dataset.relatedid)
                  );
                  querySnapshot = await getDocs(q);

                  if (querySnapshot._snapshot.docs.size === 0) {
                    const newFollow = await addDoc(
                      collection(database, "notifications"),
                      {
                        userId: followBtn.dataset.userid,
                        uuid: followBtn.dataset.uuid,
                        relatedId: followBtn.dataset.relatedid,
                        relatedUuid: followBtn.dataset.relateduuid,
                        notifText: followBtn.dataset.text,
                        notifLink: followBtn.dataset.url,
                        notifType: "follow",
                        statut: "nouveau",
                        createdAt: new Date(),
                      }
                    );
                    console.log("Notification sent with ID: ", newFollow.id);
                    followBtn.setAttribute("data-documentId", newFollow.id);
                  }
                } catch (error) {
                  console.error("Error adding document: ", error);
                }
              }
              setNotification();
            } else {
              deleteDoc(
                doc(database, "notifications", followBtn.dataset.documentid)
              );

              followBtn.classList.remove("unfollowBtn");

              if (document.querySelector(".followers-nbr-text")) {
                document.querySelector(".followers-nbr").textContent =
                  +document.querySelector(".followers-nbr").textContent - 1;
                if (
                  +document.querySelector(".followers-nbr").textContent <= 1
                ) {
                  document.querySelector(".followers-nbr-text").textContent =
                    "Guetteur";
                }
              }

              followBtn.removeAttribute("data-documentId");

              followBtn
                .querySelector(".emoji")
                .classList.add("va-guetteur-close");
              followBtn.querySelector(".emoji").classList.remove("va-guetteur");

              if (followBtn.querySelector(".wording")) {
                followBtn.querySelector("span").textContent = "Guetter";
              }
            }
          });
        }
      }
      checkFollower();
    });
  }
}
checkGuetterButton();

// PUBLIC PROFILE PAGE…
if (document.querySelector(".followers-nbr")) {
  let q = query(
    collection(database, "notifications"),
    where("notifType", "==", "follow"),
    where("relatedId", "==", idVainkeurProfil)
  );
  let querySnapshot = await getDocs(q);

  document.querySelector(".followers-nbr").textContent =
    querySnapshot._snapshot.docs.size;
  document.querySelector(".followers-nbr-text").textContent =
    querySnapshot._snapshot.docs.size <= 1 ? "Guetteur" : "Guetteurs";
}

// ACCOUNT PAGE…
if (document.querySelector(".followers-account-nbr")) {
  let q = query(
    collection(database, "notifications"),
    where("notifType", "==", "follow"),
    where("relatedId", "==", currentUserId)
  );
  let querySnapshot = await getDocs(q);

  document.querySelector(".followers-account-nbr").textContent =
    querySnapshot._snapshot.docs.size;
  document.querySelector(".followers-account-nbr-text").textContent =
    querySnapshot._snapshot.docs.size <= 1 ? "Guetteur" : "Guetteurs";
}

export { checkGuetterButton };
