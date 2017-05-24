<?php 
/**
* 
*/
namespace Box\Mod\Craftsrv\Api ;

class Admin extends \Api_Abstract
{
	public function create($data)
	{
		$required = array(
			'host'  	=> 'Host required',
			'version'  	=> 'Version required',
			'token'  	=> 'Token required',
		) ;
        $validator = $this->di['validator'];
        $validator->checkRequiredParamsForArray($required, $data);
        $service = $this->getService();
        return $service->adminCreateServerMachine($data);
	}

	public function get_list($data)
	{
        $per_page = $this->di['array_get']($data, 'per_page', $this->di['pager']->getPer_page());
        list($sql, $params) = $this->getService()->getSearchQuery($data);
        $pager = $this->di['pager']->getSimpleResultSet($sql, $params, $per_page);
        foreach($pager['list'] as $key => $craftsrvArr){
            $craftsrv = $this->di['db']->getExistingModelById('craftsrv_machine', $craftsrvArr['id'], 'CraftSRV Machines not found');
            $pager['list'][$key] = $this->getService()->toApiArray($craftsrv, true, $this->getIdentity());
        }

        return $pager;
	}
}