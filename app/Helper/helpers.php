<?php

use Carbon\Carbon;
use App\Models\Skpd;


function bulan()
{
    Carbon::setLocale('id');
    // Array untuk menyimpan nama bulan
    $namaBulan = [];

    // Loop untuk mendapatkan nama semua bulan
    for ($i = 1; $i <= 12; $i++) {
        $namaBulan[] = Carbon::createFromDate(2024, $i, 1)->translatedFormat('F');
    }

    return $namaBulan;
}
function skpd()
{
    return Skpd::get();
}

function parseIndonesianNumber($str)
{
    // Remove dots (thousand separators) and replace comma (decimal separator) with dot
    $cleaned = str_replace('.', '', $str);
    $cleaned = str_replace(',', '.', $cleaned);
    return (float) $cleaned;
}

/**
 * Automatic mutator to convert Indonesian formatted number strings to decimals
 * Handles null/empty values and returns 0 for invalid inputs
 */
function autoParseIndonesianNumber($value)
{
    if (empty($value) || $value === '') {
        return 0;
    }
    
    return parseIndonesianNumber($value);
}

/**
 * Sum multiple Indonesian formatted number strings
 * Returns formatted Indonesian number string
 */
function sumIndonesianNumbers(...$numbers)
{
    $total = 0;
    
    foreach ($numbers as $number) {
        $total += autoParseIndonesianNumber($number);
    }
    
    return number_format($total, 2, ',', '.');
}

/**
 * Get decimal value from Indonesian formatted string for calculations
 * This is the main mutator function
 */
function getDecimalValue($formattedNumber)
{
    return autoParseIndonesianNumber($formattedNumber);
}

/**
 * Format number to Indonesian format with automatic conversion from input
 */
function formatIndonesianNumber($number)
{
    if (is_string($number)) {
        $number = parseIndonesianNumber($number);
    }
    
    return number_format($number, 2, ',', '.');
}

/**
 * Get performance rating based on total score
 * Formula: IF(score>=91; "Sangat Baik"; IF(score>=85; "Baik"; IF(score>=65; "Cukup"; "Kurang")))
 */
function getPerformanceRating($totalScore)
{
    $score = is_string($totalScore) ? parseIndonesianNumber($totalScore) : (float) $totalScore;
    
    if ($score >= 91) {
        return "Sangat Baik";
    } elseif ($score >= 85) {
        return "Baik";
    } elseif ($score >= 65) {
        return "Cukup";
    } else {
        return "Kurang";
    }
}
