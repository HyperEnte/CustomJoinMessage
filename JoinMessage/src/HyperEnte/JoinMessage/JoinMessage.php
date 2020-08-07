<?php

namespace HyperEnte\JoinMessage;

use HyperEnte\JoinMessage\commands\DefaultLeaveMessageCommand;
use HyperEnte\JoinMessage\commands\DefaultMessageCommand;
use HyperEnte\JoinMessage\commands\JoinMessageCommand;
use HyperEnte\JoinMessage\commands\LeaveMessageCommand;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use _64FF00\PurePerms\PurePerms;

class JoinMessage extends PluginBase
{

	private static $main;
	public static $devices = [];
	private $purePerms;

	public function onEnable(){
		self::$main = $this;
		if($this->getConfig()->get("version") != "2"){
			$this->getServer()->getLogger()->info("\n\nYour config file was outdated. Please restart the server\n");
			unlink($this->getDataFolder() . "joinmessages.json");
			unlink($this->getDataFolder() . "config.yml");
			return;
		}
		$this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
		$config = new Config($this->getDataFolder() . "joinmessages.json", Config::JSON);
		$config->save();
		$this->getServer()->getCommandMap()->registerAll("JoinMessage", [new JoinMessageCommand(), new DefaultMessageCommand(), new LeaveMessageCommand(), new DefaultLeaveMessageCommand()]);
		$this->purePerms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
	}

	public static function getMain(): self{
		return self::$main;
	}

	public function getPlayerRank(Player $player): string{
		$group = $this->purePerms->getUserDataMgr()->getData($player)['group'];

		if($group !== null){
			return $group;
		}else{
			return "No Rank";
		}
	}
}