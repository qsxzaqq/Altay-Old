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

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\types\EntityLink;

class SetActorLinkPacket extends DataPacket{
    public const NETWORK_ID = ProtocolInfo::SET_ACTOR_LINK_PACKET;

    /** @var EntityLink */
    public $link;

    protected function decodePayload(){
        $this->link = $this->getEntityLink();
    }

    protected function encodePayload(){
        $this->putEntityLink($this->link);
    }

    public function handle(NetworkSession $session) : bool{
        return $session->handleSetActorLink($this);
    }

}
