<?php
echo 'Day 3<br /><br />';

function DebugGrid($grid) {
    //Cleanup Grid For Display
    $empty_pre_collumns = 0;
    $number_width = 0;
    foreach($grid as $lk => $grid_line) {
        $line_empty = TRUE;
        $mode_pre = TRUE;
        $pre_collumns = 0;

        foreach($grid_line as $ck => $grid_collumn) {
            if(trim($grid_collumn) != '') {
                $line_empty = FALSE;
                $mode_pre = FALSE;

                if(strlen(trim($grid_collumn)) > $number_width) {
                    $number_width = strlen(trim($grid_collumn));
                }
            }
            elseif(!$mode_pre) {
                unset($grid[$lk][$ck]);
            }
            else {
                $pre_collumns++;
            }
        }
        if($line_empty) {
            unset($grid[$lk]);
        }
        if($empty_pre_collumns == 0 OR $empty_pre_collumns > $pre_collumns) {
            $empty_pre_collumns = $pre_collumns;
        }
    }
    foreach($grid as $lk => $grid_line) {
        $tmp_pre_collumns = $empty_pre_collumns;
        foreach($grid_line as $ck => $grid_collumn) {
            if($tmp_pre_collumns > 0) {
                unset($grid[$lk][$ck]);
                $tmp_pre_collumns--;
            }
            else {
                break;
            }
        }
    }

    echo '<pre>';
    foreach($grid as $row) {
        $line_parts_arr = array();
        foreach($row as $field) {
            $line_parts_arr[] = str_pad(trim($field), $number_width, ' ', STR_PAD_BOTH);
        }
        echo implode($line_parts_arr, '   ').'<br />';
    }
    echo '</pre>';
}
function GridCellEmpty($grid, $xpos, $ypos) {
    if(isset($grid[$ypos][$xpos])) {
        return trim($grid[$ypos][$xpos]) == '';
    }
    return FALSE;
}
function Spiral($input) {
    $squareRoot = ceil(sqrt($input));
    $gridSize = $squareRoot + (($squareRoot - 1) % 2 === 0 ? 2 : 3);
    $grid = array();

    for($i = 0; $i < $gridSize; $i++) {
        $grid[] = array_fill(0, $gridSize, '   ');
    }

    $cur_pos = (object) array(
        'x' => floor($gridSize / 2),
        'y' => floor($gridSize / 2),
    );

    $cur_number = 1;
    $next_move = 'x+';
    $first_move = TRUE;
    while($cur_number <= $input) {
        $grid[$cur_pos->y][$cur_pos->x] = str_pad($cur_number, 3, ' ');
        switch($next_move) {
            case 'x+':
                //move right if up is reserved
                if(!GridCellEmpty($grid, $cur_pos->x, $cur_pos->y - 1) OR $first_move) {
                    $cur_pos->x++;
                    $next_move = 'x+';
                    $first_move = FALSE;
                }
                else {
                    $cur_pos->y--;
                    $next_move = 'y-';
                }
                break;
            case 'y-':
                //move up if left is reserved
                if(!GridCellEmpty($grid, $cur_pos->x - 1, $cur_pos->y)) {
                    $cur_pos->y--;
                    $next_move = 'y-';
                }
                else {
                    $cur_pos->x--;
                    $next_move = 'x-';
                }
                break;
            case 'x-':
                //move left if down is reserved
                if(!GridCellEmpty($grid, $cur_pos->x, $cur_pos->y + 1)) {
                    $cur_pos->x--;
                    $next_move = 'x-';
                }
                else {
                    $cur_pos->y++;
                    $next_move = 'y+';
                }
                break;
            case 'y+':
                //move down if right is reserved
                if(!GridCellEmpty($grid, $cur_pos->x + 1, $cur_pos->y)) {
                    $cur_pos->y++;
                    $next_move = 'y+';
                }
                else {
                    $cur_pos->x++;
                    $next_move = 'x+';
                }
                break;
        }
        $cur_number++;
    }
    return $grid;
}
function calcTaxiCabDist($grid, $start_value, $dest_value) {
    $start_pos = NULL;
    $dest_pos = NULL;
    foreach($grid as $grid_line_pos => $grid_line) {
        foreach($grid_line as $line_collumn_pos => $line_collumn) {
            if($line_collumn == $start_value) {
                $start_pos = (object) array(
                    'x' => $line_collumn_pos,
                    'y' => $grid_line_pos,
                );
            }
            elseif($line_collumn == $dest_value) {
                $dest_pos = (object) array(
                    'x' => $line_collumn_pos,
                    'y' => $grid_line_pos,
                );
            }
            if($start_pos !== NULL && $dest_pos !== NULL) {
                break(2);
            }
        }
    }
    $dist_x = $start_pos->x - $dest_pos->x;
    if($dist_x < 0) {
        $dist_x *= -1;
    }
    $dist_y = $start_pos->y - $dest_pos->y;
    if($dist_y < 0) {
        $dist_y *= -1;
    }

    return $dist_x + $dist_y;
}

