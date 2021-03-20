<?php
/*
    Template Name: Log votes
*/
?>
<?php
$id_ranking                      = $_GET['id_ranking'];
$id_tournoi                      = get_field('id_tournoi_r', $id_ranking);
$list_contenders_tournoi         = get_field('ranking_r', $id_ranking);

function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }
    array_multisort($sort_col, $dir, $arr);
}
array_sort_by_column($list_contenders_tournoi, 'place');
?>
<?php get_header(); ?>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-7">
            <table class="table table-dark table-striped">
                <thead>
                <tr>
                    <th scope="col">Place</th>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Supérieur à</th>
                    <th scope="col">Inférieur à</th>
                    <th scope="col">ELO</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($list_contenders_tournoi as $c) : ?>
                    <tr>
                        <td>
                            <?php echo $c['place']; ?>
                        </td>
                        <td>
                            <?php echo $c['id']; ?>
                        </td>
                        <td>
                            <?php echo get_the_title($c['id_wp']); ?>
                        </td>
                        <td>
                            <?php foreach($c['superieur_to'] as $sup) : ?>
                                <?php echo $sup." "; ?>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <?php foreach($c['inferior_to'] as $inf) : ?>
                                <?php echo $inf." "; ?>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <?php the_field('ELO_c', $c['id_wp']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-4">
            <?php
            if(isset($_GET['nb']) && $_GET['nb'] != ""){
                $nb = $_GET['nb'];
            }
            else{
                $nb = 50;
            }
            $all_votes = new WP_Query(array('post_type' => 'vote', 'order' => 'DESC', 'orderby' => 'date', 'posts_per_page' => $nb, 'meta_query' => array(
                array(
                    'key' => 'id_t_v',
                    'value' => $id_tournoi,
                    'compare' => '=',
                ),
            ))); ?>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Gagnant</th>
                    <th scope="col">Perdant</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; while ($all_votes->have_posts()) : $all_votes->the_post(); ?>
                    <?php
                    $id_v = get_field('id_v_v');
                    $id_l = get_field('id_l_v');
                    ?>
                    <tr>
                        <td>
                            <?php echo $i; ?>
                        </td>
                        <td>
                            <b><?php echo get_the_title($id_v); ?></b>
                        </td>
                        <td>
                            <?php echo get_the_title($id_l); ?>
                        </td>
                    </tr>
                    <?php $i++; endwhile; ?>
                </tbody>
                <tfooter>
                    <th>
                        TOTAL
                    </th>
                    <th colspan="2" class="text-right">
                        <?php echo $all_votes->post_count; ?>
                    </th>
                </tfooter>
            </table>
        </div>
    </div>
</div>

<?php get_footer(); ?>
