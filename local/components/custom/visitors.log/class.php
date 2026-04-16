<?php
namespace Custom\Components;

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;
use CBitrixComponent;

class VisitorLogComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        if (!Loader::includeModule('highloadblock')) {
            return;
        }

        // HL-блок
        $hlblockId = $this->arParams['HLB_ID'];
        $hlblock = HL\HighloadBlockTable::getById($hlblockId)->fetch();
        if (!$hlblock) {
            return;
        }
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entityClass = $entity->getDataClass();

        // Последние 30 записей
        $result = $entityClass::getList([
            'select' => ['ID', 'UF_IP', 'UF_URL', 'UF_DATE', 'UF_REFERRER'],
            'order' => ['UF_DATE' => 'DESC'],
            'limit' => 30,
        ]);

        $this->arResult['ITEMS'] = [];
        while ($row = $result->fetch()) {
            $this->arResult['ITEMS'][] = $row;
        }

        $this->includeComponentTemplate();
    }
}