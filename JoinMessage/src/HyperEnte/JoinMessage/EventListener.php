<?php

namespace HyperEnte\JoinMessage;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\utils\Config;
use onebone\economyapi\EconomyAPI;

class EventListener implements Listener{


	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$config = new Config(JoinMessage::getMain()->getDataFolder()."joinmessages.json", Config::JSON);
		$name = $player->getName();
		if($config->get($player->getName()) == false){
			$config->set($player->getName(), ["joinmessage" => "default", "leavemessage" => "default"]);
			$config->save();
			$event->setJoinMessage(JoinMessage::getMain()->getConfig()->get("default.firstjoin"));
		}
		$info = $config->get("$name");
		if($info["joinmessage"] === "default"){
			$money = EconomyAPI::getInstance()->myMoney($player);
			date_default_timezone_set(JoinMessage::getMain()->getConfig()->get("timezone"));
			$time = date(JoinMessage::getMain()->getConfig()->get("timeformat"));
			$rank = JoinMessage::getMain()->getPlayerRank($player);
			$joinmsg = str_replace(
				array("[PLAYER]", "[MONEY]", "[TIME]", "[DARK_BLUE]", "[DARK_GREEN]", "[DARK_AQUA]", "[DARK_RED]", "[DARK_PURPLE]", "[GOLD]", "[GRAY]", "[DARK_GRAY]", "[BLUE]", "[BLACK]", "[GREEN]", "[AQUA]", "[RED]", "[LIGHT_PURPLE]", "[YELLOW]", "[WHITE]", "[RANK]"),
				array("$name", "$money", "[$time]", "§1", "§2", "§3", "§4", "§5", "§6", "§7", "§8", "§9", "§0", "§a", "§b", "§c", "§d", "§e", "§f", "$rank"),
				JoinMessage::getMain()->getConfig()->get("default")
			);
			$event->setJoinMessage($joinmsg);
		}
		if($info["joinmessage"] !== "default"){
			$money = EconomyAPI::getInstance()->myMoney($player);
			date_default_timezone_set(JoinMessage::getMain()->getConfig()->get("timezone"));
			$time = date(JoinMessage::getMain()->getConfig()->get("timeformat"));
			$rank = JoinMessage::getMain()->getPlayerRank($player);
			$joinmsg = str_replace(
				array("[PLAYER]", "[MONEY]", "[TIME]", "[DARK_BLUE]", "[DARK_GREEN]", "[DARK_AQUA]", "[DARK_RED]", "[DARK_PURPLE]", "[GOLD]", "[GRAY]", "[DARK_GRAY]", "[BLUE]", "[BLACK]", "[GREEN]", "[AQUA]", "[RED]", "[LIGHT_PURPLE]", "[YELLOW]", "[WHITE]", "[RANK]"),
				array("$name", "$money", "[$time]", "§1", "§2", "§3", "§4", "§5", "§6", "§7", "§8", "§9", "§0", "§a", "§b", "§c", "§d", "§e", "§f", "$rank"),
				$info["joinmessage"]
			);
			$event->setJoinMessage($joinmsg);
		}
		if(JoinMessage::getMain()->getConfig()->get("teleport.to.spawn") === "true"){
			$player->teleport($player->getServer()->getDefaultLevel()->getSpawnLocation());
		}
	}
	public function onQuit(PlayerQuitEvent $event){
		$player = $event->getPlayer();
		$config = new Config(JoinMessage::getMain()->getDataFolder()."joinmessages.json", Config::JSON);
		$name = $player->getName();
		$info = $config->get("$name");
		if($info["leavemessage"] === "default"){
			$money = EconomyAPI::getInstance()->myMoney($player);
			date_default_timezone_set(JoinMessage::getMain()->getConfig()->get("timezone"));
			$time = date(JoinMessage::getMain()->getConfig()->get("timeformat"));
			$rank = JoinMessage::getMain()->getPlayerRank($player);
			$joinmsg = str_replace(
				array("[PLAYER]", "[MONEY]", "[TIME]", "[DARK_BLUE]", "[DARK_GREEN]", "[DARK_AQUA]", "[DARK_RED]", "[DARK_PURPLE]", "[GOLD]", "[GRAY]", "[DARK_GRAY]", "[BLUE]", "[BLACK]", "[GREEN]", "[AQUA]", "[RED]", "[LIGHT_PURPLE]", "[YELLOW]", "[WHITE]", "[RANK]"),
				array("$name", "$money", "[$time]", "§1", "§2", "§3", "§4", "§5", "§6", "§7", "§8", "§9", "§0", "§a", "§b", "§c", "§d", "§e", "§f", "$rank"),
				JoinMessage::getMain()->getConfig()->get("default.leave")
			);
			$event->setQuitMessage($joinmsg);
		}
		if($info["leavemessage"] !== "default"){
			$money = EconomyAPI::getInstance()->myMoney($player);
			date_default_timezone_set(JoinMessage::getMain()->getConfig()->get("timezone"));
			$time = date(JoinMessage::getMain()->getConfig()->get("timeformat"));
			$rank = JoinMessage::getMain()->getPlayerRank($player);
			$joinmsg = str_replace(
				array("[PLAYER]", "[MONEY]", "[TIME]", "[DARK_BLUE]", "[DARK_GREEN]", "[DARK_AQUA]", "[DARK_RED]", "[DARK_PURPLE]", "[GOLD]", "[GRAY]", "[DARK_GRAY]", "[BLUE]", "[BLACK]", "[GREEN]", "[AQUA]", "[RED]", "[LIGHT_PURPLE]", "[YELLOW]", "[WHITE]", "[RANK]"),
				array("$name", "$money", "[$time]", "§1", "§2", "§3", "§4", "§5", "§6", "§7", "§8", "§9", "§0", "§a", "§b", "§c", "§d", "§e", "§f", "$rank"),
				$info["leavemessage"]
			);
			$event->setQuitMessage($joinmsg);
		}
	}
	public function onLevelChange(EntityLevelChangeEvent $event){
		$entity = $event->getEntity();
		if($entity instanceof Player) {
			$name = $entity->getName();
			$money = EconomyAPI::getInstance()->myMoney($entity);
			date_default_timezone_set(JoinMessage::getMain()->getConfig()->get("timezone"));
			$time = date(JoinMessage::getMain()->getConfig()->get("timeformat"));
			$rank = JoinMessage::getMain()->getPlayerRank($entity);
			$world = $event->getTarget()->getFolderName();
			if ($entity instanceof Player) {
				if (JoinMessage::getMain()->getConfig()->get("enabled")) {
					$jm = JoinMessage::getMain()->getConfig()->get("default.world");
					$players = $event->getTarget()->getPlayers();
					foreach ($players as $player) {
						$joinmsg = str_replace(["[PLAYER]", "[MONEY]", "[TIME]", "[DARK_BLUE]", "[DARK_GREEN]", "[DARK_AQUA]", "[DARK_RED]", "[DARK_PURPLE]", "[GOLD]", "[GRAY]", "[DARK_GRAY]", "[BLUE]", "[BLACK]", "[GREEN]", "[AQUA]", "[RED]", "[LIGHT_PURPLE]", "[YELLOW]", "[WHITE]", "[RANK]", "[WORLD]"], ["$name", "$money", "[$time]", "§1", "§2", "§3", "§4", "§5", "§6", "§7", "§8", "§9", "§0", "§a", "§b", "§c", "§d", "§e", "§f", "$rank", "$world"], $jm);
						$player->sendMessage($joinmsg);
						$entity->getPlayer()->sendMessage($joinmsg);
					}
				}
			}
		}
	}
}