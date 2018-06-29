<?php

/*
 *               _ _
 *         /\   | | |
 *        /  \  | | |_ __ _ _   _
 *       / /\ \ | | __/ _` | | | |
 *      / ____ \| | || (_| | |_| |
 *     /_/    \_|_|\__\__,_|\__, |
 *                           __/ |
 *                          |___/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author TuranicTeam
 * @link https://github.com/TuranicTeam/Altay
 *
 */

declare(strict_types=1);

namespace pocketmine\entity\behavior;

use pocketmine\event\entity\EntityDamageByEntityEvent;

class OwnerHurtByTargetBehavior extends FindAttackableTargetBehavior{

    protected $mutexBits = 1;

    public function canStart() : bool{
        $owner = $this->mob->getOwningEntity();

        if($owner !== null){
            $cause = $owner->getLastDamageCause();
            if($cause instanceof EntityDamageByEntityEvent){
                $this->mob->setTargetEntity($cause->getDamager());
                return true;
            }
        }

        return false;
    }

    public function onEnd() : void{
        parent::onEnd();
        $this->mob->setLastDamageCause(null);
    }
}