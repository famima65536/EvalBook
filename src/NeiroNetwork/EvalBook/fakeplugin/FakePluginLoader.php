<?php

declare(strict_types=1);

namespace NeiroNetwork\EvalBook\fakeplugin;

use pocketmine\plugin\PluginDescription;
use pocketmine\plugin\PluginLoader;

class FakePluginLoader implements PluginLoader{

	public function canLoadPlugin(string $path) : bool{
		return false;
	}

	public function loadPlugin(string $file) : void{
	}

	public function getPluginDescription(string $file) : ?PluginDescription{
		return null;
	}

	public function getAccessProtocol() : string{
		return "";
	}
}