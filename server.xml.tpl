<?xml version="1.0" encoding="utf-8"?>
<extensionset name="External Login" description="External Login">

	<extension
		name="External Login Package"
		element="pkg_externallogin"
		type="package"
		version="@VERSION@"
		detailsurl="@SERVER@/update-pkg_externallogin-3.xml"
	/>

	<extension
		name="System - CAS Login"
		element="caslogin"
		folder="system"
		type="plugin"
		version="@VERSION@"
		detailsurl="@SERVER@/update-plg_system_caslogin-3.xml"
	/>

	<extension
		name="User - Community Builder External Login"
		element="cbexternallogin"
		folder="user"
		type="plugin"
		version="@VERSION@"
		detailsurl="@SERVER@/update-plg_user_cbexternallogin-3.xml"
	/>

</extensionset>

