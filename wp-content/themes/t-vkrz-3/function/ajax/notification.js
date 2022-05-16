$(document).ready(function ($) {
  let ajaxRunning = false;

  $(document).on("click", "#follow_btn", {}, function (e) {
    e.preventDefault();

    var btn_follow = $(this);
    var id_user = btn_follow.data("userid");
    var uuiduser = btn_follow.data("uuid");
    var relation_id = btn_follow.data("relatedid");
    var relation_uuid = btn_follow.data("related");
    var notif_text = btn_follow.data("text");
    var liens_vers = btn_follow.data("url");

    btn_follow.html("Suivi! 😉");
    btn_follow.addClass("btn-outline-success");
    btn_follow.attr("disabled", true);

    console.log(relation_id);

    if (!ajaxRunning) {
      ajaxRunning = true;
      $.ajax({
        method: "POST",
        url: vkrz_ajaxurl,
        data: {
          action: "vkzr_do_notification",
          id_user: id_user,
          uuiduser: uuiduser,
          relation_id: relation_id,
          relation_uuid: relation_uuid,
          notif_text: notif_text,
          liens_vers: liens_vers,
        },
      })
        .done(function (response) {
          console.log(response);
        })
        .always(function () {
          ajaxRunning = false;
        });
    }
  });

  $(document).on("click", "#submit-comment", {}, function (e) {
    var submit_comment = $(this);
    var id_user = submit_comment.data("id_user");
    var uuiduser = submit_comment.data("uuiduser");
    var relation_id = submit_comment.data("relation_id");
    var relation_uuid = submit_comment.data("relation_uuid");
    var notif_text = submit_comment.data("notif_text");
    var liens_vers = submit_comment.data("liens_vers");

    if (id_user !== relation_id && !ajaxRunning ) {
      ajaxRunning = true;
      $.ajax({
        method: "POST",
        url: vkrz_ajaxurl,
        data: {
          action: "vkzr_do_notification",
          id_user: id_user,
          uuiduser: uuiduser,
          relation_id: relation_id,
          relation_uuid: relation_uuid,
          notif_text: notif_text,
          liens_vers: liens_vers,
        },
      })
        .done(function (response) {
          console.log(response);
        })
        .always(function () {
          ajaxRunning = false;
        });
    }
  });

  $(document).on("click", "#read-notification", {}, function (e) {
    alert('Adil');
    e.preventDefault();

    var read_notification = $(this);
    var id_notification = read_notification.data("id_notification");
    
    if (!ajaxRunning ) {
      ajaxRunning = true;
      $.ajax({
        method: "POST",
        url: vkrz_ajaxurl,
        data: {
          action: "vkzr_read_notification",
          id_notification: id_notification
        },
      })
        .done(function (response) {
          console.log(response);
        })
        .always(function () {
          ajaxRunning = false;
        });
    }
  });
});
