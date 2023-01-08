import {
  collection,
  getDocs,
  deleteDoc,
  updateDoc,
  addDoc,
  doc,
  query,
  orderBy,
  database,
} from "./config.js";

async function getUserData(uuid) {
  try {
    let response = await fetch(
      `https://vainkeurz.com/wp-json/vkrz/v1/getuserinfo/${uuid}`
    );
    return await response.json();
  } catch (error) {
    console.log(error);
  }
}

// GET PROPOSTIONS
const tablePropositions = document.querySelector(".table-propositions"),
      tbodyPropositions = tablePropositions.querySelector("tbody");
const getPropositions = async function() {
  const propositionsQuery = query(
    collection(database, "propositions"), 
    orderBy("createdAt", "desc")
  );
  const propositionsQuerySnapshot = await getDocs(propositionsQuery);

  let rows = "";

  let userCanValidateOrNot = false,
      userCanTakeTop       = false;
  if(currentUserRole === "administrator") userCanValidateOrNot = true;
  if(currentUserRole === "administrator" || currentUserRole === "author") userCanTakeTop = true;

  let index = 0;
  if (propositionsQuerySnapshot._snapshot.docs.size !== 0) {
    propositionsQuerySnapshot.forEach(proposition => {

      (async function() {
        let topValidOrNot = "",
            attribuePar   = "";

        let propositionByUuid = proposition.data().userUuid;
        let dataUser = await getUserData(propositionByUuid);

        if(proposition.data().topValide === true && proposition.data().topValidePar === "") {
          topValidOrNot = `
            Top Validé! ✅
          `

          if (userCanTakeTop) {
            attribuePar = `
            <input type="submit" value="Je Prends" class="btn btn-success waves-effect waves-float waves-light prendre-proposition-top w-100" data-userid=${dataUser.id_user} data-useruuid=${proposition.data().userUuid} data-iddocument="${proposition.id}">
            `
          }
        } else if(proposition.data().topValide === true && proposition.data().topValidePar !== "") {
          topValidOrNot = `
            Top Validé! ✅
          `

          let AttribueParDataUser = await getUserData(proposition.data().topValidePar);
          attribuePar = `
            <div class="vainkeur-card">
              <a href="${AttribueParDataUser.profil_url}" class="btn btn-flat-primary waves-effect">
                <span class="avatar">
                  <span class="avatar-picture" style="background-image: url(${AttribueParDataUser.avatar});"></span>
                </span>
                <span class="championname">
                  <h4>${AttribueParDataUser.pseudo}</h4>
                  <span class="medailles">

                    ${AttribueParDataUser.level}
                    ${
                      AttribueParDataUser.user_role == "administrator"
                        ? '<span class="va va-vkrzteam va-z-15" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ"></span>'
                        : ""
                    }
                    ${
                      AttribueParDataUser.user_role == "administrator" ||
                      AttribueParDataUser.user_role == "author"
                        ? '<span class="va va-man-singer va-z-15" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops"></span>'
                        : ""
                    }

                  </span>
                </span>
              </a>
            </div>
          `
        } else if (proposition.data().topValide === false) {

          if(currentUserRole === "administrator") {
            topValidOrNot = `<span class="d-none">valider</span>
            <input type="submit" value="Valider" class="btn btn-primary waves-effect waves-float waves-light valider-proposition-top w-100 mb-50" data-userid=${dataUser.id_user} data-useruuid=${proposition.data().userUuid} data-iddocument="${proposition.id}">
            <input type="submit" value="Refuser" class="btn btn-danger waves-effect waves-float waves-light refuser-proposition-top w-100" data-iddocument="${proposition.id}">`
          } else {
            topValidOrNot = `En cours de validation… 🚧`
          }

        } 

        rows += `
          <tr>
            <td>
              <div class="d-flex align-items-center">
                <div class="font-weight-bold">
                  <div class="media-body">
                    <div class="media-heading">
                      <h6 class="cart-item-title mb-0">${proposition.data().createdAt.toDate().toLocaleDateString("fr")} </h6>
                    </div>
                  </div>
                </div>
              </div>
            </td>

            <td>
              <div class="d-flex align-items-center">
                <div class="font-weight-bold">
                  <div class="media-body">
                    <div class="media-heading">
                      <h6 class="cart-item-title mb-0">${proposition.data().themeTopPropose} - ${proposition.data().questionTop}  </h6>
                    </div>
                  </div>
                </div>
              </div>
            </td>

            <td class="text-center">
              <div class="vainkeur-card">
                <a href="${dataUser.profil_url}" class="btn btn-flat-primary waves-effect">
                  <span class="avatar">
                    <span class="avatar-picture" style="background-image: url(${dataUser.avatar});"></span>
                  </span>
                  <span class="championname">
                    <h4>${dataUser.pseudo}</h4>
                    <span class="medailles">

                      ${dataUser.level}
                      ${
                        dataUser.user_role == "administrator"
                          ? '<span class="va va-vkrzteam va-z-15" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ"></span>'
                          : ""
                      }
                      ${
                        dataUser.user_role == "administrator" ||
                        dataUser.user_role == "author"
                          ? '<span class="va va-man-singer va-z-15" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops"></span>'
                          : ""
                      }

                    </span>
                  </span>
                </a>
              </div>
            </td>

            <td class="d-flex flex-column align-items-center justify-content-center">
              ${topValidOrNot}
            </td>

            <td>
              ${attribuePar}
            </td>
          </tr>
        `;

        tbodyPropositions.innerHTML = rows;

        // VALIDER PROPOSITION
        if(document.querySelector('.valider-proposition-top')) {
          const buttons = document.querySelectorAll('.valider-proposition-top');

          buttons.forEach((button) => {
            button.addEventListener("click", function () {
              let id = button.dataset.iddocument;

              async function updateDocFunc() {
                const updateClick = doc(database, "propositions", id);
                let dataJSON = `{"topValide": true}`;
                let json = JSON.parse(dataJSON);
                await updateDoc(updateClick, json);
                await getPropositions();

                if(currentUuid === button.dataset.useruuid) return false;
                try {
                  const notification = await addDoc(
                    collection(database, "notifications"),
                    {
                      userId: currentUserId,
                      uuid: currentUuid,
                      relatedId: button.dataset.userid,
                      relatedUuid: button.dataset.useruuid,
                      notifText: `${vainkeurPseudo} a validé ta proposition de Top`,
                      notifLink: window.location.href,
                      notifType: "Validation Proposition Top",
                      statut: "nouveau",
                      createdAt: new Date(),
                    }
                  );
                  console.log(
                    "Notification sent with ID: ",
                    notification.id
                  );
                } catch (error) {
                  console.error("Error adding document: ", error);
                }

              }
              updateDocFunc();
            });
          });
        }

        // PRENDRE PROPOSITION
        if(document.querySelector('.prendre-proposition-top')) {
          const buttons = document.querySelectorAll('.prendre-proposition-top');

          buttons.forEach((button) => {
            button.addEventListener("click", function () {
              let id = button.dataset.iddocument;

              async function updateDocFunc() {
                const updateClick = doc(database, "propositions", id);
                let dataJSON = `{"topValidePar": "${currentUuid}"}`;
                let json = JSON.parse(dataJSON);
                await updateDoc(updateClick, json);
                await getPropositions();

                if(currentUuid === button.dataset.useruuid) return false;
                try {
                  const notification = await addDoc(
                    collection(database, "notifications"),
                    {
                      userId: currentUserId,
                      uuid: currentUuid,
                      relatedId: button.dataset.userid,
                      relatedUuid: button.dataset.useruuid,
                      notifText: `${vainkeurPseudo} a pris ta proposition de Top`,
                      notifLink: window.location.href,
                      notifType: "Validation Proposition Top",
                      statut: "nouveau",
                      createdAt: new Date(),
                    }
                  );
                  console.log(
                    "Notification sent with ID: ",
                    notification.id
                  );
                } catch (error) {
                  console.error("Error adding document: ", error);
                }

              }
              updateDocFunc();
            });
          });
        }

        // REFUSER (DELETE) PROPOSITION
        if(document.querySelector('.refuser-proposition-top')) {
          const buttons = document.querySelectorAll('.refuser-proposition-top');

          buttons.forEach((button) => {
            button.addEventListener("click", function () {
              const tr = button.closest("tr");
              let id = button.dataset.iddocument;

              (async function() {
                deleteDoc(
                  doc(database, "propositions", id)
                );
                tr.remove();
              })()
            });
          });
        }
        index++;

        if(index === propositionsQuerySnapshot._snapshot.docs.size) {

          if (!$.fn.DataTable.isDataTable(".table-propositions")) {
            $(".table-propositions").DataTable({
              autoWidth: false,
              lengthMenu: [25],
              pagingType: "full_numbers",
              order: [[0, "desc"]],
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
            });
          }

        }
      })();
      
    })
  } else {
    tbodyPropositions.innerHTML = `
      <tr>
        <td>
          <div class="d-flex align-items-center">
            <div class="font-weight-bold">
              <div class="media-body">
                <div class="media-heading">
                  <h6 class="cart-item-title mb-0">Aucune proposition de Top pour l'instant.</h6>
                </div>
              </div>
            </div>
          </div>
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    `;
  }
}
await getPropositions();

