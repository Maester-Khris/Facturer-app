<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8">
		<title>Facturer-App</title>
        @include('includes/css_assets')
        <style>
            .center-foot{
                display:flex; 
                 flex-direction:row;
                 justify-content:center;
                 align-items:center;
             }
         </style>
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
        description de la société
    </div>

    <div class="footer-wrap pd-20 mb-20 card-box center-foot">
        @include('includes/footer')
    </div>

	@include('includes/js_assets')

    <script type="text/javascript">
        $( document ).ready(function() {
            $("#linkDS").addClass("active");
            $("#linkDS").closest(".dropdown").addClass("show");
            $("#linkDS").closest(".submenu").css("display", 'block');
        });
    </script>
</body>
</html>
