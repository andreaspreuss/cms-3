<?php
	$this->set('channelData', [
		'title' => $this->fetch('title'),
		'link' => $this->Html->url('/', true),
		'description' => $this->fetch('description'),
		'language' => 'en-us'
	]);

	foreach ($nodes as $node) {
		$postTime = $node->created->format(__d('node', 'Y-m-d H:i a'));
		$bodyText = h(strip_tags($this->render($node)));
		$bodyText = $this->Text->truncate($bodyText, 400, [
			'ending' => '...',
			'exact' => true,
			'html' => true,
		]);

		echo $this->Rss->item([], [
			'title' => $node->title,
			'link' => $node->url,
			'guid' => ['url' => $node->url, 'isPermaLink' => 'true'],
			'description' => $bodyText,
			'pubDate' => $postTime,
		]);
	}