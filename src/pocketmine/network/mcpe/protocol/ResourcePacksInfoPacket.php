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
use pocketmine\resourcepacks\ResourcePack;

class ResourcePacksInfoPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::RESOURCE_PACKS_INFO_PACKET;

	/** @var bool */
	public $mustAccept = false; //if true, forces client to use selected resource packs
	/** @var ResourcePack[] */
	public $behaviorPackEntries = [];
	/** @var ResourcePack[] */
	public $resourcePackEntries = [];

	protected function decodePayload(){
		/*$this->mustAccept = $this->getBool();
		$behaviorPackCount = $this->getLShort();
		while($behaviorPackCount-- > 0){
			$id = $this->getString();
			$version = $this->getString();
			$size = $this->getLLong();
			$this->behaviorPackEntries[] = new ResourcePackInfoEntry($id, $version, $size);
			$this->getString();
		}

		$resourcePackCount = $this->getLShort();
		while($resourcePackCount-- > 0){
			$id = $this->getString();
			$version = $this->getString();
			$size = $this->getLLong();
			$this->resourcePackEntries[] = new ResourcePackInfoEntry($id, $version, $size);
			$this->getString();
		}*/
	}

	protected function encodePayload(){

		$this->putBool($this->mustAccept);
		$this->putLShort(count($this->behaviorPackEntries));
		foreach($this->behaviorPackEntries as $entry){
			$this->putString($entry->getPackId());
			$this->putString($entry->getPackVersion());
			$this->putLLong($entry->getPackSize());
			$this->putString(""); //TODO: encryption key
			$this->putString(""); //TODO: subpack name
            $this->putString(""); //TODO: content identity
		}
		$this->putLShort(count($this->resourcePackEntries));
		foreach($this->resourcePackEntries as $entry){
			$this->putString($entry->getPackId());
			$this->putString($entry->getPackVersion());
			$this->putLLong($entry->getPackSize());
			$this->putString(""); //TODO: encryption key
			$this->putString(""); //TODO: subpack name
            $this->putString(""); //TODO: content identity
		}
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleResourcePacksInfo($this);
	}
}
