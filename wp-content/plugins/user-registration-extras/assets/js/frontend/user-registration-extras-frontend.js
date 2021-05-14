/**
 * UserRegistrationExtrasPopup JS
 * global user_registration_extras_frontend_data
 */

"use strict";

(function ($) {
	// Hide the menu item for logged in users.
	$(document).ready(function () {
		if (
			user_registration_extras_frontend_data.has_create_user_capability &&
			user_registration_extras_frontend_data.is_user_logged_in
		) {
			$(document).find(".user-registration-modal-link").show();
		} else if (
			!user_registration_extras_frontend_data.has_create_user_capability &&
			user_registration_extras_frontend_data.is_user_logged_in
		) {
			$(document).find(".user-registration-modal-link").hide();
		}
	});

	// Change Cursor to pointer when modal link is hovered.
	$(document).on("hover", ".user-registration-modal-link", function (e) {
		$(".user-registration-modal-link").css("cursor", "pointer");
	});

	// When user clicks on the menu item open the popup.
	$(document).on("click", ".user-registration-modal-link", function (e) {
		e.preventDefault();
		var classes = $.map($(this)[0].classList, function (cls, i) {
			if (cls.indexOf("user-registration-modal-link-") === 0) {
				var popup_id = cls.replace("user-registration-modal-link-", "");

				$(".user-registration-modal-" + popup_id).each(function () {
					if (0 === $(this).parents(".entry-content").length) {
						$(this).show();
					}
				});

				// Add user-registration-modal-open class to body when popup is rendered on menu click.
				$(document.body).addClass("user-registration-modal-open");
			}
		});
	});

	// Catch submit event and store values in localStorage so that error can be shown in that specific login form.
	$(".ur-frontend-form.login").on("submit", function () {
		if ($(this).closest(".user-registration-modal").length) {
			var classes = $.map(
				$(this).closest(".user-registration-modal")[0].classList,
				function (cls, i) {
					if (cls.indexOf("user-registration-modal-") === 0) {
						var popup_id = cls.replace(
							"user-registration-modal-",
							""
						);

						var ur_popup_details = {};
						ur_popup_details["popup_id"] = popup_id;

						if (
							$(".user-registration-modal-" + popup_id).closest(
								".entry-content"
							).length
						) {
							ur_popup_details["inner_popup"] = true;
						} else {
							ur_popup_details["inner_popup"] = false;
						}

						localStorage.setItem(
							"ur_extras_popup",
							JSON.stringify(ur_popup_details)
						);
					}
				}
			);
		} else {
			localStorage.removeItem("ur_extras_popup");
		}
	});

	// Add user-registration-modal-open class to body when popup is rendered from shortcode.
	$(".user-registration-modal").ready(function () {
		if ($(".entry-content").find(".user-registration-modal").length) {
			$(document.body).addClass("user-registration-modal-open");
		}

		var popup_details = JSON.parse(localStorage.getItem("ur_extras_popup"));

		if (popup_details && popup_details.popup_id) {
			var popup_id = popup_details.popup_id,
				popup_div = $(".user-registration-modal-" + popup_id);

			if ($(".entry-content").find(".ur-frontend-form.login").length) {
				$(".entry-content")
					.find(".ur-frontend-form.login")
					.each(function () {
						if (
							$(this)
								.closest("body")
								.find(".entry-content .user-registration-error")
								.length
						) {
							if (true === popup_details.inner_popup) {
								$(this)
									.closest("body")
									.find(".entry-content")
									.find(".user-registration-error")
									.prependTo(
										popup_div.find(".user-registration")
									);
							} else {
								$(this)
									.closest(".user-registration")
									.find(".user-registration-error")
									.prependTo(
										popup_div.find(".user-registration")
									);
							}
							$(this)
								.closest("body")
								.find(".user-registration-modal")
								.hide();
							popup_div.show();
						}
					});
			} else {
				$(".user-registration-modal")
					.find(".ur-frontend-form.login")
					.each(function () {
						if (
							$(this).siblings(".user-registration-error").length
						) {
							$(this)
								.closest(".user-registration")
								.find(".user-registration-error")
								.prependTo(
									popup_div.find(".user-registration")
								);
						}
						$(this)
							.closest("body")
							.find(".user-registration-modal")
							.hide();
						popup_div.show();
					});
			}

			localStorage.removeItem("ur_extras_popup");

			// Add user-registration-modal-open class to body when popup is rendered on menu click.
			$(document.body).addClass("user-registration-modal-open");
		}
	});

	// When the user clicks on <span> (x), close the modal
	$(document).on(
		"click",
		".user-registration-modal__close-icon, .user-registration-modal__backdrop",
		function () {
			$(this)
				.closest(".user-registration-modal")
				.css({ display: "none", opacity: "1" });

			// Remove user-registration-modal-open class from body when popup is closed.
			$(document.body).removeClass("user-registration-modal-open");
		}
	);

	// Code for Delete Account Feature
	var delete_account_option =
		user_registration_extras_frontend_data.delete_account_option;

	if (
		"undefined" !== delete_account_option &&
		"disable" !== delete_account_option
	) {
		$(document).on(
			"click",
			".user-registration-MyAccount-navigation-link--delete-account",
			function () {
				// var icon = '<i class="dashicons dashicons-trash"></i>';
				var title =
					'<span class="user-registration-swal2-modal__title">' +
					user_registration_extras_frontend_data.delete_account_popup_title;

				swal.fire({
					title: title,
					html:
						user_registration_extras_frontend_data.delete_account_popup_html,
					confirmButtonText:
						user_registration_extras_frontend_data.delete_account_button_text,
					confirmButtonColor: "#FF4149",
					showConfirmButton: true,
					showCancelButton: true,
					cancelButtonText:
						user_registration_extras_frontend_data.cancel_button_text,
					customClass: {
						container: "user-registration-swal2-container",
					},
					focusConfirm: false,
					showLoaderOnConfirm: true,
					preConfirm: function () {
						return new Promise(function (resolve) {
							var data = "";
							if ("prompt_password" === delete_account_option) {
								var password = Swal.getPopup().querySelector(
									"#password"
								).value;

								if (!password) {
									Swal.showValidationMessage(
										user_registration_extras_frontend_data.please_enter_password
									);

									$(".swal2-actions").removeClass(
										"swal2-loading"
									);
									$(".swal2-actions")
										.find("button")
										.prop("disabled", false);
								} else {
									data = {
										action:
											"user_registration_extras_delete_account",
										password: password,
									};
								}
							} else {
								data = {
									action:
										"user_registration_extras_delete_account",
								};
							}
							if ("" !== data) {
								$.ajax({
									url:
										user_registration_extras_frontend_data.ajax_url,
									method: "POST",
									data: data,
								}).done(function (response) {
									if (response.success) {
										Swal.fire({
											type: "success",
											title:
												user_registration_extras_frontend_data.account_deleted_message,
											customClass:
												"user-registration-swal2-modal user-registration-swal2-modal--center",
											showConfirmButton: false,
											timer: 1000,
										}).then(function (result) {
											window.location.reload();
										});
									} else {
										Swal.showValidationMessage(
											response.data.message
										);
										$(".swal2-actions").removeClass(
											"swal2-loading"
										);
										$(".swal2-actions")
											.find("button")
											.prop("disabled", false);
									}
								});
							}
						});
					},
				});
				return false;
			}
		);
	}
})(jQuery);
