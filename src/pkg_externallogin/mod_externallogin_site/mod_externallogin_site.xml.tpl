<?xml version="1.0" encoding="utf-8"?>
<extension type="module" version="2.5" client="site" method="upgrade">

	<name>MOD_EXTERNALLOGIN_SITE</name>

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
	<description>MOD_EXTERNALLOGIN_SITE_DESCRIPTION</description>

	<files>
		<filename>index.html</filename>
		<filename module="mod_externallogin_site">mod_externallogin_site.php</filename>
		<filename>helper.php</filename>
		<folder>tmpl</folder>
	</files>

	<languages>
		<language tag="en-GB">language/en-GB/en-GB.mod_externallogin_site.ini</language>
		<language tag="en-GB">language/en-GB/en-GB.mod_externallogin_site.sys.ini</language>
	</languages>

	<help key="MOD_EXTERNALLOGIN_SITE_HELP" />

	<config>
		<fields name="params">
			<fieldset name="basic">
				<field
					type="sql"
					name="server"
					multiple="true"
					query="SELECT id as value, title as server FROM #__externallogin_servers ORDER BY ordering ASC"
					size="10"
					label="MOD_EXTERNALLOGIN_SITE_FIELD_SERVERS_LABEL"
					description="MOD_EXTERNALLOGIN_SITE_FIELD_SERVERS_DESC"
				/>
				<field
					name="cache"
					type="hidden"
					default="0"
				/>
			</fieldset>
			<fieldset name="advanced">
				<field
					name="show_logout"
					type="radio"
					label="MOD_EXTERNALLOGIN_SITE_FIELD_SHOW_LOGOUT_LABEL"
					description="MOD_EXTERNALLOGIN_SITE_FIELD_SHOW_LOGOUT_DESC"
					default="0"
				>
					<option value="0">JNO</option>
					<option value="1">JYES</option>
				</field>
				<field
					name="show_title"
					type="radio"
					label="MOD_EXTERNALLOGIN_SITE_FIELD_SHOW_TITLE_LABEL"
					description="MOD_EXTERNALLOGIN_SITE_FIELD_SHOW_TITLE_DESC"
					default="0"
				>
					<option value="0">JNO</option>
					<option value="1">JYES</option>
				</field>
			</fieldset>
		</fields>
	</config>

</extension>

