<?php

UKMwp_innhold::registerFunctions();
UKMwp_dashboard::addViewData('page', getPage('support'));
echo TWIG(
	'support.html.twig',
	UKMwp_dashboard::getViewData(), 
	UKMwp_dashboard::getPluginPath()
);