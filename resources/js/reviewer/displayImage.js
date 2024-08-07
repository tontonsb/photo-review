import 'ol/ol.css'
import ImageLayer from 'ol/layer/Image'
import Map from 'ol/Map'
import Projection from 'ol/proj/Projection'
import Static from 'ol/source/ImageStatic'
import View from 'ol/View'
import {getCenter} from 'ol/extent'
import {defaults as defaultControls} from 'ol/control.js'
import initUserMarkers from './userMarkers'
import BaseEvent from 'ol/events/Event'

/**
 * Displays image
 */
export default function displayImage(target, extent, url, translations, interactive = true) {
    extent = [0, 0, extent[0], extent[1]]
    const projection = new Projection({
        code: 'this-image',
        units: 'pixels',
        extent: extent,
    })

    const userMarkers = initUserMarkers(translations)

    const map = new Map({
        controls: defaultControls().extend([
            ...(interactive ? [userMarkers.clearControl] : []),
        ]),
        layers: [
            new ImageLayer({
                source: new Static({
                    url: url,
                    projection: projection,
                    imageExtent: extent,
                }),
            }),
            userMarkers.layer,
        ],
        target: target,
        view: new View({
            projection: projection,
            center: getCenter(extent),
            extent: extent,
            showFullExtent: true,
            zoom: 1,
        }),
    })

    map.getView().fit(extent)

    const updateCursor = async event => {
        const features = await userMarkers.layer.getFeatures(event.pixel)

        map.getTargetElement().style.cursor = features.length ? 'pointer' : ''
    }

    if (interactive) {
        map.on('click', userMarkers.removeClicked)
        map.on('pointermove', updateCursor)
        // Strangely new features aren't yet visible on the very next tick, so 0 timeout works wronq
        map.on('click', event => setTimeout(_ => updateCursor(event), 10))
    } else {
        map.on('click', async event => {
            const features = await userMarkers.getClickedFeatures(event)

            const output = []
            features.forEach(feature => {
                output.push(feature.getGeometry().getCoordinates())
            })

            const ev = new BaseEvent('gotcoords')
            ev.payload = 'Koordinātas (pikseļos nevis īstās):<br>' + output.map(c => c[1] + ',' + c[0]).join('<br>')
            map.dispatchEvent(ev)
        })
    }

    return {map, userMarkers}
}


