#!/bin/bash
# converts kmoddl.sql.gz into foreign keyed sql archive of site
 ARCHIVE=kmoddl.sql.gz
 TARGET=kmoddl_foreign_key.sql

if [ -f "$ARCHIVE" ]; then
    echo "found $ARCHIVE"
else
    echo "needs a file called $ARCHIVE"
    exit 1
fi

echo "expanding $ARCHIVE..."

gunzip "$ARCHIVE" -c > "$TARGET"

php sql_substitutions.php

php foreign_key_constraints.php > "constraints.sql"