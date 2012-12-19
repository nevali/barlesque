<?php

/*
 * Copyright 2012 Mo McRoberts.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

uses('form');

require_once(dirname(__FILE__) . '/page.php');

class BarlesqueDemo extends BarlesquePage
{
	protected $templateName = 'demo.phtml';
	protected $form;
	protected $title = 'Barlesque test config generator';

	protected $settings = array(
		'Global' => array(
			'COUNTRY' => '/global/country',
			'IP_IS_ADVERTISE_COMBINED' => '/global/showadverts',
			'IP_IS_UK_COMBINED' => '/global/isuk',
			'zone' => '/global/bbcdotcom',
			'REQUEST_URI' => '',
			'ADS_ENABLED' => '/global/adsenabled',
			'blq_language' => '/global/language',
			'blq_journalism_variant' => '/global/journalismvariant',
			'blq_search_variant' => '/global/searchvariant',
			'blq_variant' => '/global/cbbcvariant',
			'blq_ws_noads' => '/global/worldservicevariant',
			'blq_promo_optout' => '/global/promomechanism',
			'blq_https' => '/global/https',
			'blq_link_prefix' => '/global/linkprefix',
			'blq_gvl' => '',
			'blq_nedstat' => '/global/nedstat',
			'blq_nedstat_countername' => '/global/nedstat',
			'blq_nedstat_httpstatus' => '/global/nedstat',
			'blq_nedstat_pagetracking_optout' => '/global/nedstat',
			'blq_ie6_upgrade_optout' => '/global/ie6-upgrade',
			'blq_doctype' => '/global/doctype',
			'blq_requirejs' => '/global/requirejs',
			'blq_forced_gel_upgrade' => '',
			'blq_is_from_cdn' => '',
			'blq_idcta' => '',
			'blq_idcta_policy' => '',
			'blq_idcta_ptrt' => '',
			'blq_idcta_use_overlay' => '',
			'blq_version' => '/global/version',
			),
		'JavaScript and CSS' => array(
			'blq_css_framework' => '/jsandcss/cssframework',
			'blq_glow_map_version' => '/jsandcss/glowloader',
			'blq_gloader_version' => '/jsandcss/glowloader',
			'blq_include_glow' => '/jsandcss/includeglow',
			),
		'Masthead' => array(
			'blq_new_nav' => '/masthead/oldnav',
			'blq_toolbar_colour' => '/masthead/toolbarcolour',
			'blq_masthead_background' => '/masthead/mastheadbackground',
			'blq_masthead_opacity' => '/masthead/opacity',
			'blq_masthead_text_color' => '/masthead/mastheadtextcolour',
			'blq_acc_link_url_1' => '/masthead/acclinks',
			'blq_acc_link_text_1' => '/masthead/acclinks',
			'blq_acc_link_url_2' => '/masthead/acclinks',
			'blq_acc_link_text_2' => '/masthead/acclinks',
			'blq_no_local_nav' => '/masthead/nolocalnav',
			'blq_search_scope' => '/masthead/searchscope',
			'blq_search_term' => '/masthead/searchterm',
			'blq_nav_color' => '/masthead/navcolour',
			'blq_promo_format' => '',
			'bbcpage_survey' => '/masthead/pulsesurvey',
			'bbcpage_surveysite' => '/masthead/pulsesurvey',
			'survey_forcelocal' => '',
			'bbcpage_survey_nopop' => '/masthead/pulsesurvey',
			'survey_format' => '/masthead/pulsesurvey',
			'survey_forceon' => '',
			'blq_identity' => '/masthead/identitystatusbar',
			'blq_identity_format' => '/masthead/identitystatusbar',
			'blq_mothball' => '/masthead/mothball',
			'blq_mothball_date' => '/masthead/mothball',
			),
		'Page content' => array(
			'blq_tt_targets' => '/pagecontent/tttargets',
			),
		'Footer' => array(
			'blq_complaints_link' => '/footer/complaintslink',
			'blq_footer_color' => '/footer/footercolour',
			'blq_footer_text_color' => '',
			'blq_contact_us_url' => '/footer/contactusurl',
			'blq_bookmarks' => '/footer/socialbookmarkingbar',
			'blq_bookmark_title' => '/footer/socialbookmarkingbar',
			'blq_bookmark_format' => '/footer/socialbookmarkingbar',
			'blq_desktop_url' => '/footer/desktopurl',
			),
		'Deprecated' => array(
			'blq_ws_nojobs' => '/global/worldservicevariant',
			'blq_webservice_variant' => '',
			),
		'Mobile' => array(
			'blq_mobile_url' => '/masthead/mobileurl',
			'identitystatusbar' => '',
			),
		);

	public function __construct()
	{
		parent::__construct();
		$this->form = new Form();
		$this->form->method = 'GET';
		$bools = $this->blq->bools;
		$choices = $this->blq->choices;

		foreach($this->settings as $heading => $group)
		{
			$this->form->label($heading);
			foreach($group as $key => $link)
			{
				if(strlen($link))
				{
					$label = '<a href="http://www.bbc.co.uk/frameworks/barlesque/examples' . $link . '">' . $key . '</a>';
				}
				else
				{
					$label = $key;
				}
				$field = array(
					'name' => $key,
					'label' => $label,
					'type' => 'text',
					'escapeLabel' => false,
					);
				if(isset($bools[$key]))
				{
					if($bools[$key][0] === null)
					{
						$field['from'][$bools[$key][0]] = 'false';
						$field['type'] = 'checkbox';
						$field['checkValue'] = $bools[$key][1];
						$field['controlSuffix'] = '&nbsp;' . _e($bools[$key][1]);
					}
					else
					{
						$field['type'] = 'select';
						$field['from'][''] = 'Not set';
						$field['from'][$bools[$key][0]] = $bools[$key][0];
						$field['from'][$bools[$key][1]] = $bools[$key][1];
					}
				}
				else if(isset($choices[$key]))
				{
					$field['type'] = 'select';
					$field['from'][''] = 'Not set';
					foreach($choices[$key] as $choice)
					{
						$field['from'][$choice] = $choice;
					}
				}
				$this->form->field($field);
			}
		}	  
		
		$this->form->submit('Preview choices');
	}

	protected function getObject()
	{
		if(($r = parent::getObject()) !== true)
		{
			return $r;
		}
		$this->form->checkSubmission($this->request);
		return true;
	}

	protected function assignTemplate()
	{
		$values = $this->form->values();
		$this->blq->reset();
		foreach($values as $k => $v)
		{
			if(strlen($v))
			{
				$this->blq->{$k} = $v;
			}
		}
		parent::assignTemplate();
		$this->vars['form'] = $this->form;
	}
}