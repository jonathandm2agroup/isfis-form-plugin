<p <?php echo get_block_wrapper_attributes(); ?>>
		<form method="POST" class='flex flex-col font-Poppins mx-3 my-4' id="form">
			<h3 class='text-3xl text-MidnightB text-center my-6 font-semibold'><?php echo $attributes['textName']?></h3>
			<?php echo $content?>
			<div class='flex flex-row items-center px-3 gap-1 my-4'>
				<input id="term" type="checkbox" class='rounded-md border border-MidnightB'/>
				<label for="term" class='!text-black'>
					<span class="text-black">Acepto los </span><?php if(isset($attributes['terminosLink'])): echo '<a class="!underline text-black hover:text-DeepB" href="'.$attributes['terminosLink'].'">terminos y condiciones</a>'; endif;?>
				</label>
			</div>
			<div class="g-recaptcha px-0 md:px-3 my-2" data-sitekey="<?php echo get_option('site_key_captcha')?>"></div>
			<input class='hover:cursor-pointer font-bold mx-auto rounded-md bg-MidnightB hover:bg-DeepB text-white px-2 py-3 text-lg disabled:bg-MidnightB disabled:text-white' value="<?php echo(__('Enviar'))?>" type='submit'/>
		</form>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<script>
			function onSubmit(token) {
				document.getElementById("form").submit();
			}
		</script>
		<?php 
			if(isset($_POST) && count($_POST) > 0 && $_SERVER['REQUEST_METHOD'] == 'POST'){
				// Obtener el valor del token reCAPTCHA desde el formulario
				$recaptcha_token = $_POST['g-recaptcha-response'];

				// Enviar una solicitud POST al servicio de validación de reCAPTCHA
				$url = 'https://www.google.com/recaptcha/api/siteverify';
				$data = array(
					'secret' => get_option('secret_key_captcha'),
					'response' => $recaptcha_token
				);
				$options = array(
					'http' => array(
						'header'  => 'Content-type: application/x-www-form-urlencoded',
						'method'  => 'POST',
						'content' => http_build_query($data)
					)
				);
				$context  = stream_context_create($options);
				$response = file_get_contents($url, false, $context);
				$result = json_decode($response, true);
				if($result['success']){
					$contentData = "";
				foreach($_POST as $label => $value){
					if($value !== ""){
						$texto = $label;
						$prefijo = '';
						if (strpos($texto, 'text-') === 0) {
							$prefijo = 'text-';
						} elseif (strpos($texto, 'email-') === 0) {
							$prefijo = 'email-';
						} elseif (strpos($texto, 'textArea-') === 0) {
							$prefijo = 'textArea-';
						}
						switch ($prefijo) {
							case 'text-':
								// Acción para prefijo 'text-'
								$dataForm = str_replace('text-', '', $label);
								$contentData .= '<!-- wp:create-block/isfis-text-input {"textName":"'.$dataForm.'","valueInput":"'.$value.'","placeholder":"text-input"} /-->';
								break;
							case 'email-':
								// Acción para prefijo 'email-'
								$dataForm = str_replace('email-', '', $label);
								$contentData .= '<!-- wp:create-block/isfis-email-input {"textName":"'.$label.'","valueInput":"'.$value.'","placeholder":"text-input"} /-->';
								break;
							case 'textArea-':
								// Acción para prefijo 'textArea-'
								$dataForm = str_replace('textArea-', '', $label);
								$contentData .= '<!-- wp:create-block/isfis-textarea {"textName":"'.$label.'","valueInput":"'.$value.'","placeholder":"text-input"} /-->';
								break;
							default:
								break;
						}
					}
				}	
				$post_data = array(
					'post_title' => 'Formulario de '.$attributes['textName'],
					'post_content' => $contentData,
					'post_status' => 'private',
					'post_type' => 'formulario',
				);
				$post_id = wp_insert_post( $post_data );
				if($post_id > 0){
					echo '<div class="mx-auto my-4 bg-green-400 font-bold border border-emerald-600 text-white text-center font-Poppins px-3 py-4">Información enviada correctamente.</div>';
					wp_set_object_terms($post_id, $attributes['parentTaxonomy'], 'tipo_formulario', true);
					if(isset($attributes['selectChildTaxonomy']) && $attributes['selectChildTaxonomy'] > 0){
						wp_set_object_terms($post_id, $attributes['selectChildTaxonomy'], 'tipo_formulario', true);
					}
					/* if(isset($attributes['redirect']) && $attributes['redirect'] && isset($attributes['redirectLink'])){
						echo"<script>window.location.href='".$attributes['redirectLink']."';</script>";
					} */
				}else{
					echo '<div class="mx-auto my-4 bg-red-400 font-bold border border-red-600 text-white text-center font-Poppins px-3 py-4">Ha ocurrido un error al enviar la información.</div>';
				}
				}
			}
		
		?>
</p>