import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, InnerBlocks } from '@wordpress/block-editor';
import {ToggleControl, TextControl,Panel, PanelBody, SelectControl, CheckboxControl } from '@wordpress/components';
import apiFetch from '@wordpress/api-fetch';
import { useState, useEffect } from '@wordpress/element';
import './style.scss';

export default function Edit(props) {
	const { attributes, setAttributes } = props;
	let {textName, hasExternalLink, externalLink, parentTaxonomy, hasChildTaxonomy, selectChildTaxonomy} = attributes;;
	const [parentCategory, setParentCategory] = useState([]);
	const [childCategory, setChildCategory] = useState([]);
	const [checkExternalLink, setCheckExternalLink] = useState(hasExternalLink)

	let optionsParent = []
	let optionsChild = []
	
	useEffect(() => {
		apiFetch({ path: "/wp/v2/tipos_formulario" }).then((categoryForm) => {
			if(categoryForm.parent !== 0){
				const parentCategories = categoryForm.filter( category => category.parent === 0 );
				setParentCategory(parentCategories)
				let childCategory = categoryForm.filter( category => category.parent > 0 );
				let formatedChildItems = [];
				childCategory.forEach(item => {
					return formatedChildItems = [[{parent:item.parent}, [{label: item.name, value: item.id}]], ...formatedChildItems]
				})
				setChildCategory(formatedChildItems)
			}
		});
	}, []);
	
	const onChangeNameTextInput = (newName) => {
		setAttributes({textName: newName});
	}
	const onChangeExternalLink = (newLink) => {
		setAttributes({externalLink: newLink});
	}
	const onChangeFormType = (formType) => {
		setAttributes({parentTaxonomy: Number(formType)})
	}

	const formTypeHasChild = (formType) => {
		let hasChild = [];
		if(childCategory.length > 0){
			hasChild = childCategory.map(item => {
				if(item[0]['parent'] === formType){
					return item[1][0]
				}else{
					return undefined
				}
			})
			return hasChild.filter(item => item !== undefined);
		}else{
			return hasChild;
		}
	}

	const onChangeFormChildType = (childType) => {
		setAttributes({hasChildTaxonomy: true, selectChildTaxonomy: Number(childType)})
	}
	if(parentCategory.length > 0){
		parentCategory.forEach(item => 
			{
			return optionsParent = [{label:item.name, value:item.id}, ...optionsParent]
		});
		optionsParent.unshift({label: '<Selecciona un valor>', value: 0})
	}
	
	const ALLOWED_BLOCKS = ['create-block/isfis-text-input', 'create-block/isfis-email-input', 'create-block/isfis-textarea', 'core/columns']
	
	if(childCategory.length > 0){
		optionsChild = formTypeHasChild(parentTaxonomy);
		optionsChild.unshift({label: '<Selecciona un valor>', value: 0})
	}
	return (
		<p { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody title='Configuraciones del formulario'>
					<TextControl
						label="Titulo del formulario"
						value={textName}
						onChange={onChangeNameTextInput}
					/>
					<SelectControl
						label={__('Este formulario pertenece a:')}
						value={parentTaxonomy}
						options={parentCategory.length > 0 ? optionsParent: [{label: 'Cargando...', value: 'loading.'}]}
						onChange={onChangeFormType}
					/>
					{
						parentTaxonomy !== undefined && parentTaxonomy > 0 ?
							formTypeHasChild(parentTaxonomy).length > 0 ?
								<>
									<SelectControl 
										label={__('Selecciona la subcategoria que pertenece')}
										value={selectChildTaxonomy}
										options={optionsChild}
										onChange={onChangeFormChildType}
									/>
								</>
							:setAttributes({hasChildTaxonomy: false, selectChildTaxonomy: 0})
						: null
					}
					<CheckboxControl 
						label="Envio de datos a un link externo"
						help= "Enviar los datos a otro sitio mediante una API"
						checked={checkExternalLink}
						onChange={setCheckExternalLink}
					/>
					{
						checkExternalLink && (
							<TextControl
								label="Endpoint donde se enviarán los datos"
								value={externalLink}
								onChange={onChangeExternalLink}
							/>
						)
					}
				</PanelBody>
			</InspectorControls>
			<form className='flex flex-col font-Poppins mx-3 my-4'>
				<h3 className='text-3xl text-MidnightB text-center'>{textName}</h3>
				<InnerBlocks allowedBlocks={ALLOWED_BLOCKS}/>
				<input className='mx-auto rounded-md !bg-MidnightB hover:bg-DeepB text-white px-2 py-3 text-lg disabled:bg-MidnightB disabled:text-white' value={__('Enviar')} type='submit' disabled/>
			</form>
		</p>
	);
}
