<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if (empty($arResult['ITEMS'])): ?>
    <p>Нет данных о посещениях.</p>
<?php else: ?>
    <ul>
        <?php foreach ($arResult['ITEMS'] as $item): ?>
            <li>
                <strong>IP:</strong> <?= htmlspecialchars($item['UF_IP']) ?><br>
                <strong>URL:</strong> <?= htmlspecialchars($item['UF_URL']) ?><br>
                <strong>Дата и время:</strong> <?= htmlspecialchars($item['UF_DATE']) ?><br>
                <strong>Referrer:</strong> <?= htmlspecialchars($item['UF_REFERRER'] ?: '—') ?><br>
            </li>
            <hr>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>