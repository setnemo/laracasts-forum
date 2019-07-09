<?php

function make($class, $how = null, $attributes = []) {
    return factory($class, $how)->make($attributes);
}

function raw($class, $how = null, $attributes = []) {
    return factory($class, $how)->raw($attributes);
}

function create($class, $how = null, $attributes = []) {
    return factory($class, $how)->create($attributes);
}