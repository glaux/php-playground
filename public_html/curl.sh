#!/bin/sh
DATA="token=2B50374F596D4C13A93014C0C8D0133F&content=project&format=json&returnFormat=json"
CURL=`which curl`
$CURL -H "Content-Type: application/x-www-form-urlencoded" \
      -H "Accept: application/json" \
      -X POST \
      -d $DATA \
      https://redcap.au.dk/api/
