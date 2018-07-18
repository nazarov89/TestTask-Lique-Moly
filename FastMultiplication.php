<?php

class fastMultiplication {
    public function multiplication(string $num1, string $num2): string {
        $len = max(strlen($num1), strlen($num2));
        if (4 >= $len) {
            return (string)((int)$num1 * (int)$num2);
        }

        $len = ($len % 2 === 0) ? $len : $len + 1;

        $num1 = $this->addFirstZero($num1, $len);
        $num2 = $this->addFirstZero($num2, $len);

        $num1FirstPart = substr($num1, 0, $len / 2);
        $num1SecondPart = substr($num1, $len / 2);

        $num2FirstPart = substr($num2, 0, $len / 2);
        $num2SecondPart = substr($num2, $len / 2);

        $multi1 = $this->multiplication($num1FirstPart, $num2FirstPart);
        $multi2 = $this->multiplication($num1SecondPart, $num2SecondPart);
        $multi3 = $this->multiplication($this->addition($num1FirstPart, $num1SecondPart), $this->addition($num2FirstPart, $num2SecondPart));

        $fistSum = $multi1.str_repeat(0, $len);
        $secondSum = $this->subtraction($this->subtraction($multi3, $multi1), $multi2).str_repeat(0, $len / 2);
        $thirdSum = $multi2;

        return
            $this->addition(
                $this->addition(
                    $fistSum,
                    $secondSum
                ),
                $thirdSum
            );
    }

    private function addition(string $input1, string $input2): string {
        $length = max(strlen($input1), strlen($input2));

        if ($length < 4) {
            return (string)((int)$input1 + (int)$input2);
        }

        list($num1, $num2) = $this->alignment($input1, $input2);
        $num1 = $this->toArray($num1);
        $num2 = $this->toArray($num2);

        $sum = [];

        foreach ($num1 as $position => $value) {
            $sum[$position] = (int)$num1[$position] + (int)$num2[$position];
        }

        foreach ($sum as $position => $value) {
            if ($sum[$position] < 10) {
                continue;
            }

            $sum[$position] -= 10;
            ++$sum[$position+1];
        }

        return $this->toString($sum);
    }
    private function subtraction(string $input1, string $input2): string  {
        $length = max(strlen($input1), strlen($input2));

        if ($length < 4) {
            return (string)((int)$input1 - (int)$input2);
        }

        list($num1, $num2) = $this->alignment($input1, $input2);

        $num1 = $this->toArray($num1);
        $num2 = $this->toArray($num2);

        $minus = [];

        foreach ($num1 as $position => $value) {
            if ((int)$num1[$position] < (int)$num2[$position]) {
                $num1[$position] = (int)$num1[$position] + 10;
                --$num1[$position+1];
            }
            $minus[$position] = (int)$num1[$position] - (int)$num2[$position];
        }

        return $this->toString($minus);
    }

    private function toString(array $num, $removeFirstZero = true): string  {
        $str = implode('', array_reverse($num));

        if ($removeFirstZero) {
            $str = ltrim($str,'0');
        }

        return $str;
    }

    private function toArray(string $num): array {
        return array_reverse(str_split($num, 1));
    }

    private function alignment(string $arNum1, string $arNum2): array {
        $maxCount = max(strlen($arNum1), strlen($arNum2)) + 1;
        return [$this->addFirstZero($arNum1, $maxCount), $this->addFirstZero($arNum2, $maxCount)];
    }
    private function addFirstZero(string $arNum, int $len): string {
        return str_repeat(0, $len - strlen($arNum)).$arNum;
    }

}