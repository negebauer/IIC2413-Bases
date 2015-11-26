<?php

require_once('Git.php');

$repo = Git::open('../.git');  // -or- Git::create('/path/to/repo')

// $repo->add('.');
// $repo->commit('Some commit message');
// $repo->push('origin', 'master');
$repo->pull('origin', 'master');

?>
