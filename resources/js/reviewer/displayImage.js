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

    if (interactive)
        map.on('click', userMarkers.clickHandler)

    return {map, userMarkers}
}


