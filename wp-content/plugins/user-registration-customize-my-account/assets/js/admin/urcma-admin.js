jQuery(document).ready(function ($) {
	"use strict";

	var endpoints_container = $(".urcma-endpoints-options-wrapper");

	/*******************************
	 *  Initialize tinyMCE editor
	 *******************************/

	function init_tinyMCE(id) {
		// get tinymce options
		var mceInit = tinyMCEPreInit.mceInit,
			mceKey = Object.keys(mceInit)[0],
			mce = mceInit[mceKey],
			// get quicktags options
			qtInit = tinyMCEPreInit.qtInit,
			qtKey = Object.keys(qtInit)[0],
			qt = mceInit[qtKey];

		// change id
		mce.selector = id;
		mce.body_class = mce.body_class.replace(mceKey, id);
		qt.id = id;

		tinyMCE.init(mce);
		tinyMCE.execCommand("mceRemoveEditor", true, id);
		tinyMCE.execCommand("mceAddEditor", true, id);

		quicktags(qt);
		QTags._buttonsInit();
	}

	/*******************************
	 *  Sort and save endpoints
	 *******************************/

	if (typeof $.fn.sortable != "undefined") {
		$(".urcma-endpoint-tabs").sortable({
			containment: ".urcma-endpoint-tabs",
			tolerance: "pointer",
			revert: "invalid",
			forceHelperSize: true,
		});
	}

	$("form#mainform").on("submit", function (ev) {
		if (typeof $.fn.sortable == "undefined") {
			return;
		}

		var v = [];
		$(".urcma-endpoint-selector").each(function (i) {
			var j = { type: $(this).data("type"), id: $(this).attr("id") };
			v.push(j);
		});

		var newOrder = JSON.stringify(v);
		$("input.endpoints-order").val(newOrder);
	});

	endpoints_container.on("change", function (ev, elem) {
		if (typeof elem != "undefined") {
			init_tinyMCE(elem.find("textarea").attr("id"));
		}
	});

	/*******************
	 *  Add Endpoints
	 *********************/

	$(document).on("click", ".add_new_field", function (event) {
		event.stopPropagation();

		var t = $(this),
			target = t.data("target");

		Swal.fire({
			customClass:
				"user-registration-swal2-modal user-registration-swal2-modal--center",
			title: urcma_params.add_new_endpoint_title,
			input: "text",
			inputAttributes: {
				autocapitalize: "off",
			},
		}).then(function (result) {
			if (result.value) {
				var answers = result.value;
				$(this).add_new_field_handler(target, answers);
			}
		});
	});

	$.fn.add_new_field_handler = function (target, answers) {
		var t = $(this);

		$.ajax({
			url: urcma_params.ajaxurl,
			data: {
				target: target,
				field_name: answers,
				action: urcma_params.action_add,
			},
			dataType: "json",
			beforeSend: function () {},
			success: function (res) {
				t.find(".loader").hide();

				// check for error or if field already exists
				if (
					res.error ||
					endpoints_container.find('[data-id="' + res.field + '"]')
						.length
				) {
					swal.fire({
						customClass:
							"user-registration-swal2-modal user-registration-swal2-modal--center",
						type: "error",
						title: "Oops...",
						text: res.error,
					});
					return;
				} else {
					swal.fire({
						customClass:
							"user-registration-swal2-modal user-registration-swal2-modal--center",
						type: "success",
						html:
							answers.toUpperCase() +
							" " +
							urcma_params.add_endpoint_success_message,
					}).then(function (result) {
						$(".button-primary").trigger("click");
					});
				}

				var new_content = $(res.html);
				var fields_panel = $(".urcma-endpoints-options-wrapper");
				$(
					".urcma-endpoint-tabs > .urcma-endpoint-selector"
				).removeClass("active");
				fields_panel
					.find(".urcma-endpoint-content")
					.attr("style", "display:none;");
				var drag_label =
					'<div class="ur-sidebar-nav-tab urcma-endpoint-selector ui-sortable-handle active" id="' +
					res.field +
					'" data-id="' +
					res.endpoint_label +
					'" data-type="' +
					res.type +
					'">\n' +
					res.endpoint_label +
					"</div>";
				$(".urcma-endpoint-tabs > .urcma-endpoint-selector")
					.last()
					.after(drag_label);
				$(".urcma-endpoints-options-wrapper .urcma-endpoint-content")
					.last()
					.after(new_content);

				var new_item_id = res.field;
				fields_panel
					.find(".urcma-endpoint-content .urcma-endpoint-header")
					.attr("style", "display:none;");
				fields_panel
					.find("#" + new_item_id)
					.find(".urcma-endpoint-header")
					.removeAttr("style");
				fields_panel
					.find("#" + new_item_id)
					.find(".urcma-endpoint-options")
					.removeAttr("style");

				// reinit select
				applySelect2(new_content.find("select"));
				init_tinyMCE(new_content.find("textarea").attr("id"));
			},
		});
	};

	/**********************
	 *  Remove Endpoints
	 **********************/

	$(document).on("click", ".remove-trigger", function () {
		var t = $(this),
			endpoint = t.data("endpoint"),
			remove_endpoint = $("input.endpoint-to-remove");

		if (typeof endpoint == "undefined" || !remove_endpoint.length) {
			return false;
		}

		var r = confirm(urcma_params.remove_alert);
		if (r == true) {
			var val_remove_endpoint = remove_endpoint.val(),
				remove_endpoint_array = val_remove_endpoint.length
					? val_remove_endpoint.split(",")
					: [];
			remove_endpoint_array.push(endpoint);
			// first set value
			remove_endpoint.val(remove_endpoint_array.join(","));

			// then remove field
			$("#" + endpoint).remove();
			$(".urcma-endpoints-wrapper")
				.find("#" + endpoint)
				.remove();
			var fields_panel = $(".urcma-endpoints-options-wrapper");
			var first_item = $(".urcma-endpoint-selector:first");
			first_item.addClass("active");
			var first_item_id = first_item.attr("id");
			fields_panel
				.find(".urcma-endpoint-content .urcma-endpoint-header")
				.attr("style", "display:none;");
			fields_panel.find("#" + first_item_id).removeAttr("style");
			fields_panel
				.find("#" + first_item_id)
				.find(".urcma-endpoint-header")
				.removeAttr("style");
			fields_panel
				.find("#" + first_item_id)
				.find(".urcma-endpoint-options")
				.removeAttr("style");
		} else {
			return false;
		}
	});

	/********************************************
	 *  Append form settings to fields section.
	 ********************************************/

	$(document).ready(function () {
		var fields_panel = $(".urcma-endpoints-options-wrapper");
		var form_settings_section = $(".urcma-endpoints-list nav");

		var first_item = $(".urcma-endpoint-selector:first");
		first_item.addClass("active");
		var first_item_id = first_item.attr("id");
		fields_panel
			.find(".urcma-endpoint-content .urcma-endpoint-header")
			.attr("style", "display:none;");
		fields_panel
			.find("#" + first_item_id)
			.find(".urcma-endpoint-header")
			.removeAttr("style");
		fields_panel
			.find("#" + first_item_id)
			.find(".urcma-endpoint-options")
			.removeAttr("style");

		form_settings_section
			.find(".urcma-endpoint-selector")
			.on("click", function () {
				var this_id = $(this).attr("id");

				// Remove all active classes initially.
				$(this).siblings().removeClass("active");

				// Add active class on clicked tab.
				$(this).addClass("active");

				// Hide other settings and show respective id's settings.
				fields_panel
					.find(".urcma-endpoint-content")
					.attr("style", "display:none;");
				fields_panel.find("#" + this_id).removeAttr("style");
				fields_panel
					.find(".urcma-endpoint-content .urcma-endpoint-header")
					.removeAttr("style");
				fields_panel
					.find("#" + this_id)
					.find(".urcma-endpoint-options")
					.removeAttr("style");
			});
	});

	/****************************
	 *  Hide or show endpoint
	 ****************************/

	var onoff_field = function (trigger, elem) {
		var item = elem.closest(".urcma-endpoint-content"),
			all_check = item.find(".hide-show-check"),
			check = trigger == "checkbox" ? elem : all_check.first(),
			// set checkbox status
			checked =
				(check.is(":checked") && trigger == "checkbox") ||
				(!check.is(":checked") && trigger == "link")
					? true
					: false;

		if (true === checked) {
			all_check.prop("checked", checked);
			all_check
				.closest(".urcma-endpoint-header-option")
				.find(".user-registration-switch__control")
				.addClass("enabled");
			all_check
				.closest(".urcma-endpoint-header-option")
				.find("label")
				.html(urcma_params.enable_endpoint);
		} else {
			all_check.removeAttr("checked", checked);
			all_check
				.closest(".urcma-endpoint-header-option")
				.find(".user-registration-switch__control")
				.removeClass("enabled");
			all_check
				.closest(".urcma-endpoint-header-option")
				.find("label")
				.html(urcma_params.disable_endpoint);
		}
	};

	/**********************************
	 *  Event listener for hide/show
	 **********************************/

	$(document).on("change", ".hide-show-check", function () {
		onoff_field("checkbox", $(this));
	});

	/********************************
	 * Enable same slug validation
	 ********************************/

	$(document).on("change keyup", ".urcma_slug_input", function () {
		var current_ele = $(this);

		$(".urcma-endpoint-options")
			.find(".urcma_slug_input")
			.each(function (i, elem) {
				var $elem = $(elem);

				if (!$elem.is(current_ele)) {
					if ($.trim($elem.val()) === $.trim(current_ele.val())) {
						swal.fire({
							customClass:
								"user-registration-swal2-modal user-registration-swal2-modal--center",
							type: "error",
							title: "Oops...",
							text: urcma_params.same_slug_error_message,
						});
						$(".swal2-confirm").on("click", function () {
							$(".submit")
								.find(".button-primary")
								.attr("disabled", "disabled");
						});
					}
					return;
				}
			});

		$(".submit").find(".button-primary").removeAttr("disabled");
	});

	/********************************
	 * Enable same label validation
	 ********************************/

	$(document).on("change keyup", ".urcma_label_input", function () {
		var current_ele = $(this);

		$(".urcma-endpoint-options")
			.find(".urcma_label_input")
			.each(function (i, elem) {
				var $elem = $(elem);

				if (!$elem.is(current_ele)) {
					if ($.trim($elem.val()) === $.trim(current_ele.val())) {
						swal.fire({
							customClass:
								"user-registration-swal2-modal user-registration-swal2-modal--center",
							type: "error",
							title: "Oops...",
							text: urcma_params.same_label_error_message,
						});
						$(".swal2-confirm").on("click", function () {
							$(".submit")
								.find(".button-primary")
								.attr("disabled", "disabled");
						});
						return;
					}
				}
			});

		$(".submit").find(".button-primary").removeAttr("disabled");
	});

	/**************************************
	 * Initialize applyselect2 on select
	 **************************************/

	function format(icon) {
		return $(
			'<span><i class="fa fa-' +
				icon.text +
				'"></i>   ' +
				icon.text +
				"</span>"
		);
	}
	function applySelect2(select, is_endpoint) {
		if (typeof $.fn.select2 != "undefined") {
			var data;
			$.each(select, function () {
				// build data
				if ($(this).hasClass("icon-select")) {
					data = {
						templateResult: format,
						templateSelection: format,
						width: "100%",
					};
				} else if (is_endpoint) {
					data = {
						width: "100%",
					};
				} else {
					data = {
						minimumResultsForSearch: 10,
					};
				}

				$(this).select2(data);
			});
		}
	}

	applySelect2(endpoints_container.find("select"), true);
});
