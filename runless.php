<?php 

// begin function compress
function compress($buffer) 
{
	// remove comments
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	// remove tabs, spaces, new lines, etc.
	$buffer = str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),'',$buffer);
	// remove unnecessary spaces
	$buffer = str_replace('{ ', '{', $buffer);
	$buffer = str_replace(' }', '}', $buffer);
	$buffer = str_replace('; ', ';', $buffer);
	$buffer = str_replace(', ', ',', $buffer);
	$buffer = str_replace(' {', '{', $buffer);
	$buffer = str_replace('} ', '}', $buffer);
	$buffer = str_replace(': ', ':', $buffer);
	$buffer = str_replace(' ,', ',', $buffer);
	$buffer = str_replace(' ;', ';', $buffer);
	$buffer = str_replace(';}', '}', $buffer);

	return $buffer;
}

$uri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
// less compiler
$lesspath = __DIR__ . '/css';
require_once $lesspath . '/less.php/less.php';
$less_files = array( $lesspath . '/template.less' => $uri);
$options = array( 'cache_dir' => $lesspath.'/cache/' );
$css_file_name = Less_Cache::Get( $less_files, $options );
$compiled = file_get_contents( $lesspath.'/cache/'.$css_file_name );

if (file_exists($lesspath.'/cache/'.$css_file_name))
{
	// merge files
	$compiled = file_get_contents( $lesspath.'/cache/'.$css_file_name );
	
	$compressed = compress($compiled);

	file_put_contents($lesspath.'/template.css', $compressed);
}
