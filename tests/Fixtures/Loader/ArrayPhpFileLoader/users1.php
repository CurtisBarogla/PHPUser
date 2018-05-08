<?php
//StrictType
declare(strict_types = 1);

/*
 * Ness
 * User component
 *
 * Author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */

// Fixtures

return [
    "Foo"   =>  null,
    "Bar"   =>  [
        "attributes"    =>  [
            "Foo"           =>  "Bar",
            "Bar"           =>  "Foo"
        ],
        "roles"         =>  ["Foo", "Bar"]
    ]
];