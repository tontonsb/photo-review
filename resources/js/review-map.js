import 'ol/ol.css'
import Map from 'ol/Map.js'
import GeoJSON from 'ol/format/GeoJSON.js'
import TileLayer from 'ol/layer/Tile.js'
import View from 'ol/View.js'
import {fromLonLat} from 'ol/proj.js'
import VectorLayer from 'ol/layer/Vector'
import VectorSource from 'ol/source/Vector'
import { XYZ } from 'ol/source'
import Style from 'ol/style/Style'
import Text from 'ol/style/Text'
import Fill from 'ol/style/Fill'
import Stroke from 'ol/style/Stroke'

const labelStyle = feature => new Style({
    text: new Text({
        font: '15px sans-serif',
        text: feature.get('conclusion') + (feature.get('status') ?? ''),
        backgroundFill: new Fill({
            color: '#0009',
        }),
        padding: [3,0,1,2],
    }),
})

function showReviewMap(target, features) {
    const source = new VectorSource()

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
                style: labelStyle,
            })
        ],
        view: new View({
            center: fromLonLat([23.54238, 56.87841]),
            zoom: 12,
        }),
    })

    const container = target instanceof HTMLElement ? target : document.getElementById(target)
    const tooltip = container.querySelector('#tooltip')

    source.addFeatures(
        new GeoJSON().readFeatures(features, {
            dataProjection: 'EPSG:4326',
            featureProjection: map.getView().getProjection(),
        })
    )

    map.on('click', function (evt) {
        const pixel = map.getEventPixel(evt.originalEvent)

        map.forEachFeatureAtPixel(pixel, feature => {
            window.open(feature.get('url'))
        })
    })

    map.on('pointermove', function(evt) {
        if (evt.dragging)
            return

        // Unset styles
        map.getTargetElement().style.cursor = ''
        tooltip.style.visibility = 'hidden'

        const pixel = map.getEventPixel(evt.originalEvent)

        const features = []

        map.forEachFeatureAtPixel(pixel, feature => {
            map.getTargetElement().style.cursor = 'pointer'

            features.push(
                (feature.get('conclusion') ?? ' ')
                + (feature.get('status') ?? ' ')
                + (feature.get('id'))
            )
        })

        if (features.length) {
            tooltip.style.left = pixel[0] + 'px'
            tooltip.style.top = pixel[1] + 'px'
            tooltip.style.visibility = 'visible'
            tooltip.innerText = features.join(', ')
        }
    })

    return map
}

window.showReviewMap = showReviewMap
