
A Brief Request
Please consider installing the "mpstats" port to opt in to contributing anonymous information about your system and installed ports. The statistics collected can be viewed with our online ports database.


What is MacPorts?

MacPorts provides an infrastructure for building, installing, and packaging open source software. It is designed to match the functionality of the FreeBSD Ports system and to be extensible for future enhancements.


System Requirements:

This installer is built for macOS 10.11.x and requires the curl and OpenSSL libraries provided by macOS. To build ports locally, you will need to install the Xcode Command Line Tools by running "xcode-select --install" in your terminal. Also required for many GUI applications is the installation of Apple's Xcode development suite, available from the Mac App Store or from Apple's Developer site. It is also available as a separate installation on Mac OS X CDs and DVDs.


Install Location:

The MacPorts installer copies MacPorts to the target directory /opt/local. If you wish to install to any path other than that, you must install MacPorts via its source code. See Installing MacPorts on the MacPorts webpage for instructions on installation alternatives.


What is Installed:

Aside from a few MacPorts executable commands in /opt/local/bin, most MacPorts files are installed in /opt/local/var/macports. Within these directories you will find a "sources" directory containing the Portfiles that hold the necessary instructions to install individual ports, and also the source code for MacPorts itself. Both are kept up to date by using the port selfupdate command as shown below. Please read the port(1) man page for more information.


Shell Environment:

An appropriate configuration file for your chosen shell (such as ~/.profile, ~/.zprofile, or ~/.tcshrc) is created or updated during the MacPorts installation. It contains the necessary statements to append MacPorts' binary paths within /opt/local/ to your shell environment, so MacPorts is available to you on subsequent terminal sessions. You may have to quit and restart your terminal application for this change to take effect.


Basic Usage:

The main user interface to MacPorts is the port command and the various facilities it provides for installing ports. The first thing you should do after you install MacPorts is to make sure it is fully up to date by pulling the latest revisions to the Portfiles and any updated MacPorts base code from our rsync server, all accomplished simply by running the port selfupdate command as the Unix superuser:

	sudo port selfupdate

Running this command on a regular basis is recommended -- it ensures your MacPorts installation is always up to date. Afterwards, you may search for ports to install:

	port search <portname>

where <portname> is the name of the port you are searching for, or a partial name. To install a port you've chosen, you need to run the port install command as the Unix superuser:

	sudo port install <portname>

where now <portname> maps to an exact port name in the ports tree, such as those returned by the port search command. Please consult the port(1) man page for complete documentation for this command and the software installation process.


Documentation:

The MacPorts Guide and MacPorts Wiki should be consulted for further documentation and support. Also provided are man pages for port, macports.conf, portfile, portgroup, portstyle, and porthier. These can be invoked by typing: "man" followed by the name of the command or file (e.g. "man port" or "man macports.conf").


Creating New Ports:

If you are interested in developing your own ports for private usage, or would like to submit your ports for inclusion within the MacPorts software repository, please consult the documentation provided on our website. The MacPorts project depends on a community of active participants and we are always open to welcoming new volunteers and their contributions!

Thank you for your interest in MacPorts!
