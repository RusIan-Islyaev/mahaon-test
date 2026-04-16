<?php
use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Type\DateTime;

if (Loader::includeModule('highloadblock')) {
    // обработчик события OnPageStart
    EventManager::getInstance()->addEventHandler(
        'main',
        'OnPageStart',
        function () {
            // Если служебный url
            $requestUri = $_SERVER['REQUEST_URI'];
            $excludedPaths = ['/bitrix/', '/upload/', '/ajax/']; // исключение ядра битрикс и ajax
            foreach ($excludedPaths as $path) {
                if (strpos($requestUri, $path) === 0) {
                    return;
                }
            }

            // HL-блок
            $hlblockId = 1;
            $hlblock = HL\HighloadBlockTable::getById($hlblockId)->fetch();
            if (!$hlblock) {
                return;
            }
            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
            $entityClass = $entity->getDataClass();

            // запись о посещении
            $result = $entityClass::add([
                'UF_IP' => $_SERVER['REMOTE_ADDR'],
                'UF_URL' => $requestUri,
                'UF_DATE' => new DateTime(),
                'UF_REFERRER' => $_SERVER['HTTP_REFERER'] ?: '',
            ]);

            if (!$result->isSuccess()) {
                AddMessage2Log('Ошибка записи посещения: ' . implode(', ', $result->getErrorMessages()));
            }
        }
    );
}