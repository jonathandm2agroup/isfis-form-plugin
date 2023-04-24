import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {ToggleControl, TextControl,Panel, PanelBody} from '@wordpress/components';
import { __experimentalNumberControl as NumberControl } from '@wordpress/components';
import { useState } from '@wordpress/element';
import './style.scss';

export default function Edit(props) {
	const { attributes, setAttributes } = props;
	let {textName, required, multipleData} = attributes;
	

	const onChangeNameTextInput = (newName) => {
		setAttributes({textName: newName});
	}


	return (
		<p { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody title='Configuraciones del campo de subida de archivos'>
					<TextControl
						label="Nombre del campo"
						value={textName}
						onChange={onChangeNameTextInput}
					/>
					<ToggleControl 
						label='Campo requerido'
						help="Añade una restriccion al campo, es decir el campo no puede estar vacio"
						onChange={(value) => setAttributes({required: value})}
						checked={required}
					/>
					<ToggleControl 
						label='Multiples archivos'
						help="Permite que los usarios seleccionen más de un archivo"
						onChange={(data) => setAttributes({multipleData: data})}
						checked={multipleData}
					/>
				</PanelBody>
			</InspectorControls>
			<div className='flex flex-col'>
				<label className='mx-2 font-Poppins text-lg text-MidnightB'>{textName !== undefined ? textName: 'Label'}:</label>
				{required ? 
					<input className='block w-full text-sm text-slate-500
					file:mr-4 file:py-2 file:px-4
					file:rounded-md file:border-0
					file:text-sm file:font-semibold
					file:bg-violet-50 file:text-MidnightB
					hover:file:bg-BrightB' type="file" id={textName} name={textName} accept='.pdf' disabled/>
				: <input className='block w-full text-sm text-slate-500
				file:mr-4 file:py-2 file:px-4
				file:rounded-md file:border-0
				file:text-sm file:font-semibold
				file:bg-violet-50 file:text-MidnightB
				hover:file:bg-BrightB' type="file" required id={textName} name={textName} accept='.pdf' disabled/>}
			</div>
		</p>
	);
}
