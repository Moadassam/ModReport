<?php

namespace Moadassam\ModReport;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\Listener;


class Main extends PluginBase implements Listener {

    private $cooldown = [];

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("§aModReport §eBy Moadassam §aON");
    }

    public function onDisable() {
        $this->getLogger()->info("§4ModReport §eBy Moadassam §4OFF");
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
        switch ($cmd->getName()) {
            case "reporthelp":
                $sender->sendMessage("§6Pour faire un report, utilisez la commande suivante : /report Pseudo Raison ! (Plugin By Moadassam)");

                break;

            case "report":
                if (!isset($args[0])) {
                    $sender->sendMessage("§6Tu dois faire /report Pseudo Raison");
                } else {
                    $sendername = $sender->getName();
                    $cheater = $args[0];
                    $raison = implode(" ", array_slice($args, 1));
                    $auteur = $sender->getName();
                    if (isset($this->cooldown[$sendername])) {
                        if ($this->cooldown[$sendername] < time()) {
                            $sender->sendMessage("§4Merci de votre report ! Un modérateur en ligne va s'occuper de votre demande au plus vite !");
                            $this->cooldown[$sendername] = time() + 600;
                            $cheater = $args[0];
                            $raison = implode(" ", array_slice($args, 1));
                            $auteur = $sender->getName();
                            $player = $this->getServer()->getPlayer($cheater);
                            if ($player instanceof Player) {
                                $player->getName();
                                $cheater = $player->getName();
                            }
                            foreach ($this->getServer()->getOnlinePlayers() as $players) {
                                if ($players->hasPermission("report.see")) {
                                    $players->sendMessage("§4§l/!/REPORT/!/\n§r§e-------------\n§4Pseudo : §6 $cheater\n§4Raison : §6 $raison\n§4Auteur : §6 $auteur\n§e-------------");
                                }
                            }
                            return true;
                        } else {
                            $time = $this->cooldown[$sendername] - time();
                            $sender->sendMessage("§6Tu dois attendre encore §4 $time secondes §6pour pouvoir faire un autre report");
                        }
                    } else {
                        $sender->sendMessage("§4Merci de votre report ! Un modérateur en ligne va s'occuper de votre demande au plus vite !");
                        $this->cooldown[$sendername] = time() + 600;
                        $cheater = $args[0];
                        $raison = implode(" ", array_slice($args, 1));
                        $auteur = $sender->getName();
                        $player = $this->getServer()->getPlayer($cheater);
                        if ($player instanceof Player) {
                            $player->getName();
                            $cheater = $player->getName();
                        }
                        foreach ($this->getServer()->getOnlinePlayers() as $players) {
                            if ($players->hasPermission("report.see")) {
                                $players->sendMessage("§4§l/!/REPORT/!/\n§r§e-------------\n§4Pseudo : §6 $cheater\n§4Raison : §6 $raison\n§4Auteur : §6 $auteur\n§e-------------");
                            }
                        }
                        return true;
                    }
                }
                break;
        }
        return true;
    }
}





