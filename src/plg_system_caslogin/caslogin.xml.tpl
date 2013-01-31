<?xml version="1.0" encoding="utf-8"?>
<extension version="2.5" type="plugin" group="system" method="upgrade">

	<name>PLG_SYSTEM_CASLOGIN</name>

	<!-- The following elements are optional and free of formatting conttraints -->
	<creationDate>July 2008</creationDate>
	<author>Christophe Demko, Ioannis Barounis, Alexandre Gandois</author>
	<authorEmail>external-login@chdemko.com</authorEmail>
	<authorUrl>http://www.chdemko.com</authorUrl>
	<copyright>Copyright (C) 2008-2013 Christophe Demko, Ioannis Barounis, Alexandre Gandois.</copyright>
	<license>http://www.gnu.org/licenses/gpl-2.0.html</license>

	<!--  The version string is recorded in the extension table -->
	<version>@VERSION@</version>

	<!-- The description is optional and defaults to the name -->
	<description>PLG_SYSTEM_CASLOGIN_DESCRIPTION</description>

	<files>
		<filename plugin="caslogin">caslogin.php</filename>
		<filename>index.html</filename>
		<folder>forms</folder>
	</files>

	<media destination="plg_system_caslogin" folder="media">
		<filename>index.html</filename>
		<folder>css</folder>
		<folder>images</folder>
		<folder>js</folder>
	</media>

	<languages>
		<language tag="en-GB">language/en-GB/en-GB.plg_system_caslogin.ini</language>
		<language tag="en-GB">language/en-GB/en-GB.plg_system_caslogin.sys.ini</language>
	</languages>

	<config />

	<!-- UPDATESERVER DEFINITION -->
	<updateservers>
		<!-- Note: No spaces or linebreaks allowed between the server tags -->
		<server type="collection" priority="1" name="External Login Update Site">http://download.chdemko.com/joomla/extensions/external-login/server.xml</server>
	</updateservers>

</extension>
