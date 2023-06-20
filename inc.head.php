<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title><?php echo $app." - ".$title;?></title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="favicon-16.png" type="image/png" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-blue.css"/>
        <!-- EOF CSS INCLUDE -->
		<style type="text/css">
			.list-group-status.status-offline:after {
			  background: #E04B4A;
			}
			.form-control[disabled],.form-control[readonly],.form-control[readonly]:focus{
				background-color: #90b456;
				color: white;
			}
			.form-control[disabled]::placeholder,.form-control[readonly]::placeholder{
				color: #ccc;
			}
		
			.scroll-left {
				overflow: hidden;
				position: relative;
				color: black;
				height: 40px;
			}
			.scroll-left p {
				white-space: nowrap;
				font-size: 14px;
				position: absolute;
				width: 100%;
				height: 100%;
				margin: 0;
				line-height: 10px;
				text-align: center;
			 /* Starting position */
				transform:translateX(100%);
			 /* Apply animation to this element */
				animation: scroll-left 25s linear infinite;
			}
			/* Move it (define the animation) */
			@keyframes scroll-left {
				 0%   {
					transform: translateX(100%); 		
				 }
				 100% {
					transform: translateX(-100%); 
				 }
			}

		</style>
    </head>
    <body>
