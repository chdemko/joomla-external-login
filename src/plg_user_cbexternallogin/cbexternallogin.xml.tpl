<?xml version="1.0" encoding="utf-8"?>
<extension version="2.5" type="plugin" group="user" method="upgrade">

	<name>PLG_USER_CBEXTERNALLOGIN</name>

	<!-- The following elements are optional and free of formatting conttraints -->
	<creationDate>May 2012</creationDate>
	<author>Christophe Demko</author>
	<authorEmail>external-login@chdemko.com</authorEmail>
	<authorUrl>http://www.chdemko.com</authorUrl>
	<copyright>Copyright (C) 2008-2013 Christophe Demko</copyright>
	<license>http://www.gnu.org/licenses/gpl-2.0.html</license>

	<!--  The version string is recorded in the extension table -->
	<version>@VERSION@</version>

	<!-- The description is optional and defaults to the name -->
	<description>PLG_USER_CBEXTERNALLOGIN_DESCRIPTION</description>

	<files>
		<filename plugin="cbexternallogin">cbexternallogin.php</filename>
		<filename>index.html</filename>
	</files>

	<languages>
		<language tag="en-GB">language/en-GB/en-GB.plg_user_cbexternallogin.ini</language>
		<language tag="en-GB">language/en-GB/en-GB.plg_user_cbexternallogin.sys.ini</language>
	</languages>

	<config />

	<!-- UPDATESERVER DEFINITION -->
	<updateservers>
		<!-- Note: No spaces or linebreaks allowed between the server tags -->
		<server type="collection" priority="1" name="External Login Update Site">http://download.chdemko.com/joomla/extensions/external-login/server.xml</server>
	</updateservers>

</extension>
