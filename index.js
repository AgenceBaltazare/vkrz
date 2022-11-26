const { EmbedBuilder, WebhookClient } = require('discord.js');

const newTopsWebhook = new WebhookClient({ url: 'https://discord.com/api/webhooks/1045815659776454677/Te5GVS-eq8lROglK9czNLMgSqtftROBYYEGm5FMYTHT0QaqyxPEfWJDnnqxn-c4pVoxp' });

const topsIdeasWebhook = new WebhookClient({ url: 'https://discord.com/api/webhooks/1045843792080683129/VapEauEL9nJhzU2FySrKvGvPWmRquS1bWUP2FlWszRFkZWF1aFTMP_755YOf90CHAQx3' });

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
			👉  ${data.proposition}	
			`,
			username: "VAINKEUR",
			avatarURL: 'https://i.imgur.com/81uHAdJ.png',
			embeds: [embed],
		};

		topsIdeasWebhook.send(message);

    break;

	case 'newTop' : 

		embed = new EmbedBuilder()
			.setTitle(data.top_title)
			.setColor(0xB237F3)
			.setDescription(`${data.top_creator} a publié un nouveau Top!`)
			.setTimestamp(Date.now())
			.setAuthor({
				url: data.top_author_url,
				iconURL: data.top_author_img,
				name: data.top_creator
			})
			.setURL(data.top_url)
			.setThumbnail(data.top_visuel)
			.setImage(data.top_visuel)
			.setFooter({
				iconURL: data.top_author_img,
				text: data.top_creator
			})

		message = {
			content: data.top_title,
			content: `
			👉 ${data.top_title}
Par ${data.top_creator}
${data.top_url}
		`,
			username: "VAINKEUR",
			avatarURL: 'https://i.imgur.com/81uHAdJ.png',
			embeds: [embed],
		};

		newTopsWebhook.send(message);

	break;
}