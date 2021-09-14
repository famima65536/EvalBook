<?php

declare(strict_types=1);

namespace NeiroNetwork\EvalBook\item;

use NeiroNetwork\EvalBook\permission\EvalBookPermissionNames;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\item\WritableBook;
use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;

abstract class ExecutableBook{

	public static function equals(Item $item) : bool{
		return (EvalBook::equalsInternal($item) || CodeBook::equalsInternal($item)) && ExecutableBook::equalsInternal($item);
	}

	protected static function equalsInternal(Item $item) : bool{
		return isset(($lore = $item->getLore())[0])
			&& ($lore[0] === "default" || $lore[0] === "op" || $lore[0] === "everyone");
	}

	public static function getExecutePermission(WritableBook|string $bookOrPerm) : ?Permission{
		if(!is_string($bookOrPerm)){
			$bookOrPerm = $bookOrPerm->getLore()[0] ?? "";
		}
		return PermissionManager::getInstance()->getPermission(EvalBookPermissionNames::EVALBOOK_EXECUTE . ".$bookOrPerm");
	}

	public static function execute(WritableBook $book, CommandSender $sender = null) : bool{
		try{
			var_dump(self::parseBookCode($book));
			eval(self::parseBookCode($book));
		}catch(\Throwable $exception){
			// TODO
			return false;
		}
		return true;
	}

	public static function parseBookCode(WritableBook $book) : string{
		$stack = "";
		foreach($book->getPages() as $page){
			if(!empty($text = $page->getText())){
				$stack .= $text . (str_ends_with($text, "\n") ? "" : "\n");
			}
		}
		return $stack;
	}
}