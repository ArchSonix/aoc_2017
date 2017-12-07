<?php
echo 'Day 5<br /><br />';

$input_txt = file_get_contents('a-maze-of-twisty-trampolines_input.txt');
$offsets = explode("\n", trim($input_txt));

$steps = 0;
$pointer = 0;
while($pointer >= 0) {
    if(!isset($offsets[$pointer])) {
        break;
    }
    else {
        $new_pointer = $pointer + $offsets[$pointer];
        $offsets[$pointer]++;
        $pointer = $new_pointer;
        $steps++;
    }
}
echo '<b>Result:</b> '.$steps;

echo '<hr /><br />';

echo 'Day 5.5<br /><br />';

$input_txt = file_get_contents('a-maze-of-twisty-trampolines_input.txt');
$offsets = explode("\n", trim($input_txt));

$steps = 0;
$pointer = 0;
while($pointer >= 0) {
    if(!isset($offsets[$pointer])) {
        break;
    }
    else {
        $new_pointer = $pointer + $offsets[$pointer];
        if($offsets[$pointer] >= 3) {
            $offsets[$pointer]--;
        }
        else {
            $offsets[$pointer]++;
        }
        $pointer = $new_pointer;
        $steps++;
    }
}
echo '<b>Result:</b> '.$steps;
?>
