import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {ToggleControl, TextControl,Panel, PanelBody} from '@wordpress/components'
import { useState } from '@wordpress/element';
import './style.scss';

export default function Edit(props) {
	const { attributes, setAttributes } = props;
	let {textName, placeholder, require} = attributes;
	const [ isRequired, setIsRequired ] = useState( false );

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
				</PanelBody>
			</InspectorControls>
			<div className='flex flex-col'>
				<label className='mx-2 font-Poppins text-lg text-MidnightB'>{textName !== undefined ? textName: 'Label'}:</label>
				{isRequired ? 
					<input name={textName} className='mx-2 w-full font-Poppins font-normal rounded-md placeholder:italic placeholder:text-slate-400 focus:outline-none focus:border-MidnightB focus:ring-MidnightB focus:ring-1' type='email' placeholder={placeholder !== undefined ? placeholder: 'Placeholder'} required /> 
				: <input name={textName} className='mx-2 w-full font-Poppins font-normal rounded-md placeholder:italic placeholder:text-slate-400 focus:outline-none focus:border-MidnightB focus:ring-MidnightB focus:ring-1' type='email' placeholder={placeholder !== undefined ? placeholder: 'Placeholder'} />}
			</div>
		</p>
	);
}