#$input_pos = 289326;
$input_pos = 23;
$spiral_grid = Spiral($input_pos);
DebugGrid($spiral_grid);

echo '<br/>';
echo '<b>Result:</b> '.calcTaxiCabDist($spiral_grid, 1, $input_pos);

echo '<br /><hr />';

echo 'Day 3.5<br /><br />';
function calcNeighbourValue($grid, $xpos, $ypos, $first_run = FALSE) {
    $result = 0;
    if($first_run) {
        $result = 1;
    }

    if(!GridCellEmpty($grid, $xpos + 1, $ypos)) {
        $result += trim($grid[$ypos][$xpos + 1]);
    }
    if(!GridCellEmpty($grid, $xpos - 1, $ypos)) {
        $result += trim($grid[$ypos][$xpos - 1]);
    }
    if(!GridCellEmpty($grid, $xpos, $ypos + 1)) {
        $result += trim($grid[$ypos + 1][$xpos]);
    }
    if(!GridCellEmpty($grid, $xpos, $ypos - 1)) {
        $result += trim($grid[$ypos - 1][$xpos]);
    }

    if(!GridCellEmpty($grid, $xpos + 1, $ypos + 1)) {
        $result += trim($grid[$ypos + 1][$xpos + 1]);
    }
    if(!GridCellEmpty($grid, $xpos - 1, $ypos - 1)) {
        $result += trim($grid[$ypos - 1][$xpos - 1]);
    }
    if(!GridCellEmpty($grid, $xpos + 1, $ypos - 1)) {
        $result += trim($grid[$ypos - 1][$xpos + 1]);
    }
    if(!GridCellEmpty($grid, $xpos - 1, $ypos + 1)) {
        $result += trim($grid[$ypos + 1][$xpos - 1]);
    }

    return $result;
}
function SpiralNeigbour($input) {
    $squareRoot = ceil(sqrt($input));
    $gridSize = $squareRoot + (($squareRoot - 1) % 2 === 0 ? 2 : 3);
    $grid = array();

    for($i = 0; $i < $gridSize; $i++) {
        $grid[] = array_fill(0, $gridSize, '   ');
    }

    $cur_pos = (object) array(
        'x' => floor($gridSize / 2),
        'y' => floor($gridSize / 2),
    );

    $cur_number = 1;
    $next_move = 'x+';
    $first_move = TRUE;
    while($cur_number <= $input) {
        $cur_number = calcNeighbourValue($grid, $cur_pos->x, $cur_pos->y, $first_move);
        $grid[$cur_pos->y][$cur_pos->x] = str_pad($cur_number, 3, ' ');
        switch($next_move) {
            case 'x+':
                //move right if up is reserved
                if(!GridCellEmpty($grid, $cur_pos->x, $cur_pos->y - 1) OR $first_move) {
                    $cur_pos->x++;
                    $next_move = 'x+';
                    $first_move = FALSE;
                }
                else {
                    $cur_pos->y--;
                    $next_move = 'y-';
                }
                break;
            case 'y-':
                //move up if left is reserved
                if(!GridCellEmpty($grid, $cur_pos->x - 1, $cur_pos->y)) {
                    $cur_pos->y--;
                    $next_move = 'y-';
                }
                else {
                    $cur_pos->x--;
                    $next_move = 'x-';
                }
                break;
            case 'x-':
                //move left if down is reserved
                if(!GridCellEmpty($grid, $cur_pos->x, $cur_pos->y + 1)) {
                    $cur_pos->x--;
                    $next_move = 'x-';
                }
                else {
                    $cur_pos->y++;
                    $next_move = 'y+';
                }
                break;
            case 'y+':
                //move down if right is reserved
                if(!GridCellEmpty($grid, $cur_pos->x + 1, $cur_pos->y)) {
                    $cur_pos->y++;
                    $next_move = 'y+';
                }
                else {
                    $cur_pos->x++;
                    $next_move = 'x+';
                }
                break;
        }
    }

    return $grid;
}

$input_pos = 289326;
#$input_pos = 23;
$spiral_grid = SpiralNeigbour($input_pos);
DebugGrid($spiral_grid);
?>
