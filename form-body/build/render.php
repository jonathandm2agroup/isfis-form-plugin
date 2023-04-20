<p <?php echo get_block_wrapper_attributes(); ?>>
		<form method="POST" class='flex flex-col font-Poppins mx-3 my-4'>
			<h3 class='text-3xl text-MidnightB text-center my-6 font-semibold'><?php echo $attributes['textName']?></h3>
			<?php echo $content?>
			<input class='mx-auto rounded-md bg-MidnightB hover:bg-DeepB text-white px-2 py-3 text-lg disabled:bg-MidnightB disabled:text-white' value="<?php echo(__('Enviar'))?>" type='submit'/>
		</form>
		<?php 
			if(isset($_POST) && count($_POST) > 0 && $_SERVER['REQUEST_METHOD'] == 'POST'){
				$content = "";
				foreach($_POST as $label => $value){
					if($value !== ""){
						$content .= '<!-- wp:create-block/isfis-text-input {"textName":"'.$label.'","placeholder":"'.$value.'"} /-->';
					}
				}	
				$post_data = array(
					'post_title' => 'Formulario de '.$attributes['textName'],
					'post_content' => $content,
					'post_status' => 'publish',
					'post_type' => 'formulario',
				);
				$post_id = wp_insert_post( $post_data );
				if($post_id > 0){
					echo '<div class="mx-auto my-4 bg-green-400 font-bold border border-emerald-600 text-white text-center font-Poppins px-3 py-4">Información enviada correctamente.</div>';
					wp_set_object_terms($post_id, $attributes['parentTaxonomy'], 'tipo_formulario', true);
					if(isset($attributes['selectChildTaxonomy']) && $attributes['selectChildTaxonomy'] > 0){
						wp_set_object_terms($post_id, $attributes['selectChildTaxonomy'], 'tipo_formulario', true);
					}
					if(isset($attributes['redirect']) && $attributes['redirect'] && isset($attributes['redirectLink'])){
						echo"<script>window.location.href='".$attributes['redirectLink']."';</script>";
					}
				}else{
					echo '<div class="mx-auto my-4 bg-red-400 font-bold border border-red-600 text-white text-center font-Poppins px-3 py-4">Ha ocurrido un error al enviar la información.</div>';
				}
			}
		
		?>
</p>