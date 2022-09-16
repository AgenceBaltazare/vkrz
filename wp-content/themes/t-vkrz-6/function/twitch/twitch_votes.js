console.log("TWITCH VOTES SCRIPT… 🤹");

// INTRO PAGE… 1️⃣
if(document.querySelector('.modes-jeu-twitch')) {
  const gameModesBanner = document.querySelector('.modes-jeu-twitch'),
        gameModesBtns   = gameModesBanner.querySelectorAll('.modeGameTwitchBtn'),
        gameModesSpan   = gameModesBanner.querySelector('.modes-jeu-twitch__content-msg');
  
  if(localStorage.getItem('twitchGameMode')) {
    document.querySelector(`#${localStorage.getItem('twitchGameMode')}`).classList.add('selectedGameMode');
    gameModesSpan.classList.remove('d-none');
    document.querySelector('#begin_t')?.classList.add('pulsate');
    document.querySelector('#begin_top3')?.classList.add('pulsate');
    document.querySelectorAll('.twitch-icon-tbegin')?.forEach(icon => icon.classList.remove('d-none'));
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
      }
    })
  })
}

let contenderOneVotesPercent, contenderTwoVotesPercent, votesNumber,
    listeningForCount                      = true,
    votePredictionBoolean                  = false,
    waitingForParticipantsForPoints        = false,
    votePointsBoolean                      = false,
    voteParticipatifBoolean                = false,
    waitingForParticipantsForPrediction    = false,
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
    votePointsTable, votePointsTBody, votePointsTableFirstCopy, pointsOne, pointsTwo,
    position                               = 1,
    positionStr                            = "",
    userListItem                           = "",
    X, A, B;
  X = A = B = 0;

