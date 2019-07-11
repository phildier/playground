# PHP PDOStatement wrapper demonstration

This demonstrates the difference between fetching a result set entirely into
memory versus iterating over a PDOStatement and transforming results on demand.

## initialization

Run `php create_sqlite.php` first to create the test fixture database.

## no_wrapper.php

This is the baseline case.  It queries the test db for all rows, loads them all
into memory, transforms them all, and then echos the first 10 results.

## generator_wrapper.php

This example uses 2 generators to wrap the PDOStatement results.  One to handle
the results, and another for the result transformation.

## traversable_wrapper.php

This one uses a `TraversablePDOStatement` wrapper I found in a gist, and wraps
that with an additional class `TransformWrapper` to handle the transformation.
