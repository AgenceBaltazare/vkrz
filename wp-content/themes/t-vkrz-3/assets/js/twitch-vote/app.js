const usersElement1 = document.querySelector('#users1');
const countElement1 = document.querySelector('#count1');
const usersElement2 = document.querySelector('#users2');
const countElement2 = document.querySelector('#count2');

const client = new tmi.Client({
    connection: {
        secure: true,
        reconnect: true,
    },
    channels: [ 'vainkeurz' ],
});

client.connect();

let listeningForCount = false;
const users = {};

client.on('message', (channel, tags, message, self) => {
        if (self) return;
        const {username} = tags;
        if (username == 'vainkeurz') {

            //click sur le bouton
            if (message === '!start-count') {
                listeningForCount = true;

            //click sur mettre fin au vote
            } else if (message === '!end-count') {
                listeningForCount = false;

            //fermer
            } else if (message === '!clear-count') {
                countElement1.textContent = '';
                usersElement1.textContent = '';
                countElement2.textContent = '';
                usersElement2.textContent = '';
            }
        } else if (listeningForCount && message === '1') {
            users[tags.username] = true;
            // display current count page
            countElement1.textContent = Object.keys(users).length;
            usersElement1.textContent = Object.keys(users).join(',');
        } else if (listeningForCount && message === '2') {
            users[tags.username] = true;
            // display current count page
            countElement2.textContent = Object.keys(users).length;
            usersElement2.textContent = Object.keys(users).join(',');
        }
    }
);

function clear_click() {
    countElement1.textContent = '';
    usersElement1.textContent = '';
    countElement2.textContent = '';
    usersElement2.textContent = '';
}

function stop_count(){
    listeningForCount = false;
}