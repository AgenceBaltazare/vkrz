<?php
function custom_pagination($numpages = '', $pagerange = '', $paged='') {

    if (empty($pagerange)) {
        $pagerange = 1;
    }

    /**
     * This first part of our function is a fallback
     * for custom pagination inside a regular loop that
     * uses the global $paged and global $wp_query variables.
     *
     * It's good because we can now override default pagination
     * in our theme, and use this function in default quries
     * and custom queries.
     */
    global $paged;
    if (empty($paged)) {
        $paged = 1;
    }
    if ($numpages == '') {
        global $wp_query;
        $numpages = $wp_query->max_num_pages;
        if(!$numpages) {
            $numpages = 1;
        }
    }

    /**
     * We construct the pagination arguments to enter into our paginate_links
     * function.
     */
    $urlFormat = 'page/%#%';
    $urlCurrent = get_pagenum_link(1);
    if (isset($_GET['orderby'])) {
        $filter = $_GET['orderby'];
        switch ($filter) {
            case 'niveau' :
                $urlFormat = 'page/%#%?orderby=niveau';
                break;
            case 'date' :
                $urlFormat = 'page/%#%?orderby=date';
                break;
        }

        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
        $urlCurrent = 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0];

        if ($paged != 1 && $paged < 10) {
            $urlCurrent = substr($urlCurrent, 0, -7);
        }

        if ($paged > 9) {
            $urlCurrent = substr($urlCurrent, 0, -8);
        }
    }

    if (isset($_GET['bp_id'])) {
        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
        $urlCurrent = 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0];

        if ($paged != 1 && $paged < 10) {
            $urlCurrent = substr($urlCurrent, 0, -7);
        }

        if ($paged > 9) {
            $urlCurrent = substr($urlCurrent, 0, -8);
        }
    }

    $pagination_args = array(
        'base'            => $urlCurrent . '%_%',
        'format'          => $urlFormat,
        'total'           => $numpages,
        'current'         => $paged,
        'show_all'        => false,
        'end_size'        => 1,
        'mid_size'        => $pagerange,
        'prev_next'       => true,
        'prev_text'       => __('&lt;'),
        'next_text'       => __(' &gt;'),
        'type'            => 'plain',
        'add_args'        => false,
        'add_fragment'    => ''
    );
    $paginate_links = paginate_links($pagination_args);
    return $paginate_links;
}
