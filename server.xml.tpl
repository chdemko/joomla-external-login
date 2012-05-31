<?xml version="1.0" encoding="utf-8"?>
<extensionset name="External Login" description="External Login">

	<extension
		name="External Login Package"
		element="pkg_externallogin"
		type="package"
		version="@VERSION@"
		detailsurl="https://github.com/downloads/chdemko/joomla-external-login/update-pkg_externallogin.xml"
	/>

	<extension
		name="System - CAS Login"
		element="caslogin"
		folder="system"
		type="plugin"
		version="@VERSION@"
		detailsurl="https://github.com/downloads/chdemko/joomla-external-login/update-plg_system_caslogin.xml"
	/>

	<extension
		name="User - Community Builder External Login"
		element="cbexternallogin"
		folder="user"
		type="plugin"
		version="@VERSION@"
		detailsurl="https://github.com/downloads/chdemko/joomla-external-login/update-plg_user_cbexternallogin.xml"
	/>

	<extension
		name="External Login Admin Template"
		element="externallogin"
		type="template"
		client="administrator"
		version="@VERSION@"
		detailsurl="https://github.com/downloads/chdemko/joomla-external-login/update-tpl_externallogin.xml"
	/>

</extensionset>

