<?php

return <<<EOD

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en"
>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width"> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <meta name="x-apple-disable-message-reformatting"> 
  <link rel="shortcut icon" type='image/png' href="%favicon">
	<title></title> 
	<style>
		html,
		body {
				margin: 0 auto !important;
				padding: 0 !important;
				height: 100% !important;
				width: 100% !important;
				background: #f1f1f1;
				font-family: Arial, Helvetica, sans-serif !important;
		}

		/* What it does: Stops email clients resizing small text. */
		* {
				-ms-text-size-adjust: 100%;
				-webkit-text-size-adjust: 100%;
		}

		/* What it does: Centers email on Android 4.4 */
		div[style*="margin: 16px 0"] {
				margin: 0 !important;
		}

		/* What it does: Stops Outlook from adding extra spacing to tables. */
		table,
		td {
				mso-table-lspace: 0pt !important;
				mso-table-rspace: 0pt !important;
		}

		/* What it does: Fixes webkit padding issue. */
		table {
				border-spacing: 0 !important;
				border-collapse: collapse !important;
				table-layout: fixed !important;
				margin: 0 auto !important;
		}

		/* What it does: Uses a better rendering method when resizing images in IE. */
		img {
				-ms-interpolation-mode:bicubic;
		}

		/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
		a {
				text-decoration: none;
		}

		/* What it does: A work-around for email clients meddling in triggered links. */
		*[x-apple-data-detectors],  /* iOS */
		.unstyle-auto-detected-links *,
		.aBn {
				border-bottom: 0 !important;
				cursor: default !important;
				color: inherit !important;
				text-decoration: none !important;
				font-size: inherit !important;
				font-family: inherit !important;
				font-weight: inherit !important;
				line-height: inherit !important;
		}

		/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
		.a6S {
				display: none !important;
				opacity: 0.01 !important;
		}

		/* What it does: Prevents Gmail from changing the text color in conversation threads. */
		.im {
				color: inherit !important;
		}

		/* If the above doesn't work, add a .g-img class to any image in question. */
		img.g-img + div {
				display: none !important;
		}

		/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
		/* Create one of these media queries for each additional viewport size you'd like to fix */

		/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
		@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
				u ~ div .email-container {
						min-width: 320px !important;
				}
		}
		/* iPhone 6, 6S, 7, 8, and X */
		@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
				u ~ div .email-container {
						min-width: 375px !important;
				}
		}
		/* iPhone 6+, 7+, and 8+ */
		@media only screen and (min-device-width: 414px) {
				u ~ div .email-container {
						min-width: 414px !important;
				}
		}
		.primary{
			background: #f3a333;
		}

		.bg_primary{
			background: %primary !important;
		}

		.bg_secondary{
			background: %secondary;
		}

		.color_primary{
			color: %primary;
		}

		.color_gray{
			color: #808080 !important;
		}

		.bg_white{
			background: #ffffff;
		}

		.bg_light{
			background: #fafafa;
		}

		.bg_black{
			background: #000000;
		}

		.bg_dark{
			background: rgba(0,0,0,.8);
		}

		.email-section{
			padding:2.5em;
		}

		/*BUTTON*/
		.btn{
			padding: 10px 15px;
		}

		.btn.btn-primary{
			border-radius: 0px;
			background: #f3a333;
			color: #ffffff;
		}

		.btn-primary:hover{
			background: %secondary;
		}

		h1,h2,h3,h4,h5,h6{
			color: #000000;
			margin-top: 0;
		}

		body{
			font-weight: 400;
			font-size: 15px;
			line-height: 1.8;
			color: rgba(0,0,0,.4);
		}

		a{
			color: #f3a333;
		}

		table{
		}

		/*LOGO*/

		.logo h1{
			margin: 0;
		}

		.logo h1 a{
			color: #000;
			font-size: 20px;
			font-weight: 700;
			text-transform: uppercase;
			font-family: 'Montserrat', sans-serif;
		}

		/*HERO*/

		.hero{
			position: relative;
		}

		.hero img{

		}

		.hero .text{
			color: #fdfdfd;
			background: rgba(0,0,0, 0.3)
		}

		.hero .text h2{
			color: #fdfdfd;
			font-size: 30px;
			margin-bottom: 0;
		}

		/*HEADING SECTION*/

		.heading-section{
		}

		.heading-section h2{
			color: #000000;
			font-size: 28px;
			margin-top: 0;
			line-height: 1.4;
		}

		.heading-section .subheading{
			margin-bottom: 20px !important;
			display: inline-block;
			font-size: 13px;
			text-transform: uppercase;
			letter-spacing: 2px;
			color: rgba(0,0,0,.4);
			position: relative;
		}

		.heading-section .subheading::after{
			position: absolute;
			left: 0;
			right: 0;
			bottom: -10px;
			content: '';
			width: 100%;
			height: 2px;
			background: %primary;
			margin: 0 auto;
		}

		.heading-section-white{
			color: rgba(255,255,255,.8);
		}

		.heading-section-white h2{
			font-size: 28px;
			line-height: 1;
			padding-bottom: 0;
		}

		.heading-section-white h2{
			color: #ffffff;
		}

		.heading-section-white .subheading{
			margin-bottom: 0;
			display: inline-block;
			font-size: 13px;
			text-transform: uppercase;
			letter-spacing: 2px;
			color: rgba(255,255,255,.4);
		}

		.icon{
			text-align: center;
		}

		/*FOOTER*/

		.footer{
			color: #fdfdfd;
			padding-top: 5px;
    	padding-bottom: 5px;
		}

		.footer .heading{
			color: #ffffff;
			font-size: 20px;
		}

		.footer ul{

			margin: 0;
			padding: 0;
		}

		.footer ul li{
			list-style: none;
			margin-bottom: 10px;
		}

		.footer ul li a{
			color: rgba(255,255,255,1);
		}

		@media screen and (max-width: 500px) {
			.icon{
				text-align: left;
			}
			.text-services{
				padding-left: 0;
				padding-right: 20px;
				text-align: left;
			}
		}
	</style>
