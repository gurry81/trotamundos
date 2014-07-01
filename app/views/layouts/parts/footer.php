<footer>
	<div id="about-footer" class="footer-part">
		<div class="footer-title"><?php echo trans("messages.about-me") ?></div>
		<div class="footer-menu">
			<ul>
				<li> <a>Ismael Rojas López</a></li>
				<li> <a>IES Trassierra, Córdoba</a></li>
			</ul>
		</div>
	</div>	


	<div id="colaborators-footer" class="footer-part">
		<div class="footer-title"><?php echo trans("messages.collaborators")?></div>
		<div class="footer-menu">
			<ul>
				<li><img class="colaborator-logo" src="http://alangarciaoficial.appspot.com/images/tube.jpg"></li>
				<li><img class="colaborator-logo" src="http://www.vonpar.com.br/bebidas/Files/logos/powerade-g.png"></li>
				<li><img class="colaborator-logo" src="http://www.3qsports.co.uk/userfiles/images/adidas.png"></li>
				<li><img class="colaborator-logo" src="http://www.tribalzine.com/IMG/png/logo_uci-transparent.png"></li>
				<li><img class="colaborator-logo" src="http://www.alotrolado-mtb.com/wp-content/uploads/2012/09/specialized.png"></li>
				<li><img class="colaborator-logo" src="http://1.bp.blogspot.com/-0cWxIxK_bBY/Tz555QU_KLI/AAAAAAAAElI/2eohluaN9EI/s1600/kewledits.weebly+%2528119%2529.png"></li>
			</ul>
		</div>
	</div>	


	<div id="lang-footer" class="footer-part">
		<div class="footer-title"><?php echo trans("messages.langs")?></div>
		<div class="footer-menu">
			<ul>
				<li><a href="?locale=es<?php foreach (Input::except('locale') as $param => $value) {
					echo '&' . $param . '=' . $value;
				} ?>">Español</a></li>
				<li><a href="?locale=en<?php foreach (Input::except('locale') as $param => $value) {
					echo '&' . $param . '=' . $value;
				} ?>">English</a></li>
			</ul>
		</div>
	</div>
</footer>
