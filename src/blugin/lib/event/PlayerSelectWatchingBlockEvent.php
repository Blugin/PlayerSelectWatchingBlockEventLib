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

namespace blugin\lib\event;

use pocketmine\block\Block;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\event\player\PlayerEvent;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class PlayerSelectWatchingBlockEvent extends PlayerEvent implements Cancellable{
    use CancellableTrait;

    /** @var Block */
    private $blockSelected;
    /** @var Vector3|null */
    private $lookAt;

    public function __construct(Player $player, Block $blockSelected, ?Vector3 $lookAt = null){
        $this->player = $player;
        $this->blockSelected = $blockSelected;
        $this->lookAt = $lookAt;
    }

    /** @return Block */
    public function getBlock() : Block{
        return $this->blockSelected;
    }

    /** @return Vector3|null */
    public function getLookAt() : ?Vector3{
        return $this->lookAt;
    }

    /** @param Vector3|null $lookAt */
    public function setLookAt(?Vector3 $lookAt) : void{
        $this->lookAt = $lookAt;
    }
}
