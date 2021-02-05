<?php

function getFullnameFromParts($surname, $name, $patronomyc)
{
    return $surname . " " . $name . " " . $patronomyc;
}

function getPartsFromFullname($fullName)
{
    $dataArr = explode(" ", $fullName);
    return ['surname' => $dataArr[0], 'name' => $dataArr[1], 'patronomyc' => $dataArr[2]];
}

function getShortName($strName)
{
    $arrFullName = getPartsFromFullname($strName);
    $reductName = $arrFullName['name'];
    $reductName .= " " . mb_substr($arrFullName['surname'], 0, 1) . ".";
    return $reductName;
}


function getGenderFromName($genderName)
{
    $arrGenderName = getPartsFromFullname($genderName);
    $gender = 0;
    if (
        mb_substr($arrGenderName['patronomyc'], -3) === "вна" ||
        mb_substr($arrGenderName['surname'], -2) === "ва" ||
        mb_substr($arrGenderName['name'], -1) === "а"
    ) {

        $gender--;
    } else if (
        mb_substr($arrGenderName['patronomyc'], -2) === "ич" ||
        mb_substr($arrGenderName['surname'], -1) === "в" &&
        (mb_substr($arrGenderName['name'], -1) === "й" || mb_substr($arrGenderName['name'], -1) === "н")
    ) {
        $gender++;
    }

    return $gender;
}

function getGenderDescription($arrPerson)
{
    $male = 0;
    $female = 0;
    $undefined = 0;
    foreach ($arrPerson as $key) {
        if (getGenderFromName($key['fullname']) == 1) {
            $male++;
        } else if (getGenderFromName($key['fullname']) == -1) {
            $female++;
        } else {
            $undefined++;
        }
    }

    $male = round(calcPercent(count($arrPerson), $male), 1);
    $female = round(calcPercent(count($arrPerson), $female), 1);
    $undefined = round(calcPercent(count($arrPerson), $undefined), 1);

    $result = <<<STR

<h2>Гендерный состав аудитории:</h2>
<hr>
<ul>
    <li>Мужчины - $male%</li>
    <li>Женщины - $female%</li>
    <li>Не удалось определить - $undefined%</li>
</ul>

STR;

    return $result;
}


function calcPercent($lengthArr, $num) // Функция для определения процента результатов, от количества элементов массива
{
    return ($num / $lengthArr) * 100;
}


function getPerfectPartner($surname, $name, $patronomyc, $arrPerson)
{
    $surname = mb_convert_case($surname, MB_CASE_TITLE_SIMPLE, "UTF-8");
    $name = mb_convert_case($name, MB_CASE_TITLE_SIMPLE, "UTF-8");
    $patronomyc = mb_convert_case($patronomyc, MB_CASE_TITLE_SIMPLE, "UTF-8");

    $personOne = getFullnameFromParts($surname, $name, $patronomyc);
    $genderPersOne = getGenderFromName($personOne);

    while (true) {
        $personTwo = $arrPerson[rand(0, (count($arrPerson) - 1))]['fullname'];
        $genderPersTwo = getGenderFromName($personTwo);
        if ($genderPersOne != $genderPersTwo && $genderPersTwo != 0) {
            break;
        }
    }

    return getShortName($personOne) . " + " . getShortName($personTwo) . " = <br>&#10084; Идеально на " . (rand(5000, 10000) / 100) . "% &#10084;";
}
