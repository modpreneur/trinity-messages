#!/bin/sh sh

composer update

vendor/codeception/codeception/codecept run

phpstan analyse DependencyInjection/ Event/ EventListener/ Exception/ Interfaces/ Message/ Reader/ Sender/  --level=4

tail -f /dev/null