import 'ol/ol.css'
import Feature from 'ol/Feature.js'
import Map from 'ol/Map.js'
import GeoJSON from 'ol/format/GeoJSON.js'
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

function pin(target, location, featureEndpoint, clickFeatures) {
    const loc = [location.lon, location.lat]

    const pin = new Feature({
        geometry: new Point(fromLonLat(loc)),
    })

    pin.setStyle(
        new Style({
            image: new Circle({
                radius: 5,
                fill: new Fill({
                    color: '#b833ff',
                }),
            }),
        })
    )

    return mapWithFeature(target, pin, loc, featureEndpoint, clickFeatures)
}

function box(target, location, featureEndpoint, clickFeatures) {
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
                color: '#b833ff',
                width: 2,
            }),
            fill: new Fill({
                color: '#b833ff22',
            }),
        })
    )

    const center = [
        (bounds.east + bounds.west) / 2,
        (bounds.north + bounds.south) / 2,
    ]

    return mapWithFeature(target, box, center, featureEndpoint, clickFeatures)
}

function mapWithFeature(target, feature, center, featureEndpoint, clickFeatures) {
    const neighbours = new VectorLayer({
        source: new VectorSource({
            format: new GeoJSON(),
            url: featureEndpoint,
        }),
    })

    const map = new Map({
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
            neighbours,
            new VectorLayer({
                source: new VectorSource({
                    features: [feature],
                }),
            }),
        ],
        view: new View({
            center: fromLonLat(center),
            zoom: 14,
        }),
    })

    map.on('click', function (evt) {
        const pixel = map.getEventPixel(evt.originalEvent)

        const features = []

        map.forEachFeatureAtPixel(pixel, feature => {
            features.push({
                path: feature.get('path'),
                url: feature.get('url'),
            })
        })

        clickFeatures(features)
    })

    map.on('pointermove', function(evt) {
        if (evt.dragging)
            return

        map.getTargetElement().style.cursor = ''
        const pixel = map.getEventPixel(evt.originalEvent)

        map.forEachFeatureAtPixel(pixel, feature => {
            if (feature.get('path') && feature.get('url')) {
                map.getTargetElement().style.cursor = 'pointer'

                // stop processing features at the current pixel
                return true
            }
        })
    })

    return map
}

export default {pin, box}
