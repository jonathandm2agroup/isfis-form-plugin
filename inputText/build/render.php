<p <?php echo get_block_wrapper_attributes(); ?>>
		<div class='flex md:flex-row flex-col gap-3'>
			<label for="<?php echo $attributes['textName'] ?>" class='mx-2 font-Poppins text-lg text-MidnightB'><?php echo $attributes['textName'] ?>:</label>
			<?php if($attributes['required']): ?>
				<input id="<?php echo $attributes['textName'] ?>" name="text-<?php echo $attributes['textName'] ?>" class='px-2 py-3 mx-2 w-full font-Poppins font-normal rounded-md placeholder:italic placeholder:text-slate-400 focus:outline-none focus:border-MidnightB focus:ring-MidnightB focus:ring-1' type='text' placeholder="<?php echo $attributes['placeholder']?>" required /> 
			<?php else:?>
				<input id="<?php echo $attributes['textName'] ?>" name="text-<?php echo $attributes['textName'] ?>" class='mx-2 px-2 py-3 w-full font-Poppins font-normal rounded-md placeholder:italic placeholder:text-slate-400 focus:outline-none focus:border-MidnightB focus:ring-MidnightB focus:ring-1' type='text' placeholder="<?php echo $attributes['placeholder']?>"/> 
			<?php endif;?>
		</div>
</p>
