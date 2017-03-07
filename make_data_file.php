<?php
declare(strict_types = 1);

$file = 'data.json';
if (file_exists($file)) {
    file_put_contents($file, '');
}
$arrays = getArrays();
$json_data = json_encode($arrays, JSON_UNESCAPED_UNICODE);
$result = file_put_contents($file, $json_data, FILE_TEXT);
if ($result) {
    echo 'Данные экспортированы в файл ' . $file . ' успешно!';
} else {
    echo 'Произошла непредвиденная ошибка...';
}

function getArrays(): array
{
    //@formatter:off
    $arrMagnitude = ['миллион','миллиард','триллион','квадриллион','квинтиллион','секстиллион','септиллион','октиллион','нониллион',
                    'дециллион','ундециллион','дуодециллион','тредециллион','кватуордециллион','квиндециллион',
                    'сексдециллион','септендециллион','октодециллион','новемдециллион','вигинтиллион','унвигинтиллион',
                    'дуовигинтиллион','тревигинтиллион','кватуорвигинтиллион','квинвигинтиллион','сексвигинтиллион',
                    'септенвигинтиллион','октовигинтиллион','новемвигинтиллион','тригинтиллион','унтригинтиллион',
                    'дуотригинтиллион','третригинтиллион','кватортригинтиллион','квинтригинтиллион','секстригинтиллион',
                    'септентригинтиллион','октотригинтиллион','новемтригинтиллион','квадрагинтиллион','унквадрагинтиллион',
                    'дуоквадрагинтиллион','треквадрагинтиллион','кваторквадрагинтиллион','квинквадрагинтиллион',
                    'сексквадрагинтиллион','септенквадрагинтиллион','октоквадрагинтиллион','новемквадрагинтиллион',
                    'квинквагинтиллион','унквинкагинтиллион','дуоквинкагинтиллион','треквинкагинтиллион',
                    'кваторквинкагинтиллион','квинквинкагинтиллион','сексквинкагинтиллион','септенквинкагинтиллион',
                    'октоквинкагинтиллион','новемквинкагинтиллион','сексагинтиллион','унсексагинтиллион',
                    'дуосексагинтиллион','тресексагинтиллион','кваторсексагинтиллион','квинсексагинтиллион',
                    'секссексагинтиллион','септенсексагинтиллион','октосексагинтиллион','новемсексагинтиллион',
                    'септагинтиллион','унсептагинтиллион','дуосептагинтиллион','тресептагинтиллион',
                    'кваторсептагинтиллион','квинсептагинтиллион','секссептагинтиллион','септенсептагинтиллион',
                    'октосептагинтиллион','новемсептагинтиллион','октогинтиллион','уноктогинтиллион','дуооктогинтиллион',
                    'треоктогинтиллион','кватороктогинтиллион','квиноктогинтиллион','сексоктогинтиллион',
                    'септоктогинтиллион','октооктогинтиллион','новемоктогинтиллион','нонагинтиллион','уннонагинтиллион',
                    'дуононагинтиллион','тренонагинтиллион','кваторнонагинтиллион','квиннонагинтиллион',
                    'секснонагинтиллион','септеннонагинтиллион','октононагинтиллион','новемнонагинтиллион','центиллион'];

    $arrUnits =     ['один ','два ','три ','четыре ','пять ','шесть ','семь ', 'восемь ', 'девять ',
                    'десять ','одиннадцать ','двенадцать ','тринадцать ','четырнадцать ','пятнадцать ',
                    'шестнадцать ','семнадцать ','восемнадцать ','девятнадцать '];

    $arrTens =      ['десять ','двадцать ','тридцать ','сорок ','пятьдесят ','шестьдесят ','семьдесят ',
                    'восемьдесят ','девяносто '];

    $arrHundreds =  ['сто ','двести ','триста ','четыреста ','пятьсот ','шестьсот ','семьсот ',
                    'восемьсот ','девятьсот '];
    //@formatter:on

    return array($arrUnits, $arrTens, $arrHundreds, $arrMagnitude);
}
