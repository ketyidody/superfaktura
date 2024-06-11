<?php

// v zadani bolo aby som napisal SQL query na vytahovanie vsetkych duplikatov z tabulky
// dalsia moznost by bola vytiahnut vsetky data do Collection a tam vyfiltrovat duplikaty
// Toto riesenie by mohlo urychlit process a minimalne ulahcit query na databazu.

$sql = "SELECT duplicates.id, duplicates.value
FROM duplicates
INNER JOIN (SELECT value
            FROM duplicates
            GROUP BY value
            HAVING COUNT(id) > 1) dup
ON duplicates.value = dup.value;";