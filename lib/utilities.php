<?php

/* returns an array of group=>group from ldap */
function getGroups()
{
    $caller = new ScriptCaller();
    $result = $caller->callScript('gm/show');
    if (is_string($result))
	return array(null);
    else return array_combine($result, $result);
}
