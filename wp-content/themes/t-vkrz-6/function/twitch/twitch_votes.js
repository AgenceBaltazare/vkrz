// DECLARATION OF VARIABLES…
let listeningForCount                      = true,
    votePredictionBoolean                  = false,
    waitingForParticipantsForPoints        = false,
    votePointsBoolean                      = false,
    voteParticipatifBoolean                = false,
    waitingForParticipantsForPrediction    = false,
    winnerAlready                          = false,
    votesNumberForContenderOne             = 0,
    votesNumberForContenderTwo             = 0,
    users                                  = {},
    losers                                 = {},
    toFilter                               = [],
    passed                                 = [],
    nonPassed                              = [],
    sameVoteGroup                          = [],
    sameVoteGroupObj                       = {},
    notSameVoteGroup                       = [],
    notSameVoteGroupObj                    = {},
    participantsDOM,
    contenderOneVotesPercent, contenderTwoVotesPercent, votesNumber,
    votePointsTable, votePointsTBody, votePointsTableFirstCopy,
    preditcionParticipantsNumber, preditcionParticipantsVotedNumber,
    pointsParticipantsNumber, pointsParticipantsVotedNumber,
    position                               = 1,
    positionStr                            = "",
    userListItem                           = "",
    X, A, B;
  X = A = B = 0;

