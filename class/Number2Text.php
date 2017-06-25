<?php
declare(strict_types = 1);

namespace Converter\Core;

use Converter\Init\Data;

/**
 * Converts a number (up to 1e+333) to its text representation e.g. 12 -> двенадцать (Russian only at the moment).
 * @author    Sergey Kanashin <goujon@mail.ru>
 * @copyright 2003-2017
 */
final class Number2Text
{
    private $data;
    private $iNumber;
    private $currency;
    private $sign = null;

    /**
     * Number2Text constructor: Analyzes and creates number as a BigNumber object
     * @param string $number Number to be converted
     */
    final public function __construct(string $number)
    {
        $this->prepNumber($number);
        $this->data = new Data();
    }

    /**
     * Defines the sign of the number, returns its absolute value
     * @param string    $number - signed initial number
     * @property string $this   ->sign - sign of a number
     * @return string - unsigned number
     */
    final private function prepNumber(string $number): string
    {
        if (substr($number, 0, 1) == '-') {
            $this->sign = 'минус ';
            $number = ltrim($number, '-');
        }
        if ($number === '0') {
            $this->sign = '';
        }

        return $this->iNumber = $number;
    }

    /**
     * Flag that indicates whether to print out the currency name along the number
     * @param bool $show
     * @return bool
     */
    final public function currency(bool $show = false): bool
    {
        return $this->currency = $show;
    }

    final public function convert(): string
    {
        $fullResult = null;
        $arrChunks = $this->makeChunks();
        $numGroups = count($arrChunks);

        if ($this->iNumber === '0') {
            $fullResult = 'ноль ';
        }

        for ($i = $numGroups; $i >= 1; $i--) {
            $currChunk = (int)strrev($arrChunks[$i - 1]);
            $this->fixArray($i);
            $preResult = $this->makeWords($currChunk);

            if ($currChunk !== 0 || $i === 1) {
                $preResult .= $this->getRegister($i, $currChunk);
            }
            $fullResult .= $preResult;
        }

        return $this->sign . $fullResult;
    }

    /**
     * Creates an array with reversed 3-digit chunks of given number
     * Example: '1125468' => array['864', '521', '1']
     * @return array
     */
    final private function makeChunks(): array
    {
        $rvrsValue = strrev($this->iNumber);
        $chunks = chunk_split($rvrsValue, 3);
        $arrCh = explode("\r\n", rtrim($chunks));

        return $arrCh;
    }

    /**
     * Change data array so that femine names of units is correct (Russian specific language construct)
     * @param int $fem - flag that indicates chunk index
     * @internal param \Converter\Init\Data $data - Data object with data arrays.
     */
    final private function fixArray(int $fem)
    {
        if ($fem === 2) {
            $this->data->arrUnits[0] = 'одна ';
            $this->data->arrUnits[1] = 'две ';
        } else {
            $this->data->arrUnits[0] = 'один ';
            $this->data->arrUnits[1] = 'два ';
        }
    }

    final private function makeWords(int $cChunk): string
    {
        $resWords = '';
        $cent = (int)($cChunk / 100);
        $decs = $cChunk % 100;

        if ($cent >= 1) {
            $resWords .= $this->data->arrHundreds[$cent - 1];
        }
        if ($decs >= 1 && $decs <= 19) {
            $resWords .= $this->data->arrUnits[$decs - 1];
            $decs = 0;
        }
        if ($decs !== 0) {
            $resWords .= $this->data->arrTens[$decs / 10 - 1];
        }
        if ($decs % 10 !== 0) {
            $resWords .= $this->data->arrUnits[$decs % 10 - 1];
        }

        return $resWords;
    }

    final private function getRegister(int $chunkPos, int $chunkData): string
    {
        $subResult = '';
        $lastDigits = $chunkData % 100;
        $exponent = $this->data->arrExponents[$chunkPos];

        if (!$this->currency && $chunkPos === 1) {
            return $subResult;
        }

        return $subResult = $exponent . $this->addSuffix($lastDigits, $chunkPos);
    }

    final private function addSuffix(int $lastDigits, int $group): string
    {
        if ($group > 3) {
            $group = 3;
        }
        $last = $lastDigits % 10;
        if ($lastDigits >= 11 && $lastDigits <= 14) {
            $result = $this->data->arrSuffix[2][$group];
        } elseif ($last === 1) {
            $result = $this->data->arrSuffix[0][$group];
        } elseif ($last >= 2 && $last <= 4) {
            $result = $this->data->arrSuffix[1][$group];
        } else {
            $result = $this->data->arrSuffix[2][$group];
        }

        return $result;
    }
}
