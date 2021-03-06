<?php

namespace mcbe\boymelancholy\signedit\util;

use pocketmine\block\utils\SignText;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\nbt\tag\CompoundTag;

class WrittenSign
{
    private bool $isStandable = false;
    private bool $isHangable = false;
    private SignText $signText;

    public function __construct(SignText $signText)
    {
        $this->signText = $signText;
    }

    public function setStandable(bool $value = true)
    {
        $this->isStandable = $value;
    }

    public function setHangable(bool $value = true)
    {
        $this->isHangable = $value;
    }

    public function create(): Item {
        $id = 323;
        $name = '編集済み{%i}看板';
        if ($this->isStandable) {
            $id = ItemIds::SIGN_POST;
            $name = str_replace('{%i}', '設置型', $name);
        }
        if ($this->isHangable) {
            $id = ItemIds::WALL_SIGN;
            $name = str_replace('{%i}', '壁掛型', $name);
        }
        $obj = ItemFactory::getInstance()->get($id, 0, 1);

        $tag = new CompoundTag();
        $tag->setString('Text1', $this->signText->getLine(0));
        $tag->setString('Text2', $this->signText->getLine(1));
        $tag->setString('Text3', $this->signText->getLine(2));
        $tag->setString('Text4', $this->signText->getLine(3));
        $obj->setCustomBlockData($tag);

        $obj->setCustomName($name);
        $obj->setLore($this->signText->getLines());
        return $obj;
    }
}