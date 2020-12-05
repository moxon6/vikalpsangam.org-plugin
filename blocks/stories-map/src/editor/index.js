import { __ } from '@wordpress/i18n';

const { registerBlockType } = wp.blocks;

registerBlockType( 'vikalpsagam-blocks/stories-map', {
	title: __( 'Vikalpsangam Map', 'vikalpsangam-map' ),
	description: "Stories Map Block - built using leaflet.js and leaflet.markercluster",
	category: 'widgets',
	icon: 'location',
	attributes: {},
	edit: () => <p>"Vikalpsangam Map Block"</p>,
	save: () => null,
} );
