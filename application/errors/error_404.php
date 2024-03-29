<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Error 404</title>
		
		<style type="text/css">
			body{ margin:0; padding:0; background:#efefef; font-family:Georgia, Times, Verdana, Geneva, Arial, Helvetica, sans-serif; }
			div#mother{ margin:0 auto; width:943px; height:572px; position:relative; }
			div#errorBox{ background: url(/dating/content/img/bg-404.png) no-repeat top left; width:943px; height:572px; margin:auto; }
			div#errorText{ color:#39351e; padding:146px 0 0 446px }
			div#errorText p{ width:303px; font-size:14px; line-height:26px; }
			div.link{ /*background:#f90;*/ height:50px; width:145px; float:left; }
			div#home{ margin:20px 0 0 444px;}
			div#contact{ margin:20px 0 0 25px;}
			h1{ font-size:40px; margin-bottom:35px; }
		</style>
		
		<script src="jquery.js"></script>
		<script type="text/javascript">
			$(document).ready( function(){
				
				var bodyHeight 		= $(window).height();
				var contentHeight	= $("#mother").height();
				var newHeight;
				
				if ( bodyHeight < contentHeight ){
					var newHeight = contentHeight - bodyHeight;
									
				} else {
					var newHeight = bodyHeight - contentHeight;
	
				}
				newHeight = newHeight / 2; 
				
				$("body").css({marginTop:newHeight});
				
			});
		</script>
		
	</head>
	<body>
		<div id="mother">
			<div id="errorBox">
				<div id="errorText">
					<h1>D'oh!</h1>
					<p>
						Looks like something went completely wrong! But don't worry - it can happen to the best of us, <br />- and it just happened to you.
					</p>
					
					<p>
						Try one of these instead:
					</p>
				</div>
				<a href="/" title="Home...">
					<div class="link" id="home"></div>
				</a>
				<a href="/support/" title="Contact...">
					<div class="link" id="contact"></div>
				</a>
			</div>
		</div>
	</body>
</html>