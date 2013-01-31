<?xml version="1.0" encoding="utf-8"?>
<extension type="package" version="2.5" method="upgrade">

	<name>pkg_externallogin</name>

	<!-- The following elements are optional and free of formatting conttraints -->
	<creationDate>May 2012</creationDate>
	<author>Christophe Demko, Ioannis Barounis, Alexandre Gandois</author>
	<authorEmail>externallogin@chdemko.com</authorEmail>
	<authorUrl>http://www.chdemko.com</authorUrl>
	<copyright>Copyright (C) 2008-2013 Christophe Demko, Ioannis Barounis, Alexandre Gandois.</copyright>
	<license>http://www.gnu.org/licenses/gpl-2.0.html</license>

	<!--  The version string is recorded in the extension table -->
	<version>@VERSION@</version>

	<!-- The description is optional and defaults to the name -->
	<description>PKG_EXTERNALLOGIN_DESCRIPTION</description>

	<url>http://www.github/chdemko/joomla-externallogin</url>

	<packager>Christophe Demko</packager>
	<packagerurl>http://www.chdemko.com</packagerurl>
	<packagename>externallogin</packagename>

	<languages folder="language">
		<language tag="en-GB">en-GB/en-GB.pkg_externallogin.sys.ini</language>
	</languages>

	<files>
		<file type="component" id="com_externallogin">com_externallogin-@VERSION@.zip</file>
		<file type="module" id="mod_externallogin_site" client="site">mod_externallogin_site-@VERSION@.zip</file>
		<file type="module" id="mod_externallogin_admin" client="administrator">mod_externallogin_admin-@VERSION@.zip</file>
		<file type="plugin" id="externallogin" group="authentication">plg_authentication_externallogin-@VERSION@.zip</file>
		<file type="plugin" id="externallogin" group="system">plg_system_externallogin-@VERSION@.zip</file>
	</files>

	<!-- UPDATESERVER DEFINITION -->
	<updateservers>
		<!-- Note: No spaces or linebreaks allowed between the server tags -->
		<server type="collection" priority="1" name="External Login Update Site">http://download.chdemko.com/joomla/extensions/external-login/server.xml</server>
	</updateservers>

</extension>
