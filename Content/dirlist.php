<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             directory structure to list
| category:         directories
|
| last modified:    Mon, 14 Nov 2005 19:33:15 GMT
| downloaded:       Sat, 10 Feb 2007 07:55:51 GMT as copy from textarea
|
| code URL:
| http://phparadise.de/php-code/directories/directory-structure-to-list/
|
| description:
| this PHP function displays any given directory structure as recursive list. it
| even outputs nice HTML markup code with indenting.
| 
| Tweaked to emit comment for Master.com text crawler and to screen out various
| file extensions (jpg, gif, png, xml, css, php, etc.) 10 Feb 2007 -reb
| 
| Reworked printing code so that directory names aren't printed as links
|    13Feb2007 -reb
|
| Changed to allow it to be contained in a folder one level down.
|    Bob M. - 2/12/07 
------------------------------------------------------------------------------*/

function entab($num)
{
	return "\n".str_repeat("\t",$num);
}

function directory_to_list($dir,$onlydirs=FALSE,$sub=FALSE)
{
	$levels = explode('/',$dir);
	$subtab = (count($levels) > 2 ? count($levels)-2 : 0);
	$t = count($levels)+($sub !== false ? 1+$subtab : 0);
	$output = entab($t).'<ul>';
	$dirlist = opendir($dir);
	while ($file = readdir ($dirlist))
	{
		$fileparts = explode (".", $file);
		$extension = end($fileparts);
# Bob M. - 6/23/10 Changed to filter out files starting in "._";
		if ($file != '.' && $file != '..' && $file != '.DS_Store' && substr($file,0,2) != "._"
		&& stripos(".xml.gif.jpg.jpeg.png.js.bmp.php.css.zip", $extension) === FALSE)
		{
			$newpath = $dir.'/'.$file;
			$level = explode('/',$newpath);
			$tabs = count($level)+($sub !== false ? 1+$subtab : 0);
			
			// print the entry
			if (is_dir($newpath)) { // print directory name without URL
				$output .= entab($tabs).'<li>'. $file ;
									// recursively print subdirectory
				$output .= directory_to_list($newpath,$onlydirs,TRUE).entab($tabs);
				$output .= '</li>';		 // and close the <li>
			} elseif ($onlydirs == FALSE) { // or print filename with link
				$output .= entab($tabs).'<li><a href="'.$newpath.'">'.$file.'</a></li>';
			}
		}
	}
	closedir($dirlist); 
	$output .= entab($t).'</ul>';
	if($onlydirs == TRUE)
		$output = preg_replace('/\n([\t]+)<ul>\n([\t]+)<\/ul>\n([\t]+)/','',$output);
	return $output;
}

// demo of directory to list
echo "<html><head><title>List of files</title></head><body>\n"; // boilerplate to make a nice HTML file
echo "<!-- Master.com.content -->\n"; // to make master.com crawler happy -reb 

# Bob M. - 2/12/07 Changed to allow it to be contained in a folder one level down.
#echo directory_to_list('.');
echo directory_to_list('..');

echo "</body></html>";

// if you want to list directories only, use

//echo directory_to_list('.',TRUE);

?>

