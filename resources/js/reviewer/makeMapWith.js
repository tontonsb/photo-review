import 'ol/ol.css'
import Feature from 'ol/Feature.js'
import Map from 'ol/Map.js'
import Point from 'ol/geom/Point.js'
import Polygon from 'ol/geom/Polygon.js'
import TileLayer from 'ol/layer/Tile.js'
import View from 'ol/View.js'
import {fromLonLat} from 'ol/proj.js'
import VectorLayer from 'ol/layer/Vector'
import VectorSource from 'ol/source/Vector'
import Circle from 'ol/style/Circle'
import Fill from 'ol/style/Fill'
import Style from 'ol/style/Style'
import Stroke from 'ol/style/Stroke'
import { XYZ } from 'ol/source'

function pin(target, location) {
    const loc = [location.lon, location.lat]

    const pin = new Feature({
        geometry: new Point(fromLonLat(loc)),
    })

    pin.setStyle(
        new Style({
            image: new Circle({
                radius: 5,
                fill: new Fill({
                    color: '#3399cc',
                }),
            }),
        })
    )

    return mapWithFeature(target, pin, loc)
}

function box(target, location) {
    const bounds = {
        north: parseFloat(location.north),
        east: parseFloat(location.east),
        south: parseFloat(location.south),
        west: parseFloat(location.west),
    }

    const box = new Feature({
        geometry: new Polygon([[
            fromLonLat([bounds.west, bounds.north]),
            fromLonLat([bounds.east, bounds.north]),
            fromLonLat([bounds.east, bounds.south]),
            fromLonLat([bounds.west, bounds.south]),
            fromLonLat([bounds.west, bounds.north]),
        ]]),
    })

    box.setStyle(
        new Style({
            stroke: new Stroke({
                color: '#3399cc',
                width: 1.25,
            }),
            fill: new Fill({
                color: '#3399cc22',
            }),
        })
    )

    const center = [
        (bounds.east + bounds.west) / 2,
        (bounds.north + bounds.south) / 2,
    ]

    return mapWithFeature(target, box, center)
}

function mapWithFeature(target, feature, center)
{
    return new Map({
        target: target,
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
            new VectorLayer({
                source: new VectorSource({
                    features: [feature],
                }),
            }),
        ],
        view: new View({
            center: fromLonLat(center),
            zoom: 13,
        }),
    })
}

export default {pin, box}
