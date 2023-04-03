import {
  collection,
  getDocs,
  addDoc,
  query,
  where,
  database,
  sortContendersFuncHelper,
  calcResemblanceFuncHelper,
  fetchDataFuncHelper
} from "../firebase/config.js";

  document.querySelector('.begin_t_js').addEventListener('click', async (e) => {

    const TOP = await fetchDataFuncHelper(`/wp-json/vkrz/v1/initclassement/${id_top}/${id_user}/`);

    console.log(TOP)

    // DECLARE VARIABLES
    let timelineVotes = 0;
    let timelineMain = 1;
    let listWR = [];
    let listLR = [];
    let contenders = TOP[0].ranking;
    let alreadyVoted = false;

    console.log(contenders)
    
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
        console.log("il est un top3")
        if (timelineMain === 1) {
          if (timelineVotes === 5) {
            timelineMain = 2;
          } else {
            let keyC1 = nbContenders - (1 + timelineVotes);
            let keyC2 = nbContenders - (1 + 5 + timelineVotes);

            console.log(contenders.find(item => item.id == keyC1).id_wp)
            console.log(contenders.find(item => item.id == keyC2).id_wp)

            nextDuel.push(contenders.find(item => item.id == keyC1).id_wp);
            nextDuel.push(contenders.find(item => item.id == keyC2).id_wp);
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
    function do_user_ranking(idWinner, idLooser) {
      do_vote(idWinner, idLooser);
      return get_next_duel(contenders);
    }

    // KEYUP EVENTS
    window.addEventListener('keyup', function (e) {
      if (e.keyCode === 37 && alreadyVoted === false) {
        document.querySelector('#c_1').click();
        alreadyVoted = true;
      } else if (e.keyCode === 39 && alreadyVoted === false) {
        document.querySelector('#c_2').click();
        alreadyVoted = true;
      }
    });

    $(".contender_zone").removeClass("animate__zoomIn");
    $(".contender_zone").removeClass("animate__slideInDown");
    $(".contender_zone").removeClass("animate__slideInUp");

    const typeTop = document.querySelector('.begin_t_js').dataset.typetop;

    console.log(typeTop)

    // FIRST DUEL
    const firstDuel = get_next_duel(contenders, typeTop);
    console.log(firstDuel)

    const firstDuelContenderOneId = firstDuel.contender1;
    const firstDuelContenderTwoId = firstDuel.contender2;

    const firstDuelContenderOneIdData = contenders.find(item => item.id_wp === firstDuelContenderOneId);
    const firstDuelContenderTwoIdData = contenders.find(item => item.id_wp === firstDuelContenderTwoId);

    document.querySelector('#cover_contender_1').src = firstDuelContenderOneIdData.cover;
    document.querySelector('#cover_contender_2').src = firstDuelContenderTwoIdData.cover;

    document.querySelector('#c_1').dataset.idwinner = firstDuelContenderOneIdData.id_wp;
    document.querySelector('#c_1').dataset.idlooser = firstDuelContenderTwoIdData.id_wp;

    document.querySelector('#c_2').dataset.idwinner = firstDuelContenderTwoIdData.id_wp;
    document.querySelector('#c_2').dataset.idlooser = firstDuelContenderOneIdData.id_wp;

    document.querySelector('#name_contender_1').innerHTML = firstDuelContenderOneIdData.name;
    document.querySelector('#name_contender_2').innerHTML = firstDuelContenderTwoIdData.name;

    $("#c_1").addClass("animate__slideInDown");
    $("#c_2").addClass("animate__slideInUp");

    // NEXT DUEL
    const contendersDOM = document.querySelectorAll('.link-contender');
    contendersDOM.forEach(contender => {

      contender.addEventListener('click', function (e) {

        $("#c_1").removeClass("animate__slideInDown");
        $("#c_2").removeClass("animate__slideInUp");

        e.preventDefault();

        const target = e.target.closest('.contenders_min');

        const contenderIdWinner = target.dataset.idwinner;
        const contenderIdLooser = target.dataset.idlooser;

        if (target.id === "c_1") {
          $("#c_1").addClass("vainkeurz");
          $("#c_1").addClass("animate__headShake");
          $("#c_2").addClass("animate__fadeOutDown");
        } else if (target.id === "c_2") {
          $("#c_2").addClass("vainkeurz");
          $("#c_2").addClass("animate__headShake");
          $("#c_1").addClass("animate__fadeOutDown");
        }

        setTimeout(() => {

          $(".contender_zone").removeClass("animate__zoomIn");
          $(".contender_zone").removeClass("animate__slideInDown");
          $(".contender_zone").removeClass("animate__slideInUp");

          $(".contender_zone").removeClass("vainkeurz");
          $(".contender_zone").removeClass("animate__headShake");
          $(".contender_zone").removeClass("animate__fadeOutDown");

          const duel = do_user_ranking(contenderIdWinner, contenderIdLooser);

          if (!duel.isNextDuel) return;

          document.querySelector('.stepbar').style.width = `${duel.currentStep}%`;
          document.querySelector('.stepbar-content span').textContent = `${duel.currentStep} %`;

          const firstDuelContenderOneId = duel.contender1;
          const firstDuelContenderTwoId = duel.contender2;

          const firstDuelContenderOneIdData = contenders.find(item => item.id_wp === firstDuelContenderOneId);
          const firstDuelContenderTwoIdData = contenders.find(item => item.id_wp === firstDuelContenderTwoId);

          document.querySelector('#cover_contender_1').src = firstDuelContenderOneIdData.cover;
          document.querySelector('#cover_contender_2').src = firstDuelContenderTwoIdData.cover;

          document.querySelector('#c_1').dataset.idwinner = firstDuelContenderOneIdData.id_wp;
          document.querySelector('#c_1').dataset.idlooser = firstDuelContenderTwoIdData.id_wp;

          document.querySelector('#c_2').dataset.idwinner = firstDuelContenderTwoIdData.id_wp;
          document.querySelector('#c_2').dataset.idlooser = firstDuelContenderOneIdData.id_wp;

          document.querySelector('#name_contender_1').innerHTML = firstDuelContenderOneIdData.name;
          document.querySelector('#name_contender_2').innerHTML = firstDuelContenderTwoIdData.name;

          $("#c_1").addClass("animate__slideInDown");
          $("#c_2").addClass("animate__slideInUp");

          alreadyVoted = false;

        }, 1000);

      })

    });

  })

