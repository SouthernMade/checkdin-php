.PHONY: syntax test

default: syntax test

syntax:
	@find . -name '*.php' -exec php -l {} \; > /dev/null

test:
	@php -n -f test/all.php