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

    <div class="main-container" style="min-height:90%;">
        nouvelles entités
    </div>

    <div class="footer-wrap pd-20 mb-20 card-box">
        @include('includes/footer')
    </div>

	@include('includes/js_assets')

    <script type="text/javascript">
        $( document ).ready(function() {
            $("#linkNE").addClass("active");
            $("#linkNE").closest(".dropdown").addClass("show");
            $("#linkNE").closest(".submenu").css("display", 'block');
        });
    </script>
</body>
</html>
