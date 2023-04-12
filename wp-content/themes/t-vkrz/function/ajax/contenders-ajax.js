import {
  collection,
  getDocs,
  addDoc,
  setDoc,
  doc,
  query,
  where,
  database,
  sortContendersFuncHelper,
  calcResemblanceFuncHelper,
  fetchDataFuncHelper
} from "../firebase/config.js";

const launchTopListBtns = document.querySelectorAll(".begin_t_js");
launchTopListBtns.forEach(btn => {

  btn.addEventListener('click', async (e) => {

    const typetop = e.target.dataset.typetop;

    console.log("id_top", id_top);
    console.log('typetop', typetop);
    console.log("iduser", iduser);
    console.log("uuiduser", uuiduser);
    console.log('id_vainkeur', id_vainkeur);

    const TOP = await fetchDataFuncHelper(
      // `https://proto.vainkeurz.com/wp-json/vkrz/v1/initclassement/${id_top}/${iduser}/${uuiduser}/${id_vainkeur}/${typetop}/`
      `http://localhost:8888/vkrz/wp-json/vkrz/v1/initclassement/${id_top}/${iduser}/${uuiduser}/${id_vainkeur}/${typetop}/`
      // `http://localhost:10004/wp-json/vkrz/v1/initclassement/${id_top}/${iduser}/${uuiduser}/${id_vainkeur}/${typetop}/`
    );

    console.log(TOP)
    // const TOP = {
    //   "ranking": [
    //       {
    //           "id": 0,
    //           "id_wp": 99,
    //           "cover": "http://localhost:8888/vkrz/wp-content/uploads/2022/06/atal-300x200.png",
    //           "elo": "1275",
    //           "c_name": "numéro 0",
    //           "more_to": [],
    //           "less_to": [],
    //           "place": 0,
    //           "ratio": 0
    //       },
    //       {
    //           "id": 1,
    //           "id_wp": 10,
    //           "cover": "http://localhost:8888/vkrz/wp-content/uploads/2022/06/liberte-300x200.png",
    //           "elo": "1268",
    //           "c_name": "numéro 1",
    //           "more_to": [],
    //           "less_to": [],
    //           "place": 0,
    //           "ratio": 0
    //       },
    //       {
    //           "id": 2,
    //           "id_wp": 20,
    //           "cover": "http://localhost:8888/vkrz/wp-content/uploads/2022/06/siege-de-boralus-300x200.png",
    //           "elo": "1250",
    //           "c_name": "numéro 2",
    //           "more_to": [],
    //           "less_to": [],
    //           "place": 0,
    //           "ratio": 0
    //       },
    //       {
    //           "id": 3,
    //           "id_wp": 30,
    //           "cover": "http://localhost:8888/vkrz/wp-content/uploads/2022/06/manoir-300x200.png",
    //           "elo": "1223",
    //           "c_name": "numéro 3",
    //           "more_to": [],
    //           "less_to": [],
    //           "place": 0,
    //           "ratio": 0
    //       },
    //       {
    //           "id": 4,
    //           "id_wp": 40,
    //           "cover": "http://localhost:8888/vkrz/wp-content/uploads/2022/06/om-300x200.png",
    //           "elo": "1219",
    //           "c_name": "numéro 4",
    //           "more_to": [],
    //           "less_to": [],
    //           "place": 0,
    //           "ratio": 0
    //       },
    //       {
    //           "id": 5,
    //           "id_wp": 50,
    //           "cover": "http://localhost:8888/vkrz/wp-content/uploads/2022/06/trefonds-300x200.png",
    //           "elo": "1207",
    //           "c_name": "numéro 5",
    //           "more_to": [],
    //           "less_to": [],
    //           "place": 0,
    //           "ratio": 0
    //       },
    //       {
    //           "id": 6,
    //           "id_wp": 60,
    //           "cover": "http://localhost:8888/vkrz/wp-content/uploads/2022/06/filon-300x200.png",
    //           "elo": "1200",
    //           "c_name": "numéro 6",
    //           "more_to": [],
    //           "less_to": [],
    //           "place": 0,
    //           "ratio": 0
    //       },
    //       {
    //           "id": 7,
    //           "id_wp": 70,
    //           "cover": "http://localhost:8888/vkrz/wp-content/uploads/2022/06/sepra-300x200.png",
    //           "elo": "1180",
    //           "c_name": "numéro 7",
    //           "more_to": [],
    //           "less_to": [],
    //           "place": 0,
    //           "ratio": 0
    //       },
    //       {
    //           "id": 8,
    //           "id_wp": 80,
    //           "cover": "http://localhost:8888/vkrz/wp-content/uploads/2022/06/repos-300x200.png",
    //           "elo": "1168",
    //           "c_name": "numéro 8",
    //           "more_to": [],
    //           "less_to": [],
    //           "place": 0,
    //           "ratio": 0
    //       },
    //       {
    //           "id": 9,
    //           "id_wp": 90,
    //           "cover": "http://localhost:8888/vkrz/wp-content/uploads/2022/06/tol-300x200.png",
    //           "elo": "1123",
    //           "c_name": "numéro 9",
    //           "more_to": [],
    //           "less_to": [],
    //           "place": 0,
    //           "ratio": 0
    //       },
    //       {
    //           "id": 10,
    //           "id_wp": 100,
    //           "cover": "http://localhost:8888/vkrz/wp-content/uploads/2022/06/sanctu-300x200.png",
    //           "elo": "1087",
    //           "c_name": "numéro 10",
    //           "more_to": [],
    //           "less_to": [],
    //           "place": 0,
    //           "ratio": 0
    //       },
    //       // {
    //       //   "id": 11,
    //       //   "id_wp": 110,
    //       //   "cover": "http://localhost:8888/vkrz/wp-content/uploads/2022/06/sepra-300x200.png",
    //       //   "elo": "1087",
    //       //   "c_name": "numéro 11",
    //       //   "more_to": [],
    //       //   "less_to": [],
    //       //   "place": 0,
    //       //   "ratio": 0
    //       // },
    //       // {
    //       //   "id": 12,
    //       //   "id_wp": 120,
    //       //   "cover": "http://localhost:8888/vkrz/wp-content/uploads/2022/06/sepra-300x200.png",
    //       //   "elo": "1087",
    //       //   "c_name": "numéro 12",
    //       //   "more_to": [],
    //       //   "less_to": [],
    //       //   "place": 0,
    //       //   "ratio": 0
    //       // },
    //       // {
    //       //   "id": 13,
    //       //   "id_wp": 130,
    //       //   "cover": "http://localhost:8888/vkrz/wp-content/uploads/2022/06/sepra-300x200.png",
    //       //   "elo": "1087",
    //       //   "c_name": "numéro 13",
    //       //   "more_to": [],
    //       //   "less_to": [],
    //       //   "place": 0,
    //       //   "ratio": 0
    //       // }
    //   ]
    // }

    // console.log(TOP)

    // DECLARE VARIABLES
    const typeTop = btn.dataset.typetop;
    let timelineVotes = 0,
        timelineMain = 1,
        listWR = [],
        listLR = [],
        contenders = TOP.ranking,
        alreadyVoted = false;

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

    function get_steps(contenders) {
      const typetop = typeTop;
      const list_contenders = contenders;
      const nb_contenders = list_contenders.length;
      let counter = 0;
    
      if (typetop === "top3") {
        let inf_1 = 0;
        let inf_2 = 0;
        let inf_3 = 0;
        const fact_inf_1 = 50 / (nb_contenders - 1);
        const fact_inf_2 = 25 / (nb_contenders - 2);
        const fact_inf_3 = 25 / (nb_contenders - 3);
    
        list_contenders.forEach((contender) => {
          if (contender["less_to"].length >= 1) {
            inf_1++;
          }
          if (contender["less_to"].length >= 2) {
            inf_2++;
          }
          if (contender["less_to"].length >= 3) {
            inf_3++;
          }
        });
    
        const current_step = Math.round(
          inf_1 * fact_inf_1 + inf_2 * fact_inf_2 + inf_3 * fact_inf_3
        );
    
        return current_step;
      } else {
        list_contenders.forEach((contender) => {
          counter +=
            contender["more_to"].length + contender["less_to"].length;
        });
        const current_step = Math.round(
          (counter * 100) / ((nb_contenders - 1) * nb_contenders)
        );
    
        return current_step;
      }
    }

    function do_vote(idWinner, idLooser) {
      let listContenders = contenders,
          alreadySupTo   = [],
          alreadyInfTo   = [],
          listSupToL     = [],
          listInfToV     = [];

      listContenders.forEach((contender, key) => {
        if (contender.more_to.includes(idWinner)) {
          alreadySupTo.push(contender.id_wp);
        }
        if (contender.less_to.includes(idLooser)) {
          alreadyInfTo.push(contender.id_wp);
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
        let newPlace = countSupOf;

        let countInfOf = contenders.find(item => item.id_wp == k).less_to.length;
        let ratio = countSupOf - countInfOf;

        contenders.find(item => item.id_wp == k).place = newPlace;
        contenders.find(item => item.id_wp == k).ratio = ratio;
      });

      contenders = listContenders;

      timelineVotes++;
    }

    function check_battle_2(contenders, list) {
      let list_contenders = contenders,
          list_inf_of_c1  = [],
          list_inf_of_c2  = [],
          list_sup_of_c1  = [],
          list_sup_of_c2  = [],
          battle          = false,
          nb_list         = list.length,
          nextDuel        = [],
          key_c1, key_c1_wp,
          key_c2, key_c2_wp;

      for(let m = 0; m < nb_list; m++) {
    
        if(!battle) {
    
          for (let i = 0; i < list_contenders.length; i++) {
            let contender = list_contenders[i];
          
            if (contender.id_wp == list[timelineVotes - nb_list]) {
              key_c1 = contender.id;
              key_c1_wp = contender.id_wp;
              list_inf_of_c1 = contender.more_to;
              list_sup_of_c1 = contender.less_to;
            }

            if (contender.id_wp == list[(timelineVotes + 1) - nb_list]) {
              key_c2 = contender.id;
              key_c2_wp = contender.id_wp;
              list_inf_of_c2 = contender.more_to;
              list_sup_of_c2 = contender.less_to;
            }
          }

          let c1_less_more = list_inf_of_c1.concat(list_sup_of_c1);
          let c2_less_more = list_inf_of_c2.concat(list_sup_of_c2);
    
          if(c2_less_more.includes(key_c1) || c1_less_more.includes(key_c2) || (key_c1 == key_c2)) {
            battle = false;
            timelineVotes++;
          } else {
            battle = true;
            nextDuel.push(key_c1_wp);
            nextDuel.push(key_c2_wp);
          }
    
        }
    
      } 

      return nextDuel;
    }

    function check_battle_4(contenders, list, spaire) {
      let list_contenders = contenders,
          list_inf_of_c1  = [],
          list_inf_of_c2  = [],
          list_sup_of_c1  = [],
          list_sup_of_c2  = [],
          battle          = false,
          nb_list         = list.length,
          nextDuel        = [],
          key_c1, key_c1_wp,
          key_c2, key_c2_wp;

      for(let m = 0; m < nb_list; m++) {
    
        if(!battle) {
    
          for (let i = 0; i < list_contenders.length; i++) {
            let contender = list_contenders[i];
          
            if (contender.id_wp == list[((timelineVotes + 1) - spaire) - nb_list]) {
              key_c1 = contender.id;
              key_c1_wp = contender.id_wp;
              list_inf_of_c1 = contender.more_to;
              list_sup_of_c1 = contender.less_to;
            }

            if (contender.id_wp == list[((timelineVotes + 2) - spaire) - nb_list]) {
              key_c2 = contender.id;
              key_c2_wp = contender.id_wp;
              list_inf_of_c2 = contender.more_to;
              list_sup_of_c2 = contender.less_to;
            }
          }

          let c1_less_more = list_inf_of_c1.concat(list_sup_of_c1);
          let c2_less_more = list_inf_of_c2.concat(list_sup_of_c2);

          if(c2_less_more.includes(key_c1) || c1_less_more.includes(key_c2) || (key_c1 == key_c2)) {
            battle = false;
            timelineVotes++;
          } else {
            battle = true;
            nextDuel.push(key_c1_wp);
            nextDuel.push(key_c2_wp);
          }
    
        }
    
      } 

      return nextDuel;
    }

    function check_battle_5(contenders) {

      let list_contenders = contenders
      list_contenders = list_contenders.sort((a, b) => a.ratio - b.ratio);

      let list = list_contenders;
      let list_inf_of_c1 = [];
      let list_inf_of_c2 = [];
      let list_sup_of_c1 = [];
      let list_sup_of_c2 = [];
      let battle = false;
      let nb_list = list_contenders.length;
      let next_duel = [];
      let timeline = 0;
    
        for (let m = 1; m <= nb_list; m++) {
            if (!battle) {
                timeline += 1;
    
                let key_c1, key_c1_wp, key_c2, key_c2_wp;
    
                for (let key in list_contenders) {
                    let contender = list_contenders[key];
    
                    if (contender.id_wp == list[timeline - 1].id_wp) {
                        key_c1 = contender.id;
                        key_c1_wp = String(contender.id_wp);
                        list_inf_of_c1 = contender.more_to;
                        list_sup_of_c1 = contender.less_to;
                    }
    
                    if (contender.id_wp == list[timeline]?.id_wp) {
                        key_c2 = contender.id;
                        key_c2_wp = String(contender.id_wp);
                        list_inf_of_c2 = contender.more_to;
                        list_sup_of_c2 = contender.less_to;
                    }
                }
    
                let c1_less_more = list_inf_of_c1.concat(list_sup_of_c1);
                let c2_less_more = list_inf_of_c2.concat(list_sup_of_c2);

                if (c2_less_more.includes(key_c1_wp) || c1_less_more.includes(key_c2_wp) || (key_c1 == key_c2)) {
                    battle = false;
                } else {
                    battle = true;
                    next_duel.push(+key_c1_wp);
                    next_duel.push(+key_c2_wp);
                }
            } else {
                break;
            }
        }
    
        return next_duel;
    }
    
    function get_nextDuel(contenders) {
      
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
            timelineMain = 2;
          } else {
            let keyC1 = nbContenders - (1 + timelineVotes);
            let keyC2 = nbContenders - (1 + halfInf + timelineVotes);

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
      } else if(typeTop === "complet")  {
        
        if (nbContenders >= 10) {
          if (timelineVotes === nbContenders - 5) {
            timelineMain = 2;
          }
        } else {
          if (timelineVotes < nbContenders - 1) {
            timelineMain = 6;
          } else {
            timelineMain = 7;
          }
        }

        if (timelineMain === 1) {

          nextDuel = [];      

          let keyC1 = nbContenders - (1 + timelineVotes);
          let keyC2 = nbContenders - (6 + timelineVotes);

          nextDuel.push(contenders.find(item => item.id == keyC1).id_wp);
          nextDuel.push(contenders.find(item => item.id == keyC2).id_wp);
        }

        if (timelineMain === 2) {

          nextDuel = [];
          nextDuel = check_battle_2(contenders, listLR);

          if (nextDuel.some(item => item === undefined)) {
            timelineMain = 3;
          }
        }

        if (timelineMain === 3) {

          nextDuel = [];
          let nb_loosers = listLR.length - 1;
      
          let key_c1, key_c2, list_inf_of_c1, list_sup_of_c1, list_inf_of_c2, list_sup_of_c2, key_c1_wp, key_c2_wp;
      
          for (let key in contenders) {
              let contender = contenders[key];
      
              if (contender.id_wp == listLR[contenders.length - spaire - 1]) {
                  key_c1 = key;
                  key_c1_wp = String(contender.id_wp);
                  list_inf_of_c1 = contender.more_to;
                  list_sup_of_c1 = contender.less_to;
              }
              
              if (contender.id_wp == listWR[contenders.length - 10]) {
                  key_c2 = key;
                  key_c2_wp = String(contender.id_wp);
                  list_inf_of_c2 = contender.more_to;
                  list_sup_of_c2 = contender.less_to;
              }
          }
      
          let c1_less_more = list_inf_of_c1.concat(list_sup_of_c1);
          let c2_less_more = list_inf_of_c2.concat(list_sup_of_c2);

          if (c2_less_more.includes(key_c1_wp) || c1_less_more.includes(key_c2_wp) || (key_c1 == key_c2)) {
              timelineMain = 4;
          } else {
              nextDuel.push(+key_c1_wp);
              nextDuel.push(+key_c2_wp);
          }
        }

        if (timelineMain === 4) {

          nextDuel = [];
          nextDuel = check_battle_4(contenders, listWR, spaire);

          if (nextDuel.some(item => item === undefined)) {

            timelineMain = 5;

            nextDuel = [];
            nextDuel = check_battle_5(contenders);
        
            if (nextDuel.some(item => item === undefined) || nextDuel.some(item => isNaN(item))) {

              console.log("FINISH TIMELINE MAIN 4")
        
              isNextDuel = false;
            }
          }

        }

        if (timelineMain === 5) {

          nextDuel = [];
          nextDuel = check_battle_5(contenders);
      
          if (nextDuel.some(item => item === undefined) || nextDuel.some(item => isNaN(item))) {

            console.log("FINISH TIMELINE MAIN 5")

            isNextDuel = false;
          }
        }
          
        if (timelineMain === 6) {

          nextDuel = [];      

          let keyC1 = nbContenders - (2 + timelineVotes);
          let keyC2 = nbContenders - (1 + timelineVotes);

          nextDuel.push(contenders.find(item => item.id == keyC1).id_wp);
          nextDuel.push(contenders.find(item => item.id == keyC2).id_wp);
        }
      
        if (timelineMain === 7) {
            
          nextDuel = [];
          nextDuel = check_battle_5(contenders);
      
          if (nextDuel.some(item => item === undefined) || nextDuel.some(item => isNaN(item))) {

            console.log("FINISH TIMELINE MAIN 7")
      
            isNextDuel = false;
          }
        }
      }

      if (isNextDuel) {
        let val1 = Math.floor(Math.random() * 2);
        let val2 = val1 === 0 ? 1 : 0;
        contender1 = nextDuel[val1];
        contender2 = nextDuel[val2];
      }
      else {

        document.getElementById("waiter-toplist").style.display = "block";
        console.log("C'EST FINI !!!", contenders)
        
        // const ranking = [];
        // contenders.sort((a, b) => (a.place < b.place) ? 1 : -1);

        // contenders.forEach((c) => {
        //   if (ranking.length < 3) ranking.push(c.id_wp);
          
        // });

        contenders = listContenders;

        $.ajax({
          method: "POST",
          url: vkrz_ajaxurl,
          data: {
            action: "save_ranking",
            ranking: contenders,
            id_ranking: TOP.id_ranking,
            nbvotes: timelineVotes
          },
        })
        .done(async function( msg ) {

          try {
            await setDoc(doc(database, "topLists", String(TOP.id_ranking)), {
              ID: +TOP.id_ranking,
              done_r: "done",
              id_tournoi_r: id_top,
              id_vainkeur_r: id_vainkeur,
              nb_votes_r: timelineVotes,
              timeline_main: timelineMain,
              ranking_r: contenders,
              uuid_user_r: uuiduser
            });
            console.log("Document successfully written!")
            console.log(msg);
            // window.location.replace(TOP.url_ranking);
            window.location.replace(`http://localhost:8888/vkrz/resultat/?id_ranking=${TOP.id_ranking}`);
          } catch (error) {
            console.error("Error adding document: ", error);
          }
          
        });
      }

      let currentStep = get_steps(contenders);

      return {
        isNextDuel,
        contender1,
        contender2,
        timelineMain,
        timelineVotes,
        currentStep,
      };
    }

    // DO USER RANKING
    function do_user_ranking(idWinner, idLooser) {
      do_vote(idWinner, idLooser);
      return get_nextDuel(contenders);
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

    // FIRST DUEL
    const firstDuel = get_nextDuel(contenders);
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

    document.querySelector('#name_contender_1').innerHTML = firstDuelContenderOneIdData.c_name;
    document.querySelector('#name_contender_2').innerHTML = firstDuelContenderTwoIdData.c_name;

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

        // setTimeout(() => {

          $(".contender_zone").removeClass("animate__zoomIn");
          $(".contender_zone").removeClass("animate__slideInDown");
          $(".contender_zone").removeClass("animate__slideInUp");

          $(".contender_zone").removeClass("vainkeurz");
          $(".contender_zone").removeClass("animate__headShake");
          $(".contender_zone").removeClass("animate__fadeOutDown");

          const duel = do_user_ranking(contenderIdWinner, contenderIdLooser);
          console.log(duel, contenders)
          console.log("LIST WINNERZ", listWR);
          console.log("LIST LOOSERS", listLR);

          if (!duel.isNextDuel) return;

          // document.querySelector('.stepbar').style.width = `${duel.currentStep}%`;
          // document.querySelector('.stepbar-content span').textContent = `${duel.currentStep} %`;

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

          document.querySelector('#name_contender_1').innerHTML = firstDuelContenderOneIdData.c_name;
          document.querySelector('#name_contender_2').innerHTML = firstDuelContenderTwoIdData.c_name;

          $("#c_1").addClass("animate__slideInDown");
          $("#c_2").addClass("animate__slideInUp");

          alreadyVoted = false;

        // }, 1000);

      })

    });

  })

})

