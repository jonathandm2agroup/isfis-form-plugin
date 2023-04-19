/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

/**
 * Internal dependencies
 */
import Edit from './edit';
import metadata from './block.json';
import logo from '../src/logo.svg'
import { InnerBlocks } from '@wordpress/block-editor';
/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( metadata.name, {
	/**
	 * @see ./edit.js
	 */
	edit: Edit,
	attributes: {
		textName: {
			type: "string"
		},
		parentTaxonomy: {
			type: "number",
			default: 0
		},
		hasChildTaxonomy: {
			type: "boolean",
			default: false
		},
		selectChildTaxonomy: {
			type: "number",
		},
		hasExternalLink: {
			type: "boolean",
			default: false
		},
		externalLink:{
			type: "string"
		}
	},
	icon: <img src={logo}/>,
	save: () => {
		return <InnerBlocks.Content />;
	}
} );
