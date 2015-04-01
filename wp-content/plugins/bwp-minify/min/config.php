<?php
$min_enableBuilder = false;
$min_builderPassword = 'admin';
$min_errorLogger = false;
$min_allowDebugFlag = false;
$min_cachePath = '/var/www/html/blog/wp-content/plugins/bwp-minify/cache';
$min_documentRoot = '';
$min_cacheFileLocking = true;
$min_serveOptions['bubbleCssImports'] = true;
$min_serveOptions['maxAge'] = 2592000;
$min_serveOptions['minApp']['groupsOnly'] = false;
$min_symlinks = array();
$min_uploaderHoursBehind = 0;
$min_libPath = dirname(__FILE__) . '/lib';
ini_set('zlib.output_compression', '0');
// auto-generated on 2015-02-17 02:04:02
