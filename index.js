
const { EmbedBuilder, WebhookClient } = require('discord.js');
const webhookClient = new WebhookClient({ url: 'https://discord.com/api/webhooks/1039548051326509177/_2m-A0Bb4yfbq2ptYKLoFIGFVSjf8e7KpxeUXzOnDvu7cefcwh4v8wzuoHBvxyChJSF5' });

const embed = new EmbedBuilder()
	.setTitle('Machin est passé au niveau 4')
	.setColor(0x00FFFF);

webhookClient.send({
	content: 'Webhook test',
	username: 'some-username',
	avatarURL: 'https://i.imgur.com/AfFp7pu.png',
	embeds: [embed],
});

alert('Mamasita');