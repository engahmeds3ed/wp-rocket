<?php
return [
	[
		// Scripts are commented in HTML comments = ignored.
		'<html>
			<head>
				<title>Page title</title>
				<link rel="stylesheet" href="http://example.org/wp-content/themes/twentytwenty/style.css?ver=1.0">
				<link rel="stylesheet" href="http://example.org/wp-content/plugins/hello-dolly/style.css?ver=3.5">
				<!-- <script src="http://example.org/wp-includes/js/jquery/jquery.js?ver=5.3"></script> -->
			</head>
			<body>
            <!-- <script src="http://example.org/wp-content/plugins/hello-dolly/script.js?ver=3.5"></script> -->
			</body>
		</html>',
		'<html>
			<head>
				<title>Page title</title>
				<link rel="stylesheet" href="http://example.org/wp-content/themes/twentytwenty/style.css?ver=1.0">
				<link rel="stylesheet" href="http://example.org/wp-content/plugins/hello-dolly/style.css?ver=3.5">
				<!-- <script src="http://example.org/wp-includes/js/jquery/jquery.js?ver=5.3"></script> -->
			</head>
			<body>
            <!-- <script src="http://example.org/wp-content/plugins/hello-dolly/script.js?ver=3.5"></script> -->
			</body>
		</html>',
	],
	[
		// Default domain, JS files are cached busted. Files with the WordPress version in the query get the ?ver= removed.
		'<html>
			<head>
				<title>Page title</title>
				<link rel="stylesheet" href="http://example.org/wp-includes/css/dashicons.min.css?ver=5.3">
				<link rel="stylesheet" href="http://example.org/wp-content/themes/twentytwenty/style.css?ver=1.0">
				<link rel="stylesheet" href="http://example.org/wp-content/plugins/hello-dolly/style.css?ver=3.5">
				<link rel="stylesheet" href="https://google.com/external.css?v=20200306">
				<script src="http://example.org/wp-includes/js/jquery/jquery.js?ver=5.3"></script>
				<script src="http://example.org/wp-content/themes/twentytwenty/assets/script.js?ver=1.0"></script>
			</head>
			<body>
                <script src="http://example.org/wp-content/plugins/hello-dolly/script.js?ver=3.5"></script>
                <script src="https://maps.google.com/map.js"></script>
			</body>
		</html>',
		'<html>
			<head>
				<title>Page title</title>
				<link rel="stylesheet" href="http://example.org/wp-includes/css/dashicons.min.css?ver=5.3">
				<link rel="stylesheet" href="http://example.org/wp-content/themes/twentytwenty/style.css?ver=1.0">
				<link rel="stylesheet" href="http://example.org/wp-content/plugins/hello-dolly/style.css?ver=3.5">
				<link rel="stylesheet" href="https://google.com/external.css?v=20200306">
				<script src="http://example.org/wp-includes/js/jquery/jquery.js"></script>
				<script src="http://example.org/wp-content/cache/busting/1/wp-content/themes/twentytwenty/assets/script-1.0.js"></script>
			</head>
			<body>
                <script src="http://example.org/wp-content/cache/busting/1/wp-content/plugins/hello-dolly/script-3.5.js"></script>
                <script src="https://maps.google.com/map.js"></script>
			</body>
		</html>',
	],
];
