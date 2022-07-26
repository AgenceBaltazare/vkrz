import {
  collection,
  getDocs,
  deleteDoc,
  doc,
  query,
  where,
  orderBy,
  addDoc,
  database,
} from "./config.js";

let tbody = document.querySelector("tbody"),
  html = "";

// FOLLOWING…
const followingQuery = query(
  collection(database, "notifications"),
  where("notifType", "==", "follow"),
  where("userId", "==", currentUserId),
  orderBy("createdAt", "desc")
);
const followingQuerySnapshot = await getDocs(followingQuery);

// FOLLOWERS…
const followersQuery = query(
  collection(database, "notifications"),
  where("notifType", "==", "follow"),
  where("relatedId", "==", currentUserId),
  orderBy("createdAt", "desc")
);
const followersQuerySnapshot = await getDocs(followersQuery);

// GET FIRENDS… 👀
let followers = [],
  following = [],
  friends = [];

followingQuerySnapshot.forEach((data1) => {
  let dataFollowingObject = { uuid: data1.data().relatedUuid };
  dataFollowingObject["extra"] = { id: data1.id, following: true };

  following.push(dataFollowingObject);
});
followersQuerySnapshot.forEach((data1) => {
  let dataFollowersObject = data1.data();
  dataFollowersObject["extra"] = { id: data1.id };

  followers.push(dataFollowersObject);
  followingQuerySnapshot.forEach((data2) => {
    if (data1.data().userId == data2.data().relatedId) {
      let dataObject = data1.data();
      dataObject["extra"] = { id: data2.id, friend: true };

      friends.push(dataObject);
    }
  });
});

Array.prototype.unique = function () {
  var a = this.concat();
  for (var i = 0; i < a.length; ++i) {
    for (var j = i + 1; j < a.length; ++j) {
      if (a[i].uuid == a[j].uuid) a.splice(j--, 1);
    }
  }

  return a;
};

const amigosNumber = document.querySelector(".amigos-nbr"),
  followingNumber = document.querySelector(".following-nbr"),
  followersNumber = document.querySelector(".followers-nbr-amigos");

amigosNumber.textContent = friends.length;
followingNumber.textContent = following.length;
followersNumber.textContent = followers.length;

let list = friends.concat(followers).unique();
list = list.concat(following).unique();

let listUuids = [];
list.forEach((item) => listUuids.push(item["uuid"]));

const asyncFunc = async () => {
  const map = new Map();
  await Promise.all(
    listUuids.map(async (uuid) => {
      await fetch(`https://vainkeurz.com/wp-json/vkrz/v1/getuserinfo/${uuid}`)
        .then((res) => res.json())
        .then((response) => map.set(uuid, response));
    })
  );

  let followOrUnfollow = "";
  list.forEach((item, index) => {
    // FOLLOW OR UNFOLLOW BUTTON… 🤹
    if (item.extra.friend || item.extra.following) {
      followOrUnfollow = `
        <a href="" 
          data-documentId="${item["extra"]["id"]}" 
          data-relatedid="${map.get(item["uuid"]).user_id}"
          class="unfollowBtns dropdown-item"
          data-amigo=${item.extra.friend ? true : false}
          data-following=${item.extra.following ? true : false}
        >
          <span class="ico-action va va-throw-bin-button va-z-20"></span> 
          Unfollow
        </a>
      `;
    } else {
      followOrUnfollow = `
        <a 
          href="" 
          data-userid=${currentUserId}
          data-uuid=${currentUuid}
          data-relatedid=${map.get(item["uuid"]).user_id}
          data-relateduuid="${map.get(item["uuid"]).uuid_user_vkrz}"
          data-text="${vainkeurPseudo} vous guette !"
          data-url="${currentUserProfileUrl}"
          class="followBtns dropdown-item"
        >
          <span class="ico-action va va-new-button va-z-20"></span> 
          Follow Back
        </a>
    `;
    }

    html += `
      <tr>
        <td>
          <div class="d-flex align-items-center">
          <span class="avatar">
              <a href="${map.get(item["uuid"]).profil_url}">
                  <span class="avatar-picture" style="background-image: url(${
                    map.get(item["uuid"]).avatar
                  });"></span>
              </a>
              <span class="user-niveau">
                  ${map.get(item["uuid"]).level}
              </span>
          </span>

          <h6 class="font-weight-bold championname">
            <a href="${map.get(item["uuid"]).profil_url}">
                ${map.get(item["uuid"]).pseudo}
                <span class="user-niveau-xs">
                    ${map.get(item["uuid"]).level}
                </span>
                ${
                  !map.get(item["uuid"]).user_role_administrator
                    ? ""
                    : map.get(item["uuid"]).user_role_administrator
                } 
                ${
                  !map.get(item["uuid"]).user_role_author
                    ? ""
                    : map.get(item["uuid"]).user_role_author
                }
            </a>

              <small class="cart-item-by legende amigo-legende-${
                map.get(item["uuid"]).user_id
              }">${item.extra.friend ? "Amigo 🤙" : ""}</small>
          </h6>
          </div>
        </td>

        <td class="text-right">
          ${
            map.get(item["uuid"]).money_vkrz
          } <span class="ico va-gem va va-lg"></span>
        </td>

        <td class="text-right">
          ${
            map.get(item["uuid"]).nb_vote_vkrz
          } <span class="ico va-high-voltage va va-lg"></span>
        </td>

        <td class="text-right">
          ${
            map.get(item["uuid"]).nb_top_vkrz
          } <span class="ico va va-trophy va-lg"></span>
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
                map.get(item["uuid"]).profil_url
              }" class="dropdown-item">
                <span class="ico-action va va-eyes va-z-20"></span> Guetter ses TopList
              </a>

              ${followOrUnfollow}
            </div>

          </div>
        </td>
      </tr>
    `;
  });
  tbody.innerHTML = html;

  $(".table-amigos").DataTable({
    autoWidth: false,
    lengthMenu: [25],
    pagingType: "full_numbers",
    columns: [
      { orderable: true },
      { orderable: true },
      { orderable: true },
      { orderable: true },
      { orderable: true },
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
    order: [],
  });

  const unfollowBtns = document.querySelectorAll(".unfollowBtns");
  unfollowBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      e.target.closest("a").remove();

      if (+amigosNumber.textContent - 1 >= 0) {
        amigosNumber.textContent = +amigosNumber.textContent - 1;
      }
      followingNumber.textContent = +followingNumber.textContent - 1;

      deleteDoc(doc(database, "notifications", btn.dataset.documentid));

      document.querySelector(`.amigo-legende-${e.target.dataset.relatedid}`).textContent = "";

      if (unfollowBtns.length === 1 && btn.dataset.amigo != "true") {
        tbody.innerHTML =
          "<tr><td>NO AMIGOS… 😪</td><td></td><td></td><td></td><td></td></tr>";
      }
    });
  });

  const followBtns = document.querySelectorAll(".followBtns");
  followBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      e.target.closest("a").remove();

      amigosNumber.textContent = +amigosNumber.textContent + 1;
      followingNumber.textContent = +followingNumber.textContent + 1;

      document.querySelector(`.amigo-legende-${e.target.dataset.relatedid}`).textContent = "Amigo 🤙";

      async function setNotification() {
        try {
          let q = query(
            collection(database, "notifications"),
            where("notifText", "==", `${vainkeurPseudo} vous guette !`),
            where("relatedId", "==", idVainkeurProfil)
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
};

if (list.length === 0) {
  tbody.innerHTML =
    "<tr><td>NO AMIGOS… 😪</td><td></td><td></td><td></td><td></td></tr>";
} else {
  asyncFunc();
}