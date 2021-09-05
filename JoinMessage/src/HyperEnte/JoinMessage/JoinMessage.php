<?php

namespace HyperEnte\JoinMessage;

use HyperEnte\JoinMessage\commands\DefaultLeaveMessageCommand;
use HyperEnte\JoinMessage\commands\DefaultMessageCommand;
use HyperEnte\JoinMessage\commands\JoinCommand;
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

	public function onEnable()
	{
		self::$main = $this;

		$this->reloadConfig();

		if ($this->getConfig()->get("version") <= "3") {
			$this->getServer()->getLogger()->info("\n\nYour config file was outdated. Please restart the server\n");
			unlink($this->getDataFolder() . "config.yml");
		}
		$this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
		$config = new Config($this->getDataFolder() . "joinmessages.json", Config::JSON);
		$config->save();
		$worldmsg = new Config($this->getDataFolder() . "worldmessages.json", Config::JSON);
		$worldmsg->save();
		$this->getServer()->getCommandMap()->registerAll("JoinMessage", [new JoinMessageCommand(), new DefaultMessageCommand(), new LeaveMessageCommand(), new DefaultLeaveMessageCommand(), new JoinCommand()]);
		$this->purePerms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
	}

	public static function getMain(): self
	{
		return self::$main;
	}

	public function getPlayerRank(Player $player): string
	{
		$group = $this->purePerms->getUserDataMgr()->getData($player)['group'];

		if ($group !== null) {
			return $group;
		} else {
			return "No Rank";
		}
	}
	public function getJoinMessage(Player $player)
	{
		$name = $player->getName();
		$config = new Config(JoinMessage::getMain()->getDataFolder() . "joinmessages.json", Config::JSON);
		$info = $config->get("$name");
		$info["joinmessage"];
	}
}
