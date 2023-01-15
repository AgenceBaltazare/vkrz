import {
  collection,
  addDoc,
  database,
  fetchDataFuncHelper,
  
} from "./config.js";

// CHECK PARRAINAGE COOKIES
function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(";");
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
if (getCookie("wordpress_parrainage_cookies")) {
  // GET COOKIES DATA
  let cookies    = JSON.parse(getCookie("wordpress_parrainage_cookies")),
      referral   = cookies.referral,
      referredTo = cookies.referredTo;

  if (currentUuid == referral) {
    referral = await fetchDataFuncHelper(`http://vainkeurz.local/wp-json/vkrz/v1/getuserinfo/${referral}`);
    referredTo = await fetchDataFuncHelper(`http://vainkeurz.local/wp-json/vkrz/v1/getuserinfo/${referredTo}`);

    // SEND NOTIF
    async function sendNotification(
      userId,
      uuid,
      relatedId,
      relatedUuid,
      notifText,
      notifLink,
      notifType
    ) {
      try {
        const newRankingFollow = await addDoc(
          collection(database, "notifications"),
          {
            userId: userId,
            uuid: uuid,
            relatedId: relatedId,
            relatedUuid: relatedUuid,
            notifText: notifText,
            notifLink: notifLink,
            notifType: notifType,
            statut: "nouveau",
            createdAt: new Date(),
          }
        );
        console.log(
          "Parrainage notification sent with ID: ",
          newRankingFollow.id
        );
      } catch (error) {
        console.error("Error adding document: ", error);
      }
    }
    await sendNotification(
      referral.id_user,
      referral.uuid_vainkeur,
      referredTo.id_user,
      referredTo.uuid_vainkeur,
      `${referral.pseudo} a utilisé ton code de parrainage!`,
      referral.profil_url,
      "Parrainage"
    );
    
    // REMOVE COOKIE
    document.cookie =
      "wordpress_parrainage_cookies=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 UTC";
  }
}
