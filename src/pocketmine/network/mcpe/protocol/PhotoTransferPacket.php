<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\handler\SessionHandler;

class PhotoTransferPacket extends DataPacket{
    public const NETWORK_ID = ProtocolInfo::PHOTO_TRANSFER_PACKET;

    /** @var string */
    public $photoName;
    /** @var string */
    public $photoData;
    /** @var string */
    public $bookId; //photos are stored in a sibling directory to the games folder (screenshots/(some UUID)/bookID/example.png)

    protected function decodePayload() : void{
        $this->photoName = $this->getString();
        $this->photoData = $this->getString();
        $this->bookId = $this->getString();
    }

    protected function encodePayload() : void{
        $this->putString($this->photoName);
        $this->putString($this->photoData);
        $this->putString($this->bookId);
    }

    public function handle(SessionHandler $handler) : bool{
        return $handler->handlePhotoTransfer($this);
    }
}