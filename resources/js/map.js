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
import Icon from 'ol/style/Icon'

function showFeaturesOnMap(target, featureEndpoint, clickFeatures) {
    const source = new VectorSource({
        format: new GeoJSON(),
        url: featureEndpoint,
    })

    // Redraw points into boxes covered by the image
    source.on('featuresloadend', () =>
        source.forEachFeature(feature => {
            const geometry = feature.getGeometry()

            // We only need to redraw shapes that are not 2D yet
            if ('Point' !== geometry.getType()) {
                return
            }

            const width = feature.get('width_guess_meters')
            const height = feature.get('height_guess_meters')
            const bearing = feature.get('bearing_degrees')

            // We can't polygonize without sizes and direction
            if (!width || !height || !bearing) {
                return
            }

            const center = geometry.getCoordinates()
            const left = center[0] - width / 2
            const top = center[1] + height / 2
            const right = center[0] + width / 2
            const bottom = center[1] - height / 2

            const polygon = new Polygon([[
                [left, top],
                [left, bottom],
                [right, bottom],
                [right, top],
                [left, top],
            ]])

            polygon.rotate(-bearing * Math.PI / 180, center)

            feature.setGeometry(polygon)
        })
    )

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
                    // It returns gray placeholder tiles for higher zoom levels
                    maxZoom: 20,
                }),
            }),
            new VectorLayer({
                source: source,
            })
        ],
        view: new View({
            center: fromLonLat([23.54238, 56.87841]),
            zoom: 12,
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

window.showFeaturesOnMap = showFeaturesOnMap
