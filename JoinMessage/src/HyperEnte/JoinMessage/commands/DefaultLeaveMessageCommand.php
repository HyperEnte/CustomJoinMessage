<?php

namespace HyperEnte\JoinMessage\commands;

use HyperEnte\JoinMessage\forms\DefaultLeaveForm;
use HyperEnte\JoinMessage\JoinMessage;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use HyperEnte\JoinMessage\forms\DefaultForm;
use pocketmine\Player;

class DefaultLeaveMessageCommand extends PluginCommand{

	public function __construct(){
		parent::__construct("defaultleavemessage", JoinMessage::getMain());
		$this->setDescription("Change the Default LeaveMessage");
		$this->setAliases(["defaultleave", "dlm"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$sender instanceof Player) return;

		if(!$sender->hasPermission(JoinMessage::getMain()->getConfig()->get("permission.admin"))){
			$sender->sendMessage(JoinMessage::getMain()->getConfig()->get("prefix") . JoinMessage::getMain()->getConfig()->get("noperm"));
			return false;
		}
		if($sender->hasPermission(JoinMessage::getMain()->getConfig()->get("permission.admin"))){
			$sender->sendForm(new DefaultLeaveForm());
		}
	}
}