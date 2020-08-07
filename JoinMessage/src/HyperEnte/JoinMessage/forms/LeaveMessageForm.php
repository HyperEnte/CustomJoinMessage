<?php

namespace HyperEnte\JoinMessage\forms;

use HyperEnte\JoinMessage\JoinMessage;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\Player;
use pocketmine\utils\Config;


class LeaveMessageForm extends CustomForm{
	public function __construct(){
		$callable = function (Player $player, $data){
			$name = $player->getName();
			$config = new Config(JoinMessage::getMain()->getDataFolder()."joinmessages.json", Config::JSON);
			$info = $config->get("$name");
			$newmessage = $data[0];
			if($data === 0) return;

			$config->set("$name", ["leavemessage" => "$newmessage"]);
			$config->save();
			$player->sendMessage(strval(JoinMessage::getMain()->getConfig()->get("success.lm")));
		};
		parent::__construct($callable);
		$this->setTitle(JoinMessage::getMain()->getConfig()->get("title"));
		$this->addInput("[PLAYER] for your name", "default");
	}
}