</head>
<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;">
	<center style="width: 100%; background-color: #f1f1f1;">
		<div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
		‌	&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;
		</div>
		<div style="max-width: 600px; margin: 0 auto;" class="email-container">
			<table role="presentation" style="margin: auto;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
			<tbody>
				<tr>
					<td class="bg_white logo" style="padding: 1em 2.5em; text-align: center">
						<img src="%logo_url" alt="%enterprise_name" width="200">
					</td>
				</tr>
				<tr>
					<td class="hero" style="background-image: url(%img_url); background-size: cover; height: 400px;" valign="middle">
						<table>
							<tbody>
								<tr>
									<td>
										<div class="text" style="padding: 0 3em; text-align: center;">
											<h2>Ha recibido un mensaje del sitio web</h2>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td class="bg_white">
						<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
							<tbody>
								<tr>
									<td class="bg_white email-section" style="">
										<div class="heading-section heading-section-white">
											<span class="subheading color_gray"></span>
											<h2 class="color_gray">Datos del Mensaje</h2>
											<p class="color_gray">Nombre y Apellido</p>
											<p class="color_gray">%name</p>
											<p class="color_gray">Correo</p>
											<p class="color_gray">%email</p>
											<p class="color_gray">Teléfono</p>
											<p class="color_gray">%phone</p>
											<p class="color_gray">Consulta</p>
											<p class="color_gray">%comment</p>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>

			<table role="presentation" style="margin: auto;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
				<tbody>
					<tr>
				<td class="bg_primary footer email-section" valign="middle">
				<table>
				<tbody><tr>
				<td style="padding-top: 20px;" width="33.333%" valign="top">
				<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody><tr>
				<td style="text-align: left; padding-right: 10px;">
				<h3 class="heading">%enterprise_name</h3>
				<p style="color:#FFF">%about</p>
				</td>
				</tr>
				</tbody></table>
				</td>
				<td style="padding-top: 20px;" width="33.333%" valign="top">
				<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody><tr>
				<td style="text-align: left; padding-left: 5px; padding-right: 5px;">
				<h3 class="heading">Contacto</h3>
				<ul>
				<li><span class="text" style="color:#fdfdfd;">%adress<br>
					%email</span></li>
				<li><span class="text" style="color:#fdfdfd">T %phone</span></li>
				</ul>
				</td>
				</tr>
				</tbody></table>
				</td>
				<td style="padding-top: 20px;" width="33.333%" valign="top">
				<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody><tr>
				<td style="text-align: left; padding-left: 10px;">
				<h3 class="heading">Enlaces</h3>
				<ul>
					<li><a href="%base_url">Home</a></li>
					<li><a href="%base_urlnosotros">Nostros</a></li>
					<li><a href="%base_urlcapacitaciones">Capacitaciones</a></li>
					<li><a href="%base_urlponentes">Ponentes</a></li>
				</ul>
				</td>
				</tr>
				</tbody></table>
				</td>
				</tr>
				</tbody></table>
				</td>
				</tr>
				<tr>
				<td class="bg_secondary footer email-section" valign="middle">
				<table>
				<tbody><tr>
				<td width="33.333%" valign="top">
				<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody><tr>
				<td style="text-align: left; padding-right: 10px;">
				<p style="color:#fdfdfd">© %year %enterprise_name - Derechos Reservados</p>
				</td>
				</tr>
				</tbody></table>
				</td>
				<td width="33.333%" valign="top">
				<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody><tr>
				<td style="text-align: right; padding-left: 5px; padding-right: 5px;">
				<p><a href="http://softweb.pe/website/" style="color: #fdfdfd;">Sitio Desarollado por Software Web Perú ©</a></p>
				</td>
				</tr>
				</tbody></table>
				</td>
				</tr>
				</tbody></table>
				</td>
				</tr>
				</tbody>
			</table>
		</div>
	</center>
	<script type="text/javascript">
	</script>
</body>
</html>

EOD;
