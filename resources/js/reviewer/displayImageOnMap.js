import 'ol/ol.css'
import ImageLayer from 'ol/layer/Image'
import TileLayer from 'ol/layer/Tile'
import Map from 'ol/Map'
import Static from 'ol/source/ImageStatic'
import View from 'ol/View'
import { XYZ } from 'ol/source'
import { transformExtent } from 'ol/proj'
import {ScaleLine, defaults as defaultControls} from 'ol/control.js'
import initUserMarkers from './userMarkers'

/**
 * Places image with known WGS84 bounds on the map.
 */
export default function displayImageOnMap(target, bounds, url, interactive = true) {
    const extent = transformExtent([
        parseFloat(bounds.west),
        parseFloat(bounds.south),
        parseFloat(bounds.east),
        parseFloat(bounds.north),
    ], 'EPSG:4326', 'EPSG:3857')

    const userMarkers = initUserMarkers()

    const scaleLine = new ScaleLine({
        units: 'metric',
        bar: true,
        steps: 4,
        text: false,
        minWidth: 140,
    })

    const map = new Map({
        controls: defaultControls().extend([
            scaleLine,
            ...(interactive ? [userMarkers.clearControl] : []),
        ]),
        layers: [
            new TileLayer({
                source: new XYZ({
                    attributions: [
                        'Powered by Esri',
                        'Source: Esri, DigitalGlobe, GeoEye, Earthstar Geographics, CNES/Airbus DS, USDA, USGS, AeroGRID, IGN, and the GIS User Community'
                    ],
                    url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
                    // It returns gray placeholder tiles for higher zoom levels
                    maxZoom: 20,
                }),
            }),
            new ImageLayer({
                source: new Static({
                    url: url,
                    imageExtent: extent,
                }),
            }),
            userMarkers.layer,
        ],
        target: target,
        view: new View(),
    })

    map.getView().fit(extent)

    const updateCursor = async event => {
        const features = await userMarkers.layer.getFeatures(event.pixel)

        map.getTargetElement().style.cursor = features.length ? 'pointer' : ''
    }

    if (interactive) {
        map.on('click', userMarkers.clickHandler)
        map.on('pointermove', updateCursor)
        // Strangely new features aren't yet visible on the very next tick, so 0 timeout works wronq
        map.on('click', event => setTimeout(_ => updateCursor(event), 10))
    }

    return {map, userMarkers}
}


