<?php
declare(strict_types=1);

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
];

$items = [];

// Запрос номера операции у пользователя
function requestOperation(array $operations,): int
{
    system('clear');

    if (!empty($items)) {
        echo 'Ваш список покупок:' . PHP_EOL;
        echo implode(PHP_EOL, $items) . PHP_EOL;
    } else {
        echo 'Ваш список покупок пуст.' . PHP_EOL;
    }
    
    echo 'Выберите операцию для выполнения:' . PHP_EOL;
    echo implode(PHP_EOL, $operations) . PHP_EOL . '> ';

    $input = trim(fgets(STDIN));
    $operationNumber = is_numeric($input) ? (int)$input : -1;

    while (!array_key_exists($operationNumber, $operations)) {
        system('clear');
        echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        echo 'Выберите операцию для выполнения:' . PHP_EOL;
        echo implode(PHP_EOL, $operations) . PHP_EOL . '> ';
        $input = trim(fgets(STDIN));
        $operationNumber = is_numeric($input) ? (int)$input : -1;
    }

    return $operationNumber;
}

// Добавление товаров в список
function addOperation(array &$items): void
{
    echo 'Введите название товара для добавления в список:' . PHP_EOL . '> ';
    $itemName = trim(fgets(STDIN));
    if ($itemName !== '') {
        $items[] = $itemName;
        echo "Товар '$itemName' добавлен в список." . PHP_EOL; 
    } else {
        echo 'Название товара не может быть пустым.' . PHP_EOL;
    }
}

// Удаление товаров из списка
function deleteOperation(array &$items): void
{
    if (empty($items)) {
        echo 'Список покупок пуст, удаление невозможно.' . PHP_EOL;
        return;
    }

    echo 'Текущий список покупок:' . PHP_EOL;
    echo implode(PHP_EOL, $items) . PHP_EOL;
    echo 'Введите название товара для удаления из списка:' . PHP_EOL . '> ';
    
    $itemName = trim(fgets(STDIN));
    
    if ($itemName === '') {
        echo 'Название товара не может быть пустым.' . PHP_EOL;
        return;
    }

    $removed = false;
    foreach ($items as $key => $value) {
        if ($value === $itemName) {
            unset($items[$key]);
            $removed = true;
        }
    }

    if ($removed) {
        echo "Товар '$itemName' удалён из списка." . PHP_EOL;
    } else {
        echo "Товар '$itemName' не найден в списке." . PHP_EOL;
    }
}

// Печать списка товаров
function printOperation(array $items): void
{
    echo 'Ваш список покупок:' . PHP_EOL;
    if (!empty($items)) {
        echo implode(PHP_EOL, $items) . PHP_EOL;
    }
    echo 'Всего ' . count($items) . ' позиций.' . PHP_EOL;
    echo 'Нажмите Enter для продолжения...';
    fgets(STDIN);
}

do {
    $operationNumber = requestOperation($operations, $items);
    echo 'Выбрана операция: ' . $operations[$operationNumber] . PHP_EOL;

    switch ($operationNumber) {
        case OPERATION_ADD:
            addOperation($items);
            break;

        case OPERATION_DELETE:
            deleteOperation($items);
            break;
            
        case OPERATION_PRINT:
            printOperation($items);
            break;
    }

    echo PHP_EOL . '-----' . PHP_EOL;
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;
