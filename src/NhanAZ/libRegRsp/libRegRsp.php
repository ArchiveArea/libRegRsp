<?php

declare(strict_types=1);

namespace NhanAZ\libRegRsp;

use pocketmine\plugin\PluginBase;
use pocketmine\resourcepacks\ZippedResourcePack;
use ReflectionClass;

class libRegRsp {

	public function __construct(
		private PluginBase $plugin
	) {
	}

	public function regRsp(string $packName): void {
		$this->plugin->saveResource($packName, true);

		$manager = $this->plugin->getServer()->getResourcePackManager();
		$pack = new ZippedResourcePack($this->plugin->getDataFolder() . $packName);

		$reflection = new ReflectionClass($manager);

		$property = $reflection->getProperty("resourcePacks");
		$property->setAccessible(true);

		$currentResourcePacks = $property->getValue($manager);
		$currentResourcePacks[] = $pack;
		$property->setValue($manager, $currentResourcePacks);

		$property = $reflection->getProperty("uuidList");
		$property->setAccessible(true);
		$currentUUIDPacks = $property->getValue($manager);
		$currentUUIDPacks[strtolower($pack->getPackId())] = $pack;
		$property->setValue($manager, $currentUUIDPacks);

		$property = $reflection->getProperty("serverForceResources");
		$property->setAccessible(true);
		$property->setValue($manager, true);
	}

	public function unRegRsp(string $packName): void {
		$this->plugin->saveResource($packName, true);

		$manager = $this->plugin->getServer()->getResourcePackManager();
		$pack = new ZippedResourcePack($this->plugin->getDataFolder() . $packName);

		$reflection = new ReflectionClass($manager);

		$property = $reflection->getProperty("resourcePacks");
		$property->setAccessible(true);
		$currentResourcePacks = $property->getValue($manager);
		$key = array_search($pack, $currentResourcePacks, true);
		if ($key !== false) {
			unset($currentResourcePacks[$key]);
			$property->setValue($manager, $currentResourcePacks);
		}

		$property = $reflection->getProperty("uuidList");
		$property->setAccessible(true);
		$currentUUIDPacks = $property->getValue($manager);
		if (isset($currentResourcePacks[mb_strtolower($pack->getPackId())])) {
			unset($currentUUIDPacks[mb_strtolower($pack->getPackId())]);
			$property->setValue($manager, $currentUUIDPacks);
		}
	}
}
