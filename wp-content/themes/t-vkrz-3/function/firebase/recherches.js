import {
  collection,
  database,
  addDoc
} from "./config.js";

if(document.querySelector('.recherche-firestore')) {
  const container     = document.querySelector('.recherche-firestore'),
        lama2lombre   = container.dataset.lama2lombre,
        userId        = container.dataset.userid,
        userName      = container.dataset.username,
        uuid          = container.dataset.uuid,
        searchedTerm  = container.dataset.searchedterm,
        resultsNumber = container.dataset.resultsnumber;

  (async function() {
    try {
      const newSearch = await addDoc(
        collection(database, "recherches"), {
          guest: lama2lombre,
          userId: userId,
          userName: userName,
          uuid: uuid,
          searchedTerm: searchedTerm,
          resultsNumber: resultsNumber,
          createdAt: new Date(),
        }
      );
      console.log(
        "Document sent with ID: ",
        newSearch.id
      );
    } catch (error) {
      console.error("Error adding document: ", error);
    }
  })();
}