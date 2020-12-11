#!/bin/sh
DATA="token=DC71E58DED9F29A9F59EC14FACCED4C6&content=project&format=json&returnFormat=json"
CURL=`which curl`
$CURL -H "Content-Type: application/x-www-form-urlencoded" \
      -H "Accept: application/json" \
      -X POST \
      -d $DATA \
      https://redcap.au.dk/api/
