import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {ToggleControl, TextControl,Panel, PanelBody} from '@wordpress/components';
import { __experimentalNumberControl as NumberControl } from '@wordpress/components';
import { useState } from '@wordpress/element';
import './style.scss';

export default function Edit(props) {
	const { attributes, setAttributes } = props;
	let {textName, placeholder, require, maxlength} = attributes;
	const [ isRequired, setIsRequired ] = useState( require );

	const onChangeNameTextInput = (newName) => {
		setAttributes({textName: newName});
	}

	const onChangePlaceHolder = (newPlaceholder) => {
		setAttributes({placeholder: newPlaceholder})
	}

	const onChangeRequirer = (isRequired) => {
		setIsRequired(( isRequired ) => ! isRequired);
		setAttributes({required: isRequired});
	}

	const onChangeMaxCaracter = (maxCaracter) => {
		setAttributes({maxlength: maxCaracter})
	}

	return (
		<p { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody title='Configuraciones del campo de texto'>
					<TextControl
						label="Nombre del campo"
						value={textName}
						onChange={onChangeNameTextInput}
					/>
					<TextControl
						label="Placeholder"
						value={placeholder}
						onChange={onChangePlaceHolder}
					/>
					<ToggleControl 
						label='Campo requerido'
						help="Añade una restriccion al campo, es decir el campo no puede estar vacio"
						onChange={onChangeRequirer}
						checked={isRequired}
					/>
					<NumberControl
						label='Longitud de caracteres'
						value={maxlength}
						min={0}
						max={500}
						onChange={onChangeMaxCaracter}
						required
					/>
				</PanelBody>
			</InspectorControls>
			<div className='flex flex-col'>
				<label className='mx-2 font-Poppins text-lg text-MidnightB'>{textName !== undefined ? textName: 'Label'}:</label>
				{isRequired ? 
					<textarea maxLength={maxlength} name={textName} className='mx-2 px-2 py-3 resize w-full font-Poppins font-normal rounded-md placeholder:italic placeholder:text-slate-400 focus:outline-none focus:border-MidnightB focus:ring-MidnightB focus:ring-1' type='email' placeholder={placeholder !== undefined ? placeholder: 'Placeholder'} required /> 
				: <textarea maxLength={maxlength} name={textName} className='mx-2 px-2 py-3 resize w-full font-Poppins font-normal rounded-md placeholder:italic placeholder:text-slate-400 focus:outline-none focus:border-MidnightB focus:ring-MidnightB focus:ring-1' type='email' placeholder={placeholder !== undefined ? placeholder: 'Placeholder'} />}
			</div>
		</p>
	);
}
