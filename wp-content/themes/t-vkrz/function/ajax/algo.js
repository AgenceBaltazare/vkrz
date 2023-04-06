// ALGORITHM FUNCTIONS
function get_contenders_top_3_2(contenders) {
  const listInf1 = [];
  const listContenders = contenders;

  listContenders.forEach(contender => {
    if ((contender.less_to).length === 0) {
      listInf1.push(contender.id_wp);
    }
  });

  contenders = listContenders;

  return listInf1;
}

function get_contenders_top_3_3(contenders) {
  const listInf2 = [];
  const listContenders = contenders;

  listContenders.forEach(contender => {
    if (contender.less_to && contender.less_to.length === 1) {
      listInf2.push(contender.id_wp);
    }
  });

  return listInf2;
}

function get_contenders_top_3_4(contenders) {
  const listInf3 = [];
  const listContenders = contenders;

  listContenders.forEach(contender => {
    if (contender.less_to && contender.less_to.length === 2) {
      listInf3.push(contender.id_wp);
    }
  });

  return listInf3;
}

function get_steps(timelineVotes) {

  var randomInt = Math.floor(Math.random() * 4) + 3;

  const currentStep = timelineVotes * 5 + randomInt;

  if (currentStep >= 100) {
    const currentStep = "98";
  }

  return currentStep;
}

function do_vote(idWinner, idLooser) {

  let alreadySupTo = [];
  let alreadyInfTo = [];
  let listContenders = contenders;

  let listSupToL;
  let listInfToV;

  listContenders.forEach((contender, key) => {
    if (contender.more_to.includes(idWinner)) {
      alreadySupTo.push(idWinner);
    }
    if (contender.less_to.includes(idLooser)) {
      alreadyInfTo.push(idLooser);
    }
  });

  if (idWinner) {
    alreadySupTo.push(idWinner);

    listSupToL = contenders.find(item => item.id_wp == idLooser).more_to;

    if (timelineMain === 1) {
      listWR.push(idWinner);
    }
  }

  if (idLooser) {
    alreadyInfTo.push(idLooser);

    listInfToV = contenders.find(item => item.id_wp == idWinner).less_to;

    if (timelineMain === 1) {
      listLR.push(idLooser);
    }
  }

  [...new Set(alreadySupTo)].forEach((k) => {
    let toUpSupTo = contenders.find(item => item.id_wp == k).more_to;

    toUpSupTo.push(idLooser);

    let totalSupTo = [...listSupToL, ...toUpSupTo];
    contenders.find(item => item.id_wp == k).more_to = [...new Set(totalSupTo)];

    let countSupOf = contenders.find(item => item.id_wp == k).more_to.length;
    let newPlace = countSupOf;

    let countInfOf = contenders.find(item => item.id_wp == k).less_to.length;
    let ratio = countSupOf - countInfOf;

    contenders.find(item => item.id_wp == k).place = newPlace;
    contenders.find(item => item.id_wp == k).ratio = ratio;
  });

  [...new Set(alreadyInfTo)].forEach((k) => {
    let toUpInfTo = contenders.find(item => item.id_wp == k).less_to;

    toUpInfTo.push(idWinner);

    let totalInfTo = [...listInfToV, ...toUpInfTo];
    contenders.find(item => item.id_wp == k).less_to = [...new Set(totalInfTo)];

    let countSupOf = contenders.find(item => item.id_wp == k).more_to.length;

    let countInfOf = contenders.find(item => item.id_wp == k).less_to.length;
    let ratio = countSupOf - countInfOf;

    contenders.find(item => item.id_wp == k).ratio = ratio;
  });

  contenders = listContenders;

  timelineVotes++;

}

function get_next_duel(contenders, typeTop) {
  
  let nextDuel = [];
  let isNextDuel = true;
  let contender1 = 0;
  let contender2 = 0;

  let listContenders = contenders;

  let nbContenders = listContenders.length;
  let spaire;
  if (nbContenders % 2 == 0) 
    spaire = 5; // Paire
  else 
    spaire = 6; // Impaire

  if(typeTop === "top3") {
    let halfInf = Math.floor(nbContenders / 2);
    let halfSup = Math.round((nbContenders / 2), 0.5);

    if (timelineMain === 1) {

      if (timelineVotes === halfInf) {
        console.log(timelineVotes, halfInf)
        timelineMain = 2;
      } else {
        let keyC1 = nbContenders - (1 + timelineVotes);
        let keyC2 = nbContenders - (1 + halfInf + timelineVotes);

        nextDuel.push(contenders.find(item => item.id == keyC1).id_wp);
        nextDuel.push(contenders.find(item => item.id == keyC2).id_wp);

        console.log("keyC1", keyC1, "keyC2", keyC2);
      }

    }

    if (timelineMain === 2) {
      let listInf1 = get_contenders_top_3_2(contenders);
      let nbListInf1 = listInf1.length;
      let random = Math.floor(Math.random() * (nbListInf1 - 1)) + 2;

      if (nbListInf1 === 1) {
        timelineMain = 3;
      } else {
        let keyC1 = listInf1[random - 2];
        let keyC2 = listInf1[random - 1];
        nextDuel.push(keyC1);
        nextDuel.push(keyC2);

        // console.log("keyC1", keyC1, "keyC2", keyC2);
      }
    }

    if (timelineMain === 3) {
      let listInf2 = get_contenders_top_3_3(contenders);
      let nbListInf2 = listInf2.length;
      let random = Math.floor(Math.random() * (nbListInf2 - 1)) + 2;

      if (nbListInf2 === 1) {
        timelineMain = 4;
      } else {
        let keyC1 = listInf2[random - 2];
        let keyC2 = listInf2[random - 1];
        nextDuel.push(keyC1);
        nextDuel.push(keyC2);
      }
    }

    if (timelineMain === 4) {
      let listInf3 = get_contenders_top_3_4(contenders);
      let nbListInf3 = listInf3.length;
      let random = Math.floor(Math.random() * (nbListInf3 - 1)) + 2;

      if (nbListInf3 < 2) {
        isNextDuel = false;
        // document.querySelector("#generation").classList.add("d-block");
      } else {
        let keyC1 = listInf3[random - 2];
        let keyC2 = listInf3[random - 1];
        nextDuel.push(keyC1);
        nextDuel.push(keyC2);
      }
    }
  } else {
    // TOP COMPLET
  }

  if (isNextDuel) {
    let val1 = Math.floor(Math.random() * 2);
    let val2 = val1 === 0 ? 1 : 0;
    contender1 = nextDuel[val1];
    contender2 = nextDuel[val2];
  }
  else {
    
    const ranking = [];
    contenders.sort((a, b) => (a.place < b.place) ? 1 : -1);
    contenders.forEach((c) => {
      if (ranking.length < 3) ranking.push(c.id_wp);
      
    });

    // apiCreateRanking(ID_TOP, ranking, timelineVotes).then(function (r) {
    //   setTimeout(() => {
    //     window.location = BASE_RELPATH + "/result/?r=" + r.public_id;
    //   }, 2000);
    // });
  }

  let currentStep = get_steps(timelineVotes);

  contenders = listContenders;

  return {
    isNextDuel,
    contender1,
    contender2,
    currentStep,
    timelineMain,
    // nbUserVotes,
    // nbContenders,
    // idTop,
    // idRanking,
    // userId
  };
}

// DO USER RANKING
function do_user_ranking(idWinner, idLooser, typeTop) {
  do_vote(idWinner, idLooser);
  return get_next_duel(contenders, typeTop);
}

export {
  get_next_duel,
  do_user_ranking,
};