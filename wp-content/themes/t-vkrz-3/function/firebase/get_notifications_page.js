import {
  collection,
  getDocs,
  updateDoc,
  doc,
  query,
  where,
  database,
  orderBy,
} from "http://localhost:8888/vkrz/wp-content/themes/t-vkrz-3/function/firebase/config.js";

const q = query(
  collection(database, "notifications"),
  where("relatedId", "==", currentUserId),
  orderBy("createdAt", "desc")
);
const querySnapshot = await getDocs(q);

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

const tbody = document.querySelector("tbody");
let row = "";

if (querySnapshot._snapshot.docs.size !== 0) {
  let notificationsUsersUuids = [];
  querySnapshot.forEach(notification => {
    notificationsUsersUuids.push(notification.data().uuid)
  });

  const asyncFunc = async () => {
    const map = new Map();
    await Promise.all(notificationsUsersUuids.map(async uuid => {
        await fetch(`https://vainkeurz.com/wp-json/vkrz/v1/getuserinfo/${uuid}`)
            .then((res) => res.json())
            .then(response => map.set(uuid, response));
    }));

    querySnapshot.forEach(notification => {
      let secondes =
      new Date().getTime() - notification.data().createdAt.seconds * 1000;
      
      row += `
        <tr role="row" class="odd" id="row" data-id="${notification.id}">
          <td>
            <div class="media-body">
              <div class="media-heading">
                <div class="d-flex">
                  <div class="avatar mr-50">
                    <a href="${notification.data().notifLink}">
                      <span class="avatar-picture" style="background-image: url(${
                        !notification.data().uuid
                          ? anonymeAvatarUrl
                          : map.get(notification.data().uuid).avatar
                      });"></span>
                    </a>
                  </div>
                  <div>
                    <a class="cart-item-title lead mb-0 text-body" id="readNotification" style="line-height: 0;" href="${
                      notification.data().notifLink
                    }" data-id="">${notification.data().notifText}</a>
                    <small class="cart-item-by legende">Il y a ${secondsToStr(
                      secondes
                    )}</small>
                  </div>
                </div>
              </div>
            </div>
          </td>
          <td class="text-right">
            <span id="statut" class="badge rounded-pill badge-light-${
              notification.data().statut == "nouveau" ? "success" : "primary"
            } me-1" style="text-transform: capitalize;">${
        notification.data().statut
      }</span>
          </td>
          <td class="text-right">
            <a
              class="mr-1"
              id="readNotification"
              data-id=""
              href="${notification.data().notifLink}"
            >
              <span class="ico va va-eyes va-lg"> </span>
            </a>
          </td>
        </tr>
      `;
    });
    tbody.innerHTML = row;

    // PROCESS TO UPDATE STATUT… 🎺
    const rows = document.querySelectorAll("#row");
    rows.forEach((row) => {
      row.addEventListener("click", function () {
        let id = row.dataset.id;

        async function updateDocFunc() {
          const updateClick = doc(database, "notifications", id);
          let dataJSON = `{"statut": "vu"}`;
          let json = JSON.parse(dataJSON);
          await updateDoc(updateClick, json);
        }
        updateDocFunc();
      });
    });
  }
  asyncFunc()
} else {
  tbody.innerHTML = "<tr><td>NO NOTIFICATIONS… 😪</td><td></td><td></td><td></td><td></td></tr>";
}