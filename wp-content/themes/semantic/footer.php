		<footer class="ui inverted segment" style="border-radius:0px; margin-bottom: 0px !important; z-index:10"><br>
			<div class="ui container">
				<div class="ui stackable grid">
					<div class="middle aligned row">
						<div class="ui three wide column">
							<img src="<?php bloginfo('stylesheet_directory'); ?>/img/logo.png" class="ui tiny image"/>
						</div>
						<div class="ui seven wide column">
							<p style="color: #FFF !important;"><a style="color: #FFF !important;" href="/legal-notice/" target="_parent">Aviso Legal</a> · Todos los derechos reservados <br>© TU COMPANÍA - <?php echo date("Y");?></p>
						</div>
						<div class="ui six wide right aligned column">
							<p>
								<a href="https://www.facebook.com/company/" target="_blank"><i class="circular blue inverted facebook icon"></i></a>
								<a href="https://www.instagram.com/company/" target="_blank"><i class="circular inverted pink instagram icon"></i></a>
								<a href="https://wa.link/XXXXXX" target="_blank"><i class="circular inverted green whatsapp icon"></i></a>
								<a href="<?php echo site_url();?>/rss" target="_blank"><i class="circular inverted red rss icon"></i></a>
							</p>
							<p><?php echo get_option( 'woocommerce_store_address', '' );?><br>
                                <?php echo get_option( 'woocommerce_store_city', '' );?> <?php echo explode( ":",get_option( 'woocommerce_default_country', '' ))[0];?><br>
							    <a href="tel:+593996393939"><i class="inverted phone icon"></i> +593 99 888 999</a><br>
							    <a href="mailto:fotoyvinilosuio@gmail.com"><i class="inverted mail icon"></i>example@yourcompany.com</a>
                            </p>
						</div>

					</div>
				</div><br>
			</div>
		</footer>

		<?php wp_footer();?>
	</body>
</html>
