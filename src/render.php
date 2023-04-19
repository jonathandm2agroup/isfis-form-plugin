<p <?php echo get_block_wrapper_attributes(); ?>>
		<?php var_dump($attributes)?>
		<form method="POST" class='flex flex-col font-Poppins mx-3 my-4'>
			<h3 class='text-3xl text-MidnightB text-center my-6 font-semibold'><?php echo $attributes['textName']?></h3>
			<?php echo $content?>
			<input class='mx-auto rounded-md bg-MidnightB hover:bg-DeepB text-white px-2 py-3 text-lg disabled:bg-MidnightB disabled:text-white' value="<?php echo(__('Enviar'))?>" type='submit'/>
		</form>
		<?php 
			if(isset($_POST['Nombre'])){
				$post_data = array(
					'post_title' => 'Formulario de '.$attributes['textName'],
					'post_content' => '<p>'.$_POST['Nombre'].'</p>',
					'post_status' => 'publish',
					'post_type' => 'formulario',
				);

				$post_id = wp_insert_post( $post_data );
				wp_set_object_terms($post_id, $attributes['parentTaxonomy'], 'tipo_formulario', true);

				if($post_id > 0){
					echo 'Mensaje enviado correctamente';
					
				}
			}
		
		?>
</p>