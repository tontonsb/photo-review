import 'ol/ol.css'
import ImageLayer from 'ol/layer/Image'
import Map from 'ol/Map'
import Static from 'ol/source/ImageStatic'
import View from 'ol/View'
import {ScaleLine, Control, defaults as defaultControls} from 'ol/control.js'
import initUserMarkers from './userMarkers'
import { fromLonLat, getPointResolution } from 'ol/proj'

function createSwapViewControl() {
    const button = document.createElement('button')

    const element = document.createElement('div')
    element.className = 'ol-unselectable ol-control'
    element.style.right = '.5em'
    element.style.top = '.5em'
    element.appendChild(button)

    const control = new Control({element})

    return {button, control}
}

/**
 * Displays image with known WGS84 center, guessed size and unknown orientation.
 */
export default function displayImage(target, center, extent, url, interactive = true, legacyScale = false) {
    center = fromLonLat(center)

    const viewWithoutExtent = new View({
        center: center,
    })

    // map units might be meters at the equator, but not everywhere!
    const scale = legacyScale ? 0.83236 : getPointResolution(viewWithoutExtent.getProjection(), 1, center)

    extent = [ // minX, minY, maxX, maxY
        center[0] - (extent[0] / 2 / scale),
        center[1] - (extent[1] / 2 / scale),
        center[0] + (extent[0] / 2 / scale),
        center[1] + (extent[1] / 2 / scale),
    ]

    const viewWithExtent = new View({
        extent: extent,
        showFullExtent: true,
    })

    const userMarkers = initUserMarkers()

    const scaleLine = new ScaleLine({
        units: 'metric',
        bar: true,
        steps: 4,
        text: false,
        minWidth: 160,
    })

    const swapView = createSwapViewControl()
    let currentView = 'extent' === window.sessionStorage.getItem('view-type') ? viewWithoutExtent : viewWithExtent
    swapView.button.innerHTML = 'extent' === window.sessionStorage.getItem('view-type') ? '🔲' :  '🔳'

    const map = new Map({
        controls: defaultControls().extend([
            scaleLine,
            swapView.control,
            ...(interactive ? [userMarkers.clearControl] : []),
        ]),
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
        view: currentView,
    })

    currentView.fit(extent)

    swapView.button.addEventListener('click', _ => {
        if (currentView === viewWithoutExtent) {
            swapView.button.innerHTML = '🔳'
            window.sessionStorage.setItem('view-type', 'extent')
            currentView = viewWithExtent
        } else {
            swapView.button.innerHTML = '🔲'
            window.sessionStorage.setItem('view-type', 'free')
            currentView = viewWithoutExtent
        }

        map.setView(currentView)
        currentView.fit(extent)
    })

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


