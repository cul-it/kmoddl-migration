<?php
// work file to store best guess of the name of the table that the fk_
// (fake foriegn key) field is pointing at

$real_table = array(
'fk_audience' => 'v2_audiences',
'fk_bib' => 'v2_bibrecords',
'fk_bio_auth' => 'v2_people',
'fk_category_schemes' => 'v2_model_category_schemes',
'fk_category' => 'v2_model_categories', *
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

* v2_stills.fk_category => v2_still_categories.id

// unique table names
oai_records
oai_types
v2_audiences
v2_bibrecord_journal_instances
v2_bibrecord_journals
v2_bibrecord_publishers
v2_bibrecord_types
v2_bibrecords
v2_bibrecords2models
v2_bibrecords2people
v2_clark_categories
v2_collections
v2_dcmi_types
v2_documents
v2_manufacturers
v2_mimetypes
v2_model_categories
v2_model_category_schemes
v2_models
v2_models2models
v2_models2resources
v2_owners2resources
v2_people
v2_people_media_types
v2_people_types
v2_pod
v2_publishers
v2_resource_types
v2_resources
v2_resources2people
v2_resources2resources
v2_resources2surrogates
v2_still_categories
v2_stills
v2_surrogate_types
v2_surrogates
v2_user_roles
v2_users