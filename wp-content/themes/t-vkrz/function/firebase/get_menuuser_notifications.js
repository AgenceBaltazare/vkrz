import {
  collection,
  getDocs,
  doc,
  updateDoc,
  query,
  where,
  orderBy,
  database,
  secondsToStrFuncHelper,
} from "./config.js";

(async function renderMenuNotifs() {
  const menuUserQuery = query(
    collection(database, "notifications"),
    where("relatedUuid", "==", currentUuid),
    where("statut", "==", "nouveau"),
    orderBy("createdAt", "desc")
  );
  const menuUserQuerySnapshot = await getDocs(menuUserQuery);
  
  const notificationsContainer = document.querySelector(".notifications-container");
  document.querySelectorAll(".notifications-nombre").forEach((nombre) => {
    nombre.textContent = menuUserQuerySnapshot._snapshot.docs.size;
  });
  let html = "";
  
  let notificationsUsersUuids = [];
  menuUserQuerySnapshot.forEach((notification) => notificationsUsersUuids.push(notification.data().uuid));

  // REMOVE DUPLICATE UUIDs FROM ARRAY…
  let set = new Set(
    notificationsUsersUuids.map((notificationUserUuid) => JSON.stringify(notificationUserUuid))
  );
  notificationsUsersUuids = Array.from(set).map((elem) => JSON.parse(elem));

  // GET USERS DATA FIRST…
  const map = new Map();
  await Promise.all(
    notificationsUsersUuids.map(async (uuid) => {
      await fetch(
        `http://localhost:8888/vkrz/wp-json/vkrz/v1/getuserinfo/${uuid}`
      )
        .then((response) => response.json())
        .then((data) => map.set(uuid, data));
    })
  );

  menuUserQuerySnapshot.forEach((notification) => {
    let secondes;
    if(notification.data().createdAt.seconds) 
      secondes = new Date().getTime() - notification.data().createdAt.seconds * 1000;
    else 
      secondes = new Date().getTime() -  notification.data().createdAt * 1000;
    

    html += `
      <a 
        class="list-group-item list-group-item-action dropdown-notifications-item"
        id="readNotification" 
        href="${notification.data().notifLink}"
        data-id="${notification.id}"
      >
        <div class="d-flex">
          <div class="flex-shrink-0 me-3">
            <div class="avatar">
              <img src="${
                !notification.data().uuid
                  ? anonymeAvatarUrl
                  : map.get(notification.data().uuid).avatar
              }" alt="" class="h-auto rounded-circle">
            </div>
          </div>
          <div class="flex-grow-1">
            <h6 class="mb-1">${notification.data().notifText}</h6>
            <small class="notification-text text-muted">Il y a ${secondsToStrFuncHelper(
              secondes
            )}</small>
          </div>
        </div>
      </a>
    `;
  });
  notificationsContainer.innerHTML = html;

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
})()