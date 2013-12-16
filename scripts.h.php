<?php
$header_file_name = 'scripts.h';


if ($argc<2) {
    print 'specify scripts dir' . PHP_EOL;
    exit(1);
}

$dir_path = $argv[1];
$dir = dir($dir_path);
if (!$dir) {
    print 'failed to open directory' . PHP_EOL;
    exit(2);
}

$decls = '';

while (false !== ($entry = $dir->read())) {
    if ($entry=='.' || $entry=='..')
        continue;
    $path = $dir->path . DIRECTORY_SEPARATOR . $entry;
    $decls = generate_script_decl($path);
}
$dir->close();

//print $decls;
$fh = fopen($header_file_name, 'w');
if (!$fh) {
    print 'failed create header file' . PHP_EOL;
    exit (2);
}

fwrite($fh, $decls);
fclose($fh);

function generate_script_decl($path) {
    $patterns = array(
        '/\./',
        '/"/',
        '/\s+$/');
    $replacements = array(
        '_',
        '\"',
        '');
    $name = preg_replace($patterns, $replacements, basename($path));
    $decl = "char* script_$name = " . PHP_EOL;
    $fh = fopen($path, 'r');
    while (false!==($line=fgets($fh))) {
        //$decl .= "\t\"" . rtrim(addcslashes($line, "\"")) . "\"" . PHP_EOL;
        $decl .= "\t\"" . preg_replace($patterns, $replacements, $line) . "\"" . PHP_EOL;
    }

    fclose($fh);
    $decl .= ';' . PHP_EOL;
    return $decl;
}
