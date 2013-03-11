ApacheAddVHost
==============

Add Virtual Host pointing to current directory.

Speedup creation of vhost.


INSTALL

Copy all file in the package bin/ folder into ~/bin folder and add ~/bin to PATH
environment.

i.e. :

$ git clone https://github.com/danielecr/ApacheAddVHost.git
$ cd ApacheAddVHost
$ cp bin/* ~/bin;
$ export PATH=$PATH:~/bin

setup a dns server and a fantastic domain .u84 (or change it in
templatevhost.apache file), as *.u84 pointing to your local server.

USAGE

Go in the folder that you want to make a virtual host root, and execute

AddVHost

