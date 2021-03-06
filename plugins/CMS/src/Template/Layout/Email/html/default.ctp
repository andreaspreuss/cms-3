<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @since    2.0.0
 * @author   Christopher Castro <chris@quickapps.es>
 * @link     http://www.quickappscms.org
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */

/**
 * Default layout for sending HTML-format emails.
 *
 * @author Christopher Castro <chris@quickapps.es>
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
	<head>
		<title><?= $this->fetch('title'); ?></title>
	</head>
	<body>
		<?= $this->fetch('content'); ?>
		<p><?= __d('cms', 'This email was sent using the QuickAppsCMS, http://quickappscms.org.'); ?></p>
	</body>
</html>