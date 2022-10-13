import {
  collection,
  getDocs,
  deleteDoc,
  doc,
  query,
  where,
  orderBy,
  addDoc,
  database,
} from "./config.js";

// SEND NOTIFICATION FUNCTION…
async function sendNotification(
  userId,
  uuid,
  relatedId,
  relatedUuid,
  notifText,
  notifLink,
  notifType,
  extendedData
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
        extendedData: extendedData,
        statut: "nouveau",
        createdAt: new Date(),
      }
    );
    console.log(
      "Notification sent to follower with ID: ",
      newRankingFollow.id
    );
  } catch (error) {
    console.error("Error adding document: ", error);
  }
}

function callMe(name) {
  alert(`Hello ${name} :)`);
}