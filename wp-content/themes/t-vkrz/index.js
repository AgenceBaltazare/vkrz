const { EmbedBuilder, WebhookClient } = require('discord.js');
const express                         = require('express');
const cors                            = require("cors");

const app = express();

app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

app.post('/discord', async (req, res) => {
  const { typeMessage, data } = req.body;

	const newCreatedTopsWebhook = new WebhookClient({ url: 'https://discord.com/api/webhooks/1075548617743548446/sc1JRRcj9pJmLfZITLgnNS1bx3KpeZV1Oy21Lg7p7z53Ixij-ELMk92_JCpgbWtd9jl4' });

	let embed, message, action; 

	switch(typeMessage) {
		
		case 'newTopCreated' :
	
		// let managers = ["@Guillaume V.#0210", "@Sunny55#6247", "@Staphylo#6383", "@Adil#8840"];
		let managers = ["<@!831531283892535326>", "<@!625052076002639902>"];

		// https://firebasestoragefirebasestorage.googleapis.com/v0/b/vainkeurz-48eb4.appspot.com/o/Test-1677146240473-iV0mDvIRe1AlgzHR%2FTest-1677146269406-F8j8Nu22gYOJLxZs?alt=media&token=c9c0e0eb-fcc8-46a7-8cd0-38677022242a
		
		// https://firebasestoragefirebasestorage.googleapis.com/v0/b/vainkeurz-48eb4.appspot.com/o/Test-1677146240473-iV0mDvIRe1AlgzHR%2FTest-1677146269406-F8j8Nu22gYOJLxZs?alt=media&token=c9c0e0eb-fcc8-46a7-8cd0-38677022242a
	
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
			.setImage("https://images.ctfassets.net/hrltx12pl8hq/3j5RylRv1ZdswxcBaMi0y7/b84fa97296bd2350db6ea194c0dce7db/Music_Icon.jpg");
			console.log("https://images.ctfassets.net/hrltx12pl8hq/3j5RylRv1ZdswxcBaMi0y7/b84fa97296bd2350db6ea194c0dce7db/Music_Icon.jpg")
	
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
	
	}

  res.send(action);

});

app.listen(3002, () => {
  console.log('Listening on port 3002');
});

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