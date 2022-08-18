import {
  initializeApp
} from "https://www.gstatic.com/firebasejs/9.8.1/firebase-app.js";
const firebaseConfig = {
  apiKey: "AIzaSyCba6lgfmSJsZg02F9djkZB8mcuprgZSeI",
  authDomain: "vainkeurz---dev.firebaseapp.com",
  databaseURL: "https://vainkeurz---dev-default-rtdb.europe-west1.firebasedatabase.app",
  projectId: "vainkeurz---dev",
  storageBucket: "vainkeurz---dev.appspot.com",
  messagingSenderId: "627334561477",
  appId: "1:627334561477:web:cb476e53ad67bc5954faac"
};
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
};