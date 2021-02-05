<?php

include 'dataPerson.php';
include 'functions.php';

// echo $example_persons_array[0]['fullname'];
// echo getFullnameFromParts('Иванов', 'Ваня', 'Иванович');
// print_r(getPartsFromFullname('Ворошилов Дмитрий Сергеевич'));
// print_r(getShortName('Ворошилов Дмитрий Сергеевич'));
// echo getGenderFromName('Бардо Жаклин Фёдоровна');
// echo getGenderDescription($example_persons_array);

echo getPerfectPartner('Иванов', 'Иван', 'Иванович', $example_persons_array);