// BATTLE PAGE… 2️⃣
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
    listeningForCount = false;

    document.querySelector('#prediction-player').classList.remove('d-none');

    const twitchOverlay = document.querySelector('.twitch-overlay');
    twitchOverlay.classList.remove('d-none')

    participantsDOM = document.querySelector('#participants'); 
    participantsDOM.classList.remove('d-none'); 
    participantsDOM = participantsDOM.querySelector('.list-group'); 

    (function countdownFunc() {
      const nums = twitchOverlay.querySelectorAll('.nums span');
      const counter = twitchOverlay.querySelector('.counter');
      const finalMessage = twitchOverlay.querySelector('.final');
      const launchGameBtn = twitchOverlay.querySelector('#launchGameBtn');
      votePredictionBoolean = waitingForParticipantsForPrediction = true;

      runAnimation();

      function runAnimation() {
        nums.forEach((num, idx) => {
          const penultimate = nums.length - 1;
          num.addEventListener('animationend', (e) => {
            if(e.animationName === 'goIn' && idx !== penultimate){
              num.classList.remove('in');
              num.classList.add('out');
            } else if (e.animationName === 'goOut' && num.nextElementSibling){
              num.nextElementSibling.classList.add('in');
            } else {
              counter.classList.add('hide');
              finalMessage.classList.add('show');

              if(Object.keys(users).length < 2) twitchOverlay.querySelector('.reload').classList.remove('d-none');

              twitchOverlay.querySelector('#countdown').style.margin = "0";
              twitchOverlay.querySelector('h4:first-of-type').remove()
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
          A = votesNumberForContenderOne + 1;

          contenderOneVotesPercent.textContent = Math.round((A * 100) / X) + "%";
          contenderTwoVotesPercent.textContent =
            Math.round(100 - (A * 100) / X) + "%";
        } else if (message === "2") {
          B = votesNumberForContenderTwo + 1;

          contenderOneVotesPercent.textContent = Math.round((A * 100) / X) + "%";
          contenderTwoVotesPercent.textContent =
            Math.round(100 - (A * 100) / X) + "%";
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

        document.querySelector('#participants-overlay').textContent = Object.keys(users).join(', ') // SHOW PARTICIPANTS…
  
        // ADD TO THE TABLE…
        userListItem = `<li class="list-group-item" id="${username}">${username}</li>`;
        participantsDOM.insertAdjacentHTML("afterbegin", userListItem);
  
        if(Object.keys(users).length >= 2) $('.mode-alert').animate({ opacity: 0 }); // REMOVE THE ALERT IF THERE IS MORE THAN 2 PARTICIPANTS…
      }
  
      // DEALING WITH VOTES…
      if (
        listeningForCount === true &&
        twitchChannel !== username &&
        users.hasOwnProperty(username) &&
        !users[username].voted &&
        (message === "1" || message === "2")
      ) {
        document.querySelector(`#${username}`).classList.add('text-primary');
  
        if (message === "1") {
          users[tags.username] = { side: "1", voted: true };
        } else if (message === "2") {
          users[tags.username] = { side: "2", voted: true };
        }
      }
    }
  });
}



/* const voteParticipatifBtn   = document.querySelector("#voteParticipatif"),
      votePredictionBtn        = document.querySelector("#votePrediction"),
      votePointsBtn            = document.querySelector("#votePoints"),
      twitchVotesContainer     = document.querySelector(".twitch-votes-container"),
      // twitchChannel         = twitchVotesContainer.dataset.twitchchannel,
      startCountBtn            = twitchVotesContainer.querySelector("#start-count"),
      resetCountBtn            = twitchVotesContainer.querySelector("#reset-count"),
      contenderOneVotes        = twitchVotesContainer.querySelector("#span-contender-1"),
      contenderTwoVotes        = twitchVotesContainer.querySelector("#span-contender-2"),
      contenderOneVotesPercent = twitchVotesContainer.querySelector("#votes-percent-1"),
      contenderTwoVotesPercent = twitchVotesContainer.querySelector("#votes-percent-2");

let listeningForCount                      = true,
    votePredictionBoolean                  = false,
    waitingForParticipantsForPoints        = false,
    votePointsBoolean                      = false,
    voteParticipatifBoolean                = false,
    waitingForParticipantsForPrediction    = false,
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
    votePointsTable, votePointsTBody, votePointsTableFirstCopy, pointsOne, pointsTwo,
    position                               = 1,
    positionStr                            = "",
    userListItem                           = "",
    X, A, B;
X = A = B = 0;

const launchVotes = function (typeVotes) {
  $(".twitch-overlay").removeClass("d-none");
  $(".twitch-overlay").addClass("slide-in-fwd-center"); // jQuery TOUCH… 🤹

  const nums = document.querySelectorAll('.nums span');
  const counter = document.querySelector('.counter');
  const finalMessage = document.querySelector('.final');
  const stopWaitingBtn = document.getElementById('disableWaiting');
  
  runAnimation();
  
  function runAnimation() {
    nums.forEach((num, idx) => {
      const penultimate = nums.length - 1;
      num.addEventListener('animationend', (e) => {
        if(e.animationName === 'goIn' && idx !== penultimate){
          num.classList.remove('in');
          num.classList.add('out');
        } else if (e.animationName === 'goOut' && num.nextElementSibling){
          num.nextElementSibling.classList.add('in');
        }
        // else {
        //   counter.classList.add('hide');
        //   finalMessage.classList.add('show');
        // }
      });
    });
  }

  voteParticipatifBtn.closest(".card").remove();
  twitchVotesContainer.classList.remove("d-none");

  // $(".twitch-votes-container").fadeIn(); // jQuery TOUCH… 🤹

  if (typeVotes === "voteParticipatif") {
    twitchVotesContainer.querySelectorAll('.taper-container').forEach(div => div.classList.remove("d-none"));
    voteParticipatifBoolean = true;
  } else if (typeVotes === "votePrediction") {
    listeningForCount = false;

    twitchVotesContainer.querySelectorAll('.taper-zone').forEach(div => div.classList.add("d-none"));
    document.querySelector('#prediction-player').classList.remove('d-none');

    const countdownContainer = twitchVotesContainer.querySelector('#countdown');
    countdownContainer.classList.remove('d-none')

    participantsDOM = document.querySelector('#participants'); 
    participantsDOM.classList.remove('d-none'); 
    participantsDOM = participantsDOM.querySelector('.list-group'); 

    (function countdownFunc() {
      const nums = document.querySelectorAll('.nums span');
      const counter = document.querySelector('.counter');
      const finalMessage = document.querySelector('.final');
      const stopWaitingBtn = document.getElementById('disableWaiting');

      runAnimation();

      function runAnimation() {
        nums.forEach((num, idx) => {
          const penultimate = nums.length - 1;
          num.addEventListener('animationend', (e) => {
            if(e.animationName === 'goIn' && idx !== penultimate){
              num.classList.remove('in');
              num.classList.add('out');
            } else if (e.animationName === 'goOut' && num.nextElementSibling){
              num.nextElementSibling.classList.add('in');
            } else {
              counter.classList.add('hide');
              finalMessage.classList.add('show');

              votePredictionBoolean = waitingForParticipantsForPrediction = true;
            }
          });
        });
      }

      stopWaitingBtn.addEventListener('click', () => {
        if(Object.keys(users).length !== 2) return false;

        twitchVotesContainer.querySelectorAll('.taper-container').forEach(div => div.classList.remove("d-none"));
        countdownContainer.remove();
        waitingForParticipantsForPrediction = false;
        listeningForCount = true;
      });
    })()
  } else if (typeVotes === "votePoints") {
    listeningForCount = false;

    twitchVotesContainer.querySelectorAll('.taper-zone').forEach(div => div.classList.add("d-none"));

    document.querySelector('#ranking-player').classList.remove('d-none');
    const countdownContainer = twitchVotesContainer.querySelector('#countdown');
    countdownContainer.classList.remove('d-none')

    twitchVotesContainer.querySelectorAll('.taper-zone').forEach(div => div.classList.add("d-none"));

    votePointsTable = document.querySelector('.table-points');
    votePointsTBody = votePointsTable.querySelector('tbody');

    (function countdownFunc() {
      const nums = document.querySelectorAll('.nums span');
      const counter = document.querySelector('.counter');
      const finalMessage = document.querySelector('.final');
      const stopWaitingBtn = document.getElementById('disableWaiting');

      runAnimation();

      function runAnimation() {
        nums.forEach((num, idx) => {
          const penultimate = nums.length - 1;
          num.addEventListener('animationend', (e) => {
            if(e.animationName === 'goIn' && idx !== penultimate){
              num.classList.remove('in');
              num.classList.add('out');
            } else if (e.animationName === 'goOut' && num.nextElementSibling){
              num.nextElementSibling.classList.add('in');
            } else {
              counter.classList.add('hide');
              finalMessage.classList.add('show');

              votePointsBoolean = waitingForParticipantsForPoints = true;
            }
          });
        });
      }

      stopWaitingBtn.addEventListener('click', () => {
        countdownContainer.remove();
        twitchVotesContainer.querySelectorAll('.taper-container').forEach(div => div.classList.remove("d-none"));
        waitingForParticipantsForPoints = false;
        listeningForCount = true;
        votePointsTableFirstCopy = votePointsTable.innerHTML;
      });
    })()
  }
};

voteParticipatifBtn.addEventListener("click", launchVotes.bind(this, "voteParticipatif"));
votePredictionBtn.addEventListener("click", launchVotes.bind(this, "votePrediction"));
votePointsBtn.addEventListener("click", launchVotes.bind(this, "votePoints"));

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

      if (message === "1") {
        A = votesNumberForContenderOne + 1;

        votesNumberForContenderOne = votesNumberForContenderOne + 1;
        contenderOneVotes.textContent = votesNumberForContenderOne;

        contenderOneVotesPercent.textContent = Math.round((A * 100) / X) + "%";
        contenderTwoVotesPercent.textContent =
          Math.round(100 - (A * 100) / X) + "%";
      } else if (message === "2") {
        B = votesNumberForContenderTwo + 1;

        votesNumberForContenderTwo = votesNumberForContenderTwo + 1;
        contenderTwoVotes.textContent = votesNumberForContenderTwo;

        contenderOneVotesPercent.textContent = Math.round((A * 100) / X) + "%";
        contenderTwoVotesPercent.textContent =
          Math.round(100 - (A * 100) / X) + "%";
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

      userListItem = `<li class="list-group-item" id="${username}">${username}</li>`;
      participantsDOM.insertAdjacentHTML("afterbegin", userListItem);

      if(Object.keys(users).length >= 2) $('.mode-alert').animate({ opacity: 0 });
    }

    // DEALING WITH VOTES…
    if (
      listeningForCount === true &&
      twitchChannel !== username &&
      users.hasOwnProperty(username) &&
      !users[username].voted &&
      (message === "1" || message === "2")
    ) {
      document.querySelector(`#${username}`).classList.add('text-primary');

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
          <td>🟠</td>
          <td>0</td>
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
      document.querySelector(`#${username} td:nth-of-type(3)`).textContent = '🟢'
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
 */
