<?php

function updateNaming()
{
    echo "\nRENAMING started:\n";

    $bhv = new library();
    $bhv->updateCatalog();

    echo "\n\nfinished.\n\n";
}
