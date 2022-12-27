<?php
/*
    Template Name: Recap
*/
?>

<section class="list-tournois">

    <table border="1">
        <thead>
            <tr>
                <td>Pseudo</td>
                <td>Email</td>
                <td>NB Votes</td>
                <td>NB TopList</td>
                <td>NB Jugements Faits</td>
                <td>Code Parrainage</td>
                <td>Participation Top Sponso</td>
                <td>NB Tops Créés</td>
                <td>NB Votes générées</td>
                <td>NB TopList générées</td>
            </tr>
        </thead>
        <tbody>
            <?php

            $args = array(
                'role'    => 'author',
            );
            $users = get_users($args);

            foreach ($users as $user) : ?>

                <?php
                    $id_vainkeur =  get_field("id_vainkeur_user", "user_" . $user->ID);

                    $data_creator = get_creator_t($user->ID);
                    
                    $count_sponso = 0;
                    $user_tops = get_field('liste_des_top_vkrz', $id_vainkeur);
                    $user_tops = json_decode($user_tops);
                    foreach($user_tops as $top) {
                        $post_taxonomies = array();
                        foreach(get_the_terms($top, 'type') as $tax ) {
                          array_push($post_taxonomies, $tax->name);
                        }
                        if(in_array("Sponso", $post_taxonomies)) {
                          $count_sponso++;
                        }
                    }
                ?>

                <tr>
                    <td>
                        <?php echo esc_html($user->display_name); ?>
                    </td>
                    <td>
                        <?php echo esc_html($user->user_email); ?>
                    </td>
                    <td>
                        <?php echo get_field("nb_vote_vkrz", $id_vainkeur) ? get_field("nb_vote_vkrz", $id_vainkeur) : "0"; ?>
                    </td>
                    <td>
                        <?php echo get_field("nb_top_vkrz", $id_vainkeur) ? get_field("nb_top_vkrz", $id_vainkeur) : "0"; ?>
                    </td>
                    <td>
                        <?php echo get_field("nb_jugement_vkrz", $id_vainkeur) ? get_field("nb_jugement_vkrz", $id_vainkeur) : "0"; ?>
                    </td>
                    <td>
                        <?php echo get_field("code_parrain_user", "user_" . $user->ID); ?>
                    </td>
                    <td>
                        <?php echo $count_sponso; ?>
                    </td>
                    <td>
                        <?php echo $data_creator['creator_nb_tops']; ?>
                    </td>
                    <td>
                        <?php echo $data_creator['creator_all_v']; ?>
                    </td>
                    <td>
                        <?php echo $data_creator['creator_all_t']; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br><br>

    <a href="#" onclick="download_table_as_csv('my_id_table_to_export');">Download as CSV</a>

</section>

<script type="text/javascript">
function download_table_as_csv(table_id, separator = ',') {
    // Select rows from table_id
    var rows = document.querySelectorAll('table tr');
    // Construct csv
    var csv = [];
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll('td, th');
        for (var j = 0; j < cols.length; j++) {
            // Clean innertext to remove multiple spaces and jumpline (break csv)
            var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
            // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
            data = data.replace(/"/g, '""');
            // Push escaped string
            row.push(data);
        }
        csv.push(row.join(separator));
    }
    var csv_string = csv.join('\n');
    // Download it
    var filename = 'list.csv';
    var link = document.createElement('a');
    link.style.display = 'none';
    link.setAttribute('target', '_blank');
    link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>