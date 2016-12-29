# [Additional Files](http://www.chack1172.altervista.org/Projects/MyBB-18/Additional-Files.html)
Category: [MyBB 1.8](http://www.chack1172.altervista.org/Projects/MyBB-18/)
Author: [chack1172](http://www.chack1172.altervista.org/?language=english)

Additional Files is a plugin for MyBB 1.8.* that adds a new section in the AdminCP that checks for additional files and folders in the board directory.

### Installation
1. Upload contents of the folder Upload to your board directory
2. Go to `ACP > Plugins > Activate 'Additional Files'` 

### Compatibility
This plugin is by default compatible with [File Manager](http://www.chack1172.altervista.org/Projects/MyBB-18/File-Manager.html).
If you have it, a link will be added that will redirect you to the parent directory of the file/folder.

### Hooks
This plugin has 3 hooks.
<table>
<tbody>
    <tr>
        <td colspan="3"><strong>File:</strong> admin/modules/tools/additional_files.php</td>
    </tr>
    <tr>
        <td>Hook</td>
        <td>Params</td>
        <td>Line</td>
    </tr>
    <tr>
        <td>admin_tools_additional_files_begin</td>
        <td></td>
        <td>22</td>
    </tr>
    <tr>
        <td>admin_tools_additional_files_check</td>
        <td></td>
        <td>25</td>
    </tr>
    <tr>
        <td>admin_tools_additional_files_check_commit_start</td>
        <td></td>
        <td>71</td>
    </tr>
</tbody>
</table>
