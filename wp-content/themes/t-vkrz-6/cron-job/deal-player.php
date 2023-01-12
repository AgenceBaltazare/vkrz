<?php
include __DIR__ . '/../../../../wp-load.php';

$players = new WP_Query(array(
  'post_type'              => 'player',
  'posts_per_page'         => 5,
  'fields'                 => 'ids',
  'post_status'            => 'publish',
  'ignore_sticky_posts'    => true,
  'update_post_meta_cache' => false,
  'no_found_rows'          => false,
  'orderby'                => 'date',
  'order'                  => 'DESC',
  'meta_query' => array(
    array(
      'key'     => 'sendtofirebase',
      'compare' => 'NOT EXISTS',
    ),
  )
));
$i = 1;
if ($players->have_posts()) {

  foreach ($players->posts as $player_id) {

    $uuid_vainkeur  = get_field('uuid_vainkeur_p', $player_id);
    $id_vainkeur    = get_vainkeur_id($uuid_vainkeur);
    $id_top         = get_field('id_t_p', $player_id);
    $id_ranking     = get_field('id_r_p', $player_id);
    $email_player   = get_field('email_player_p', $player_id);
    $date_player    = get_the_date('Y-m-d H:i:s', $player_id);

    echo $i . " - Le player " . $id_vainkeur . " qui a joué le " . $date_player . " a été envoyé dans firebase <br>";

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
        appId: "1:627334561477:web:cb476e53ad67bc5954faac",
      };
      const app = initializeApp(firebaseConfig);
      import {
        getFirestore,
        collection,
        getDocs,
        getDoc,
        query,
        addDoc,
        setDoc,
        deleteDoc,
        doc,
        where,
        orderBy,
        updateDoc,
      } from "https://cdnjs.cloudflare.com/ajax/libs/firebase/9.8.1/firebase-firestore.min.js";
      const database = getFirestore(app);

      const uuiduser = "<?= $uuid_vainkeur ?>";
      const id_vainkeur = "<?= $id_vainkeur ?>";
      const id_top = "<?= $id_top ?>";
      const id_ranking = "<?= $id_ranking ?>";
      const email_player = "<?= $email_player ?>";
      const date_player = "<?= $date_player ?>";

      const customDocId = `U:${uuiduser};T:${id_top};R:${id_ranking}`;
      try {
        const newPlayer = await setDoc(doc(database, "players", customDocId), {
          uuidPlayer: uuiduser,
          emailPlayer: email_player,
          ranking: id_ranking,
          top: id_top,
          vainkeurId: id_vainkeur,
          createdAt: date_player,
        });
        console.log("Player well sent ! <?= $i ?>");
      } catch (error) {
        console.error("Error adding comment: ", error);
      }
    </script>

<?php

    $i++;
    update_field('sendtofirebase', date('d/m/Y'), $player_id);
  }
}
