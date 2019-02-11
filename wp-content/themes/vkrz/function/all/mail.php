<?php
class MandrilMail {
	//Mandrill API KEY - connexion au compte Mandrill
	private $mandrillKey = "wWAcDSE5tAu4aiF-Tdm3bg";
	//Nom expéditeur
	private $fromName = 'Gopened';
	private $mandrill = null;
	public function __construct(){
		$this->mandrill = new Mandrill($this->mandrillKey);
	}
	/* Paramètres :     - template :            nom du template sur le compte Mandrill
						- to :                  adresse à laquelle on l'envoi
						- subject :             objet du mail
						- template_content :    contenu dynamique
	*/
	public function sendMail($template, $to, $from, $template_content){

		//configuration du message
		$message = array(
			'from_name'  => $this->fromName,
			'from_email' => $from,
			'to'         => array(
				array(
					'email' => $to
				)
			)
		);
		$this->mandrill->messages->sendTemplate($template, $template_content, $message);
	}
}