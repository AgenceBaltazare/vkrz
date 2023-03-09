const { EmbedBuilder, WebhookClient } = require('discord.js');
const express                         = require('express');
const cors                            = require("cors");

const app = express();

app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// PARAMETERS
let routeParam, typeMessageParam, dataParam;
if(process.argv.length > 4) {
	routeParam       = process.argv[2];
	typeMessageParam = process.argv[3];
	dataParam        = process.argv[4];
}

// const managers = ["@Guillaume V.#0210", "@Sunny55#6247", "@Staphylo#6383", "@Adil#8840"];
const managers = ["<@!831531283892535326>", "<@!625052076002639902>"];

app.post('/discord', async (req, res) => {
	const { typeMessage, data } = req.body;
	// console.log(req.body)

	let embed, message, action; 

	switch(typeMessage) {

		case 'topIdea' :

			const topsIdeasWebhook = new WebhookClient({ url: 'https://discord.com/api/webhooks/1075548617743548446/sc1JRRcj9pJmLfZITLgnNS1bx3KpeZV1Oy21Lg7p7z53Ixij-ELMk92_JCpgbWtd9jl4' });

			embed = new EmbedBuilder()
				.setTitle(data.proposition)
				.setColor(0xf4167f)
				.setDescription(`${data.userData.pseudo} a publié une nouvelle proposition du Top!`)
				.setTimestamp(Date.now())
				.setAuthor({
					url: data.userData.profil_url,
					iconURL: data.userData.avatar,
					name: data.userData.pseudo
				})
				.setURL("https://vainkeurz.com/proposition-de-tops/");

			message = {
				content: `
				NOUVELLE PROPOSITION DE TOP !\nEt ce sera pour ${managers[ Math.floor( Math.random() * managers.length ) ]} a valider la proposition 🤪
				`,
				username: "NOTEURZ 🤖",
				avatarURL: 'https://vainkeurz.com/wp-content/uploads/2022/12/boteurz-image-300x300.jpeg',
				embeds: [embed],
			};

			action = topsIdeasWebhook.send(message);	

    break;
		
		case 'newTopCreated' :

			const newCreatedTopsWebhook = new WebhookClient({ url: 'https://discord.com/api/webhooks/1075548617743548446/sc1JRRcj9pJmLfZITLgnNS1bx3KpeZV1Oy21Lg7p7z53Ixij-ELMk92_JCpgbWtd9jl4' });
	
			embed = new EmbedBuilder()
				.setTitle(data.top)
				.setColor(0x7217FF)
				.setDescription(data.topQuestion)
				.setTimestamp(Date.now())
				.setAuthor({
					url: data.creatorData.profil_url,
					// iconURL: data.creatorData.avatar,
					iconURL: "https://i.pinimg.com/originals/6e/9e/dc/6e9edc603eabce0b383680797ca59b74.jpg",
					name: data.creatorData.pseudo
				})
				.setURL(data.topUrl)
				// .setImage(data.topVisuel);
				// https://firebasestorage.googleapis.com/v0/b/vainkeurz-48eb4.appspot.com/o/Test-1677346544635-ewuGOILKh5pFMbqR%2FTest-1677346575822-ex0LAD3zzblgAW5U?alt=media&token=4f01a6c8-a2fc-497c-8bca-ebe1927d31e8
		
			message = {
				content: `
				NOUVEAU TOP CRÉE !\nEt ce sera pour ${managers[ Math.floor( Math.random() * managers.length ) ]} a valider le Top 🤪
				`,
				username: "NOTEURZ 🤖",
				avatarURL: 'https://vainkeurz.com/wp-content/uploads/2022/12/boteurz-image-300x300.jpeg',
				embeds: [embed],
			};
			
			action = newCreatedTopsWebhook.send(message);

		break;
	
		case 'newTop' :

			const newTopsWebhook = new WebhookClient({ url: 'https://discord.com/api/webhooks/1075548617743548446/sc1JRRcj9pJmLfZITLgnNS1bx3KpeZV1Oy21Lg7p7z53Ixij-ELMk92_JCpgbWtd9jl4' });

			// embed = new EmbedBuilder()
			// 	.setTitle(data.top_full_title)
			// 	.setColor(0xB237F3)
			// 	.setDescription(data.top_question)
			// 	.setTimestamp(Date.now())
			// 	.setAuthor({
			// 		url: data.top_author_url,
			// 		iconURL: data.top_author_img,
			// 		name: data.top_creator
			// 	})
			// 	.setURL(data.top_url)
			// 	.setImage(data.top_visuel)
			
				message = {
					content: `MACHA`,
					username: "NOTEURZ 🤖",
					avatarURL: 'https://vainkeurz.com/wp-content/uploads/2022/12/boteurz-image-300x300.jpeg',
					// embeds: [embed],
				};
			
			action = newTopsWebhook.send(message);

		break;

	}

  res.send(action);

});

console.log(routeParam)

if (routeParam === "/discord") {
	const axios = require("axios");

	let data        = JSON.stringify(dataParam);
	let typeMessage = typeMessageParam;

	axios.post("http://localhost:3002/discord", { typeMessage, data })
		.then(response => {
			console.log(response.data);
		})
		.catch(error => {
			console.error(error);
		});
} else {
	app.listen(3002, () => {
		console.log('Listening on port 3002');
	});
}

