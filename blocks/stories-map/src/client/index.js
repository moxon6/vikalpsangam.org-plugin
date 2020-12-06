/*global pluginBaseUrl */

import * as L from 'leaflet';
import LCluster from 'leaflet.markercluster';
import iconUrl from 'leaflet/dist/images/marker-icon.png';
import shadowUrl from 'leaflet/dist/images/marker-shadow.png';
import 'leaflet/dist/leaflet.css';
import 'leaflet.markercluster/dist/MarkerCluster.css';
import 'leaflet.markercluster/dist/MarkerCluster.Default.css';
import './style.scss';

const icon = L.icon( {
	iconUrl: `${ pluginBaseUrl }/${ iconUrl }`,
	shadowUrl: `${ pluginBaseUrl }/${ shadowUrl }`,
} );

async function fetchCoordinates() {
	const coordinatesMap = await wp.apiFetch( {
		path: '/vikalpsangam/v1/map',
	} );
	return Object.values( coordinatesMap );
}

const mean = ( arr ) => arr.reduce( ( x, y ) => x + y, 0 ) / arr.length;

const averageLocation = ( coordinates ) => [
	mean( coordinates.map( ( x ) => x.latitude ) ),
	mean( coordinates.map( ( x ) => x.longitude ) ),
];

const INITIAL_ZOOM_LEVEL = 5;

async function renderVikalpsangamMap( mapNode ) {
	const coordinates = await fetchCoordinates();

	if ( mapNode.querySelector( '.loader' ) ) {
		mapNode.querySelector( '.loader' ).remove();
	}

	const map = L.map( mapNode ).setView(
		averageLocation( coordinates ),
		INITIAL_ZOOM_LEVEL
	);

	L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution:
			'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	} ).addTo( map );

	const markers = new LCluster.MarkerClusterGroup();

	coordinates.forEach( ( coordinate ) => {
		const marker = L.marker(
			[ coordinate.latitude, coordinate.longitude ],
			{ icon }
		);
		marker.bindPopup(
			`<a href="${ coordinate.url }">${ coordinate.title }</a>`
		);
		markers.addLayer( marker );
	} );
	map.addLayer( markers );
}

window.onload = () =>
	document
		.querySelectorAll( '.vikalp-leaflet-block' )
		.forEach( renderVikalpsangamMap );
