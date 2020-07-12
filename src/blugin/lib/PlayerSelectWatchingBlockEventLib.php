<?php

/*
 *
 *  ____  _             _         _____
 * | __ )| |_   _  __ _(_)_ __   |_   _|__  __ _ _ __ ___
 * |  _ \| | | | |/ _` | | '_ \    | |/ _ \/ _` | '_ ` _ \
 * | |_) | | |_| | (_| | | | | |   | |  __/ (_| | | | | | |
 * |____/|_|\__,_|\__, |_|_| |_|   |_|\___|\__,_|_| |_| |_|
 *                |___/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author  Blugin team
 * @link    https://github.com/Blugin
 * @license https://www.gnu.org/licenses/lgpl-3.0 LGPL-3.0 License
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 */

declare(strict_types=1);

namespace blugin\lib;

use blugin\lib\event\PlayerSelectWatchingBlockEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class PlayerSelectWatchingBlockEventLib extends PluginBase implements Listener{
    /** @var int[] */
    private $sneaktimes = [];

    /**
     * Called when the plugin is loaded, before calling onEnable()
     */
    public function onLoad() : void{
        $this->getServer()->getLogger()->debug(TextFormat::AQUA . "[Blugin/lib] PlayerSelectWatchingBlockEventLib is loaded");
    }

    /**
     * Called when the plugin is enabled
     */
    public function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    /**
     * @priority MONITOR
     *
     * @param PlayerToggleSneakEvent $event
     */
    public function onPlayerToggleSneakEvent(PlayerToggleSneakEvent $event) : void{
        if($event->isCancelled() || $event->isSneaking())
            return;

        $player = $event->getPlayer();
        $id = $player->getId();
        if(!isset($this->sneaktimes[$id]) || $this->sneaktimes[$id] < time() - 1){
            $this->sneaktimes[$id] = time();
            return;
        }

        $targetBlock = $player->getTargetBlock(5);
        if($targetBlock === null)
            return;

        $ev = new PlayerSelectWatchingBlockEvent($player, $targetBlock);
        $ev->call();
    }
}
