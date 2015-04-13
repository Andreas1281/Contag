<pre>
<?php

// Include DB library
require_once("db.lib.php");

function main(){

        session_start();
        $SESSION["id"] = 1; // For debugging
        db_init(); // Create new db if missing

        echo "<h2>Index for: vzwnsugd</h2>";
        echo db_get_index("vzwnsugd");

        echo "<h2>Address for: vzwnsugd</h2>";
        echo db_get_address("vzwnsugd");

        // Check user permission for entry
        echo "<h2>Access Level for User ".$SESSION["id"]." & Hash: vzwnsugd</h2>";
        switch(db_check_permission($SESSION,"vzwnsugd")){

                case "N": echo "<b style='color:red'>No access allowed</b>"; break;
                case "R": echo "<b style='color:BADA55'>Read only access</b>"; break;
                case "W": echo "<b style='color:green'>Full write access</b>"; break;

        }

        echo "<h2>Current User</h2>";
        print_r(db_get_user($SESSION["id"]));

        /*
        db_add_user([
                name => "testuser",
                password => "testpw",
                email => "test@email.de"
        ]);
        */

        echo "<h2>All Users</h2>";
        print_r(db_get_all_user());

        $new_entry = db_add_address($SESSION, "de_de", [
                type => 1, access => 2,
                organisation => "Wessolly Mobile Marketing",
                first_name => "Andreas",
                last_name => "Wessolly",
                title_1 => "Prof. Dr.",
                title_2 => "Allgemeinmediziner",
                description_1 => "c/o Office-Factory",
                description_2 => "Erste Etage",
                street_name => "Am Rosengarten",
                street_number => "20",
                postal_code => "36037",
                city => "Fulda",
                region => "Hessen",
                country => "Deutschland",
                email_address => "email@address.com",
                web_address => "www.wessolly-mobile.de",
                phone_number => "1234567",
                mobile_number => "1234567",
                fax_number => "1234568"
        ]);

        echo "<h2>New Entry</h2><p>Created new entry $new_entry for user ".$SESSION["id"]."!</p>";

        echo "<h2>Index of All Entries</h2>";
        echo db_get_all_index();

        echo "<h2>All Entries by Current User</h2>";
        echo db_get_all_by_user($SESSION["id"]);

        return 1;
}

main();
?>
</pre>
