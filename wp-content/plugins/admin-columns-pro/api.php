<?php

use AC\Request;
use ACP\Bookmark\SegmentRepository;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Search;
use ACP\Sorting;

/**
 * @return ACP\AdminColumnsPro
 */
function ACP() {
	return ACP\AdminColumnsPro::instance();
}

/**
 * @return string
 * @since 4.4
 */
function acp_support_email() {
	return 'support@admincolumns.com';
}

/**
 * @return bool
 * @deprecated 6.0
 * @since      5.1
 */
function acp_sorting_show_all_results() {
	_deprecated_function( __FUNCTION__, '6.0' );

	return true;
}

/**
 * @deprecated 5.7
 */
function acp_get_license_page_url() {
	_deprecated_function( __FUNCTION__, '5.7' );
}

/**
 * @return Filtering\Helper
 * @since      4.2
 * @deprecated 4.5
 */
function acp_filtering_helper() {
	_deprecated_function( __FUNCTION__, '4.5', 'ACP\Filtering\Helper' );

	return new Filtering\Helper();
}

/**
 * @deprecated 4.5
 */
function acp_editing_helper() {
	_deprecated_function( __FUNCTION__, '4.5' );
}

/**
 * @since      4.0
 * @deprecated 5.1
 */
function acp_editing() {
	_deprecated_function( __FUNCTION__, '5.1' );

	return new Editing\Addon( AC()->get_storage(), ACP()->get_location(), new Request() );
}

/**
 * @deprecated 5.1
 * @since      4.0
 */
function acp_filtering() {
	_deprecated_function( __FUNCTION__, '5.1' );

	return new Filtering\Addon( AC()->get_storage(), ACP()->get_location(), new Request() );
}

/**
 * @deprecated 5.1
 * @since      4.0
 */
function acp_sorting() {
	_deprecated_function( __FUNCTION__, '5.1' );

	return new Sorting\Addon(
		AC()->get_storage(),
		ACP()->get_location(),
		new SegmentRepository()
	);
}

/**
 * @deprecated 5.1
 */
function ac_addon_export() {
	_deprecated_function( __FUNCTION__, '5.1' );

	return new Export\Addon( ACP()->get_location(), AC()->get_storage() );
}

/**
 * @deprecated 5.1
 */
function ac_addon_search() {
	_deprecated_function( __FUNCTION__, '5.1' );

	return new Search\Addon(
		AC()->get_storage(),
		ACP()->get_location(),
		new SegmentRepository()
	);
}