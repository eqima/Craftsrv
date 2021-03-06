<?php 
/**
* CraftSRV admin controller
* @version 0.1.0
*/
namespace Box\Mod\Craftsrv\Controller;

class Admin implements \Box\InjectionAwareInterface
{
	protected $di ;

	public function setDi($di)
	{
		$this->di = $di ;
	}

	public function getDi()
	{
		return $this->di ;
	}

	public function fetchNavigation()
	{
		return array(
			'group' => array(
				'index'  	=> 1000,
				'location'  => 'craftsrv',
                'label'     => 'CraftSRV',
                'class'     => 'craftsrv'
			),
			'subpages' => array(
                array(
                    'location'  => 'craftsrv',
                    'label'     => 'Overview',
                    'index'     => 1000,
                    'uri'       => $this->di['url']->adminLink('craftsrv'),
                ),
            ),
		) ;
	}

	public function register(\Box_App &$app)
	{
		$app->get('/craftsrv', 'get_index', array(), get_class($this)) ;
		$app->get('/craftsrv/manage/:id', 'get_manage', array('id'=>'[0-9]+'), get_class($this)) ;
	}

	public function get_index(\Box_App $app)
	{
		$this->di['is_admin_logged'] ;
		return $app->render('mod_craftsrv_index') ;
	}

	public function get_manage(\Box_App $app, $id)
	{
		$api = $this->di['api_admin'] ;
		$craftsrv = $api->craftsrv_get(array('id'=>$id,'deep'=>true)) ;
		return $app->render('mod_craftsrv_manage', array('craftsrv'=>$craftsrv)) ;
	}
}