// SEND PROPOSITION
const form            = document.querySelector("#form-propositions");
const categorie       = form.querySelector(".categorie");
const themeTopPropose = form.querySelector(".theme_propose");
const questionTop     = form.querySelector(".question_top");
const submitBtn       = form.querySelector(".proposer-btn");

// DOM
const headingTitle    = document.querySelector('.heading-title');
const propAlert       = document.querySelector('.prop-alert');
const afterSubmitText = document.querySelector('.merci-proposition');

submitBtn.addEventListener("click", (e) => {
  e.preventDefault();

  if (categorie.value && themeTopPropose.value && questionTop.value) {
    propAlert.classList.add('d-none');

    (async function() {
      const form = document.querySelector("#form-propositions");

      try {
        const newProposition = await addDoc(
          collection(database, "propositions"),
          {
            userUuid: currentUuid,
            categorie: categorie.value,
            themeTopPropose: themeTopPropose.value,
            questionTop: questionTop.value,
            topValide: false,
            topValidePar: "",
            createdAt: new Date(),
          }
        );

        let currentUserData = await getUserData(currentUuid);

        $.ajax({
          method: "POST",
          url: vkrz_ajaxurl,
          data: {
            action: "vkrz_to_discord",
            typeMessage: "topIdea",
            data: {
              proposition: `${themeTopPropose.value} | ${questionTop.value}`,
              userData: currentUserData,
            }
          },
        });

        form.classList.add('d-none');
        afterSubmitText.classList.remove('d-none')
        headingTitle.innerHTML = `
          Propose <strong id="autre-prop-top" class="cursor-pointer"><u>un autre Top ?</u></strong>
        `;

        const autrePropTopBtn = document.querySelector('#autre-prop-top');
        autrePropTopBtn.addEventListener('click', () => {
          form.classList.remove('d-none');
          afterSubmitText.classList.add('d-none')
          headingTitle.innerHTML = `
            Propose ton <strong>Top</strong>
          `;
        })

        await getPropositions();

        // RESET…
        form.reset();
      } catch (error) {
        console.error("Error adding document: ", error);
      }
    })()

  } else {
    propAlert.classList.remove('d-none');
  }
});