$(document).ready(function ($) {

  let ajaxRunning = false;

  $(document).on('click', '#follow_btn', {}, function (e) {

    e.preventDefault();

    var btn_follow = $(this);
    var id_user = btn_follow.data('userid');
    var uuiduser = btn_follow.data('uuid');
    var relation_uuid = btn_follow.data('related');
    var notif_text = btn_follow.data('text');
    var liens_vers = btn_follow.data('url');

    btn_follow.html('Suivi! 😉');
    btn_follow.addClass('btn-outline-success');
    btn_follow.attr("disabled", true);

    if (!ajaxRunning) {
      ajaxRunning = true;
      $.ajax({
        method: "POST",
        url: vkrz_ajaxurl,
        data: {
          action: 'vkzr_do_notification',
          id_user: id_user,
          uuiduser: uuiduser,
          relation_uuid: relation_uuid,
          notif_text: notif_text,
          liens_vers: liens_vers,
        }
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