import {
  collection,
  addDoc,
  database,
} from "http://localhost:8888/vkrz/wp-content/themes/t-vkrz-3/function/firebase/config.js";

const commentBtn  = document.querySelector('#submit-comment'),
      replyData   = document.querySelector('#replyData'),
      commentData = document.querySelector('#commentData')
commentBtn.addEventListener('click', function() {
  async function sendCommentNotificationToTopCreator() {
    let userId, uuid, relatedId, relatedUuid, notifText, notifLink, notifType;

    /* CHECK IF IT IS ABOUT A COMMENT OR REPLY… 😎 */
    if (document.querySelector('#comment_parent').value) {
      // REPLY…
      userId = replyData.dataset.userid;
      uuid = replyData.dataset.uuid;
      relatedId = replyData.dataset.relatedid;
      relatedUuid = replyData.dataset.relateduuid;
      notifText = `${replyData.dataset.notiftext} a répondu à ton commentaire!`;
      notifLink = replyData.dataset.notiflink;
      notifType = 'Comment Reply Notification';

      if (userId == "0") {
        notifText = "Un anonyme a répondu a ton commentaire!"
      }
    } else {
      // COMMENT…
      userId = commentData.dataset.userid;
      uuid = commentData.dataset.uuid;
      relatedId = commentData.dataset.relatedid;
      relatedUuid = commentData.dataset.relateduuid;
      notifText = `${commentData.dataset.notiftext} a commenté sur ton Top!`;
      notifLink = commentData.dataset.notiflink;
      notifType = 'Comment Reply Notification';

      if (userId == "0") {
        notifText = "Un anonyme a commenté sur ton Top!"
      }
    }

    try {
      const newCommentNotification = await addDoc(collection(database, "notifications"), {
        userId: userId,
        uuid: uuid,
        relatedId: relatedId,
        relatedUuid: relatedUuid,
        notifText: notifText,
        notifLink: notifLink,
        notifType: notifType,
        statut: 'nouveau',
        createdAt: new Date()
      });
      console.log("Notification sent with ID: ", newCommentNotification.id);
    } catch (error) {
      console.error("Error adding document: ", error);
    }
  }
  sendCommentNotificationToTopCreator()
})