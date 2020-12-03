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

uses('curl');

class Barlesque
{
	public $environment = 'live';
	public $host = null;
	public $path = '/frameworks/barlesque/webservice.xml';

	protected $results;
	protected $options = array();
	protected $keys = array('head', 'bodyfirst', 'bodylast');
	protected $map = array();
	protected $bools = array();
	protected $choices = array();

	public function __construct()
	{
		/* Global */
		$this->options['COUNTRY'] = 'gb';
		$this->map['country'] = 'COUNTRY';
		$this->choices['COUNTRY'] = array('gb', 'us');
		
		$this->options['IP_IS_ADVERTISE_COMBINED'] = null;
		$this->map['showAdverts'] = 'IP_IS_ADVERTISE_COMBINED';
		$this->bools['IP_IS_ADVERTISE_COMBINED'] = array('no', 'yes');

		$this->options['IP_IS_UK_COMBINED'] = null;
		$this->map['isUK'] = 'IP_IS_UK_COMBINED';
		$this->bools['IP_IS_UK_COMBINED'] = array('no', 'yes');

		$this->options['zone'] = null;
		$this->choices['zone'] = array('test_zone');
		
		$this->options['REQUEST_URI'] = null;
		$this->choices['REQUEST_URI'] = array('/food/index.shtml?recipe_id=12');

		$this->options['ADS_ENABLED'] = null;
		$this->map['adsEnabled'] = 'ADS_ENABLED';
		$this->bools['ADS_ENABLED'] = array('no', 'yes');

		$this->options['blq_language'] = 'en-GB';
		$this->map['language'] = 'blq_language';		
		$this->choices['blq_language'] = array("en-GB", "cy", "gd", "ga", "fa", "en", "cy", "gd", "ga", "en", "pt", "es", "sq", "mk", "ru", "sr", "tr", "uk", "ar", "fr", "ha", "rw", "pt", "so", "sw", "ps", "fa", "az", "ky", "uz", "bn", "hi", "ne", "en", "ta", "ur", "my", "zh", "zh", "id", "vi", "cy-GB", "gd-GB", "ga-GB", "en-029", "pt-BR", "es-005", "sq-AL", "mk-MK", "ru-RU", "sr-RS", "tr-TR", "uk-UA", "ar-SA", "fr-002", "ha-GH", "rw-RW", "pt-002", "so-SO", "sw-KE", "ps-AF", "fa-IR", "az-AZ", "ky-KG", "uz-UZ", "bn-BD", "hi-IN", "ne-NP", "en-IN", "ta-IN", "ur-IN", "my-MM", "zh-Hant-CN", "zh-Hans-CN", "id-ID", "vi-VN", "en-GB-pir");
		$this->options['blq_journalism_variant'] = null;
		$this->map['journalismVariant'] = 'blq_journalism_variant';
		$this->bools['blq_journalism_variant'] = array(null, 1);

		$this->options['blq_search_variant'] = null;
		$this->map['searchVariant'] = 'blq_search_variant';
		$this->bools['blq_search_variant'] = array(null, 1);

		$this->options['blq_variant'] = null;
		$this->map['childrensVariant'] = 'blq_variant';
		$this->choices['blq_variant'] = array('cbbc', 'cbeebies');

		$this->options['blq_ws_noads'] = null;
		$this->map['worldServiceVariant'] = 'blq_ws_noads';
		$this->bools['blq_ws_noads'] = array(null, 1);
		
		$this->options['blq_promo_optout'] = null;
		$this->map['globalPromosOptOut'] = 'blq_promo_optout';
		$this->bools['blq_promo_optout'] = array(null, 1);

		$this->options['blq_https'] = null;
		$this->map['https'] = 'blq_https';
		$this->bools['blq_https'] = array(null, 1);
		
		$this->options['blq_link_prefix'] = 'http://www.bbc.co.uk';
		$this->map['linkPrefix'] = 'blq_link_prefix';
		$this->choices['blq_link_prefix'] = array('http://www.bbc.co.uk', 'http://extdev.bbc.co.uk');

		$this->options['blq_gvl'] = '3.5';
		$this->map['gvl'] = 'blq_gvl';
		$this->choices['blq_gvl'] = array('2.7', '2.8', '3', '3.5', '4');

		$this->options['blq_nedstat'] = null;
		$this->map['nedstat'] = 'blq_nedstat';
		$this->bools['blq_nedstat'] = array(null, 1);
		
		$this->options['blq_nedstat_countername'] = null;
		$this->map['nedstatCounterName'] = 'blq_nedstat_countername';
		$this->choices['blq_nedstat_countername'] = array('my.custom.page');

		$this->options['blq_nedstat_httpstatus'] = null;
		$this->map['netstatHttpStatus'] = 'blq_nedstat_httpstatus';
		$this->choices['blq_nedstat_httpstatus'] = array('404');

		$this->options['blq_nedstat_pagetracking_optout'] = null;
		$this->map['nedstatPageTrackingOptOut'] = 'blq_nedstat_pagetracking_optout';
		$this->bools['blq_nedstat_pagetracking_optout'] = array(null, 1);

		$this->options['blq_ie6_upgrade_optout'] = null;
		$this->map['ie6UpgradeOptout'] = 'blq_ie6_upgrade_optout';
		$this->bools['blq_ie6_upgrade_optout'] = array(null, 1);
		
		$this->options['blq_doctype'] = 'html5';
		$this->map['doctype'] = 'blq_doctype';
		$this->choices['blq_doctype'] = array('xhtml', 'xhtml+rdfa', 'html5');

		$this->options['blq_requirejs'] = null;
		$this->map['requirejs'] = 'blq_requirejs';
		$this->bools['blq_requirejs'] = array('off', 'on');

		$this->options['blq_forced_gel_upgrade'] = null;
		$this->bools['blq_forced_gel_upgrade'] = array(null, 1);
		
		$this->options['blq_is_from_cdn'] = null;
		$this->bools['blq_is_from_cdn'] = array(0, 1);
		
		$this->options['blq_idcta'] = null;
		$this->bools['blq_idcta'] = array('off', 'on');

		$this->options['blq_idcta_policy'] = null;
		$this->choices['blq_idcta_policy'] = array('comment');

		$this->options['blq_idcta_ptrt'] = null;
		$this->choices['blq_idcta_ptrt'] = array('http://www.bbc.co.uk/iplayer');

		$this->options['blq_idcta_use_overlay'] = null;
		$this->bools['blq_idcta_use_overlay'] = array(0, 1);

		$this->options['blq_istats_linktracking'] = null;
		$this->map['istats'] = 'blq_istats_linktracking';

		$this->options['blq_version'] = null;
		$this->map['version'] = 'blq_version';
		$this->choices['blq_version'] = array('4');

		/* Javascript and CSS */
		$this->options['blq_css_framework'] = null;
		$this->map['cssFramework'] = 'blq_css_framework';
		$this->choices['blq_css_framework'] = array('v01');

		$this->options['blq_glow_map_version'] = null;
		$this->map['glowMapVersion'] = 'blq_glow_map_version';
		$this->choices['blq_glow_map_version'] = array('1.4.0');

		$this->options['blq_gloader_version'] = null;
		$this->map['gloaderVersion']  = 'blq_gloader_version';
		$this->choices['blq_gloader_version'] = array('0.1.0');

		$this->options['blq_include_glow'] = null;
		$this->map['includeGlow'] = 'blq_include_glow';
		$this->bools['blq_include_glow'] = array('false', 'true');

		/* Masthead */
		$this->options['blq_new_nav'] = 'true';
		$this->map['newnav'] = 'blq_new_nav';
		$this->bools['blq_new_nav'] = array(0, 'true');

		$this->options['blq_toolbar_colour'] = 'dark';
		$this->map['toolbarColour'] = 'blq_toolbar_colour';
		$this->choices['blq_toolbar_colour'] = array('dark', 'transp');

		$this->options['blq_masthead_background'] = 'black';
		$this->map['mastheadBackground'] = 'blq_masthead_background';
		$this->choices['blq_masthead_background'] = array('black', 'white', 'transparent-dark', 'transparent-medium', 'transparent-light', 'transparent');

		$this->options['blq_masthead_opacity'] = 40;
		$this->map['mastheadOpacity'] = 'blq_masthead_opacity';
		$this->choices['blq_masthead_opacity'] = array(40, 70);

		$this->options['blq_masthead_text_color'] = null;
		$this->map['mastheadTextColour'] = 'blq_masthead_text_color';
		$this->choices['blq_masthead_text_color'] = array('light', 'dark');

		$this->options['blq_acc_link_url_1'] = null;
		$this->map['accLinksURL1'] = 'blq_acc_link_url_1';
		$this->choices['blq_acc_link_url_1'] = array('/test/url/1/');

		$this->options['blq_acc_link_text_1'] = null;
		$this->map['accLinksText1'] = 'blq_acc_link_text_1';
		$this->choices['blq_acc_link_text_1'] = array('Test link text 1');

		$this->options['blq_acc_link_url_2'] = null;
		$this->map['accLinksURL2'] = 'blq_acc_link_url_2';
		$this->choices['blq_acc_link_url_2'] = array('/test/url/2/');

		$this->options['blq_acc_link_text_2'] = null;
		$this->map['accLinksText2'] = 'blq_acc_link_text_2';
		$this->choices['blq_acc_link_text_1'] = array('Test link text 2');
		
		$this->options['blq_no_local_nav'] = null;
		$this->choices['noLocalNav'] = 'blq_no_local_nav';
		$this->bools['blq_no_local_nav'] = array(null, 'true');

		$this->options['blq_search_scope'] = null;
		$this->map['searchScope'] = 'blq_search_scope';
		$this->choices['blq_search_scope'] = array('persian', 'cbbc', 'cnews', '[% global.scope | html %]');

		$this->options['blq_search_term'] = null;
		$this->map['searchTerm'] = 'blq_search_term';
		$this->choices['blq_search_term'] = array('Test term', '[% query.q | html %]');

		$this->options['blq_nav_color'] = 'blue';
		$this->map['navColour'] = 'blq_nav_color';
		$this->choices['blq_nav_color'] = array('blue', 'sky', 'teal', 'lime', 'green', 'aqua', 'khaki', 'magenta', 'purple', 'rose', 'red', 'orange');

		$this->options['blq_promo_format'] = null;
		$this->choices['blq_promo_format'] = array('ssi');

		$this->options['bbcpage_survey'] = null;
		$this->map['pulsesurvey'] = 'bbcpage_survey';
		$this->bools['bbcpage_survey'] = array(null, 'yes');
		
		$this->options['bbcpage_surveysite'] = null;
		$this->map['surveyId'] = 'bbcpage_surveysite';
		$this->choices['bbcpage_surveysite'] = array('test', 'bbcfour');

		$this->options['survey_forcelocal'] = null;
		$this->bools['survey_forcelocal'] = array(null, 'true');
		
		$this->options['bbcpage_survey_nopop'] = null;
		$this->map['surveyAsBar'] = 'bbcpage_survey_nopop';
		$this->bools['bbcpage_survey_nopop'] = array(null, 1);

		$this->options['survey_format'] = null;		
		$this->choices['survey_format'] = array('ssi');

		$this->options['survey_forceon'] = null;
		$this->map['surveyTest'] = array('survey_forceon');
		$this->bools['survey_forceon'] = array(null, 1);

		$this->options['blq_identity'] = null;
		$this->bools['blq_identity'] = array('off', 'on');

		$this->options['blq_identity_format'] = null;
		$this->choices['blq_identity_format'] = array('ssi');

		$this->options['blq_mothball'] = null;
		$this->map['mothball'] = 'blq_mothball';
		$this->bools['blq_mothball'] = array(null, 1);

		$this->options['blq_mothball_date'] = null;
		$this->map['mothballDate'] = 'blq_mothball_date';
		$this->choices['blq_mothball_date'] = array('April 2009');

		/* Page content */

		$this->options['blq_tt_targets'] = null;
		$this->map['TTTargets'] = 'blq_tt_targets';
		$this->choices['blq_tt_targets'] = array('blq-content');

		/* Footer */

		$this->options['blq_complaints_link'] = null;
		$this->map['complaintsLink'] = 'blq_complaints_link';
		$this->bools['blq_complaints_link'] = array(null, 'true');

		$this->options['blq_footer_color'] = null;
		$this->map['footerColour'] = 'blq_footer_color';
		$this->choices['blq_footer_color'] = array('transparent', 'black', 'opaque');

		$this->options['blq_footer_text_color'] = null;
		$this->map['footerTextColour'] = 'blq_footer_text_color';
		$this->choices['blq_footer_text_color'] = array('dark', 'light');

		$this->options['blq_contact_us_url'] = null;
		$this->map['contactUsURL'] = 'blq_contact_us_url';
		$this->choices['blq_contact_us_url'] = array('/test/url/5');

		$this->options['blq_bookmarks'] = null;
		$this->bools['blq_bookmarks'] = array(null, 1);

		$this->options['blq_bookmark_title'] = null;
		$this->choices['blq_bookmark_title'] = array('BBC - Food - Black pudding recipe');

		$this->options['blq_bookmark_format'] = null;
		$this->choices['blq_bookmark_format'] = array('ssi');

		$this->options['blq_desktop_url'] = null;
		$this->map['desktopURL'] = 'blq_desktop_url';
		$this->choices['blq_desktop_url'] = array('/foo/bar');

		/* Deprecated */
		
		$this->options['blq_ws_nojobs'] = null;
		$this->bools['blq_ws_nojobs'] = array(null, 1);

		$this->options['blq_webservice_variant'] = null;
		$this->choices['blq_webservice_variant'] = array('search', 'journalism');

		/* Mobile */

		$this->options['blq_mobile_url'] = null;
		$this->choices['blq_mobile_url'] = array('/mobile/test/url/1/');

		$this->options['identitystatusbar'] = null;
		$this->bools['identitystatusbar'] = array('false', 'true');
		
	}

