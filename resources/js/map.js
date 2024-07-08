import 'ol/ol.css'
import Map from 'ol/Map.js'
import GeoJSON from 'ol/format/GeoJSON.js'
import Polygon from 'ol/geom/Polygon.js'
import TileLayer from 'ol/layer/Tile.js'
import View from 'ol/View.js'
import {fromLonLat, toLonLat, getPointResolution} from 'ol/proj.js'
import VectorLayer from 'ol/layer/Vector'
import VectorSource from 'ol/source/Vector'
import { XYZ } from 'ol/source'
import * as turf from '@turf/turf'

function showFeaturesOnMap(target, featureEndpoint, clickFeatures) {
    const source = new VectorSource({
        format: new GeoJSON(),
        url: featureEndpoint,
    })

    const center = fromLonLat([23.54238, 56.87841])
    const view = new View({
        center: center,
        zoom: 12,
    })
    // map units might be meters at the equator, but not everywhere!
    const scale = getPointResolution(view.getProjection(), 1, center)

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

            // Turf needs WGS84
            const centerCoord = toLonLat(geometry.getCoordinates())
            const center = turf.point(centerCoord)
            const sides = turf.featureCollection([
                turf.destination(center, width/2, -90, {units: 'meters'}), // left
                turf.destination(center, height/2, 0, {units: 'meters'}), // top
                turf.destination(center, width/2, 90, {units: 'meters'}), // right
                turf.destination(center, height/2, 180, {units: 'meters'}), // bottom
            ])

            const box = turf.envelope(sides)
            const polygon = turf.transformRotate(box, bearing, {mutate: false, pivot: centerCoord})
            const coords = turf.getCoords(polygon)

            feature.setGeometry(new Polygon([
                coords[0].map(coord => fromLonLat(coord))
            ]))
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
