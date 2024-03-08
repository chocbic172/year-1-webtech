<?php
// To keep the database configuration secret from git, we
// import the SQL host, username and password from a configuration
// file (`.env`).

// Cribbed from Stack Overflow:
// https://stackoverflow.com/questions/67963371/load-a-env-file-with-php

$env = parse_ini_file('.env');
