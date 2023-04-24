<p <?php echo get_block_wrapper_attributes(); ?>>
		<div class='flex md:flex-row flex-col gap-3'>
			<label for="<?php echo $attributes['textName'] ?>" class='mx-2 font-Poppins text-lg text-MidnightB'><?php echo $attributes['textName'] ?>:</label>
			<?php if($attributes['required'] && !isset($attributes['multipleData'])): ?>
				<input class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-MidnightB hover:file:bg-BrightB" required type="file" id="<?php echo $attributes['textName']?>" name="file-<?php echo $attributes['textName']?>" accept='.pdf'/>
			<?php elseif($attributes['required'] && isset($attributes['multipleData'])):?>
				<input class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-MidnightB hover:file:bg-BrightB" required multiple type="file" id="<?php echo $attributes['textName']?>" name="file-<?php echo $attributes['textName']?>" accept='.pdf'/>
			<?php elseif(!$attributes['required'] && isset($attributes['multipleData'])):?>
				<input class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-MidnightB hover:file:bg-BrightB" multiple type="file" id="<?php echo $attributes['textName']?>" name="file-<?php echo $attributes['textName']?>" accept='.pdf'/>
			<?php else:?>	
				<input class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-MidnightB hover:file:bg-BrightB" type="file" id="<?php echo $attributes['textName']?>" name="file-<?php echo $attributes['textName']?>" accept='.pdf'/>
			<?php endif;?>
		</div>
</p>