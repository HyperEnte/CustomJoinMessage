<?php

namespace HyperEnte\JoinMessage;

use HyperEnte\JoinMessage\commands\DefaultMessageCommand;
use HyperEnte\JoinMessage\commands\JoinMessageCommand;
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
		$this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
		$config = new Config($this->getDataFolder() . "joinmessages.json", Config::JSON);
		$config->save();
		$this->getServer()->getCommandMap()->registerAll("JoinMessage", [new JoinMessageCommand(), new DefaultMessageCommand()]);
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