	public function reset()
	{
		foreach($this->options as $k => $v)
		{
			$this->options[$k] = null;
		}
	}

	protected function url()
	{
		$host = $this->host;
		if(!strlen($host))
		{
			if($this->environment == 'live')
			{
				$host = 'www.bbc.co.uk';
			}
			else
			{
				$host = 'www.' . $this->environment . '.bbc.co.uk';
			}
		}
		if(substr($this->path, 0, 1) != '/')
		{
			$this->path = '/' . $this->path;
		}
		$url = 'http://' . $host . $this->path . '?' . $this->query();
		return $url;
	}

	protected function query()
	{
		$options = array();
		foreach($this->options as $k => $v)
		{
			if($v === true)
			{
				$v = isset($this->bools[$k]) ? $this->bools[$k][1] : 'yes';
			}
			else if($v === false)
			{
				$v = isset($this->bools[$k]) ? $this->bools[$k][0] : 'no';
			}
			if($v === null)
			{
				continue;
			}
			$options[$k] = $v;
		}
		return http_build_query($options, null, '&');
	}

	public function fetch()
	{
		if(!isset($this->results))
		{
			$this->fetchFragments();
		}
	}

	protected function fetchFragments()
	{
		$c = new CurlCache($this->url());
		$c->returnTransfer = true;
		$c->followLocation = true;
		$buf = $c->exec();
		$c->close();
		if(!strlen($buf))
		{
			return;
		}
		$this->results = array();
		$root = @simplexml_load_string($buf);
		if(!$root)
		{
			return;
		}
		foreach($this->keys as $k)
		{
			if(isset($root->{$k}))
			{
				$this->results[$k] = trim($root->{$k});
			}
			else
			{
				$this->results[$k] = '';
			}
		}
		if($this->options['blq_version'] == 4 && strlen($this->options['blq_link_prefix']))
		{
			foreach($this->results as $k => $fragment)
			{
				$this->results[$k] = preg_replace('!(\s+)href="/!', '\1href="' . $this->options['blq_link_prefix'] . '/', $fragment);
			}
		}
	}

	public function __get($name)
	{
		if($name == 'options')
		{
			return $this->options;
		}
		if($name == 'bools')
		{
			return $this->bools;
		}
		if($name == 'choices')
		{
			return $this->choices;
		}
		if($name == 'url')
		{
			return $this->url();
		}
		if($name == 'query')
		{
			return $this->query();
		}
		if(in_array($name, $this->keys))
		{
			return isset($this->results[$name]) ? $this->results[$name] : null;
		}
		if(isset($this->map[$name]))
		{
			$name = $this->map[$name];
		}
		if(isset($this->options[$name]))
		{
			return $this->options[$name];
		}
	}

	public function __set($name, $value)
	{
		if(in_array($name, $this->keys) || $name == 'options' ||
			$name == 'bools' || $name == 'choices' || $name == 'url')
		{
			trigger_error('Attempt to set read-only property ' . get_class($this) . '::$' . $name, E_USER_NOTICE);
			return;
		}
		if(isset($this->map[$name]))
		{
			$name = $this->map[$name];
			$this->options[$name] = $value;
			return;
		}
		if(array_key_exists($name, $this->options))
		{
			$this->options[$name] = $value;
			return;
		}
		$this->{$name} = $value;
	}
}