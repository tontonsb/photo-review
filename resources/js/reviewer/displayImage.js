import 'ol/ol.css'
import ImageLayer from 'ol/layer/Image'
import Map from 'ol/Map'
import Projection from 'ol/proj/Projection'
import Static from 'ol/source/ImageStatic'
import View from 'ol/View'
import {getCenter} from 'ol/extent'
import initUserMarkers from './userMarkers'

export default function displayImage(target, width, height, url, interactive = true) {
    const extent = [0, 0, width, height]
    const projection = new Projection({
        code: 'this-image',
        units: 'pixels',
        extent: extent,
    })

    const userMarkers = initUserMarkers()

    const map = new Map({
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
        map.on('click', userMarkers.clickHandler)
        map.on('pointermove', updateCursor)
        // Strangely new features aren't yet visible on the very next tick, so 0 timeout works wronq
        map.on('click', event => setTimeout(_ => updateCursor(event), 10))
    }

    return {map, userMarkers}
}


