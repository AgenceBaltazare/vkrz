<?php
/*
    Template Name: Users Ranks
*/
if (isset($_GET['id_top'])) {
    $id_top  = $_GET['id_top'];
} else {
    header('Location: ' . get_bloginfo('url'));
}
get_header();
global $id_vainkeur;
global $top_infos;
$top_datas = get_top_data($id_top);
global $user_tops;
$list_t_already_done  = $user_tops['list_user_tops_done_ids'];
$id_resume      = get_resume_id($id_top);
$list_toplist   = json_decode(get_field('all_toplist_resume', $id_resume));

$actual_uuiduser = get_field('uuiduser_user', 'user_' . get_current_user_id());
?>

<script type="module">
    import {
        initializeApp
    } from "https://www.gstatic.com/firebasejs/9.8.1/firebase-app.js";
    const firebaseConfig = {
        apiKey: "AIzaSyCba6lgfmSJsZg02F9djkZB8mcuprgZSeI",
        authDomain: "vainkeurz---dev.firebaseapp.com",
        databaseURL: "https://vainkeurz---dev-default-rtdb.europe-west1.firebasedatabase.app",
        projectId: "vainkeurz---dev",
        storageBucket: "vainkeurz---dev.appspot.com",
        messagingSenderId: "627334561477",
        appId: "1:627334561477:web:cb476e53ad67bc5954faac"
    };

    import {
        getFirestore,
        collection,
        doc,
        getDoc,
        setDoc,
        getDocs,
        addDoc,
        updateDoc,
        deleteDoc,
        query,
        where
    } from "https://cdnjs.cloudflare.com/ajax/libs/firebase/9.8.1/firebase-firestore.min.js";
    const app = initializeApp(firebaseConfig);
    const database = getFirestore(app);

    // DOM…
    const domQuery = query(collection(database, "wpClassement"), where("custom_fields.id_tournoi_r", "==", "<?php echo $id_top; ?>"), where('custom_fields.done_r', "==", "done"));
    const domQuerySnapshot = await getDocs(domQuery);

    document.querySelectorAll('.nombres-classements').forEach(item => {
        item.textContent = domQuerySnapshot._snapshot.docs.size;
    })
    document.querySelector('.nombres-classements-p').textContent = domQuerySnapshot._snapshot.docs.size <= 1 ? 'Top' : 'Tops';

    // FUNCTION TO SORT CONTENDERS…
    const sortContenders = function(contenders) {
        let contendersArr = [],
            contendersArrPlaces = [],
            contendersArrIDs = [];

        for (let contender of contenders) {
            // delete contender.c_name;
            delete contender.elo;
            delete contender.id;
            delete contender.less_to;
            delete contender.more_to;
            delete contender.ratio;
            delete contender.image;

            contendersArr.push(contender);
            contendersArrPlaces.push(contender.place);

            contendersArrIDs.push(contender.id_wp);
        }
        contendersArr.sort(function(a, b) {
            return b.place - a.place;
        });
        contendersArrPlaces.sort(function(a, b) {
            return b - a;
        }).reverse();
        for (let j = 0; j < contendersArr.length; j++) {
            contendersArr[j].place = contendersArrPlaces[j];
        }
        contenders = contendersArr;

        return contenders;
    }

    // CALC RESSEMBLANCE…
    const calcRessemblance = function(myContenders, otherContenders) {
        let numberContenders = myContenders.length,
            positionEcart,
            similaire,
            pourcentSimilaire = [],
            ressemblances = [],
            totalRessemblances = 0;

        for (let i = 0; i < numberContenders; i++) {
            let otherContenderPlace = otherContenders.find(contender => contender.id_wp === myContenders[i].id_wp).place;

            positionEcart = Math.abs(myContenders[i].place - otherContenderPlace);

            similaire = (1 / numberContenders) / (positionEcart + 1);
            if (similaire <= ((1 / numberContenders) / (Math.floor(numberContenders / 2) + 1))) {
                similaire = 0;
                pourcentSimilaire.push(similaire);
            } else {
                pourcentSimilaire.push(similaire);
            }
        }

        if (Math.round(pourcentSimilaire.reduce((a, b) => a + b, 0) * 100) == 100) {
            totalRessemblances++;
        }

        ressemblances.push(Math.round(pourcentSimilaire.reduce((a, b) => a + b, 0) * 100));
        let result = Math.round(pourcentSimilaire.reduce((a, b) => a + b, 0) * 100) + '%';

        return result;
    }

    // GET ACTUAL USER RANKING…
    const actualUserRankingQuery = query(collection(database, "wpClassement"), where("custom_fields.id_tournoi_r", "==", "<?php echo $id_top; ?>"), where('custom_fields.done_r', "==", "done"), where("custom_fields.uuid_user_r", "==", currentUuid));
    const actualUserRankingQuerySnapshot = await getDocs(actualUserRankingQuery);

    // SORT MY RANKING…
    let myContenders = [];
    actualUserRankingQuerySnapshot.forEach(ranking => myContenders = sortContenders(ranking.data().custom_fields.ranking_r))
    console.log('My contenders: ', myContenders);

    // USERS RANKS…
    const usersRanksQuery = query(collection(database, "wpClassement"), where("custom_fields.id_tournoi_r", "==", "<?php echo $id_top; ?>"), where('custom_fields.done_r', "==", "done"), where('author', "!=", false));
    const usersRanksQuerySnapshot = await getDocs(usersRanksQuery);
    let html = "";

    // GET FOLLOWING…
    let following = [];
    const followingQuery = query(
        collection(database, "notifications"),
        where("notifType", "==", "follow"),
        where("userId", "==", currentUserId)
    );
    const followingQuerySnapshot = await getDocs(followingQuery);
    followingQuerySnapshot.forEach(f => following.push(f.data().relatedUuid))

    let i = 0;
    usersRanksQuerySnapshot.forEach((ranking) => {
        let contendersDiv = '',
            contendersIDs = [],
            contenders = [];
        contenders = sortContenders(ranking.data().custom_fields.ranking_r);

        let calcRessemblanceVar = calcRessemblance(myContenders, contenders) // CALC RESSEMBLANCE…

        contenders.forEach(contender => contendersIDs.push(contender.id_wp));

        const fetchDataAndShow = async () => {
            // FETCH ALL CONTENDERS…
            const map = new Map();
            await Promise.all(contendersIDs.map(async id => {
                await fetch(`https://vainkeurz.com/wp-json/vkrz/v1/getcontenderinfo/${id}`)
                    .then((res) => res.json())
                    .then(response => map.set(id, response));
            }));
            contenders.forEach((contender, index) => {
                if (index < 3) {
                    contendersDiv += `
                        <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="${map.get(contender.id_wp).Title}" class="avatartop3 avatar pull-up">
                            <img src="${map.get(contender.id_wp).Thumbnail}" alt="${map.get(contender.id_wp).Title}">
                        </div>
                    `
                }
            })
            $(document).ready(function() {
                $("body").tooltip({
                    selector: '[data-toggle=tooltip]'
                });
            });

            // FETCH USER DATA…
            await fetch(`https://vainkeurz.com/wp-json/vkrz/v1/getuserinfo/${ranking.data().custom_fields.uuid_user_r}`)
                .then((res) => res.json())
                .then(response => {

                    let followingOrNotDiv = "";
                    let followingOrNot = following.includes(ranking.data().custom_fields.uuid_user_r);
                    if (followingOrNot) {
                        followingOrNotDiv = `
                            <a 
                                href="" 
                                data-userid=${response.user_id}
                                class="unfollowBtns dropdown-item"
                                >
                                <span class="ico-action va va-new-button va-z-20"></span> 
                                Unfollow
                            </a>
                        `
                    } else if (ranking.data().custom_fields.uuid_user_r == currentUuid) {
                        followingOrNotDiv = ``
                    } else {
                        followingOrNotDiv = `
                            <a 
                                href="" 
                                class="followBtns dropdown-item"
                                data-userid=${currentUserId}
                                data-uuid=${currentUuid}
                                data-relatedid=${response.user_id}
                                data-relateduuid="${response.uuid_user_vkrz}"
                                data-text="${vainkeurPseudo} te guette !"
                                data-url="${currentUserProfileUrl}"
                                >
                                <span class="ico-action va va-new-button va-z-20"></span> 
                                Follow
                            </a>
                        `
                    }

                    // RESSEMBLANCE NUMBER…
                    let ressemblanceOnlyNumber = calcRessemblanceVar.substring(0, calcRessemblanceVar.indexOf('%'));
                    ressemblanceOnlyNumber = +ressemblanceOnlyNumber
                    if (ressemblanceOnlyNumber == 100) {
                        calcRessemblanceVar = `
                            <span class="badge rounded-pill badge-light-success me-1">${calcRessemblanceVar}</span>
                        `
                    } else if (ressemblanceOnlyNumber >= 30 && ressemblanceOnlyNumber < 100) {
                        calcRessemblanceVar = `
                            <span class="badge rounded-pill badge-light-info me-1">${calcRessemblanceVar}</span>
                        `
                    } else {
                        calcRessemblanceVar = `
                            <span class="badge rounded-pill badge-light-warning me-1">${calcRessemblanceVar}</span>
                        `
                    }

                    html += `
                        <tr style="background-color: transparent !important;"">
                            <td class="vainkeur-table">
                                <span class="avatar">
                                    <a href="${!response.pseudo ? '#' : response.profil_url}">
                                        <span class="avatar-picture" style="background-image: url(${!response.pseudo ? '' : response.avatar});"></span>
                                    </a>
                                    <span class="user-niveau">
                                        ${response.level}
                                    </span>
                                </span>
                                <span class="font-weight-bold championname">
                                    <a href="${!response.pseudo ? '#' : response.profil_url}">
                                        ${!response.pseudo ? '<i>ANONYME</i>' : response.pseudo}
                                        <span class="user-niveau-xs">
                                            ${response.level}
                                        </span>
                                        ${!response.user_role_administrator ? '' : response.user_role_administrator} 
                                        ${!response.user_role_author ? '' : response.user_role_author}
                                    </a>
                                </span>
                            </td>

                            <td>
                                ${contendersDiv}
                            </td>

                            <td class="text-center">
                                ${calcRessemblanceVar}
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
                                        <a href="${ranking.data().permalink}" class="dropdown-item">
                                            <span class="ico-action va va-eyes va-z-20"></span> Guetter ses TopList
                                        </a>

                                        ${followingOrNotDiv}
                                    </div>      
                                </div>
                            </td>
                        </tr>
                    `

                    document.querySelector('tbody').innerHTML = html;

                    i++;
                    document.querySelector('.step').textContent = i;

                    // LAST ROUND…
                    if (usersRanksQuerySnapshot._snapshot.docs.size == i) {
                        document.querySelector('.step').textContent = domQuerySnapshot._snapshot.docs.size;

                        const unfollowBtns = document.querySelectorAll(".unfollowBtns");
                        unfollowBtns.forEach((btn) => {
                            btn.addEventListener("click", (e) => {
                                e.preventDefault();
                                e.target.closest("a").remove();

                                const checkFollower = async () => {
                                    const checkFollowerQuery = query(
                                        collection(database, "notifications"),
                                        where("notifType", "==", "follow"),
                                        where("userId", "==", currentUserId),
                                        where("relatedId", "==", btn.dataset.userid)
                                    );
                                    const checkFollowerQuerySnapshot = await getDocs(checkFollowerQuery);

                                    if (checkFollowerQuerySnapshot._snapshot.docs.size === 1) {
                                        deleteDoc(doc(database, "notifications", checkFollowerQuerySnapshot.docs[0].id));
                                    }
                                }
                                checkFollower();
                            });
                        });

                        const followBtns = document.querySelectorAll(".followBtns");
                        followBtns.forEach((btn) => {
                            btn.addEventListener("click", (e) => {
                                e.preventDefault();
                                e.target.closest("a").remove();

                                async function setNotification() {
                                    try {
                                        let q = query(
                                            collection(database, "notifications"),
                                            where("notifText", "==", `${vainkeurPseudo} te guette !`),
                                            where("relatedId", "==", btn.dataset.relatedid)
                                        );
                                        let querySnapshot = await getDocs(q);

                                        if (querySnapshot._snapshot.docs.size === 0) {
                                            const newFollow = await addDoc(
                                                collection(database, "notifications"), {
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

                        $("#table-ressemblance").DataTable({
                            autoWidth: false,
                            lengthMenu: [25],
                            pagingType: "full_numbers",
                            order: [
                                [2, 'desc']
                            ],
                            columns: [{
                                    orderable: false
                                },
                                {
                                    orderable: false
                                },
                                {
                                    orderable: true
                                },
                                {
                                    orderable: false
                                },
                            ],
                            language: {
                                search: "_INPUT_",
                                searchPlaceholder: "Rechercher...",
                                processing: "Traitement en cours...",
                                info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                                infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                                infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
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
                });
        };

        fetchDataAndShow();
    });
</script>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">

            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Liste de tous les Tops <?php echo $top_infos['top_number']; ?> <span class="ico text-center va va-trophy va-lg"></span> <?php echo $top_infos['top_title']; ?>
                    </h3>
                    <h4 class="mb-0">
                        <?php echo $top_infos['top_question']; ?>
                    </h4>
                </div>
            </div>

            <div class="classement">
                <div class="row">
                    <div class="col-md-8">
                        <section id="profile-info">
                            <div class="row" id="table-bordered">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title pt-1 pb-1">
                                                <span class="step">0</span> Of
                                                <span class="nombres-classements">0</span> <span class="va va-trophy va-lg"></span> TopList générées pour ce Top !
                                            </h4>
                                        </div>
                                        <div class="table-responsive">
                                            <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                <table class="invoice-list-table table table-tdonee dataTable no-footer" id="table-ressemblance">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <span class="text-muted">
                                                                    Vainkeurs
                                                                </span>
                                                            </th>
                                                            <th>
                                                                <span class="text-muted">
                                                                    Podium
                                                                </span>
                                                            </th>
                                                            <th>
                                                                <span class="text-muted">
                                                                    Ressemblance ↕
                                                                </span>
                                                            </th>
                                                            <th class="text-center">
                                                                <span class="text-muted">
                                                                    Voir
                                                                </span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tbody">

                                                        <!-- LOADER… 🎺 -->
                                                        <tr style="background-color: transparent !important;">
                                                            <th></th>
                                                            <th>
                                                                <span>
                                                                    <div class="loader loader--style1" title="0">
                                                                        <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
                                                                            <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
                                                            s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
                                                            c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z" />
                                                                            <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
                                                                C22.32,8.481,24.301,9.057,26.013,10.047z">
                                                                                <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite" />
                                                                            </path>
                                                                        </svg>
                                                                    </div>
                                                                </span>
                                                            </th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="col-md-3 offset-md-1">

                        <div class="related">

                            <div class="infoelo">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card text-left">
                                            <?php
                                            $creator_id         = get_post_field('post_author', $id_top);
                                            $creator_uuiduser   = get_field('uuiduser_user', 'user_' . $creator_id);
                                            $creator_data       = get_user_infos($creator_uuiduser);
                                            ?>
                                            <div class="card-body">
                                                <h4 class="card-title">
                                                    <?php
                                                    date_default_timezone_set('Europe/Paris');
                                                    $origin     = new DateTime(get_the_date('Y-m-d', $id_top));
                                                    $target     = new DateTime(date('Y-m-d'));
                                                    $interval   = $origin->diff($target);
                                                    if ($interval->days == 0) {
                                                        $info_date = "aujourd'hui";
                                                    } elseif ($interval->days == 1) {
                                                        $info_date = "hier";
                                                    } else {
                                                        $info_date = "depuis " . $interval->days . " jours";
                                                    }
                                                    ?>
                                                    <span class="ico va va-birthday-cake va-lg"></span> Créé <span class="t-violet"><?php echo $info_date; ?></span> par :
                                                </h4>
                                                <div class="employee-task d-flex justify-content-between align-items-center">
                                                    <a href="<?php echo $creator_data['profil_url']; ?>" class="d-flex flex-row link-to-creator">
                                                        <div class="avatar me-75 mr-1">
                                                            <img src="<?php echo $creator_data['avatar']; ?>" class="circle" width="42" height="42" alt="Avatar">
                                                        </div>
                                                        <div class="my-auto">
                                                            <h3 class="mb-0">
                                                                <?php echo $creator_data['pseudo']; ?> <br>
                                                                <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau actuel">
                                                                    <?php echo $creator_data['level']; ?>
                                                                </span>
                                                                <?php if ($creator_data['user_role']  == "administrator") : ?>
                                                                    <span class="ico va va-vkrzteam va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                                    </span>
                                                                <?php endif; ?>
                                                                <?php if ($creator_data['user_role']  == "administrator" || $creator_data['user_role'] == "author") : ?>
                                                                    <span class="ico va va-man-singer va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                                                    </span>
                                                                <?php endif; ?>
                                                            </h3>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4 va-high-voltage va va-md"></span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo $top_datas['nb_votes']; ?>
                                                </h2>
                                                <p class="card-text legende">
                                                    <?php if ($top_datas['nb_votes'] <= 1) : ?>
                                                        vote
                                                    <?php else : ?>
                                                        Votes
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4 va-trophy va va-md"></span>
                                                </div>
                                                <h2 class="font-weight-bolder nombres-classements">
                                                    -
                                                </h2>
                                                <p class="card-text legende nombres-classements-p">
                                                    Tops
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <span class="ico va va-speech-balloon va-lg"></span> <?php echo $top_datas['nb_comments']; ?>
                                        <?php if ($top_datas['nb_comments'] <= 1) : ?>
                                            Commentaire
                                        <?php else : ?>
                                            Commentaires
                                        <?php endif; ?>
                                    </h4>
                                    <h6 class="card-subtitle text-muted mb-1">
                                        Tout ce qui te passe par la tête à propos de ce Top mérite d'être partagé avec les autres Vainkeurs.
                                    </h6>
                                    <a href="<?php echo get_the_permalink(get_page_by_path('discuz')) . '?id_top=' . $id_top; ?>" class="btn btn-outline-primary waves-effect">
                                        Lire & poster
                                    </a>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <span class="ico">🌎</span> Voir la TopList mondiale
                                    </h4>
                                    <h6 class="card-subtitle text-muted mb-1">
                                        Découvre le classement complet généré par les <?php echo $top_datas['nb_votes']; ?> votes !
                                    </h6>
                                    <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $id_top; ?>" class="btn btn-outline-primary waves-effect">
                                        Voir la TopList mondiale
                                    </a>
                                </div>
                            </div>
                            <?php if (!get_top_done_by_current_vainkeur($id_top, $id_vainkeur, $list_t_already_done)) : ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <span class="ico va va-victory-hand va-lg"></span> A toi de jouer
                                        </h4>
                                        <h6 class="card-subtitle text-muted mb-1 text-center">
                                            Toi aussi fais ta TopList afin de faire bouger les positions !
                                        </h6>
                                        <a href="<?php the_permalink($id_top); ?>" class="btn btn-outline-primary waves-effect">
                                            Faire ma propre TopList
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>