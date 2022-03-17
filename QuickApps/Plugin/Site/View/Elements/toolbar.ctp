<?php

$posRep = strpos($this->request->action,'representante');
$posLoj = strpos($this->request->action,'loja');
$posLojVt = strpos($this->request->action,'virtua');

if($this->request->params['controller'] == 'cidade')
{
	$links = array(
		array(__t('Cidades'), '/admin/cidades', array('title' => __t('Cidades'))),
		array(__t('Nova Cidade'), '/admin/cidade/add', array('title' => __t('Nova Cidade'))),
	);
}
elseif($this->request->params['controller'] == 'estado')
{
	$links = array(
		array(__t('Estados'), '/admin/estados', array('title' => __t('Estados'))),
		array(__t('Novo Estado'), '/admin/estado/add', array('title' => __t('Novo Estado'))),
	);
}
elseif($this->request->params['controller'] == 'pais')
{
	$links = array(
		array(__t('Países'), '/admin/paises', array('title' => __t('Países'))),
		array(__t('Novo País'), '/admin/pais/add', array('title' => __t('Novo País'))),
	);
}
elseif($this->request->params['controller'] == 'userApp')
{
	$links = array(
		array(__t('Usuários'), '/admin/site/userApp', array('title' => __t('Usuários'))),
		array(__t('Novo Usuário'), '/admin/site/userApp/add', array('title' => __t('Novo Usuário'))),
	);
}
elseif($posLojVt)
{
	$links = array(
		array(__t('Lojas Virtuais'), '/admin/lojasvirtuais', array('title' => __t('Lojas Virtuais'))),
		array(__t('Nova Loja Virtual'), '/admin/lojavirtual/add', array('title' => __t('Nova Loja Virtual'))),
	);
}
elseif($posRep)
{
	$links = array(
		array(__t('Representantes'), '/admin/representantes', array('title' => __t('Representantes'))),
		array(__t('Novo Representante'), '/admin/representante/add', array('title' => __t('Novo Representante'))),
	);
}
elseif($posLoj)
{
	$links = array(
		array(__t('Lojas'), '/admin/lojas', array('title' => __t('Lojas'))),
		array(__t('Nova Loja'), '/admin/loja/add', array('title' => __t('Nova Loja'))),
	);
}

echo $this->Menu->toolbar($links);