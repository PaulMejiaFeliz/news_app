<?php

$config = require "config.php";
require "core/Router.php";
require "core/database/connection.php";
require "core/database/QueryBuilder.php";

$app = [];

$app["con"] = Connection::getConnection($config["database"]);

$app["qBuilder"] = new QueryBuilder($app["con"]);
