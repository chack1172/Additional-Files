<?php
/**
 * Additional Files
 * 
 * PHP Version 5
 * 
 * @category MyBB_18
 * @package  Additional_Files
 * @author   chack1172 <NBerardozzi@gmail.com>
 * @license  https://creativecommons.org/licenses/by-nc/4.0/ CC BY-NC 4.0
 * @link     http://www.chack1172.altervista.org/Projects/MyBB-18/Additional-Files.html
 */

if (!defined('IN_MYBB')) {
    die('This file cannot be accessed directly.');
}

@set_time_limit(0);

$page->add_breadcrumb_item($lang->additional_files, 'index.php?module=tools-additional_files');

$plugins->run_hooks('admin_tools_additional_files_begin');

if (!$mybb->input['action']) {
    $plugins->run_hooks('admin_tools_additional_files_check');
    
    if ($mybb->request_method == 'post') {
        if ($mybb->input['no']) {
            admin_redirect('index.php?module=tools-system_health');
        }
        
        $page->add_breadcrumb_item($lang->checking);
        
        $page->output_header($lang->additional_files.' - '.$lang->checking);
        
        $file = explode("\n", fetch_remote_file('https://mybb.com/checksums/release_mybb_{$mybb->version_code}.txt'));
        
		if (strstr($file[0], '<?xml') !== false || empty($file[0])) {
			$page->output_inline_error($lang->error_communication);
			$page->output_footer();
			exit;
		}
        
        $files = $additionals = array();
        foreach ($file as $line) {
            $parts = explode(' ', $line, 2);
			if (empty($parts[0]) || empty($parts[1])) {
				continue;
			}

			if (substr($parts[1], 0, 7) == './admin') {
				$parts[1] = './'.$mybb->config['admin_dir'].substr($parts[1], 7);
			}

			if (file_exists(MYBB_ROOT.'forums.php') && !file_exists(MYBB_ROOT.'portal.php')) {
				if (trim($parts[1]) == './index.php') {
					$parts[1] = './forums.php';
				} elseif ($parts[1] == './portal.php') {
					$parts[1] = './index.php';
				}
			}
            
            if (!in_array($parts[1], $files)) {
                folders($parts[1]);
                $files[] = trim($parts[1]);
            }
        }
        
        verify_additionals();
        
        $plugins->run_hooks('admin_tools_additional_files_check_commit_start');
        
        $table = new Table;
        $table->construct_header($lang->file, ['colspan' => 2]);
        
        foreach ($additionals as $file) {
            if (isset($modules['file'])) {
                $dir = str_replace('.', '', pathinfo($file['path'], PATHINFO_DIRNAME));
                $file['path'] = '<a href="index.php?module=file&directory='.$dir.'" title="'.$lang->additional_files_go.'">'.$file['path'].'</a>';
            }
            
            switch ($file['type']) {
                case 'dir':
                    $file['type'] = $lang->additional_files_dir;
                    break;
                case 'file':
                    $file['type'] = $lang->additional_files_file;
                    break;
            }
            
            $table->construct_cell($file['path']);
            $table->construct_cell($file['type']);
            $table->construct_row();
        }
        
        if ($table->num_rows() == 0) {
            $table->construct_cell($lang->no_additional_files, ['colspan' => 2]);
            $table->construct_row();
        }
        
        $table->output($lang->additional_files);
        
        $page->output_footer();
        exit;
    }
    
    $page->output_confirm_action('index.php?module=tools-additional_files', $lang->additional_files_confirm.'<br/><small>'.$lang->additional_files_confirm_small.'</small>', $lang->additional_files);
}

function folders($path)
{
    global $files;
    if (!empty($path) && $path != '.') {
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        if (!empty($dir) && $dir != '.' && !in_array($dir, $files)) {
            folders($dir);
            $files[] = $dir;
        }
    }
}

function verify_additionals($path=MYBB_ROOT)
{
	global $files, $additionals;

	$ignore = ['.', '..'];

	if (substr($path, -1, 1) == '/') {
		$path = substr($path, 0, -1);
	}
    
	if (@is_dir($path) && !@is_link($path)) {
		if ($dh = @opendir($path)) {
			while (($file = @readdir($dh)) !== false) {
				if (in_array($file, $ignore)) {
					continue;
				}

				$file_path = '.'.str_replace(substr(MYBB_ROOT, 0, -1), '', $path).'/'.$file;
                $filename = $path."/".$file;
                
				if (is_dir($filename)) {
                    if (in_array($file_path, $files)) {
				        verify_additionals($filename);
                        continue;
                    } else {
                        $additionals[] = [
                            'path' => $file_path,
                            'type' => 'dir',
                        ];
                    }
				} elseif (!in_array($file_path, $files)) {
					$additionals[] = [
                        'path' => $file_path,
                        'type' => 'file',
                    ];
				}
			}
            @closedir($dh);
		}
	}
}
