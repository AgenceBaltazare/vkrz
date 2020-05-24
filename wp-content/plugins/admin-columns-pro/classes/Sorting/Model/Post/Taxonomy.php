<?php

namespace ACP\Sorting\Model\Post;

use ACP\Sorting\Model;
use WP_Query;

class Taxonomy extends Model {

	public function get_sorting_vars() {
		add_filter( 'posts_clauses', [ $this, 'sorting_clauses_callback' ], 10, 2 );

		return [
			'suppress_filters' => false,
		];
	}

	/**
	 * Setup clauses to sort by taxonomies
	 *
	 * @param array    $clauses array
	 * @param WP_Query $query
	 *
	 * @return array
	 * @since 3.4
	 */
	public function sorting_clauses_callback( $clauses, $query ) {
		global $wpdb;

		$conditions[] = $wpdb->prepare( 'taxonomy = %s', $this->column->get_taxonomy() );
		$conditions[] = acp_sorting_show_all_results() ? ' OR taxonomy IS NULL' : '';

		$clauses['where'] .= vsprintf( ' AND (%s%s)', $conditions );
		$clauses['orderby'] = "acp_sorting_t.name " . $query->query_vars['order'];
		$clauses['join'] .= "
            LEFT OUTER JOIN {$wpdb->term_relationships} AS acp_sorting_tr
                ON {$wpdb->posts}.ID = acp_sorting_tr.object_id
            LEFT OUTER JOIN {$wpdb->term_taxonomy} AS acp_sorting_tt
                ON acp_sorting_tr.term_taxonomy_id = acp_sorting_tt.term_taxonomy_id
            LEFT OUTER JOIN {$wpdb->terms} AS acp_sorting_t
                ON acp_sorting_tt.term_id = acp_sorting_t.term_id
        ";

		$clauses['groupby'] = "{$wpdb->posts}.ID";

		// remove this filter
		remove_filter( 'posts_clauses', [ $this, __FUNCTION__ ] );

		return $clauses;
	}

}