// INTRO PAGE…
if(document.querySelector('.modes-jeu-twitch')) {
  const twitchBannerToggleBtnGlobal = document.querySelector('.showTwitchBanner');
  twitchBannerToggleBtnGlobal.classList.remove('d-none');

  // EXTENSION TOGGLE ICON…
  const twitchGamesToggleIcon = function(to) {
    const twitchBannerToggleBtn = document.querySelector('.showTwitchBanner');

    if(to === "plus") {
      twitchBannerToggleBtn.querySelector('.fa-twitch').classList.add('d-none');
      twitchBannerToggleBtn.querySelector('.fa-plus').classList.remove('d-none');
      twitchBannerToggleBtn.querySelector('.fa-minus').classList.add('d-none');
    } else if(to === "twitch") {
      twitchBannerToggleBtn.querySelector('.fa-twitch').classList.remove('d-none');
      twitchBannerToggleBtn.querySelector('.fa-plus').classList.add('d-none');
      twitchBannerToggleBtn.querySelector('.fa-minus').classList.add('d-none');
    } else if(to === "minus") {
      twitchBannerToggleBtn.querySelector('.fa-twitch').classList.add('d-none');
      twitchBannerToggleBtn.querySelector('.fa-plus').classList.add('d-none');
      twitchBannerToggleBtn.querySelector('.fa-minus').classList.remove('d-none');
    }
  }

  // T-NORMAL…
  if(document.querySelector('.t-normal-container')) {
    const tNormalContainer      = document.querySelector('.t-normal-container'),
          twitchBannerToggleBtn = tNormalContainer.querySelector('.showTwitchBanner'),
          twitchModesBanner     = document.querySelector('.modes-jeu-twitch');
          
    let out;
    window.addEventListener('click', (e) => {
      if(e.target.closest('.modes-jeu-twitch') !== twitchModesBanner && e.target !== twitchModesBanner && out === true) {
        setTimeout(() => twitchModesBanner.classList.add('d-none'), 1000)
        twitchModesBanner.classList.add('animate__slideOutRight');

        twitchGamesToggleIcon("twitch");

        twitchBannerToggleBtn.setAttribute('onmouseover', "twitchGamesToggleIcon('plus')");
        twitchBannerToggleBtn.setAttribute('onmouseout', "twitchGamesToggleIcon('twitch')");
        out = false;
      } else if(e.target.parentNode === twitchBannerToggleBtn || e.target === twitchBannerToggleBtn) {
        out = true;
        twitchBannerToggleBtn.removeAttribute('onmouseover');
        twitchBannerToggleBtn.removeAttribute('onmouseout');

        twitchModesBanner.classList.remove('d-none');
        twitchModesBanner.classList.remove('animate__slideOutRight');

        twitchGamesToggleIcon("minus");
      }
    })
  }

  // T-SPONSO…
  if(document.querySelector('.t-sponso-container') && document.querySelector('.t-sponso-banner')) {
    const tSponsoContainer      = document.querySelector('.t-sponso-container'),
          tSponsoBanner         = tSponsoContainer.querySelector('.t-sponso-banner'),
          twitchBannerToggleBtn = tSponsoContainer.querySelector('.showTwitchBanner'),
          twitchModesBanner     = document.querySelector('.modes-jeu-twitch');
    
    let out;
    window.addEventListener('click', (e) => {
      if(e.target.closest('.modes-jeu-twitch') !== twitchModesBanner && e.target !== twitchModesBanner && out === true) {
        twitchGamesToggleIcon("twitch");

        twitchBannerToggleBtn.setAttribute('onmouseover', "twitchGamesToggleIcon('plus')");
        twitchBannerToggleBtn.setAttribute('onmouseout', "twitchGamesToggleIcon('twitch')");

        twitchModesBanner.classList.remove('out');
        tSponsoBanner.classList.remove('blur');
        out = false;
      } else if(e.target.parentNode === twitchBannerToggleBtn || e.target === twitchBannerToggleBtn) {
        out = true;
        twitchModesBanner.classList.add('out');
        tSponsoBanner.classList.add('blur');

        twitchGamesToggleIcon("minus");

        twitchBannerToggleBtn.removeAttribute('onmouseover');
        twitchBannerToggleBtn.removeAttribute('onmouseout');
      }
    })
  }

  const gameModesBanner = document.querySelector('.modes-jeu-twitch'),
        gameModesBtns   = gameModesBanner.querySelectorAll('.modeGameTwitchBtn'),
        gameModesSpan   = gameModesBanner.querySelector('.modes-jeu-twitch__content-msg');

  if(localStorage.getItem('twitchGameMode')) {
    document.querySelector(`#${localStorage.getItem('twitchGameMode')}`).classList.add('selectedGameMode');
    gameModesSpan.classList.remove('d-none');
    document.querySelector('#begin_t')?.classList.add('pulsate');
    document.querySelector('#begin_top3')?.classList.add('pulsate');
    document.querySelectorAll('.twitch-icon-tbegin')?.forEach(icon => icon.classList.remove('d-none'));

    twitchBannerToggleBtnGlobal.classList.add('alreadySelected')
  }

  gameModesBtns.forEach(button => {
    button.addEventListener('click', function() {
      document.querySelector('#begin_t')?.classList.add('pulsate'); // MAKE THE BEGIN TOP BUTTON MOVE…
      document.querySelector('#begin_top3')?.classList.add('pulsate'); // MAKE THE BEGIN TOP BUTTON MOVE…
      document.querySelectorAll('.twitch-icon-tbegin')?.forEach(icon => icon.classList.remove('d-none'));
      gameModesBtns.forEach(btn => { 
        if(btn !== button) btn.classList.remove('selectedGameMode')
      })
      button.classList.toggle('selectedGameMode')

      if(document.querySelector('.selectedGameMode')) {
        gameModesSpan.classList.remove('d-none');

        localStorage.removeItem('twitchGameMode');

        localStorage.setItem('twitchGameMode', button.id);
      } else {
        gameModesSpan.classList.add('d-none');

        document.querySelector('#begin_t')?.classList.remove('pulsate');
        document.querySelector('#begin_top3')?.classList.remove('pulsate');
        document.querySelectorAll('.twitch-icon-tbegin')?.forEach(icon => icon.classList.add('d-none'));

        localStorage.removeItem('twitchGameMode');
        twitchBannerToggleBtnGlobal.classList.remove('alreadySelected')
      }
    })
  })
}

