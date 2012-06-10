<?xml version="1.0" encoding="utf-8"?>
<extension version="2.5" type="plugin" group="system" method="upgrade">

	<name>PLG_SYSTEM_EXTERNALLOGIN</name>

	<!-- The following elements are optional and free of formatting conttraints -->
	<creationDate>July 2008</creationDate>
	<author>Christophe Demko, Ioannis Barounis, Alexandre Gandois</author>
	<authorEmail>external-login@chdemko.com</authorEmail>
	<authorUrl>http://www.chdemko.com</authorUrl>
	<copyright>Copyright (C) 2008-2012 Christophe Demko, Ioannis Barounis, Alexandre Gandois.</copyright>
	<license>http://www.gnu.org/licenses/gpl-2.0.html</license>

	<!--  The version string is recorded in the extension table -->
	<version>@VERSION@</version>

	<!-- The description is optional and defaults to the name -->
	<description>PLG_SYSTEM_EXTERNALLOGIN_DESCRIPTION</description>

	<files>
		<filename plugin="externallogin">externallogin.php</filename>
		<filename>index.html</filename>
	</files>

	<languages>
		<language tag="en-GB">language/en-GB/en-GB.plg_system_externallogin.ini</language>
		<language tag="en-GB">language/en-GB/en-GB.plg_system_externallogin.sys.ini</language>
	</languages>

	<config>
		<fields name="params">
			<fieldset
				name="basic"
			>
				<field
					name="allow_change_password"
					type="radio"
					default="0"
					label="PLG_SYSTEM_EXTERNALLOGIN_FIELD_ALLOW_CHANGE_PASSWORD_LABEL"
					description="PLG_SYSTEM_EXTERNALLOGIN_FIELD_ALLOW_CHANGE_PASSWORD_DESC"
				>
					<option value="0">JNO</option>
					<option value="1">JYES</option>
				</field>
			</fieldset>
		</fields>
	</config>

</extension>
