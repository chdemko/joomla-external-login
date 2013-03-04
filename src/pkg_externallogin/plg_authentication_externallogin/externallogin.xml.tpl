<?xml version="1.0" encoding="utf-8"?>
<extension version="2.5" type="plugin" group="authentication" method="upgrade">

	<name>PLG_AUTHENTICATION_EXTERNALLOGIN</name>

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
	<description>PLG_AUTHENTICATION_EXTERNALLOGIN_DESCRIPTION</description>

	<files>
		<filename plugin="externallogin">externallogin.php</filename>
		<filename>index.html</filename>
	</files>

	<languages>
		<language tag="en-GB">language/en-GB/en-GB.plg_authentication_externallogin.ini</language>
		<language tag="en-GB">language/en-GB/en-GB.plg_authentication_externallogin.sys.ini</language>
	</languages>

	<config/>

</extension>
