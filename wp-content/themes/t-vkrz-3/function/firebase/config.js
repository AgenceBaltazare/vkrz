import {
  initializeApp
} from "https://www.gstatic.com/firebasejs/9.8.1/firebase-app.js";
const firebaseConfig = {
  apiKey: "AIzaSyDX3AkehDOsSpznrUG_mXRJBY_jkBeLCds",
  authDomain: "vainkeurz-48eb4.firebaseapp.com",
  databaseURL: "https://vainkeurz-48eb4-default-rtdb.europe-west1.firebasedatabase.app",
  projectId: "vainkeurz-48eb4",
  storageBucket: "vainkeurz-48eb4.appspot.com",
  messagingSenderId: "915310626932",
  appId: "1:915310626932:web:3a2118ed2a1551af3d2921",
  measurementId: "G-BGB5H22QLZ"
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