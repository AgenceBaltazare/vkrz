import {
  collection,
  getDocs,
  deleteDoc,
  addDoc,
  doc,
  query,
  where,
  database,
} from "http://localhost:8888/vkrz/wp-content/themes/t-vkrz-3/function/firebase/config.js";

if (document.querySelector("#followBtn")) {
  /* CHECK IF HE'S FOLLOWED BY CURRENT VAINKEUR! */
  let q = query(
    collection(database, "notifications"),
    where("notifText", "==", `${vainkeurPseudo} vous guette !`),
    where("relatedId", "==", idVainkeurProfil)
  );
  let querySnapshot = await getDocs(q);

  const followBtn = document.querySelector("#followBtn");
  const svg = followBtn.querySelector("svg"),
    span = followBtn.querySelector("span");
  followBtn.style.display = "block";

  if (querySnapshot._snapshot.docs.size === 0) {
    /* NOT A FOLLOWER… */

    // SET NOTIFICATION… 🧑‍💻
    followBtn.addEventListener("click", function () {
      if (!followBtn.classList.contains("unfollowBtn")) {
        // STYLES… 🍏
        followBtn.classList.remove("btn-warning");
        followBtn.classList.add("btn-success");
        followBtn.classList.add("unfollowBtn");

        svg.setAttribute("fill", "#FFF");
        span.textContent = "Suivi";

        document.querySelector('.followers-nbr').textContent = +document.querySelector('.followers-nbr').textContent + 1;
        if(+document.querySelector('.followers-nbr').textContent > 1) {
          document.querySelector('.followers-nbr-text').textContent = "Followers";
        }

        // INSERT DATA TO Firebase… 🤹
        async function setNotification() {
          try {
            q = query(
              collection(database, "notifications"),
              where("notifText", "==", `${vainkeurPseudo} vous guette !`),
              where("relatedId", "==", idVainkeurProfil)
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
          doc(
            database,
            "notifications",
            document.querySelector(".unfollowBtn").dataset.documentid
          )
        );

        document.querySelector('.followers-nbr').textContent = +document.querySelector('.followers-nbr').textContent - 1;
        if(+document.querySelector('.followers-nbr').textContent <= 1) {
          document.querySelector('.followers-nbr-text').textContent = "Follower";
        }

        followBtn.classList.add("btn-warning");
        followBtn.classList.remove("btn-success");
        followBtn.classList.remove("unfollowBtn");

        svg.setAttribute("fill", "transparent");
        span.textContent = "Suivre";
      }
    });
  } else {
    /* FOLLOWED ALREADY… */

    // STYLES… 🍏
    followBtn.classList.remove("btn-warning");
    followBtn.classList.add("btn-success");
    followBtn.classList.add("unfollowBtn");

    const svg = followBtn.querySelector("svg"),
      span = followBtn.querySelector("span");
    svg.setAttribute("fill", "#FFF");
    span.textContent = "Suivi";
    followBtn.setAttribute(
      "data-documentId",
      querySnapshot._snapshot.docChanges[0].doc.key.path.segments[6]
    );

    followBtn.addEventListener("click", function () {
      if (!followBtn.classList.contains("unfollowBtn")) {
        // STYLES… 🍏
        followBtn.classList.remove("btn-warning");
        followBtn.classList.add("btn-success");
        followBtn.classList.add("unfollowBtn");

        svg.setAttribute("fill", "#FFF");
        span.textContent = "Suivi";

        document.querySelector('.followers-nbr').textContent = +document.querySelector('.followers-nbr').textContent + 1;
        if(+document.querySelector('.followers-nbr').textContent > 1) {
          document.querySelector('.followers-nbr-text').textContent = "Followers";
        }

        // INSERT DATA TO Firebase… 🤹
        async function setNotification() {
          try {
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
          } catch (error) {
            console.error("Error adding document: ", error);
          }
        }
        setNotification();
      } else {
        deleteDoc(
          doc(
            database,
            "notifications",
            document.querySelector(".unfollowBtn").dataset.documentid
          )
        );

        followBtn.classList.add("btn-warning");
        followBtn.classList.remove("btn-success");
        followBtn.classList.remove("unfollowBtn");

        document.querySelector('.followers-nbr').textContent = +document.querySelector('.followers-nbr').textContent - 1;
        if(+document.querySelector('.followers-nbr').textContent <= 1) {
          document.querySelector('.followers-nbr-text').textContent = "Follower";
        }

        followBtn.removeAttribute("data-documentId");

        svg.setAttribute("fill", "transparent");
        span.textContent = "Suivre";
      }
    });
  }
}

// PUBLIC PROFILE PAGE…
if(document.querySelector('.followers-nbr')) {
  let q = query(
    collection(database, "notifications"),
    where("notifType", "==", "follow"),
    where("relatedId", "==", idVainkeurProfil),
  );
  let querySnapshot = await getDocs(q);

  document.querySelector('.followers-nbr').textContent = querySnapshot._snapshot.docs.size;
  document.querySelector(".followers-nbr-text").textContent = querySnapshot._snapshot.docs.size <= 1 ? "Follower" : "Followers";
}

// ACCOUNT PAGE…
if(document.querySelector('.followers-account-nbr')) {
  let q = query(
    collection(database, "notifications"),
    where("notifType", "==", "follow"),
    where("relatedId", "==", currentUserId),
  );
  let querySnapshot = await getDocs(q);

  document.querySelector('.followers-account-nbr').textContent = querySnapshot._snapshot.docs.size;
  document.querySelector(".followers-account-nbr-text").textContent = querySnapshot._snapshot.docs.size <= 1 ? "Follower" : "Followers";
}