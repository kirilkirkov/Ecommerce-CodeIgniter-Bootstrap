<?php
declare(strict_types=1);

// Standalone installer (no CodeIgniter bootstrap)

function h(string $v): string {
	return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

function basePath(): string {
	$scriptName = isset($_SERVER['SCRIPT_NAME']) ? (string)$_SERVER['SCRIPT_NAME'] : '/installation.php';
	$dir = str_replace('\\', '/', dirname($scriptName));
	$dir = rtrim($dir, '/');
	return ($dir === '' ? '' : $dir);
}

function appHomeUrl(): string {
	$bp = basePath();
	return ($bp === '' ? '/' : $bp.'/');
}

function parseDbConfigText(string $configText): array {
	$out = [
		'hostname' => '',
		'username' => '',
		'password' => '',
		'database' => '',
	];

	foreach (array_keys($out) as $key) {
		if (preg_match("/'".$key."'\\s*=>\\s*'((?:\\\\\\\\'|[^'])*)'/", $configText, $m)) {
			$out[$key] = stripcslashes($m[1]);
		}
	}

	return $out;
}

function phpSingleQuoteEscape(string $v): string {
	// Escapes for PHP single-quoted strings.
	return str_replace(["\\", "'"], ["\\\\", "\\'"], $v);
}

function updateDatabaseConfigFile(string $path, array $values, string &$error): bool {
	$configText = @file_get_contents($path);
	if (!is_string($configText)) {
		$error = "Can't read database config at: ".$path;
		return false;
	}

	$replacements = [
		'hostname' => $values['hostname'] ?? '',
		'username' => $values['username'] ?? '',
		'password' => $values['password'] ?? '',
		'database' => $values['database'] ?? '',
	];

	$counts = [
		'hostname' => 0,
		'username' => 0,
		'password' => 0,
		'database' => 0,
	];

	foreach ($replacements as $key => $val) {
		$escaped = phpSingleQuoteEscape((string)$val);
		$pattern = "/('".$key."'\\s*=>\\s*)'((?:\\\\\\\\'|[^'])*)'/";
		$configText = preg_replace($pattern, "$1'".$escaped."'", $configText, 1, $counts[$key]);
		if (!is_string($configText)) {
			$error = "Failed to update '".$key."' in database config (regex error).";
			return false;
		}
	}

	foreach ($counts as $key => $c) {
		if ($c !== 1) {
			$error = "Couldn't update '".$key."' in database config (matched ".$c." times).";
			return false;
		}
	}

	$tmp = $path.'.tmp';
	$bytes = @file_put_contents($tmp, $configText, LOCK_EX);
	if ($bytes === false) {
		$error = "Can't write temp database config at: ".$tmp;
		return false;
	}
	if (!@rename($tmp, $path)) {
		@unlink($tmp);
		$error = "Can't replace database config at: ".$path;
		return false;
	}

	return true;
}

function splitSqlStatements(string $sql): array {
	$statements = [];
	$buf = '';

	$inSingle = false;
	$inDouble = false;
	$inBacktick = false;
	$inLineComment = false;
	$inBlockComment = false;

	$len = strlen($sql);
	for ($i = 0; $i < $len; $i++) {
		$ch = $sql[$i];
		$next = ($i + 1 < $len) ? $sql[$i + 1] : "\0";

		if ($inLineComment) {
			$buf .= $ch;
			if ($ch === "\n") {
				$inLineComment = false;
			}
			continue;
		}

		if ($inBlockComment) {
			$buf .= $ch;
			if ($ch === '*' && $next === '/') {
				$buf .= $next;
				$i++;
				$inBlockComment = false;
			}
			continue;
		}

		// Start of comments (only when not inside quotes)
		if (!$inSingle && !$inDouble && !$inBacktick) {
			if ($ch === '-' && $next === '-') {
				// MySQL treats '-- ' as a comment; accept it broadly here.
				$inLineComment = true;
				$buf .= $ch;
				continue;
			}
			if ($ch === '#') {
				$inLineComment = true;
				$buf .= $ch;
				continue;
			}
			if ($ch === '/' && $next === '*') {
				$inBlockComment = true;
				$buf .= $ch;
				continue;
			}
		}

		// Quote state machine
		if ($ch === "'" && !$inDouble && !$inBacktick) {
			// Toggle unless escaped
			$escaped = ($i > 0 && $sql[$i - 1] === '\\');
			if (!$escaped) {
				$inSingle = !$inSingle;
			}
			$buf .= $ch;
			continue;
		}
		if ($ch === '"' && !$inSingle && !$inBacktick) {
			$escaped = ($i > 0 && $sql[$i - 1] === '\\');
			if (!$escaped) {
				$inDouble = !$inDouble;
			}
			$buf .= $ch;
			continue;
		}
		if ($ch === '`' && !$inSingle && !$inDouble) {
			$inBacktick = !$inBacktick;
			$buf .= $ch;
			continue;
		}

		// Statement boundary
		if ($ch === ';' && !$inSingle && !$inDouble && !$inBacktick) {
			$trimmed = trim($buf);
			if ($trimmed !== '') {
				$statements[] = $trimmed;
			}
			$buf = '';
			continue;
		}

		$buf .= $ch;
	}

	$trimmed = trim($buf);
	if ($trimmed !== '') {
		$statements[] = $trimmed;
	}

	return $statements;
}

$root = __DIR__;
$lockPath = $root.'/application/config/installed.lock';
$dbConfigPath = $root.'/application/config/database.php';
$sqlPath = $root.'/database.sql';

$messages = [];
$errors = [];

$prefill = [
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => '',
];

if (is_file($dbConfigPath)) {
	$text = @file_get_contents($dbConfigPath);
	if (is_string($text)) {
		$prefill = array_merge($prefill, parseDbConfigText($text));
	}
}

if (is_file($lockPath)) {
	$messages[] = 'Already installed (lock file exists).';
}

$method = isset($_SERVER['REQUEST_METHOD']) ? strtoupper((string)$_SERVER['REQUEST_METHOD']) : 'GET';

if ($method === 'POST' && !is_file($lockPath)) {
	$hostname = isset($_POST['hostname']) ? trim((string)$_POST['hostname']) : '';
	$username = isset($_POST['username']) ? trim((string)$_POST['username']) : '';
	$password = isset($_POST['password']) ? (string)$_POST['password'] : '';
	$database = isset($_POST['database']) ? trim((string)$_POST['database']) : '';

	$prefill = [
		'hostname' => $hostname,
		'username' => $username,
		'password' => $password,
		'database' => $database,
	];

	if ($hostname === '' || $username === '' || $database === '') {
		$errors[] = 'Hostname, username and database are required.';
	} elseif (!extension_loaded('mysqli')) {
		$errors[] = 'PHP extension mysqli is not enabled.';
	} elseif (!is_file($sqlPath)) {
		$errors[] = "Missing database.sql at: ".$sqlPath;
	} elseif (!is_writable($dbConfigPath)) {
		$errors[] = "database.php is not writable: ".$dbConfigPath." (fix permissions and retry)";
	} else {
		mysqli_report(MYSQLI_REPORT_OFF);
		$mysqli = @mysqli_connect($hostname, $username, $password);
		if (!$mysqli) {
			$errors[] = 'DB connect failed: '.mysqli_connect_error();
		} else {
			@mysqli_set_charset($mysqli, 'utf8');

			// Create/select DB (allow any name by quoting as identifier)
			$dbIdent = str_replace('`', '``', $database);
			if (!@mysqli_query($mysqli, "CREATE DATABASE IF NOT EXISTS `".$dbIdent."` CHARACTER SET utf8 COLLATE utf8_general_ci")) {
				// Not fatal; maybe insufficient privileges
				$errors[] = 'Could not create database (maybe no privileges): '.mysqli_error($mysqli);
			}
			if (!@mysqli_select_db($mysqli, $database)) {
				$errors[] = 'Could not select database "'.$database.'": '.mysqli_error($mysqli);
			} else {
				// Write config first (so the app can use the credentials even if import has warnings)
				$cfgErr = '';
				if (!updateDatabaseConfigFile($dbConfigPath, $prefill, $cfgErr)) {
					$errors[] = $cfgErr;
				} else {
					$sql = @file_get_contents($sqlPath);
					if (!is_string($sql)) {
						$errors[] = "Can't read database.sql at: ".$sqlPath;
					} else {
						if (stripos($sql, 'DELIMITER ') !== false) {
							$errors[] = 'database.sql contains DELIMITER statements. This installer supports only simple SQL dumps without custom delimiters.';
						} else {
							$statements = splitSqlStatements($sql);
							$importErrors = [];

							foreach ($statements as $idx => $stmt) {
								if (!@mysqli_query($mysqli, $stmt)) {
									$importErrors[] = [
										'i' => $idx + 1,
										'errno' => mysqli_errno($mysqli),
										'error' => mysqli_error($mysqli),
										'sql' => (strlen($stmt) > 400 ? substr($stmt, 0, 400).'…' : $stmt),
									];
								}
							}

							// Verify schema presence
							$installed = false;
							$res = @mysqli_query($mysqli, "SHOW TABLES LIKE 'active_pages'");
							if ($res && @mysqli_num_rows($res) > 0) {
								$installed = true;
							}
							if ($res) {
								@mysqli_free_result($res);
							}

							if (!$installed) {
								$errors[] = 'Import finished, but schema check failed (table active_pages not found).';
							} else {
								// Create lock file and continue even with warnings
								if (@file_put_contents($lockPath, "installed_at=".date('c')."\n", LOCK_EX) === false) {
									$errors[] = "Couldn't create lock file at: ".$lockPath;
								} else {
									$messages[] = 'Installed successfully.';
									if (!empty($importErrors)) {
										$messages[] = 'Installed with warnings (some SQL statements failed).';
										// Show up to 20 errors to keep page usable
										$max = min(20, count($importErrors));
										for ($i = 0; $i < $max; $i++) {
											$e = $importErrors[$i];
											$errors[] = 'SQL #'.$e['i'].' (errno '.$e['errno'].'): '.$e['error'].' | '.$e['sql'];
										}
										if (count($importErrors) > $max) {
											$errors[] = '... and '.(count($importErrors) - $max).' more SQL errors.';
										}
									}

									// Redirect only if there were no hard errors after install
									if (empty($errors)) {
										header('Location: '.appHomeUrl());
										exit;
									}
								}
							}
						}
					}
				}
			}

			@mysqli_close($mysqli);
		}
	}
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Installation</title>
	<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen bg-gray-50">
	<div class="mx-auto max-w-lg px-4 py-10">
		<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
			<div class="mb-6">
				<h1 class="text-2xl font-semibold text-gray-900">Install</h1>
				<p class="mt-1 text-sm text-gray-600">Enter your MySQL database credentials, then click Install.</p>
			</div>

			<?php if (!empty($messages)): ?>
				<div class="mb-4 space-y-2">
					<?php foreach ($messages as $m): ?>
						<div class="rounded-lg bg-green-50 px-3 py-2 text-sm text-green-800 ring-1 ring-green-200"><?php echo h($m); ?></div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if (!empty($errors)): ?>
				<div class="mb-4 space-y-2">
					<?php foreach ($errors as $e): ?>
						<div class="rounded-lg bg-red-50 px-3 py-2 text-sm text-red-800 ring-1 ring-red-200 break-words"><?php echo h($e); ?></div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if (is_file($lockPath)): ?>
				<a class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800" href="<?php echo h(appHomeUrl()); ?>">Go to homepage</a>
			<?php else: ?>
				<form method="post" class="space-y-4">
					<div>
						<label class="block text-sm font-medium text-gray-700" for="hostname">Hostname</label>
						<input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" id="hostname" name="hostname" value="<?php echo h($prefill['hostname']); ?>" placeholder="localhost">
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-700" for="username">Username</label>
						<input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" id="username" name="username" value="<?php echo h($prefill['username']); ?>" placeholder="root">
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-700" for="password">Password</label>
						<input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" id="password" name="password" value="<?php echo h($prefill['password']); ?>" type="password" autocomplete="current-password" placeholder="">
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-700" for="database">Database</label>
						<input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" id="database" name="database" value="<?php echo h($prefill['database']); ?>" placeholder="shop">
					</div>

					<div class="pt-2">
						<button class="inline-flex w-full items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800" type="submit">Install</button>
					</div>

					<p class="text-xs text-gray-500">
						Note: this installer needs write access to <code class="rounded bg-gray-100 px-1 py-0.5">application/config/database.php</code>.
					</p>
				</form>
			<?php endif; ?>
		</div>
	</div>
</body>
</html>
