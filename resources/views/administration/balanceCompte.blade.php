<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8">
		<title>Facturer-App</title>
        @include('includes/css_assets')
	</head>
<body>

	@include('includes/loader')

    <div class="header">
        @include('includes/header')
    </div>

    <div class="left-side-bar">
        @include('includes/sidebar')
    </div>

    <div class="main-container">
        balance compte
    </div>

    <div class="footer-wrap pd-20 mb-20 card-box">
        @include('includes/footer')
    </div>

	@include('includes/js_assets')

    <script type="text/javascript">
        $( document ).ready(function() {
            $("#linkBC").addClass("active");
            $("#linkBC").closest(".dropdown").addClass("show");
            $("#linkBC").closest(".submenu").css("display", 'block');
        });
    </script>
</body>
</html>
