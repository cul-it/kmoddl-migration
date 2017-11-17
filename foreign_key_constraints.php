<?php
// read kmoddl.sql and output constraints for foreign keys

$thisdir = realpath(dirname(__FILE__));
$filename = "$thisdir/kmoddl_foreign_key.sql";

$handle = fopen("$filename", "r");
if ($handle) {
    $table = false;
    $keys = array();
    $real_table = array(
        'fk_audience' => 'v2_audiences',
        'fk_bib' => 'v2_bibrecords',
        'fk_bio_auth' => 'v2_people',
        'fk_category_schemes' => 'v2_model_category_schemes',
        'fk_category' => 'v2_model_categories',
        'fk_collection' => 'v2_collections',
        'fk_creator' => 'v2_people',
        'fk_DCMI_type' => 'v2_dcmi_types',
        'fk_desc_author' => 'v2_people',
        'fk_journal' => 'v2_bibrecord_journals',
        'fk_manufacturer' => 'v2_manufacturers',
        'fk_mime' => 'v2_mimetypes',
        'fk_mimetype' => 'v2_mimetypes',
        'fk_model_a' => 'v2_models',
        'fk_model_b' => 'v2_models',
        'fk_model_collection_a' => 'v2_collections',
        'fk_model_collection_b' => 'v2_collections',
        'fk_model' => 'v2_models',
        'fk_person' => 'v2_people',
        'fk_publisher' => 'v2_publishers',
        'fk_resource_a' => 'v2_resources',
        'fk_resource_b' => 'v2_resources',
        'fk_resource_type_a' => 'v2_resource_types',
        'fk_resource_type_b' => 'v2_resource_types',
        'fk_resource_type' => 'v2_resource_types',
        'fk_resource' => 'v2_resources',
        'fk_resources' => 'v2_resources',
        'fk_scheme' => 'v2_model_category_schemes',
        'fk_surrogate_type' => 'v2_surrogate_types',
        'fk_surrogate' => 'v2_surrogates',
        'fk_type' => 'v2_bibrecord_types',
        );
    $table_names = array();
    $tables = array();
    while (($line = fgets($handle)) !== false) {
        // process the line read.
        if (preg_match('|^CREATE TABLE \`([^\`]+)\`|',$line,$matches)) {
            $table = $matches[1];
            $table_names["$table"] = 1;
        } elseif (preg_match('|\`(fk_[^\`]+)\`|',$line,$matches)) {
            $keys[] = $matches[1];
        } elseif (strpos($line, ') ENGINE=MyISAM') == 0) {
            // this marks the end of CREATE TABLE definition
            // output constraints for the current table
            foreach ($keys as $key) {
                if (isset($real_table["$key"])) {
                    $tables["$table"]["$key"] = $real_table["$key"];
                    // ALTER TABLE `v2_bibrecord_journal_instances` ADD INDEX(`fk_publisher`);
                    // echo "ALTER TABLE `$table` ADD INDEX(`$key`);\n";
                    // $referenced = $real_table["$key"];
                    // echo "ALTER TABLE `$table` ADD CONSTRAINT `C$key` FOREIGN KEY (`$key`) REFERENCES $referenced(id);\n";
                }
            }
            $keys = array();
        }
    }

    fclose($handle);
    $skip_key = array(
        'v2_models' => array('fk_category'),
        'v2_bibrecords' => array('fk_type'),
        'v2_bibrecord_journal_instances' => array('fk_publisher'),
    );

    foreach($tables as $table => $fields) {
        if (preg_match('/v2_[^2]+2[^2]+/',$table)) {
            continue;
        }
        $alter = "ALTER TABLE `$table` ";
        $clauses = array();
        // if (!preg_match('/v2_[^2]+2[^2]+/',$table)) {
        //     // tables like v2_models2resources don't have id fields
        //     $clauses[] = "ADD UNIQUE KEY `id` (`id`)";
        //     // v2_owners2resources does have an id field!!!
        // }
        foreach ($fields as $key => $referenced) {
            // foreign key fields must be indexed
            if (isset($skip_key["$table"]) && in_array($key, $skip_key["$table"])) {
                continue;
            }
            $clauses[] = "ADD KEY `$key` (`$key`)";
        }
        echo $alter . implode(', ', $clauses) . ";\n";

    }
    foreach($tables as $table => $fields) {
        foreach ($fields as $key => $referenced) {
            echo "ALTER TABLE `$table` ADD CONSTRAINT `C$key` FOREIGN KEY (`$key`) REFERENCES $referenced(id);\n";
        }
    }
    // foreach($real_table as $key => $val) {
    //     echo "'$key' => '$key',\n";
    // }
    // foreach($table_names as $key => $val) {
    //     echo "$key\n";
    // }
} else {
    // error opening the file.
    echo "can not open $filename";
}

