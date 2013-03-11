<?php

define ('APACHEAV','/etc/apache2/sites-available/');

define ('APACHEEN','/etc/apache2/sites-enabled/');

$HOME = $_SERVER['HOME'];

#echo $HOME; exit();

$tmplfile = $HOME.'/bin/templatevhost.apache';

$ARGV = $_SERVER['argv'];

print_r($ARGV);

if(count($ARGV) == 1) {
        $cwd = getcwd();
        $VHOSTNAME = basename($cwd);
} else {
        $VHOSTNAME = $ARGV[1];
}

if(file_exists(APACHEAV.$VHOSTNAME)) {
        print "$VHOSTNAME already exists\nExit.\n";
        exit();
}

print "vhostname setted to\n\n\t$VHOSTNAME\n\n";

if(count($ARGV) >= 2) {
        $documentRoot = getcwd();
} else {
        $documentRoot = realpath($ARGV[2]);
}
if(!isset($documentRoot) || $documentRoot=='') {
        print "Document Root not found\nExit.";
        exit();
} else {
        print "Document root setted to:\n\n\t$documentRoot\n\n";
}

$tmpl = file_get_contents($tmplfile);

if($tmpl === FALSE) {
        print "Error: template file $tmplfile does not exist\nExit.\n";
        exit();
}

print "Are you sure to continue? ";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);

if(trim($line) != 'y') {
        print "exiting\n";
        exit();
}

$tmpl = str_replace('%VHOSTNAME%',$VHOSTNAME, $tmpl);
$tmpl = str_replace('%DOCUMENTROOT%',$documentRoot, $tmpl);

$r = file_put_contents(APACHEAV.$VHOSTNAME,$tmpl);

print "Writing ".APACHEAV.$VHOSTNAME." ...\n";

if($r === FALSE) {
        print "Some problem while writing file.\nExit.\n";
        exit();
}

$rsl = symlink(APACHEAV.$VHOSTNAME,APACHEEN.$VHOSTNAME);

if($rsl === FALSE) {
        print "Cannot symlink ".APACHEAV.$VHOSTNAME." to ".APACHEEN.$VHOSTNAME."\nExit.\n";
        exit();
}

$r = `/etc/init.d/apache2 reload`;

print $r;
