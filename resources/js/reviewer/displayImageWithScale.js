import 'ol/ol.css'
import ImageLayer from 'ol/layer/Image'
import TileLayer from 'ol/layer/Tile'
import Map from 'ol/Map'
import Static from 'ol/source/ImageStatic'
import View from 'ol/View'
import { XYZ } from 'ol/source'
import {ScaleLine, defaults as defaultControls} from 'ol/control.js'
import initUserMarkers from './userMarkers'
import { fromLonLat, getPointResolution } from 'ol/proj'

/**
 * Displays image with known WGS84 center, guessed size and unknown orientation.
 */
export default function displayImage(target, center, extent, url, interactive = true) {
    center = fromLonLat(center)

    const view = new View({
        showFullExtent: true,
    })

    // map units might be meters at the equator, but not everywhere!
    const scale = getPointResolution(view.getProjection(), 1, center)

    extent = [ // minX, minY, maxX, maxY
        center[0] - (extent[0] / 2 / scale),
        center[1] - (extent[1] / 2 / scale),
        center[0] + (extent[0] / 2 / scale),
        center[1] + (extent[1] / 2 / scale),
    ]

    view.setProperties({extent: extent})

    const userMarkers = initUserMarkers()

    const scaleLine = new ScaleLine({
        units: 'metric',
        bar: true,
        steps: 4,
        text: false,
        minWidth: 160,
    })

    const map = new Map({
        controls: defaultControls().extend([scaleLine]),
        layers: [
            new ImageLayer({
                source: new Static({
                    url: url,
                    imageExtent: extent,
                }),
            }),
            userMarkers.layer,
        ],
        target: target,
        view: view,
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


