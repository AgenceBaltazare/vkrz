const { EmbedBuilder, WebhookClient } = require('discord.js');

const webhookClient = new WebhookClient({ url: 'https://discord.com/api/webhooks/1039548051326509177/_2m-A0Bb4yfbq2ptYKLoFIGFVSjf8e7KpxeUXzOnDvu7cefcwh4v8wzuoHBvxyChJSF5' });

// PARAMETERS
const typeMessage = process.argv[2];
const data        = JSON.parse(process.argv[3]);

// VARIABLES
let embed, message; 

switch(typeMessage) {
	case 'topIdea' :

		embed = new EmbedBuilder()
			.setTitle(`Nouvelle idée de Top!`)
			.setColor(0xf4167f)
			// .setDescription(`${data.userData.pseudo} a publié une nouvelle proposition du Top!`)
			// .setTimestamp(Date.now())
			// .setAuthor({
			// 	url: data.userData.profil_url,
			// 	iconURL: data.userData.profil_url,
			// 	name: data.userData.pseudo
			// })
			// .setFooter({
			// 	iconURL: data.userData.profil_url,
			// 	text: data.userData.pseudo
			// })
			// .setURL("http://localhost:8888/vkrz/proposition-de-tops/");

		message = {
			content: `
			👉 ${data.proposition}	
			`,
			username: "VAINKEUR",
			avatarURL: 'https://i.imgur.com/81uHAdJ.png',
			embeds: [embed],
		};

    break;
}

webhookClient.send(message);

/*
const typeMessage 		= process.argv[2];
const themeTopPropose = process.argv[3];
const user        		= process.argv[4];
const newTopTitle 		= process.argv[5];
const newTopUrl   		= process.argv[6];

 let messageTitle = "",
		url          = "",
		content      = "";

switch (typeMessage) {
  case 'topIdea':
		messageTitle = `${user} a publié une nouvelle proposition du Top!`;
		url = "http://localhost:8888/vkrz/proposition-de-tops/";
		content = `
		👉 ${themeTopPropose}	
`
    break;
  case 'newTop':
		messageTitle = `${user} a publié un nouveau Top!`;
		url = newTopUrl;
		content = `
			👉 ${newTopTitle}
Par ${user}
${url}
		`
    break;

	default:
    console.log(`Sorry, we are out of ${typeMessage}.`);
} 
*/



