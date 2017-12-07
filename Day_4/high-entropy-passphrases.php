<?php
echo 'Day 4<br /><br />';

$input_txt = file_get_contents('high-entropy-passphrases_input.txt');
$passphrases = explode("\n", $input_txt);

$correct_phrases = 0;
foreach($passphrases as $pk => &$phrase) {
    $phrase = trim($phrase);
    if($phrase != '') {
        $already_used_block = array();
        $duplicate_blocks = FALSE;
        foreach(explode(' ', $phrase) as $block) {
            if(!in_array($block, $already_used_block)) {
                $already_used_block[] = $block;
            }
            else {
                $duplicate_blocks = TRUE;
                break;
            }
        }

        if(!$duplicate_blocks) {
            $correct_phrases++;
        }
    }
}

echo '<b>Result:</b> '.$correct_phrases;

echo '<hr /><br />';

echo 'Day 4.5<br /><br />';

$input_txt = file_get_contents('high-entropy-passphrases_input.txt');
$passphrases = explode("\n", $input_txt);

$correct_phrases = 0;
foreach($passphrases as $pk => &$phrase) {
    $phrase = trim($phrase);
    if($phrase != '') {
        $already_used_block = array();
        $duplicate_blocks = FALSE;
        foreach(explode(' ', $phrase) as $block) {
            $block_chars = str_split($block);
            sort($block_chars);
            $block_check_string = implode('', $block_chars);
            if(!in_array($block_check_string, $already_used_block)) {
                $already_used_block[] = $block_check_string;
            }
            else {
                $duplicate_blocks = TRUE;
                break;
            }
        }

        if(!$duplicate_blocks) {
            $correct_phrases++;
        }
    }
}

echo '<b>Result:</b> '.$correct_phrases;
?>
