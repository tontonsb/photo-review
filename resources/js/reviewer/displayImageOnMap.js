import ImageLayer from 'ol/layer/Image.js'
import TileLayer from 'ol/layer/Tile.js'
import Map from 'ol/Map.js'
import Static from 'ol/source/ImageStatic.js'
import View from 'ol/View.js'
import {getCenter} from 'ol/extent.js'
import { XYZ } from 'ol/source'
import { transformExtent } from 'ol/proj'


export default function displayImageOnMap(target, bounds, url) {
    const extent = transformExtent([
        parseFloat(bounds.west),
        parseFloat(bounds.south),
        parseFloat(bounds.east),
        parseFloat(bounds.north),
    ], 'EPSG:4326', 'EPSG:3857')

    return new Map({
        layers: [
            new TileLayer({
                source: new XYZ({
                    attributions: [
                        'Powered by Esri',
                        'Source: Esri, DigitalGlobe, GeoEye, Earthstar Geographics, CNES/Airbus DS, USDA, USGS, AeroGRID, IGN, and the GIS User Community'
                    ],
                    url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
                }),
            }),
            new ImageLayer({
                source: new Static({
                    url: url,
                    imageExtent: extent,
                }),
            }),
        ],
        target: target,
        view: new View({
            center: getCenter(extent),
            extent: extent,
            showFullExtent: true,
            zoom: 1,
        }),
    })
}


