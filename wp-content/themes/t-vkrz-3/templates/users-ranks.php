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

$actual_uuiduser = get_field('uuiduser_user', 'user_' . get_current_user_id());
?>


<!-- 
    // ALL IS GOOD…
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
    const app = initializeApp(firebaseConfig);

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
    const database = getFirestore(app);

    // FUNCTION TO COMPARE MY RANKING TO OTHER'S RANKING…
    const sameRankingFunc = function(obj1, obj2) {
        const obj1Keys = Object.keys(obj1);
        const obj2Keys = Object.keys(obj2);

        if (obj1Keys.length !== obj2Keys.length) {
            return false;
        }

        for (let objKey of obj1Keys) {
            if (obj1[objKey] !== obj2[objKey]) {
                if (typeof obj1[objKey] == "object" && typeof obj2[objKey] == "object") {
                    if (!sameRankingFunc(obj1[objKey], obj2[objKey])) {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

        return true;
    };

    // FUNCTION TO SORT CONTENDERS…
    const sortContenders = function(contenders) {
        let contendersArr = [],
            contendersArrPlaces = [],
            contendersArrIDs = [];

        for (let contender of contenders) {
            delete contender.c_name;
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

    // GET ACTUAL USER RANKING…
    const currentUuid = "<?php echo $actual_uuiduser; ?>";
    const actualUserRankingQuery = query(collection(database, "wpClassement"), where("custom_fields.id_tournoi_r", "==", "<?php echo $id_top; ?>"), where('custom_fields.done_r', "==", "done"), where("custom_fields.uuid_user_r", "==", currentUuid));
    const actualUserRankingQuerySnapshot = await getDocs(actualUserRankingQuery);

    // SORT MY RANKING…
    let myContenders = [];
    actualUserRankingQuerySnapshot.forEach(ranking => myContenders = sortContenders(ranking.data().custom_fields.ranking_r))
    console.log('myContenders', myContenders);

    // USERS RANKS…
    const usersRanksQuery = query(collection(database, "wpClassement"), where("custom_fields.id_tournoi_r", "==", "<?php echo $id_top; ?>"), where('custom_fields.done_r', "==", "done"), where('author', "!=", false));
    const usersRanksQuerySnapshot = await getDocs(usersRanksQuery);
    let html = ''

    let contenders = [];
    usersRanksQuerySnapshot.forEach((ranking) => {
        let contendersDiv = '',
            contendersIDs = [];

        contenders = sortContenders(ranking.data().custom_fields.ranking_r);

        if (sameRankingFunc(contenders, myContenders))
            console.log(sameRankingFunc(contenders, myContenders), ranking.data().author.display_name);

        contenders.forEach(contender => contendersIDs.push(contender.id_wp));
        const fetchDataAndShow = async () => {
            // FETCH ALL CONTENDERS…
            const map = new Map();
            await Promise.all(contendersIDs.map(async id => {
                await fetch(`http://localhost:8888/vkrz/wp-json/vkrz/v1/getcontenderinfo/${id}`)
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

                            <td class="text-right">
                                <a href="${ranking.data().permalink}" class="mr-1 btn btn-outline-primary waves-effect">
                                    <span class="ico ico-reverse va va-eyes va-lg"></span>
                                </a>
                            </td>
                        </tr>
                    `

                    document.querySelector('tbody').innerHTML = html;
                });
        };
        fetchDataAndShow()
    });

    // DOM…
    const domQuery = query(collection(database, "wpClassement"), where("custom_fields.id_tournoi_r", "==", "<?php echo $id_top; ?>"), where('custom_fields.done_r', "==", "done"));
    const domQuerySnapshot = await getDocs(domQuery);

    document.querySelectorAll('.nombres-classements').forEach(item => {
        item.textContent = domQuerySnapshot._snapshot.docs.size;
    })
    document.querySelector('.nombres-classements-p').textContent = domQuerySnapshot._snapshot.docs.size <= 1 ? 'Top' : 'Tops';
</script>
-->

<script type="module">
    import {
        initializeApp
    } from "https://www.gstatic.com/firebasejs/9.8.1/firebase-app.js";
    const firebaseConfig = {
        apiKey: "AIzaSyDX3AkehDOsSpznrUG_mXRJBY_jkBeLCds",
        authDomain: "vainkeurz-48eb4.firebaseapp.com",
        databaseURL: "https://vainkeurz-48eb4-default-rtdb.europe-west1.firebasedatabase.app",
        projectId: "vainkeurz-48eb4",
        storageBucket: "vainkeurz-48eb4.appspot.com",
        messagingSenderId: "915310626932",
        appId: "1:915310626932:web:3a2118ed2a1551af3d2921",
        measurementId: "G-BGB5H22QLZ"
    };
    const app = initializeApp(firebaseConfig);
    import {
        getFirestore,
        collection,
        doc,
        setDoc,
        getDocs,
        addDoc,
        updateDoc,
        deleteDoc,
        query,
        where
    } from "https://cdnjs.cloudflare.com/ajax/libs/firebase/9.8.1/firebase-firestore.min.js";
    const database = getFirestore(app);

    // FUNCTION TO SORT CONTENDERS…
    const sortContenders = function(contenders) {
        let contendersArr = [],
            contendersArrPlaces = [],
            contendersArrIDs = [];

        for (let contender of contenders) {
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

    // GET ACTUAL USER RANKING…
    const actualUserRankingQuery = query(collection(database, "classements"), where('user_id', "==", <?= get_current_user_id(); ?>));
    const actualUserRankingQuerySnapshot = await getDocs(actualUserRankingQuery);

    // SORT MY RANKING…
    let myContenders = [];
    actualUserRankingQuerySnapshot.forEach(ranking => myContenders = sortContenders(ranking.data().array_ranking))
    console.log('myContenders', myContenders);

    const classementQuery = query(collection(database, "classements"), where("top_id", "==", 342099), where("user_id", '!=', <?= get_current_user_id(); ?>));
    const classementQuerySnapshot = await getDocs(classementQuery);


    let otherContendersArr = [];
    classementQuerySnapshot.forEach(classement => {
        let otherContenders = [];
        otherContenders = sortContenders(classement.data().array_ranking)
        otherContendersArr.push(otherContenders)
    })
    // console.log('otherContenders', otherContenders);

    otherContendersArr.forEach((otherContenders, index) => {
        console.log('otherContenders', index + 1, otherContenders);
        let obj1 = myContenders
        let obj2 = otherContenders
        var count = [0, 0];
        for (var key in obj1) {
            count[1]++; // total count
            if (obj2.hasOwnProperty(key) && obj2[key].id_wp === obj1[key].id_wp && obj2[key].place === obj1[key].place) {
                count[0]++; // match count
            }
        }
        var percentage = count[0] / count[1] * 100 + "%";
        console.log('Percentage of match :', percentage);
    })
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
                                                <span class="nombres-classements"></span> <span class="va va-trophy va-lg"></span> TopList générées pour ce Top !
                                            </h4>
                                        </div>
                                        <div class="table-responsive">
                                            <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                <table class="invoice-list-table table table-tdonee dataTable no-footer">
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
                                                            <th class="text-center">
                                                                <span class="text-muted">
                                                                    Voir
                                                                </span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <!-- LOADER… 🎺 -->
                                                        <tr style="background-color: transparent !important;">
                                                            <th></th>
                                                            <th>
                                                                <span class="similarpercent" data-uuiduser="<?php echo get_field('uuid_user_r', $id_ranking); ?>" data-idtop="<?php echo $id_top_global; ?>">
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

                    <div class="col-md-4">

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
                                                    <a href="<?php echo $creator_data['profil']; ?>" class="d-flex flex-row link-to-creator">
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
                                                <h2 class="font-weight-bolder">
                                                    <span class="nombres-classements"></span>
                                                </h2>
                                                <p class="nombres-classements-p card-text legende">
                                                    Top
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>