import {
  collection,
  getDocs,
  doc,
  updateDoc,
  query,
  where,
  orderBy,
  database,
} from "./config.js";

const menuUserQuery = query(
  collection(database, "notifications"),
  where("relatedId", "==", currentUserId),
  where("statut", "==", "nouveau"),
  orderBy("createdAt", "desc")
);
const menuUserQuerySnapshot = await getDocs(menuUserQuery);

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
  return "less than a second"; //'just now' //or other string you like;
};
const notificationsContainer = document.querySelector(".notifications-container");
document.querySelectorAll(".notifications-nombre").forEach((nombre) => {
  nombre.textContent = menuUserQuerySnapshot._snapshot.docs.size;
});
let notificationsDiv = "";

let notificationsUsersUuids = [];
menuUserQuerySnapshot.forEach((notification) => {
  notificationsUsersUuids.push(notification.data().uuid);
});

const asyncFunc = async () => {
  const map = new Map();
  await Promise.all(
    notificationsUsersUuids.map(async (uuid) => {
      await fetch(
        `https://vainkeurz.com/wp-json/vkrz/v1/getuserinfo/${uuid}`
      )
        .then((res) => res.json())
        .then((response) => map.set(uuid, response));
    })
  );

  menuUserQuerySnapshot.forEach((notification) => {
    let secondes =
      new Date().getTime() - notification.data().createdAt.seconds * 1000;

    notificationsDiv += `
      <a 
        class="d-flex" 
        id="readNotification" 
        href="${notification.data().notifLink}"
        data-id="${notification.id}"
      >
        <div class="media d-flex align-items-start test">
          <div class="media-left">
            <div class="avatar">                  
              <span class="avatar-picture" style="background-image: url(${
                !notification.data().uuid
                  ? anonymeAvatarUrl
                  : map.get(notification.data().uuid).avatar
              });"></span>
            </div>
          </div>

          <div class="media-body">
            <p class="media-heading">
              <span class="font-weight-bolder">
                ${notification.data().notifText}
              </span>
            </p>
            <small class="notification-text">Il y a ${secondsToStr(
              secondes
            )}</small>
          </div>
        </div>
      </a>
    `;
  });

  notificationsContainer.innerHTML = notificationsDiv;
  document.querySelector(".notifications-span").textContent =
    menuUserQuerySnapshot._snapshot.docs.size <= 1 ? "Nouvelle" : "Nouvelles";

  // PROCESS TO UPDATE STATUT… 🎺
  const buttons = document.querySelectorAll("#readNotification");
  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      let id = button.dataset.id;

      async function updateDocFunc() {
        const updateClick = doc(database, "notifications", id);
        let dataJSON = `{"statut": "vu"}`;
        let json = JSON.parse(dataJSON);
        await updateDoc(updateClick, json);
      }
      updateDocFunc();
    });
  });
};
asyncFunc();