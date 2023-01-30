import {
  collection,
  getDocs,
  updateDoc,
  doc,
  query,
  where,
  database,
  orderBy,
  secondsToStrFuncHelper
} from "./config.js";

const table = document.querySelector(".table-notifications"),
      tbody = table.querySelector("tbody");

(async function renderNotifs() {
  const notifsQuery = query(
    collection(database, "notifications"),
    where("relatedUuid", "==", currentUuid),
    orderBy("createdAt", "desc")
  );
  const notifsQuerySnapshot = await getDocs(notifsQuery);

  let html = "";
  if (notifsQuerySnapshot._snapshot.docs.size !== 0) {
    let notificationsUsersUuids = [],
      notificationsIDs = [];
    notifsQuerySnapshot.forEach((notification) => {
      notificationsUsersUuids.push(notification.data().uuid);
      notificationsIDs.push(notification.id);
    });

    // REMOVE DUPLICATE UUIDs FROM ARRAY…
    let set = new Set(
      notificationsUsersUuids.map((notificationUserUuid) => JSON.stringify(notificationUserUuid))
    );
    notificationsUsersUuids = Array.from(set).map((elem) => JSON.parse(elem));

    // GET USERS DATA FIRST…
    const map = new Map();
    await Promise.all(
      notificationsUsersUuids.map(async (uuid) => {
        await fetch(`http://localhost:8888/vkrz/wp-json/vkrz/v1/getuserinfo/${uuid}`)
          .then((response) => response.json())
          .then((data) => map.set(uuid, data));
      })
    );

    notifsQuerySnapshot.forEach((notification) => {
      let secondes =
        new Date().getTime() - notification.data().createdAt.seconds * 1000;

      html += `
        <tr role="row" class="odd" id="row" data-id="${notification.id}">
          <td>
            <div class="media-body">
              <div class="media-heading">
                <div class="d-flex">
                  <div class="avatar me-2">
                    <a href="${notification.data().notifLink}">
                      <span class="avatar-picture" style="background-image: url(${
                        !notification.data().uuid
                          ? anonymeAvatarUrl
                          : map.get(notification.data().uuid).avatar
                      });"></span>
                    </a>
                  </div>
                  <div>
                    <a class="cart-item-title mb-0 text-body" id="readNotification" style="line-height: 0;" href="${
                      notification.data().notifLink
                    }" data-id="">${notification.data().notifText}</a>
                    <small class="cart-item-by legende">Il y a ${secondsToStrFuncHelper(
                      secondes
                    )}</small>
                  </div>
                </div>
              </div>
            </div>
          </td>
          <td class="text-right">
            <span id="statut" class="badge rounded-pill bg-label-${
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
    tbody.innerHTML = html;

    if (!$.fn.DataTable.isDataTable(".table-notifications")) {
      $(".table-notifications").DataTable({
        autoWidth: false,
        lengthMenu: [25],
        pagingType: "full_numbers",
        columns: [
          { orderable: false },
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
    }

    // VIEW ONLY STATUT nouveau…
    document
      .querySelector(".notifs_statut_nouveau")
      .addEventListener("click", function () {
        $(".table-notifications")
          .DataTable()
          .column(1)
          .search("Nouveau")
          .draw();
      });

    // VIEW ALL NOTIFICATIONS…
    document
      .querySelector(".notifs_statut_all")
      .addEventListener("click", function () {
        $(".table-notifications").DataTable().columns().search("").draw();
      });

    // READ ALL OF NOTIFICATIONS AT ONCE…
    document.querySelector(".notifs_read_all").addEventListener("click", () => {
      notificationsIDs.forEach((id) => {
        async function updateDocFunc() {
          const updateClick = doc(database, "notifications", id);
          let dataJSON = `{"statut": "vu"}`;
          let json = JSON.parse(dataJSON);
          await updateDoc(updateClick, json);
        }
        updateDocFunc();
      });

      html = "";

      $(".table-notifications").DataTable().clear();
      $(".table-notifications").DataTable().destroy();

      renderNotifs();
    });

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
  } else {
    tbody.innerHTML = ` 
      <tr>
        <td>Pas de notification pour le moment 😪</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    `;
  }
})();