// // const newTopsWebhook = new WebhookClient({ url: 'https://discord.com/api/webhooks/1045815659776454677/Te5GVS-eq8lROglK9czNLMgSqtftROBYYEGm5FMYTHT0QaqyxPEfWJDnnqxn-c4pVoxp' });
// const newTopsWebhook = new WebhookClient({ url: 'https://discord.com/api/webhooks/1075548617743548446/sc1JRRcj9pJmLfZITLgnNS1bx3KpeZV1Oy21Lg7p7z53Ixij-ELMk92_JCpgbWtd9jl4' });

// // const topsIdeasWebhook = new WebhookClient({ url: 'https://discord.com/api/webhooks/1045843792080683129/VapEauEL9nJhzU2FySrKvGvPWmRquS1bWUP2FlWszRFkZWF1aFTMP_755YOf90CHAQx3' });
// const topsIdeasWebhook = new WebhookClient({ url: 'https://discord.com/api/webhooks/1075548617743548446/sc1JRRcj9pJmLfZITLgnNS1bx3KpeZV1Oy21Lg7p7z53Ixij-ELMk92_JCpgbWtd9jl4' });

// const newCreatedTopsWebhook = new WebhookClient({ url: 'https://discord.com/api/webhooks/1075548617743548446/sc1JRRcj9pJmLfZITLgnNS1bx3KpeZV1Oy21Lg7p7z53Ixij-ELMk92_JCpgbWtd9jl4' });

// // PARAMETERS
// const typeMessage = process.argv[2];
// // const data        = JSON.parse(process.argv[3].replaceAll("&rsquo;", "'"));
// const data        = JSON.parse(process.argv[3]);

// // VARIABLES
// let embed, message; 

// switch(typeMessage) {
// 	case 'topIdea' :

// 		embed = new EmbedBuilder()
// 			.setTitle(`Nouvelle idée de Top!`)
// 			.setColor(0xf4167f)
// 			.setDescription(`${data.userData.pseudo} a publié une nouvelle proposition du Top!`)
// 			.setTimestamp(Date.now())
// 			.setAuthor({
// 				url: data.userData.profil_url,
// 				iconURL: data.userData.avatar,
// 				name: data.userData.pseudo
// 			})
// 			.setURL("https://vainkeurz.com/proposition-de-tops/");

// 		message = {
// 			content: `
// 			👉  ${data.proposition}	
// 			`,
// 			username: "NOTEURZ 🤖",
// 			avatarURL: 'https://vainkeurz.com/wp-content/uploads/2022/12/boteurz-image-300x300.jpeg',
// 			embeds: [embed],
// 		};

// 		topsIdeasWebhook.send(message);

//     break;

// 	case 'newTopCreated' :

// 	let administrators = ["@Guillaume V.#0210", "@Sunny55#6247", "@Staphylo#6383", "@Adil#8840"];

// 	/* 	embed = new EmbedBuilder()
// 		.setTitle(`${data.newTop}`)
// 		.setColor(0xf4167f)
// 		.setDescription(`${data.topQuestion}`)
// 		.setTimestamp(Date.now())
// 		.setAuthor({
// 			url: data.userData.profil_url,	
// 			iconURL: data.userData.avatar,
// 			name: data.userData.pseudo
// 		})
// 		.setURL("https://vainkeurz.com/proposition-de-tops/");

// 	message = {
// 		content: `
// 		👉  A toi ${administrators[ Math.floor( Math.random() * administrators.length ) ]} de valider le Top
// 		`,
// 		username: "NOTEURZ 🤖",
// 		avatarURL: 'https://vainkeurz.com/wp-content/uploads/2022/12/boteurz-image-300x300.jpeg',
// 		embeds: [embed],
// 	}; */

// 	message = {
// 		content: `
// 		👉  A toi ${administrators[ Math.floor( Math.random() * administrators.length ) ]} de valider le Top
// 		`,
// 		username: "NOTEURZ 🤖",
// 		avatarURL: 'https://vainkeurz.com/wp-content/uploads/2022/12/boteurz-image-300x300.jpeg',
// 	};

// 	newCreatedTopsWebhook.send(message);

// 	break;

// 	case 'newTop' : 

// 		embed = new EmbedBuilder()
// 			.setTitle(data.top_full_title)
// 			.setColor(0xB237F3)
// 			.setDescription(data.top_question)
// 			.setTimestamp(Date.now())
// 			.setAuthor({
// 				url: data.top_author_url,
// 				iconURL: data.top_author_img,
// 				name: data.top_creator
// 			})
// 			.setURL(data.top_url)
// 			.setImage(data.top_visuel)

// 		message = {
// 			username: "NOTEURZ 🤖",
// 			avatarURL: 'https://vainkeurz.com/wp-content/uploads/2022/12/boteurz-image-300x300.jpeg',
// 			embeds: [embed],
// 		};

// 		newTopsWebhook.send(message);

// 	break;
// }