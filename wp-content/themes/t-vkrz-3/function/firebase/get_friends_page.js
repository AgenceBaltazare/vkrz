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

const guetteurFunc = async () => {
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

  if (list.length === 0) {
    tbody.innerHTML =
      "<tr><td>Aucune relation pour le moment... 😪</td><td></td><td></td><td></td><td></td></tr>";
  } else {
    let listUuids = [];
    list.forEach((item) => listUuids.push(item["uuid"]));

    const map = new Map();
    await Promise.all(
      listUuids.map(async (uuid) => {
        await fetch(`https://vainkeurz.com/wp-json/vkrz/v1/getuserinfo/${uuid}`)
          .then((res) => res.json())
          .then((response) => map.set(uuid, response));
      })
    );

    let followOrUnfollowDiv = "",
      relationDiv = "";
    list.forEach((item, index) => {
      // RELATION TYPE…
      if (item.extra.friend) {
        relationDiv = `
        <td class="text-right" data-relation="duo" id="duos">
          <div 
            data-toggle="tooltip" 
            data-popup="tooltip-custom" 
            data-placement="bottom" 
            data-original-title="En mode duo" 
            class="avatar pull-up"
          >
          <span class="va-duo va va-z-30" alt="Duo"></span>
          </div>
        </td>
        <td class="d-none">duo</td>
      `;
      } else if (item.extra.following) {
        relationDiv = `
        <td class="text-right" data-relation="following" id="following">
          <div 
            data-toggle="tooltip" 
            data-popup="tooltip-custom" 
            data-placement="bottom" 
            data-original-title="Guetté" 
            class="avatar pull-up"
          >
          <span class="va-guetteur va va-z-25" alt="Guetté"></span>
          </div>
        </td>
        <td class="d-none">following</td>
      `;
      } else {
        relationDiv = `
        <td class="text-right" data-relation="guetteur" id="guetteurs">
          <div 
            data-toggle="tooltip" 
            data-popup="tooltip-custom" 
            data-placement="bottom" 
            data-original-title="Guetteur" 
            class="avatar pull-up"
          >
          <span class="va-monocle va va-z-30" alt="Guetteur"></span>
          </div>
        </td>
        <td class="d-none">guetteur</td>
      `;
      }

      // FOLLOW OR UNFOLLOW BUTTON… 🤹
      if (item.extra.friend || item.extra.following) {
        followOrUnfollowDiv = `
        <a href="" 
          data-documentId="${item["extra"]["id"]}" 
          data-relatedid="${map.get(item["uuid"]).user_id}"
          class="unfollowBtns dropdown-item"
          data-amigo=${item.extra.friend ? true : false}
          data-following=${item.extra.following ? true : false}
        >
          <span class="ico-action va va-cross va-z-20"></span> 
          Ne plus guetter
        </a>
      `;
      } else {
        followOrUnfollowDiv = `
        <a 
          href="" 
          data-userid=${currentUserId}
          data-uuid=${currentUuid}
          data-relatedid=${map.get(item["uuid"]).user_id}
          data-relateduuid="${map.get(item["uuid"]).uuid_user_vkrz}"
          data-text="${vainkeurPseudo} te guette !"
          data-url="${currentUserProfileUrl}"
          class="followBtns dropdown-item"
        >
          <span class="ico-action va va-star-struck va-z-20"></span> 
          Guetter aussi
        </a>
    `;
      }

      html += `
      <tr>
        <td>
          <div class="d-flex align-items-center">
          <span class="avatar">
              <a href="${map.get(item["uuid"]).profil_url}">
                  <span class="avatar-picture" style="background-image: url(${map.get(item["uuid"]).avatar
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
                ${!map.get(item["uuid"]).user_role_administrator
          ? ""
          : map.get(item["uuid"]).user_role_administrator
        } 
                ${!map.get(item["uuid"]).user_role_author
          ? ""
          : map.get(item["uuid"]).user_role_author
        }
            </a>

              <small class="cart-item-by legende amigo-legende-${map.get(item["uuid"]).user_id
        }">${item.extra.friend ? "En mode duo" : ""}</small>
          </h6>
          </div>
        </td>

        ${relationDiv}

        <td class="text-right">
          ${map.get(item["uuid"]).nb_top_vkrz
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
              <a href="${map.get(item["uuid"]).profil_url
        }" class="dropdown-item">
                <span class="ico-action va va-eyes va-z-20"></span> Voir ses TopList
              </a>

              ${followOrUnfollowDiv}
            </div>

          </div>
        </td>
      </tr>
    `;
    });
    tbody.innerHTML = html;

    $(document).ready(function () {
      $("body").tooltip({
        selector: "[data-toggle=tooltip]",
      });
    });

    if (!$.fn.DataTable.isDataTable(".table-amigos")) {
      $(".table-amigos").DataTable({
        autoWidth: false,
        lengthMenu: [25],
        pagingType: "full_numbers",
        columns: [
          { orderable: false },
          { orderable: false },
          { orderable: false },
          { orderable: false },
          { orderable: false },
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
    }

    const unfollowBtns = document.querySelectorAll(".unfollowBtns");
    unfollowBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();

        html = "";

        deleteDoc(doc(database, "notifications", btn.dataset.documentid));

        $(".table-amigos").DataTable().clear();
        $(".table-amigos").DataTable().destroy();

        guetteurFunc();
      });
    });

    const followBtns = document.querySelectorAll(".followBtns");
    followBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();

        async function setNotification() {
          try {
            let q = query(
              collection(database, "notifications"),
              where("notifText", "==", `${vainkeurPseudo} te guette !`),
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

              html = "";

              $(".table-amigos").DataTable().clear();
              $(".table-amigos").DataTable().destroy();

              guetteurFunc();
            }
          } catch (error) {
            console.error("Error adding document: ", error);
          }
        }
        setNotification();
      });
    });

    // TABLE FILTER…
    const guetteursContainer = document.querySelectorAll("#guetteurs");
    guetteursContainer.forEach(button => {
      button.addEventListener("click", function () {
        document.querySelector(".reset-table").classList.add("d-block");
        $(".table-amigos").DataTable().column(2).search("guetteur|duo", true, false).draw();
      });
    })

    const followingContainer = document.querySelectorAll("#following");
    followingContainer.forEach(button => {
      button.addEventListener("click", function () {
        document.querySelector(".reset-table").classList.add("d-block");
        $(".table-amigos").DataTable().column(2).search("following").draw();
      });
    })

    const duosContainer = document.querySelectorAll("#duos");
    duosContainer.forEach(button => {
      button.addEventListener("click", function () {
        document.querySelector(".reset-table").classList.add("d-block");
        $(".table-amigos").DataTable().column(2).search("duo").draw();
      });
    })

    // RESET TABLE…
    document
      .querySelector(".reset-table")
      .addEventListener("click", function () {
        document.querySelector(".reset-table").classList.remove("d-block");
        $(".table-amigos").DataTable().columns().search("").draw();
      });
  }
};
guetteurFunc();