<?php
echo 'Day 6<br /><br />';

$input_txt = trim(file_get_contents('memory-reallocation_input.txt'));
#$input_txt = trim('0	2	7	0');
$banks = explode('	', $input_txt);

$reallocations = 0;
$bank_pointer = array_search(max($banks), $banks);
$snapshots = array();
$loop_detected = FALSE;

echo implode('-', $banks).'<br/>';
while(!$loop_detected) {
    //Redistribute
    $redis_pointer = $bank_pointer + 1;
    $cycle_count = $banks[$bank_pointer];
    while($cycle_count > 0) {
        if(!isset($banks[$redis_pointer])) {
            $redis_pointer = 0;
        }
        $banks[$redis_pointer]++;
        $banks[$bank_pointer]--;
        $cycle_count--;
        $redis_pointer++;
    }
    $reallocations++;

    $bank_pointer_comp = 0;
    foreach($banks as $tbk => $tmp_bank) {
        if($tmp_bank > $bank_pointer_comp) {
            $bank_pointer = $tbk;
            $bank_pointer_comp = $tmp_bank;
        }
    }
    echo implode('-', $banks).'<br/>';
    if(!in_array(implode('-', $banks), $snapshots)) {
        $snapshots[] = implode('-', $banks);
    }
    else {
        $loop_detected = TRUE;
    }
}

echo '<b>Result:</b> '.$reallocations;

echo '<hr /><br />';

echo 'Day 6.5<br /><br />';

$input_txt = trim(file_get_contents('memory-reallocation_input.txt'));
#$input_txt = trim('0	2	7	0');
$banks = explode('	', $input_txt);

$reallocations = 0;
$bank_pointer = array_search(max($banks), $banks);
$snapshots = array();
$loop_detected = FALSE;
$loop_size = 0;
echo implode('-', $banks).'<br/>';
while(!$loop_detected) {
    //Redistribute
    $redis_pointer = $bank_pointer + 1;
    $cycle_count = $banks[$bank_pointer];
    while($cycle_count > 0) {
        if(!isset($banks[$redis_pointer])) {
            $redis_pointer = 0;
        }
        $banks[$redis_pointer]++;
        $banks[$bank_pointer]--;
        $cycle_count--;
        $redis_pointer++;
    }
    $reallocations++;

    $bank_pointer_comp = 0;
    foreach($banks as $tbk => $tmp_bank) {
        if($tmp_bank > $bank_pointer_comp) {
            $bank_pointer = $tbk;
            $bank_pointer_comp = $tmp_bank;
        }
    }
    echo implode('-', $banks).'<br/>';
    if(!isset($snapshots[implode('-', $banks)])) {
        $snapshots[implode('-', $banks)] = $reallocations;
    }
    else {
        $loop_detected = TRUE;
        $loop_size = $reallocations - $snapshots[implode('-', $banks)];
    }
}

echo '<b>Result:</b> '.$loop_size;
?>
