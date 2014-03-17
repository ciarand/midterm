all: test
	
test:
	php app.php

test-all:
	php53 app.php
	php54 app.php
	php55 app.php
	php56 app.php
