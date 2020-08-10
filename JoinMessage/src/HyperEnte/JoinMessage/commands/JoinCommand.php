<?php

namespace HyperEnte\JoinMessage\commands;

use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use HyperEnte\JoinMessage\JoinMessage;

class JoinCommand extends PluginCommand{

	public function __construct(){
		parent::__construct("join", JoinMessage::getMain());
		$this->setDescription("JoinMessage Main Command");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if (!$sender instanceof Player)
			return;
			if(!isset($args[0])){
				$sender->sendMessage("§cPlease use /join help");
			}
			if(isset($args[0])) {
				switch ($args[0]) {
					case "help":
						$sender->sendMessage("§a/join help §8- §fSee all commands");
						$sender->sendMessage("§a/join about §8- §f See infos to the plugin and the author");
						if ($sender->hasPermission(JoinMessage::getMain()->getConfig()->get("permission"))) {
							$sender->sendMessage("§a/join placeholders §8- §fSee all placeholders");
							$sender->sendMessage("§a/joinmessage §8- §f Change your JoinMessage");
							$sender->sendMessage("§a/leavemessage §8- §fChange your LeaveMessage");
						}
						if ($sender->hasPermission(JoinMessage::getMain()->getConfig()->get("permission.admin"))) {
							$sender->sendMessage("§a/defaultmessage §8- §fSet the default JoinMessage");
							$sender->sendMessage("§a/defaultleavemessage §8- §fSet the default LeaveMessage");
						}
						break;
					case "about":
						$sender->sendMessage("§f-=-=- [§bCustomJoinMessage§f] -=-=-");
						$sender->sendMessage("§fVersion: §61.2.0");
						$sender->sendMessage("§fAuthor: §6HyperEnte");
						break;
					case "placeholders":
						$sender->sendMessage("§e[NAME] - The players name");
						$sender->sendMessage("§e[TIME] - Show the time");
						$sender->sendMessage("§e[MONEY] - Show the players money");
						$sender->sendMessage("§e[RANK] - Show the players Rank");
						$sender->sendMessage("§f-- §aC§bO§cL§dO§eR§5S §f --");
						$sender->sendMessage("[DARK_BLUE], [DARK_GREEN], [DARK_AQUA], [DARK_RED], [DARK_PURPLE], [GOLD], [GRAY], [DARK_GRAY], [BLUE], [BLACK], [GREEN], [AQUA], [RED], [LIGHT_PURPLE], [YELLOW], [WHITE]");
				}
			}
	}
}
