<?php
// file substitiutions in sql
function table_name($line, &$current_table) {
    $re = '/^CREATE TABLE `([^`]+)`/';
    if (preg_match($re,$line,$matches) == 1) {
        $current_table = $matches[1];
    }
}

function kconvert($line, $current_table) {
    // for foreign keys, use the InnoDB engine
    $re = '/^\) ENGINE=MyISAM/';
    $subst = ') ENGINE=InnoDB';
    $line = preg_replace($re, $subst, $line);

    // only one auto_increment per table
    if (!in_array($current_table, array('oai_records'))) {
        // each file with an id field - use the same field type
        $re = '/^  `id` (small|tiny|medium)int.*,$/';
        if (preg_match($re, $line) == 1) {
            $line = "  `id` MEDIUMINT unsigned NOT NULL auto_increment,\n";
        }
    }

    // each fake foreign key field - use the same type as above
    $re = '/^(  `fk_[^`]+`) (smallint|tinyint|mediumint|int)\(\d+\) (unsigned)?([^,]+,)$/';
    $subst = '\\1 MEDIUMINT unsigned \\4' . "\n";
    $line = preg_replace($re, $subst, $line);

    return $line;
}

$thisdir = realpath(dirname(__FILE__));
$filename = "$thisdir/kmoddl_foreign_key.sql";
echo "Using $filename\n";
$fh = false;
$tfh = false;

try {
    if (($fh = fopen($filename, 'r')) === false) {
        throw new Exception("Can't open $filename");
    }

    $tempfile = tempnam('/tmp', 'kmoddl');
    if (($tfh = fopen($tempfile, 'w')) === false) {
        throw new Exception("Can't open $tempfile");
    }
    echo "temp output to $tempfile\n";
    
    $current_table = '';
    while (!feof($fh)) {
        $line = fgets($fh);
        table_name($line, $current_table);
        fwrite($tfh, kconvert($line, $current_table));
    }

    fclose($tfh);
    $tfh = false;
    fclose($fh);
    $fh=false;

    if (copy($tempfile, $filename)) {
        unlink($tempfile);
    }
    else {
        throw new Exception("Can't copy $tempfile back over $filename");
    }

} 
catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
} 
finally {
    if ($fh) {
        fclose($fh);
    }
    if ($tfh) {
        fclose($tfh);
    }
}
