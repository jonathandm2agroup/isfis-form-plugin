<p <?php echo get_block_wrapper_attributes(); ?>>
<?php $post_type = get_post_type(get_the_ID());?>
<?php if(isset($_COOKIE['formInfo'])){
		$responsePayment = $_REQUEST;
		$newContentPost = "<table class='my-4'><thead class='text-center text-3xl border border-gray-500'><th class='py-3'>Información de pago</th></thead><tbody class='flex flex-row border border-gray-500'>";
		if(isset($responsePayment['Estado']) && $responsePayment['Estado'] != 'Denegada'){
			$newContentPost .= hex2bin($_COOKIE['formInfo']);
			foreach($responsePayment as $response => $data){
				switch($response){
					case 'Oper':
						$newContentPost .= '<tr class="flex flex-col"><th class="text-center border border-gray-500">Cod REF</th><td class="text-center border border-gray-500">'.$data.'</td></tr>';
					break;
					case 'Usuario':
						$newContentPost .= '<tr class="flex flex-col "><th class="text-center border border-gray-500">Titular del pedido</th><td class="text-center border border-gray-500">'.$data.'</td></tr>';
					break;
					case 'Email':
						$newContentPost .= '<tr class="flex flex-col"><th class="text-center border border-gray-500">Correo Electrónico</th><td class="text-center border border-gray-500">'.$data.'</td></tr>';
					break;
					case 'Fecha':
						$newContentPost .= '<tr class="flex flex-col "><th class="text-center border border-gray-500">Fecha de compra</th><td class="text-center border border-gray-500">'.$data.'</td></tr>';
					break;
					case 'Hora':
						$newContentPost .= '<tr class="flex flex-col"><th class="text-center border border-gray-500">Hora de compra</th><td class="text-center border border-gray-500">'.$data.'</td></tr>';
					break;
				}
			}
			$newContentPost .= "</tbody></table>";
			$post_data = array(
				'post_title' => 'Formulario de '.$attributes['textName'],
				'post_content' => $newContentPost,
				'post_status' => 'private',
				'post_type' => 'formulario',
			);
			$post_id = wp_insert_post( $post_data );
			if($post_id > 0){
				echo '<div class="mx-auto my-4 bg-green-400 font-bold border border-emerald-600 text-white text-center font-Poppins px-3 py-4">Pago Completado e información enviada correctamente.</div>';
				wp_set_object_terms($post_id, $attributes['parentTaxonomy'], 'tipo_formulario', true);
				if(isset($attributes['selectChildTaxonomy']) && $attributes['selectChildTaxonomy'] > 0){
					wp_set_object_terms($post_id, $attributes['selectChildTaxonomy'], 'tipo_formulario', true);
				}
				setcookie( 'formInfo', "", time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
				unset($_COOKIE['formInfo']);
			}
			
		}else{
			if(isset($responsePayment['Razon'])){
				echo '<div class="mx-auto my-4 bg-red-400 font-bold border border-red-600 text-white text-center font-Poppins px-3 py-4">Su Pago ha presentado un problema.Razón: '.$responsePayment['Razon'].'.</div>';
				setcookie( 'formInfo', "", time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
				unset($_COOKIE['formInfo']);
			}else{
				echo '<div class="mx-auto my-4 bg-red-400 font-bold border border-red-600 text-white text-center font-Poppins px-3 py-4">No hemos recibido confirmación de su pago, intente nuevamente.</div>';
				setcookie( 'formInfo', "", time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
				unset($_COOKIE['formInfo']);
			}
		}
	}
?>

<?php
$url_actual = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
if($post_type == "formulario_de_matric" && !isset($_COOKIE['formInfo'])){
	
	$data = array(
		"CCLW" => get_option('pgf_cclw') ,
		"CMTN" => get_field('monto', get_the_ID()),
		"CDSC" => get_field('descripcion_compra', get_the_ID()),
		"RETURN_URL" => bin2hex($url_actual),
		"PF_CF" => '5B7B226964223A227472616D6974654964222C226E616D654F724C6162656C223A2249642064656C205472616D697465222C2276616C7565223A2254494432333435227D5D',
		"PARM_1" => '19816201',
		"EXPIRES_IN" => 3600,
	);
	$url = get_option('base_url_pgf').'LinkDeamon.cfm?' . http_build_query($data);
	
	$options = array(
		'http' => array(
			'method' => 'POST',
			'header' => 'Content-Type: application/x-www-form-urlencoded',
			'content' => http_build_query($data)
		)
	);
	
	$context = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	$decoded_result = json_decode($result, true);
}

?>
		<form method="POST" class='flex flex-col font-Poppins mx-3 my-4' id="form" enctype="multipart/form-data">
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
						} elseif (strpos($texto, 'file-') === 0){
							$prefijo = 'file-';
						}

						switch ($prefijo) {
							case 'text-':
								// Acción para prefijo 'text-'
								$dataForm = str_replace('text-', '', $label);
								$contentData .= '<p class="text-2xl">'.$dataForm.':</p><br><p class="text-base">'.$value.'</p>';
								break;
							case 'email-':
								// Acción para prefijo 'email-'
								$dataForm = str_replace('email-', '', $label);
								$contentData .= '<p class="text-2xl">'.$dataForm.':</p><br><p class="text-base">'.$value.'</p>';
								break;
							case 'textArea-':
								// Acción para prefijo 'textArea-'
								$dataForm = str_replace('textArea-', '', $label);
								$contentData .= '<p class="text-2xl">'.$dataForm.':</p><br><p class="text-base">'.$value.'</p>';
								break;
							case 'file-':
								break;
								default:
								break;
							}
						}
					}	
				/*Condicion para evaluar si está en el post pertece a el post de matrícula*/
					if($post_type == "formulario_de_matric" && $decoded_result['success'] && !isset($_COOKIE['formInfo'])){
						/*Redireccionar al link de pago*/
						setcookie( 'formInfo', bin2hex($contentData), time() + 3600, COOKIEPATH, COOKIE_DOMAIN );
						header('Location: '.$decoded_result['data']['url'].'');
						exit;
					}
				/* Condición para evaluar si hay un archivo en el formulario */
				if(isset($_FILES) && count($_FILES) > 0){
					foreach($_FILES as $file){
						$upload_dir = wp_upload_dir();
						$upload_path = $upload_dir['path'] . '/' . basename($file['name']);
						$upload_url = $upload_dir['url'] . '/' . basename($file['name']);
						move_uploaded_file($file['tmp_name'], $upload_path); // Mueve el archivo cargado a la carpeta de subidas de WordPress
						$file_info = wp_upload_bits($file['name'], null, file_get_contents($upload_path)); // Obtiene la URL y ruta del archivo cargado en la carpeta de subidas de WordPress
						$uploaded_file_url = $file_info['url'];
						$uploaded_file_path = $file_info['file'];
						
						$contentData .= '
						<!-- wp:file {"id":614,"href":"'.$uploaded_file_url.'","showDownloadButton":true,"displayPreview":false,"className":"","epAnimationGeneratedClass":"edplus_anim-rwrAET","epGeneratedClass":"eplus-wrapper"} -->
						<div class=" wp-block-file eplus-wrapper"><a href="'.$uploaded_file_url.'">'.$file['name'].'</a><a href="'.$uploaded_file_url.'" class="wp-block-file__button wp-element-button" download>'.__('Descargar').'</a></div>
						<!-- /wp:file -->
						';

						var_dump($file_info);

						if ($file_info['error']) {
							// Si hay un error, mostrar el mensaje de error
							echo "Error al subir el archivo: " . $file_info['error'];
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