// BATTLE PAGE… 
if(document.querySelector('.display_battle') && localStorage.getItem('twitchGameMode')) {
  const gameMode                 = localStorage.getItem('twitchGameMode'),
        twitchVotesContainer     = document.querySelector(".twitch-votes-container"),
        twitchChannel            = twitchVotesContainer.dataset.twitchchannel,
        totalVotesNumber         = twitchVotesContainer.querySelector('.votes-number-total'),
        votesNumberWording       = twitchVotesContainer.querySelector('.votes-number-wording');

  votesNumber              = twitchVotesContainer.querySelector('.votes-number');
  contenderOneVotesPercent = twitchVotesContainer.querySelector("#votes-percent-1");
  contenderTwoVotesPercent = twitchVotesContainer.querySelector("#votes-percent-2");
  
  twitchVotesContainer.classList.remove("d-none");
  
  if (gameMode === "voteParticipatif") {
    twitchVotesContainer.querySelectorAll('.taper-zone').forEach(div => div.classList.remove("d-none"));
    twitchVotesContainer.querySelector('.votes-stats-container').classList.remove('d-none')
    voteParticipatifBoolean = true;
  } else if (gameMode === "votePrediction") {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    listeningForCount = false;

    preditcionParticipantsNumber = document.querySelector('.prediction-participants');
    preditcionParticipantsVotedNumber = document.querySelector('.prediction-participants-votey-nbr');

    document.querySelectorAll('.votes-container > p:first-of-type').forEach(p => p.style.marginTop = '2rem');

    document.querySelector('#prediction-player').classList.remove('d-none');

    const twitchOverlay = document.querySelector('.twitch-overlay');
    twitchOverlay.classList.remove('d-none')

    participantsDOM = document.querySelector('#participants'); 
    participantsDOM.classList.remove('d-none'); 
    participantsDOM = participantsDOM.querySelector('.card-body'); 

    (function countdownFunc() {
      const nums            = twitchOverlay.querySelectorAll('.nums span');
      const counter         = twitchOverlay.querySelector('.counter');
      const finalMessage    = twitchOverlay.querySelector('.final');
      const launchGameBtn   = twitchOverlay.querySelector('#launchGameBtn');
      votePredictionBoolean = waitingForParticipantsForPrediction = true;

      runAnimation();

      function runAnimation() {
        nums.forEach((num, index) => {
          const penultimate = nums.length - 1;
          num.addEventListener('animationend', (e) => {
            if(e.animationName === 'goIn' && index !== penultimate){
              num.classList.remove('in');
              num.classList.add('out');
            } else if (e.animationName === 'goOut' && num.nextElementSibling){
              num.nextElementSibling.classList.add('in');
            } else {
              counter.classList.add('hide');
              finalMessage.classList.add('show');

              if(Object.keys(users).length < 2) {
                launchGameBtn.classList.remove('btn-rose');
                launchGameBtn.classList.add('btn-relief-danger');
                launchGameBtn.textContent = "Recharger le Top";
                launchGameBtn.addEventListener('click', () => {location.reload()});
              } else {
                twitchOverlay.querySelector('.mode-alert').remove();
              }

              twitchOverlay.querySelector('#countdown').style.margin = "0";
              twitchOverlay.querySelector('h4:first-of-type').remove();
              waitingForParticipantsForPrediction = false;
            }
          });
        });
      }

      launchGameBtn.addEventListener('click', () => {
        if(Object.keys(users).length < 2) return false;
  
        listeningForCount = true;
        twitchOverlay.classList.add('d-none')
      });
    })()
  } else if (gameMode === "votePoints") {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    listeningForCount = false;

    pointsParticipantsNumber = document.querySelector('.points-participants');
    pointsParticipantsVotedNumber = document.querySelector('.points-participants-votey-nbr');

    document.querySelectorAll('.votes-container > p:first-of-type').forEach(p => p.style.marginTop = '2rem');

    document.querySelector('#ranking-player').classList.remove('d-none');

    const twitchOverlay = document.querySelector('.twitch-overlay');
    twitchOverlay.classList.remove('d-none')

    votePointsTable = document.querySelector('.table-points');
    votePointsTBody = votePointsTable.querySelector('tbody');

    (function countdownFunc() {
      const nums            = twitchOverlay.querySelectorAll('.nums span');
      const counter         = twitchOverlay.querySelector('.counter');
      const finalMessage    = twitchOverlay.querySelector('.final');
      const launchGameBtn   = twitchOverlay.querySelector('#launchGameBtn');
      votePointsBoolean = waitingForParticipantsForPoints = true;

      runAnimation();

      function runAnimation() {
        nums.forEach((num, index) => {
          const penultimate = nums.length - 1;
          num.addEventListener('animationend', (e) => {
            if(e.animationName === 'goIn' && index !== penultimate){
              num.classList.remove('in');
              num.classList.add('out');
            } else if (e.animationName === 'goOut' && num.nextElementSibling){
              num.nextElementSibling.classList.add('in');
            } else {
              counter.classList.add('hide');
              finalMessage.classList.add('show');

              if(Object.keys(users).length < 2) {
                launchGameBtn.classList.remove('btn-rose');
                launchGameBtn.classList.add('btn-relief-danger');
                launchGameBtn.textContent = "Reload the page";
                launchGameBtn.addEventListener('click', () => {location.reload()});
              } else {
                twitchOverlay.querySelector('.mode-alert').remove();
              }

              twitchOverlay.querySelector('#countdown').style.margin = "0";
              twitchOverlay.querySelector('h4:first-of-type').remove();
              waitingForParticipantsForPoints = false;
            }
          });
        });
      }

      launchGameBtn.addEventListener('click', () => {
        if(Object.keys(users).length < 2) return false;
  
        twitchOverlay.classList.add('d-none')
        listeningForCount = true;
      });
    })()
  }

  // tmi.js STUFF… 🎙
  const client = new tmi.Client({
    channels: [twitchChannel],
  });
  client.connect();
  client.on("message", (channel, tags, message, self) => {
    if (self) return;
    const { username } = tags;

    if (voteParticipatifBoolean) {
      if (
        twitchChannel !== username &&
        !users.hasOwnProperty(username) &&
        (message === "1" || message === "2")
      ) {
        users[username] = true;
        X = X + 1;
        votesNumber.textContent = X;
        totalVotesNumber.textContent = +totalVotesNumber.textContent + 1;
        if(X > 1) votesNumberWording.textContent = "Votes";

        if (message === "1") {
          A = A + 1;

          contenderOneVotesPercent.textContent = Math.round((A * 100) / X) + "%";
          contenderTwoVotesPercent.textContent =
            Math.round(100 - Math.round((A * 100) / X)) + "%";
        } else if (message === "2") {
          B = B + 1;

          contenderOneVotesPercent.textContent = Math.round((A * 100) / X) + "%";
          contenderTwoVotesPercent.textContent =
            Math.round(100 - Math.round((A * 100) / X)) + "%";
        }

        // STYLES… 🍏
        if (A > B) {
          document.querySelector(".contender-1-votes-twitch").style.transform =
            "scale(1.1)";
          document.querySelector(".contender-2-votes-twitch").style.transform =
            "scale(0.9)";

          document.querySelector("#votes-stats-1").classList.add("active");
          document.querySelector("#votes-stats-2").classList.remove("active");
        } else if (A == B) {
          document.querySelector(".contender-2-votes-twitch").style.transform =
            "scale(1)";
          document.querySelector(".contender-1-votes-twitch").style.transform =
            "scale(1)";

          document.querySelector("#votes-stats-1").classList.add("active");
          document.querySelector("#votes-stats-2").classList.add("active");
        } else {
          document.querySelector(".contender-2-votes-twitch").style.transform =
            "scale(1.1)";
          document.querySelector(".contender-1-votes-twitch").style.transform =
            "scale(0.9)";

          document.querySelector("#votes-stats-2").classList.add("active");
          document.querySelector("#votes-stats-1").classList.remove("active");
        }
      }
    } else if (votePredictionBoolean) {
      // GET THE PARTICIPANTS FIRST…
      if (
        votePredictionBoolean &&
        waitingForParticipantsForPrediction &&
        listeningForCount === false &&
        message.toLowerCase() === "vkrz" &&
        twitchChannel !== username &&
        !users.hasOwnProperty(username)
      ) {
        users[username] = { ...true, voted: false };

        const participants = document.querySelector('#participants-overlay');
        participants.classList.remove('d-none');
        if(Object.keys(users).length < 25) {
          if(Object.keys(users).length > 1) {
            participants.dataset.content = `${Object.keys(users).length} Participants :`;
          } else {
            participants.dataset.content = `${Object.keys(users).length} Participant :`;
          }
          participants.textContent = Object.keys(users).join(', ') // SHOW PARTICIPANTS…
        } else {
          participants.dataset.content = ``;
          participants.innerHTML = `Plus de ${Object.keys(users).length - 1} participants… <span class="va va-star-struck va-lg" style="vertical-align: sub !important;
          "></span>`
        }

        preditcionParticipantsNumber.textContent = Object.keys(users).length;
  
        // ADD TO THE TABLE…
        userListItem = `<div class="card-element" id="${username}">${username}</div>`;
        participantsDOM.insertAdjacentHTML("afterbegin", userListItem);
  
        if(Object.keys(users).length >= 2) $('.mode-alert').animate({ opacity: 0 }); // REMOVE THE ALERT IF THERE IS MORE THAN 2 PARTICIPANTS…
      }
  
      // DEALING WITH VOTES…
      if (
        listeningForCount === true &&
        twitchChannel !== username &&
        users.hasOwnProperty(username) &&
        !users[username].voted &&
        winnerAlready === false &&
        (message === "1" || message === "2")
      ) {
        document.querySelector(`#${username}`).classList.add('text-primary');
        preditcionParticipantsVotedNumber.textContent = +preditcionParticipantsVotedNumber.textContent + 1;
  
        if (message === "1") {
          users[tags.username] = { side: "1", voted: true };
        } else if (message === "2") {
          users[tags.username] = { side: "2", voted: true };
        }
      }
    } else if(votePointsBoolean) {
      // GET THE PARTICIPANTS FIRST…
      if (
        votePointsBoolean &&
        waitingForParticipantsForPoints &&
        listeningForCount === false &&
        message.toLowerCase() === "vkrz" &&
        twitchChannel !== username &&
        !users.hasOwnProperty(username)
      ) {
        users[username] = { ...true, voted: false };
  
        const participants = document.querySelector('#participants-overlay');
        participants.classList.remove('d-none');
        if(Object.keys(users).length < 25) {
          if(Object.keys(users).length > 1) {
            participants.dataset.content = `${Object.keys(users).length} Participants :`;
          } else {
            participants.dataset.content = `${Object.keys(users).length} Participant :`;
          }
          participants.textContent = Object.keys(users).join(', ') // SHOW PARTICIPANTS…
        } else {
          participants.dataset.content = ``;
          participants.innerHTML = `Plus de ${Object.keys(users).length - 1} participants… <span class="va va-star-struck va-lg" style="vertical-align: sub !important;
          "></span>`
        }

        pointsParticipantsNumber.textContent = Object.keys(users).length;

        if(Object.keys(users).length >= 2) $('.mode-alert').animate({ opacity: 0 }); // REMOVE THE ALERT IF THERE IS MORE THAN 2 PARTICIPANTS…

        switch (position) {
          case 1:
            positionStr = '<span class="ico va va-medal-1 va-lg"></span>';
            break;
          case 2:
            positionStr = '<span class="ico va va-medal-2 va-lg"></span>';
            break;
          case 3:
            positionStr = '<span class="ico va va-medal-3 va-lg"></span>';
            break;
          default:
            positionStr = position;
        }
  
        userListItem = `
          <tr id="${username}">
            <td>${positionStr}</td>
            <td>${username}</td>
            <td data-order="0">0</td>
          </tr>
        `;
        votePointsTBody.insertAdjacentHTML("beforeend", userListItem);
        position++;
      }
  
      // DEALING WITH VOTES…
      if(
        listeningForCount === true &&
        twitchChannel !== username &&
        users.hasOwnProperty(username) &&
        !users[username].voted &&
        (message === "1" || message === "2")
      ) 
      {
        document.querySelector(`#${username} td:nth-of-type(2)`).classList.add('voted');
        pointsParticipantsVotedNumber.textContent = +pointsParticipantsVotedNumber.textContent + 1;
        // let speech = new SpeechSynthesisUtterance(`${username} a bien voté!`)
        // window.speechSynthesis.speak(speech)
  
        if (message === "1") {
          users[tags.username] = {side: "1", voted: true };
        } else if (message === "2") {
          users[tags.username] = {side: "2", voted: true };
        }
      }
    }
  });
}