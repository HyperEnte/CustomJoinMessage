<?php

namespace HyperEnte\JoinMessage\forms;

use HyperEnte\JoinMessage\JoinMessage;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\Player;
use pocketmine\utils\Config;


class DefaultForm extends CustomForm{
	public function __construct(){
		$callable = function (Player $player, $data){
			$name = $player->getName();
			if($data === 0){
				return;
			}
			JoinMessage::getMain()->getConfig()->set("default", $data[0]);
			JoinMessage::getMain()->getConfig()->save();
			$player->sendMessage(strval(JoinMessage::getMain()->getConfig()->get("success")));
		};
		parent::__construct($callable);
		$this->setTitle(JoinMessage::getMain()->getConfig()->get("title"));
		$this->addInput("[PLAYER] for the playername", "default");
	}
}