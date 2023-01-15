import { initializeApp } from "https://www.gstatic.com/firebasejs/9.8.1/firebase-app.js";

let firebaseConfig;
switch (location.hostname) {
  // LOCAL
  case "localhost":
  case "127.0.0.1":
  case "vainkeurz.local":
  case "proto.vainkeurz.com":
    firebaseConfig = {
      apiKey: "AIzaSyDX3AkehDOsSpznrUG_mXRJBY_jkBeLCds",
      authDomain: "vainkeurz-48eb4.firebaseapp.com",
      databaseURL:
        "https://vainkeurz-48eb4-default-rtdb.europe-west1.firebasedatabase.app",
      projectId: "vainkeurz-48eb4",
      storageBucket: "vainkeurz-48eb4.appspot.com",
      messagingSenderId: "915310626932",
      appId: "1:915310626932:web:3a2118ed2a1551af3d2921",
      measurementId: "G-BGB5H22QLZ",
    };
    break;

  // PROD
  default:
    firebaseConfig = {
      apiKey: "AIzaSyCba6lgfmSJsZg02F9djkZB8mcuprgZSeI",
      authDomain: "vainkeurz---dev.firebaseapp.com",
      databaseURL:
        "https://vainkeurz---dev-default-rtdb.europe-west1.firebasedatabase.app",
      projectId: "vainkeurz---dev",
      storageBucket: "vainkeurz---dev.appspot.com",
      messagingSenderId: "627334561477",
      appId: "1:627334561477:web:cb476e53ad67bc5954faac",
    };
}
const app = initializeApp(firebaseConfig);

import {
  getFirestore,
  collection,
  doc,
  setDoc,
  getDoc,
  getDocs,
  addDoc,
  updateDoc,
  deleteDoc,
  query,
  where,
  limit,
  orderBy,
} from "https://cdnjs.cloudflare.com/ajax/libs/firebase/9.8.1/firebase-firestore.min.js";
const database = getFirestore(app);

// HELPERS TO EXPORT
const sortContendersFuncHelper = function (ranking) {
  let contendersArr     = [],
    contendersArrPlaces = [],
    contendersArrIDs    = [];

  for (let contender of ranking) {
    delete contender.c_name;
    delete contender.elo;
    delete contender.id;
    delete contender.less_to;
    delete contender.more_to;
    delete contender.ratio;
    delete contender.image;

    contendersArr.push(contender);
    contendersArrPlaces.push(contender.place);

    contendersArrIDs.push(contender.id_wp);
  }
  contendersArr.sort(function (a, b) {
    return b.place - a.place;
  });
  contendersArrPlaces
    .sort(function (a, b) {
      return b - a;
    })
    .reverse();
  for (let j = 0; j < contendersArr.length; j++) {
    contendersArr[j].place = contendersArrPlaces[j];
  }
  ranking = contendersArr;

  return ranking;
}

const calcResemblanceFuncHelper = function (myRanking, otherRanking, typeRanking3) {
  let numberContenders = myRanking.length,
    positionEcart,
    similaire,
    pourcentSimilaire = [],
    ressemblances = [],
    ecartRessemblance;

  if (typeRanking3 === true) {
    myRanking = myRanking.slice(0, 3);
    otherRanking = otherRanking.slice(0, 3);

    numberContenders = 3;

    myRanking.forEach((contender, index) => (contender.place = index));
    otherRanking.forEach(
      (contender, index) => (contender.place = index)
    );
  }

  for (let i = 0; i < numberContenders; i++) {
    let otherContenderPlace;
    if (
      otherRanking.find(
        (contender) => contender.id_wp === myRanking[i].id_wp
      )
    ) {
      otherContenderPlace = otherRanking.find(
        (contender) => contender.id_wp === myRanking[i].id_wp
      ).place;
      positionEcart = Math.abs(myRanking[i].place - otherContenderPlace);
      similaire = 1 / numberContenders / (positionEcart + 1);
    } else {
      otherContenderPlace = 0;
      positionEcart = Math.abs(myRanking[i].place - otherContenderPlace);
      similaire = 0;
    }

    if (typeRanking3 == true) {
      ecartRessemblance = 1 / numberContenders / (numberContenders / 2 + 1);
      pourcentSimilaire.push(similaire);
    } else {
      ecartRessemblance =
        1 / numberContenders / (Math.floor(numberContenders / 2) + 1);

      if (similaire <= ecartRessemblance) {
        similaire = 0;
        pourcentSimilaire.push(similaire);
      } else {
        pourcentSimilaire.push(similaire);
      }
    }
  }

  ressemblances.push(
    Math.round(pourcentSimilaire.reduce((a, b) => a + b, 0) * 100)
  );
  let result =
    Math.round(pourcentSimilaire.reduce((a, b) => a + b, 0) * 100) + "%";

  return result;
};

const secondsToStrFuncHelper = function (secondes) {
  function numberEnding(number) {
    return number > 1 ? "s" : "";
  }

  let temp = Math.floor(secondes / 1000);
  let years = Math.floor(temp / 31536000);
  if (years) {
    return years + " ans" + numberEnding(years);
  }
  let days = Math.floor((temp %= 31536000) / 86400);
  if (days) {
    return days + " jour" + numberEnding(days);
  }
  let hours = Math.floor((temp %= 86400) / 3600);
  if (hours) {
    return hours + " heure" + numberEnding(hours);
  }
  let minutes = Math.floor((temp %= 3600) / 60);
  if (minutes) {
    return minutes + " minute" + numberEnding(minutes);
  }
  let seconds = temp % 60;
  if (seconds) {
    return seconds + " seconde" + numberEnding(seconds);
  }
  return "moins d'une seconde"; //'just now' //or other string you like;
};

const fetchDataFuncHelper = async function (url) {
  try {
    let response = await fetch(url);
    return await response.json();
  } catch (error) {
    console.log(error);
  }
}

export {
  getFirestore,
  collection,
  doc,
  setDoc,
  getDocs,
  getDoc,
  addDoc,
  updateDoc,
  deleteDoc,
  query,
  where,
  limit,
  orderBy,
  database,
  secondsToStrFuncHelper,
  fetchDataFuncHelper,
  sortContendersFuncHelper,
  calcResemblanceFuncHelper
};