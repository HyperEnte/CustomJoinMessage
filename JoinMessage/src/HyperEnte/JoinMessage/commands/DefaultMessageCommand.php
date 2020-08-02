<?php

namespace HyperEnte\JoinMessage\commands;

use HyperEnte\JoinMessage\JoinMessage;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use HyperEnte\JoinMessage\forms\DefaultForm;
use pocketmine\Player;

class DefaultMessageCommand extends PluginCommand{

	public function __construct(){
		parent::__construct("defaultmessage", JoinMessage::getMain());
		$this->setDescription("Change the Default JoinMessage");
		$this->setAliases(["defaultmsg", "djm"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$sender instanceof Player) return;

		if(!$sender->hasPermission(JoinMessage::getMain()->getConfig()->get("permission.admin"))){
			$sender->sendMessage(JoinMessage::getMain()->getConfig()->get("prefix") . JoinMessage::getMain()->getConfig()->get("noperm"));
			return false;
		}
		if($sender->hasPermission(JoinMessage::getMain()->getConfig()->get("permission.admin"))){
			$sender->sendForm(new DefaultForm());
		}
	}
}