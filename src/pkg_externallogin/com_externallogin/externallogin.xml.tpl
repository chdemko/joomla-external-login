<?xml version="1.0" encoding="utf-8"?>
<extension type="component" version="2.5" method="upgrade">

	<name>COM_EXTERNALLOGIN</name>

	<!-- The following elements are optional and free of formatting conttraints -->
	<creationDate>July 2008</creationDate>
	<author>Christophe Demko, Ioannis Barounis, Alexandre Gandois</author>
	<authorEmail>externallogin@chdemko.com</authorEmail>
	<authorUrl>http://www.chdemko.com</authorUrl>
	<copyright>Copyright (C) 2008-2013 Christophe Demko, Ioannis Barounis, Alexandre Gandois.</copyright>
	<license>http://www.gnu.org/licenses/gpl-2.0.html</license>

	<!--  The version string is recorded in the extension table -->
	<version>@VERSION@</version>

	<!-- The description is optional and defaults to the name -->
	<description>COM_EXTERNALLOGIN_DESCRIPTION</description>

	<!-- Runs on install/uninstall/update; New in 1.6 -->
	<scriptfile>script.php</scriptfile>

	<install> <!-- Runs on install -->
		<sql>
			<file driver="mysql" charset="utf8">sql/install.mysql.utf8.sql</file>
		</sql>
	</install>
	<uninstall> <!-- Runs on uninstall -->
		<sql>
			<file driver="mysql" charset="utf8">sql/uninstall.mysql.utf8.sql</file>
		</sql>
	</uninstall>
	<update> <!-- Runs on update; New in 1.6 -->
		<schemas>
			<schemapath type="mysql">sql/updates/mysql</schemapath>
		</schemas>
	</update>

	<!-- Site Main File Copy Section -->
	<!-- Note the folder attribute: This attribute describes the folder
		to copy FROM in the package to install therefore files copied
		in this section are copied from /site/ in the package -->
	<files folder="site">
		<filename>index.html</filename>
		<filename>externallogin.php</filename>
		<filename>controller.php</filename>
		<filename>helpers.php</filename>
		<filename>router.php</filename>
		<folder>models</folder>
		<folder>views</folder>
	</files>

	<languages folder="site">
		<language tag="en-GB">language/en-GB/en-GB.com_externallogin.ini</language>
	</languages>

	<media destination="com_externallogin" folder="media">
		<filename>index.html</filename>
		<folder>css</folder>
		<folder>images</folder>
		<folder>js</folder>
	</media>

	<administration>
		<!-- Administration Menu Section -->
		<menu img="../media/com_externallogin/images/administrator/icon-16-externallogin.png">COM_EXTERNALLOGIN_MENU</menu>
		<submenu>
			<menu
				view="users"
				img="../media/com_externallogin/images/administrator/icon-16-users.png"
			>COM_EXTERNALLOGIN_MENU_USERS</menu>
			<menu
				view="logs"
				img="../media/com_externallogin/images/administrator/icon-16-logs.png"
			>COM_EXTERNALLOGIN_MENU_LOGS</menu>
			<menu
				view="about"
				img="../media/com_externallogin/images/administrator/icon-16-about.png"
			>COM_EXTERNALLOGIN_MENU_ABOUT</menu>
		</submenu>

		<!-- Administration Main File Copy Section -->
		<!-- Note the folder attribute: This attribute describes the folder
			to copy FROM in the package to install therefore files copied
			in this section are copied from /admin/ in the package -->
		<files folder="admin">
			<!-- Admin Main File Copy Section -->
			<filename>index.html</filename>
			<filename>config.xml</filename>
			<filename>access.xml</filename>
			<filename>externallogin.php</filename>
			<filename>controller.php</filename>
			<filename>helpers.php</filename>
			<!-- SQL files section -->
			<folder>sql</folder>
			<!-- tables files section -->
			<folder>tables</folder>
			<!-- models files section -->
			<folder>models</folder>
			<!-- views files section -->
			<folder>views</folder>
			<!-- controllers files section -->
			<folder>controllers</folder>
			<!-- helpers files section -->
			<folder>helpers</folder>
			<!-- Logger files section -->
			<folder>log</folder>
		</files>

		<languages folder="admin">
			<language tag="en-GB">language/en-GB/en-GB.com_externallogin.ini</language>
			<language tag="en-GB">language/en-GB/en-GB.com_externallogin.sys.ini</language>
		</languages>
	</administration>

</extension>

