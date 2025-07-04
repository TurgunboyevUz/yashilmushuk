<?php

function buildTriangle($n) {
    $rows = findTriangleRows($n);
    
    if ($rows === false) {
        echo "Невозможно построить треугольник\n";
        return;
    }
    
    printTriangle($n, $rows);
}

function findTriangleRows($n) {
    $k = sqrt($n);
    
    if ($k != floor($k) || $k <= 0) {
        return false;
    }
    
    return (int)$k;
}

function printTriangle($n, $rows) {
    $current_number = 1;
    
    $max_width = calculateMaxWidth($n, $rows);
    
    for ($row = 1; $row <= $rows; $row++) {
        $numbers_in_row = 2 * $row - 1;
        
        $row_width = calculateRowWidth($current_number, $numbers_in_row);
        $padding = ($max_width - $row_width) / 2;
        
        echo str_repeat(' ', (int)$padding);
        
        for ($col = 1; $col <= $numbers_in_row; $col++) {
            echo $current_number;
            if ($col < $numbers_in_row) {
                echo ' ';
            }
            $current_number++;
        }
        
        echo "\n";
    }
}

function calculateMaxWidth($n, $rows) {
    $numbers_in_last_row = 2 * $rows - 1;
    $last_row_start = $n - $numbers_in_last_row + 1;
    $width = 0;
    
    for ($i = 0; $i < $numbers_in_last_row; $i++) {
        $width += strlen((string)($last_row_start + $i));
        if ($i < $numbers_in_last_row - 1) {
            $width += 1;
        }
    }
    
    return $width;
}

function calculateRowWidth($start_number, $count) {
    $width = 0;
    
    for ($i = 0; $i < $count; $i++) {
        $width += strlen((string)($start_number + $i));
        if ($i < $count - 1) {
            $width += 1;
        }
    }
    
    return $width;
}

function main() {
    global $argv, $argc;

    if ($argc < 2) {
        echo "Использование: php triangle.php <число>\n";
        echo "Пример: php triangle.php 9\n";
        exit(1);
    }
    
    $n = (int)$argv[1];
    
    if ($n <= 0) {
        echo "Ошибка: число должно быть положительным\n";
        exit(1);
    }
    
    buildTriangle($n);
}
?>