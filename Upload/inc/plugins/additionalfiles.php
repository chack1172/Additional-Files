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

if (defined("IN_ADMINCP")) {
    $plugins->add_hook('admin_tools_menu', 'additionalfiles_menu');
    $plugins->add_hook('admin_tools_action_handler', 'additionalfiles_action_handler');
    $plugins->add_hook('admin_tools_permissions', 'additionalfiles_permissions');
    $plugins->add_hook('admin_config_plugins_deactivate_commit', 'additionalfiles_destroy');
}

function additionalfiles_info()
{
    global $lang, $mybb;
    $lang->load('tools_additional_files');
    
    $lang->additional_files_desc .= <<<EOT
<p>
    <a href="index.php?module=config-plugins&amp;action=deactivate&amp;uninstall=1&amp;destroy=1&amp;plugin=additionalfiles&amp;my_post_key={$mybb->post_code}" style="color: red; font-weight: bold">{$lang->additional_files_destroy}</a>
</p>
EOT;
    
    return [
        'name'          => $lang->additional_files,
        'description'   => $lang->additional_files_desc,
        'website'       => $lang->additional_files_url,
        'author'        => 'chack1172',
        'authorsite'    => $lang->additional_files_chack1172,
        'version'       => '1.1',
        'compatibility' => '18*',
        'codename'      => 'additionalfiles',
    ];
}

function additionalfiles_activate()
{
    
}

function additionalfiles_deactivate()
{
    
}

function additionalfiles_files()
{
    return [
        'admin/modules/tools/additional_files.php',
        'inc/languages/english/admin/tools_additional_files.lang.php',
        'inc/languages/italiano/admin/tools_additional_files.lang.php',
        'inc/plugins/additionalfiles.php',
    ];
}

function additionalfiles_destroy()
{
    global $mybb, $lang, $message;
    
    if ($mybb->input['destroy'] == 1) {
        $lang->load('tools_additional_files');
        
        $files = additionalfiles_files();
        foreach ($files as $file) {
            if (empty($file) || is_dir(MYBB_ROOT.$file) || !file_exists(MYBB_ROOT.$file)) {
                continue;
            }
            
            @unlink(MYBB_ROOT.$file);
        }
        
        $message = $lang->additional_files_destroyed;
    }
}

function additionalfiles_menu(&$sub_menu)
{
    global $lang;
    $lang->load('tools_additional_files');
    $sub_menu[90] = [
        'id'    => 'additional_files',
        'title' => $lang->additional_files,
        'link'  => 'index.php?module=tools-additional_files',
    ];
}

function additionalfiles_action_handler(&$actions)
{
    $actions['additional_files'] = [
        'active' => 'additional_files',
        'file'   => 'additional_files.php',
    ];
}

function additionalfiles_permissions(&$admin_permissions)
{
    global $lang;
    $lang->load('tools_additional_files');
    $admin_permissions['additional_files'] = $lang->can_view_additional_files;
}
