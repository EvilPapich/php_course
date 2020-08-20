<?php

echo "Задание 1.<br/>";

for ($n=0; ($numPower = 2**$n)<=10000; $n++) {
    echo "2^$n = $numPower <br/>";
}

echo "<br/>";

/**
 *
 */

echo "Задание 2. <br/>";

$mystr = "absd";

echo "оригинальная строка: $mystr <br/>";

echo "после переворачивания: " . strrev($mystr) . "<br/>";

echo "<br/>";

/**
 *
 */

echo "Задание 3. <br/>";

function addQuotes($item) {
    if (is_string($item)) {
        return "\"$item\"";
    } else {
        return $item;
    }
}

function sum368($arr) {
    $result = 0;
    foreach ($arr as $key => $value) {
        if (is_string($value)) {
            echo "Achtung! Achtung! <br/>";
            return null;
        }
        elseif (in_array($key, [3,6,8])) {
            $result+=$value;
        }
    }
    return $result;
}

$arrayOnlyNumbers = [10,11,12,13,14,15,16,17,18,19];
$arrayWithStrings = [10,11,12,13,14,15,16,17,"18",19];

echo "сумма массива с цифрами [" . implode(",", $arrayOnlyNumbers) . "] = ";
echo sum368($arrayOnlyNumbers) . "<br/>";
echo "сумма массива со строками [" . implode(",", array_map('addQuotes', $arrayWithStrings)) . "] = ";
echo sum368($arrayWithStrings) . "<br/>";

echo "<br/>";

/**
 *
 */

echo "Задание 4. <br/>";

$daysInSep2020 = cal_days_in_month(CAL_GREGORIAN, 9, 2020);
$date=DateTime::createFromFormat("d.m.Y", "01.09.2020")->getTimestamp();
echo "Все вторники сентября 2020г.<br/>";
for ($day=1; $day<=$daysInSep2020; $day++) {
    if (date("D", $date) === "Tue") {
        echo date("d.m.Y", $date) . "<br/>";
    }
    $date += 60 * 60 * 24;
}

echo "<br/>";

/**
 *
 */

echo "Задание 5. <br/>";

function addStrToArr(array $arr, string $text) {
    if (empty($arr) or empty($text)) {
        return false;
    } else {
        $result = [];

        foreach ($arr as $key => $value) {
            $result[$key] = $value . $text;
        }

        return $result;
    }
}

$resultWithEmptyArr = addStrToarr([], "text");
$resultWithEmptyText = addStrToarr(["one", "two", "three"], "");
$resultWithBothParams = addStrToarr(["one", "two", "three"], "text");

echo "function addStrToArr(array \$arr, string \$text) <br/>";
echo "Пустой параметр \$arr: " . ($resultWithEmptyArr ? $resultWithEmptyArr : "false") . " <br/>";
echo "Пустой параметр \$text: " . ($resultWithEmptyText ? $resultWithEmptyText : "false") . " <br/>";
echo "Запуск с параметрами: [" . ($resultWithBothParams ? implode(", ", $resultWithBothParams) : "false") . "] <br/>";

echo "<br/>";

/**
 *
 */

echo "Задание 6. <br/>";

function allTueOfMonth($month, $year) {
    $date = strtotime(str_pad($month, 2, "0", STR_PAD_LEFT) . "/01" .  "/$year");

    if ($date) {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        echo "Все вторники " . str_pad($month, 2, "0", STR_PAD_LEFT) . ".2020г.<br/>";
        for ($day=1; $day<=$daysInMonth; $day++) {
            if (date("D", $date) === "Tue") {
                echo date("d.m.Y", $date) . "<br/>";
            }
            $date += 60 * 60 * 24;
        }
    } else {
        echo $year . " - неверный год<br/>";
    }
}

echo "function allTueOfMonth(\$month, \$year) <br/>";
echo "Вызов с некорректным годом (1, -10): <br/>";
echo allTueOfMonth(1, -10) . "<br/>";
echo "Вызов с корректным годом (9, 2020): <br/>";
echo allTueOfMonth(9, 2020) . "<br/>";

echo "<br/>";

/**
 *
 */

echo "Задание 7. <br/>";

function a($number=0) {
    while (true) {
        $tempNumber = "" . $number;

        $arrayNumber = preg_split('//',$tempNumber);
        array_pop($arrayNumber);
        array_shift($arrayNumber);
        $match = true;
        foreach ($arrayNumber as $int) {
            if (!in_array($int, [3,7])) {
                $match = false;
            }
        }

        if ($match) {
            break;
        }

        $number++;
    }
    return $number;
}

function b($number=0) {
    while (true) {
        $tempNumber = "" . $number;

        $arrayNumber = preg_split('//',$tempNumber);
        array_pop($arrayNumber);
        array_shift($arrayNumber);
        $match = true;
        foreach ($arrayNumber as $int) {
            if (!in_array($int, [3,7])) {
                $match = false;
            }
        }
        if ($match) {
            if (in_array(3, $arrayNumber) && in_array(7, $arrayNumber)) {
                $match = true;
            } else {
                $match = false;
            }
        }

        if ($match) {
            break;
        }

        $number++;
    }
    return $number;
}

function c($number=1) {
    while (true) {
        $match = true;
        if($number % 3 === 0 && $number % 7 === 0) {
            $match = true;
        } else {
            $match = false;
        }

        if ($match) {
            $tempNumber = "" . $number;

            $arrayNumber = preg_split('//',$tempNumber);
            array_pop($arrayNumber);
            array_shift($arrayNumber);

            $sumNumber = 0;
            foreach ($arrayNumber as $int) {
                $sumNumber+= $int;
            }

            if($sumNumber % 3 === 0 && $sumNumber % 7 === 0) {
                $match = true;
            } else {
                $match = false;
            }
        }

        if ($match) {
            break;
        }

        $number++;
    }
    return $number;
}

$resultA = a(0);
$resultB = b($resultA);
$resultC = c(1);

echo "a. оно записывается только с помощью цифр 3 и 7: <br/>";
echo $resultA . "<br/>";
echo "b. оно обязательно должно содержать цифры 3 и 7: <br/>";
echo $resultB . "<br/>";
echo "c. оно и сумма его цифр делятся на 3 и 7. Например, 7 733 733 делится без<br/>" .
    "остатка на 3 и на 7, но сумма его цифр (33) на 3 делится, а на 7 нет,<br/>".
    " поэтому такое число не может служить решением задачи. <br/>";
echo $resultC . "<br/>";
