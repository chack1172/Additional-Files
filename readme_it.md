# [Additional Files](http://www.chack1172.altervista.org/Progetti/MyBB-18/File-Aggiuntivi.html)
Categoria: [MyBB 1.8](http://www.chack1172.altervista.org/Progetti/MyBB-18/)
Autore: [chack1172](http://www.chack1172.altervista.org/?language=italiano)

File Aggiuntivi è un plugin per MyBB 1.8.* che aggiunge una nuova sezione nel Pannello Amministrazione che controllerà i file e le cartelle aggiuntive nella cartella della tua board.

### Installation
1. Carica il contenenuto della cartella Upload nella cartella della tua board
2. Vai in `ACP > Plugins > Attiva 'File Aggiuntivi'` 

### Compatibility
Questo plugin è compatibile di default con il plugin [Gestore File](http://www.chack1172.altervista.org/Progetti/MyBB-18/Gestore-File.html).
Se lo hai verrà aggiunto un link che ti reindirizzerà alla cartella padre del file o della cartella.

### Hooks
Questo plugin ha 3 hook.
<table>
<tbody>
    <tr>
        <td colspan="3"><strong>File:</strong> admin/modules/tools/additional_files.php</td>
    </tr>
    <tr>
        <td>Hook</td>
        <td>Parametri</td>
        <td>Linea</td>
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
