<p <?php echo get_block_wrapper_attributes(); ?>>
		<div class='flex phone:flex-row desktop:flex-col gap-3'>
			<label for="<?php echo $attributes['textName'] ?>" class='mx-2 font-Poppins text-lg text-MidnightB'><?php echo $attributes['textName'] ?>:</label>
			<?php if($attributes['required']): ?>
				<textarea maxlength="<?php echo $attributes['maxlength'] ?>" name="<?php echo $attributes['textName'] ?>" class='mx-2 px-2 py-3 resize-y w-full font-Poppins font-normal rounded-md placeholder:italic placeholder:text-slate-400 focus:outline-none focus:border-MidnightB focus:ring-MidnightB focus:ring-1' placeholder="<?php echo $attributes['placeholder']?>" required></textarea> 
			<?php else:?>
				<textarea maxlength="<?php echo $attributes['maxlength'] ?>" name="<?php echo $attributes['textName'] ?>" class='mx-2 px-2 py-3 resize-y w-full font-Poppins font-normal rounded-md placeholder:italic placeholder:text-slate-400 focus:outline-none focus:border-MidnightB focus:ring-MidnightB focus:ring-1' placeholder="<?php echo $attributes['placeholder']?>"/></textarea>
			<?php endif;?>
		</div>
</p>