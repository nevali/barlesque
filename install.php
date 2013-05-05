<?php

/*
 * Copyright 2012-2013 Mo McRoberts.
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

class BarlesqueModuleInstall extends ModuleInstaller
{
	public $coexists = true;
	
	public function writeAppConfig($file, $isSoleWebModule = false, $chosenSoleWebModule = null)
	{
		fwrite($file,
			   "if(defined('BARLESQUE_DEMO') && BARLESQUE_DEMO)\n" .
			   "{\n" .
			   "\t\$HTTP_ROUTES['demo'] = array('name' => 'barlesque', 'file' => 'demo.php', 'class' => 'BarlesqueDemo');\n" .
			   "}\n" .
			   "\n");   
	}
}
