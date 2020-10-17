<?php
/*
  Created by Pierre Bernardeau.
  Date: 17/10/2020
  Time: 16:58
  
        _
    ,--'_`--.    
  ,/( \   / )\.  
 //  \ \_/ /  \\ 
|/___/     \___\|
((___       ___))    Join the Empire !!!  ﴾̵ ̵◎̵ ̵﴿
|\   \  _  /   /|
 \\  / / \ \  // 
  `\(_/___\_)/'
    `--._.--'
  
 */

// Créer ici un tableau des membres participant au Secret Santa sous la forme Nom,email.
$members = array(
    "Player 1,player1@mail.com",
    "Player 2,player2@mail.com",
    "Player 3,player3@mail.com",
    "Player 4,player4@mail.com",
    "Player 5,player5@mail.com",
    "Player 6,player6@mail.com",
    "Player 7,player7@mail.com",
    "Player 8,player8@mail.com",
    "Player 9,player9@mail.com",
    "Player 10,player10@mail.com"
);

// Et maintenant notre liste de cibles...
$targets = $members;

// On mélange tout ça... (ça marche bien avec des petites listes...)
while(count(array_intersect_assoc($members, $targets))) {
    shuffle($targets);
}

// On va préparer des mails pour l'envoi du secret santa.
$mails = array();
foreach ($members as $key=>$value){
    $member_name = explode(",",$value)[0];
    $mails[$key]["mail"] = explode(",",$value)[1];
    $target_name = explode(",",$targets[$key])[0];
    $mails[$key]["content"] = "Bonjour $member_name.\r\n Ta cible pour le Secret Santa de cetta année a été désignée... Fais défiler ce mail pour découvrir son identité...";
    $mails[$key]["content"] .="\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n";
    $mails[$key]["content"] .= "Ta cible est : $target_name !!!\r\nTu ne devras jamais révéler cette information à quiconque sous peine de briser la magie du Secret Santa.";
}

// Et on envoie les mails :)
require 'vendor/autoload.php';
use Mailgun\Mailgun;
$mg = Mailgun::create("clef de mailgun");

foreach ($mails as $mail){
    echo "Envoi du mail à ". $mail["mail"]."\n";
    $mg->messages()->send("domaine du compte mailgun", [
        "from"    => "noreply@domaine.com",
        "to"      => $mail["mail"],
        "subject" => "Ta cible pour le Secret Santa 2020 a été désignée !",
        "text"    => $mail["content"]
    ]);
}
